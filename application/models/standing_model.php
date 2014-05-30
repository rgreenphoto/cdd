<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Standing_model extends MY_Model {
    public $_table = 'standing';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'user_id',
            'label' => 'User ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'canine_id',
            'label' => 'Canine ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'type',
            'label' => 'type',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'season',
            'label' => 'Season',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'place',
            'label' => 'Place',
            'rules' => 'xss_clean'),
        array(
            'field' => 'total_points',
            'label' => 'Total Points',
            'rules' => 'xss_clean'),
        array(
            'field' => 'comps',
            'label' => 'Comps',
            'rules' => 'xss_clean'),
        array(
            'field' => 'low1',
            'label' => 'Low 1',
            'rules' => 'xss_clean'),
        array(
            'field' => 'low2',
            'label' => 'Low 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hershey_total',
            'label' => 'Hershey Total',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hi_sky',
            'label' => 'HI SKy',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hi_ufo',
            'label' => 'HI UFO',
            'rules' => 'xss_clean'),
        array(
            'field' => 'lowest',
            'label' => 'lowest',
            'rules' => 'xss_clean')        
    );
    
    public $belongs_to = array('user', 'canine');
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public $after_get = array('names');
    
    public function names($row) {
        //add handler and dog names to the array for easy display
        if(is_object($row)) {
            if(!empty($row->canine_id)) {
                $this->db->select('name');
                $this->db->where('id', $row->canine_id);
                $query = $this->db->get('canine');
                $canine = $query->result();
                if(!empty($canine)) {
                    $row->canine = $canine[0]->name;
                }                
            }
            if(!empty($row->user_id)) {
                $this->db->select('first_name, last_name');
                $this->db->where('id', $row->user_id);
                $query = $this->db->get('users');
                $user = $query->result();
                if(!empty($user)) {
                    $row->handler = $user[0]->first_name .' '.$user[0]->last_name;
                }                
            }
            $row->lowest_competition = '';
            if(!empty($row->lowest)) {
                $this->db->select('name');
                $this->db->where('id', $row->lowest);
                $query = $this->db->get('competition');
                $competition = $query->result();
                if(!empty($competition)) {
                    $row->lowest_competition = $competition[0]->name;
                }
            }
        }
        return $row;
    }
    
    public function get_select() {
        //generate a select array for the enum field on this table
        $data[''] = 'Select...';
        $data['Cup'] = 'Cup';
        $data['RRR'] = 'RRR';
        $data['Hershey'] = 'Hershey';
        $data['Rookie'] = 'Rookie';
        return $data;
    }
    
    public function calculate($members, $competitions, $season) {
        $this->load->model(array('canine_model', 'competition_result_model', 'points_guide_model'));        
        if(!empty($members)) {
            $i = 0;
            foreach($members as $user) {            
                $canine_options = array('user_id' => $user->id);
                $canines = $this->canine_model->get_many_by($canine_options);
                if(!empty($canines)) {
                    foreach($canines as $dog) {
                        $cup_points_array = array();
                        $competition_array = array();
                        $stats = '';
                        $total = 0;
                        //grab cup points for each member/dog from the competition_result table and add them up
                        if(!empty($competitions)) {
                            $comp_count = 0;
                            foreach($competitions as $comp) {
                                $cup_options = array('user_id' => $user->id, 'canine_id' => $dog->id, 'competition_id' => $comp->id, 'cup_points !=' => 'NULL');
                                $results = $this->competition_result_model->get_many_by($cup_options);                                
                                if(!empty($results)) {
                                    $comp_count++;
                                    if(count($results) > 1) {
                                        if($results[0]->cup_points > $results[1]->cup_points) {
                                            $stats .= $comp->name.' ('.$results[0]->division.') '.$results[0]->cup_points.'|';
                                            $points = $results[0]->cup_points;
                                            $total += $results[0]->cup_points;
                                            $cup_points_array[] = $results[0]->cup_points;
                                            $competition_array[] = $results[0]->competition_id;
                                        } else {                                            
                                            $stats .= $comp->name.' ('.$results[1]->division.') '.$results[1]->cup_points.'|';
                                            $points = $results[1]->cup_points;
                                            $total += $results[1]->cup_points;
                                            $cup_points_array[] = $results[1]->cup_points;
                                            $competition_array[] = $results[1]->competition_id;
                                        }
                                    } else {
                                        $stats .= $comp->name.' ('.$results[0]->division.') '.$results[0]->cup_points.'|';
                                        $points = $results[0]->cup_points;
                                        $total += $results[0]->cup_points;
                                        $cup_points_array[] = $results[0]->cup_points;
                                        $competition_array[] = $results[0]->competition_id;
                                    }                                    
                                }
                                
                            }
                        }
                        if($total != 0) {
                            $lowest_competition = '';
                            if($comp_count >= 7) {
                                $total -= min($cup_points_array);
                                $lowest_key = array_search(min($cup_points_array), $cup_points_array);
                                $lowest_competition = $competition_array[$lowest_key];
                            }                
                            //create an array to pass to the _set_place function
                            //always make sure to the total is listed first to property sort array
                            $final_array[] = array(
                                'total_points' => $total,
                                'user_id' => $user->id,
                                'canine_id' => $dog->id,
                                'comps' => $comp_count,
                                'type' => 'Cup',
                                'season' => $season,
                                'lowest' => $lowest_competition,
                                'stats' => rtrim($stats, '|')
                            );
                        }
                    }
                }
            }
        }
        //pass to _set_place to resort the array based on total
        $data = $this->_set_place($final_array, 'total_points');
        if(!empty($data)) {
            //in this case, we will simply delete all records to ensure all updates are applied.
            if($this->_delete_record('Cup', $season)) {
                //insert the data
                if($this->insert_many($data)) {
                    //calculated rookie standings based on the previous insert
                    if($this->_calculate_rookie($members, $season)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
       
    public function calculate_rrr($members, $season) {
        //members array should only contain CDD members eligible for points
        if(!empty($members)) {
            foreach($members as $user) {
                $options = array('user_id' => $user->id);
                $dogs = $this->canine_model->get_many_by($options);
                if(!empty($dogs)) {
                    foreach($dogs as $dog) {
                        $total = 0;
                        //grab the highest score for qualified division
                        $sky_total = $this->_get_max_fs($user->id, $dog->id, 'Skyhoundz', $season);
                        if(!empty($sky_total)) {
                            $total += $sky_total;
                        }
                        //grab the highest score for qualified division
                        $ufo_total = $this->_get_max_fs($user->id, $dog->id, 'UFO', $season);
                        if(!empty($ufo_total)) {
                            $total += $ufo_total;
                        }
                        //create final array for place sort
                        if($total != 0) {
                            //total points is the sum of two highest scores divided by 2
                            $award = round((($sky_total + $ufo_total) / 2),1);
                            $final_array[] = array(
                                'rrr_award' => $award,                                
                                'r_hi_sky' => $sky_total,
                                'r_hi_ufo' => $ufo_total,
                                'rrr_total' => round($total, 1),
                                'user_id' => $user->id,
                                'canine_id' => $dog->id,
                                'type' => 'RRR',
                                'season' => $season
                            );
                        }
                    }
                }
            }
            //pass the array to the _set_place function to resort by total points
            $data = $this->_set_place($final_array, 'rrr_award');
            if(!empty($data)) {
                //delete all RRR records for clean insert
                $this->_delete_record('RRR', $season);
                if($this->insert_many($data)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }            
        } else {
            return false;
        }        
    }
    public function calculate_hershey($members, $season) {
        //should only be eligible members contained.
        if(!empty($members)) {
            foreach($members as $user) {
                //grab all dogs for each members and calculate scores for each
                $options = array('user_id' => $user->id);
                $dogs = $this->canine_model->get_many_by($options);
                if(!empty($dogs)) {
                    foreach($dogs as $dog) {
                        $total = 0;
                        //get the highest SKyhoundz TC score for qualified divisions
                        $sky_total = $this->_get_max_tc($user->id, $dog->id, 'Skyhoundz', $season);
                        if(!empty($sky_total)) {
                            $total += $sky_total;
                        }
                        //get the highest UFO TC score
                        $ufo_total = $this->_get_max_tc($user->id, $dog->id, 'UFO', $season);
                        if(!empty($ufo_total)) {
                            $total += $ufo_total;
                        }
                        if($total != 0) {
                            //award points are the sum of two highest divided by 2
                            $award = round((($sky_total + $ufo_total) / 2),1);
                            $final_array[] = array(
                                'hershey_award' => $award,                                
                                'h_hi_sky' => $sky_total,
                                'h_hi_ufo' => $ufo_total,
                                'hershey_total' => round($total, 1),
                                'user_id' => $user->id,
                                'canine_id' => $dog->id,
                                'type' => 'Hershey',
                                'season' => $season
                            );
                        }
                    }
                }
            }
            //sort the array based on total
            $data = $this->_set_place($final_array, 'hershey_award');
            if(!empty($data)) {
                //delete the current records for a clean insert
                $this->_delete_record('Hershey', $season);
                if($this->insert_many($data)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }            
        } else {
            return false;
        }        
    }
    
    public function top5($year) {
        $options = array('type' => 'Cup', 'season' => $year);
        $top5['season'] = $year;
        $top5['people'] = $this->limit(5)->order_by('place')->get_many_by($options);
        if(empty($top5['people'])) {
            $options['season'] = ($year - 1);
            $top5['season'] = $options['season'];
            $top5['people'] = $this->limit(5)->order_by('place')->get_many_by($options);
        }
        return $top5;
    }
    
    private function _calculate_rookie($members, $season) {
        foreach($members as $user) {
            //create a subset of members for the season being executed
            if($user->rookie_year == $season) {
                $options = array('user_id' => $user->id, 'type' => 'Cup', 'season' => $season);
                $rookies = $this->get_many_by($options);
                if(!empty($rookies)) {
                    foreach($rookies as $rookie) {
                        //create final array for sorting
                        $final_array[] = array(
                            'total_points' => $rookie->total_points,
                            'user_id' => $rookie->user_id,
                            'canine_id' => $rookie->canine_id,
                            'comps' => $rookie->comps,
                            'type' => 'Rookie',
                            'season' => $season,
                            'lowest' => $rookie->lowest,
                            'stats' => $rookie->stats
                        );                            
                    }
                }
            }
        }
        //resort array based on points/
        $data = $this->_set_place($final_array, 'total_points');
        if(!empty($data)) {
            //delete records for clean insert
            $this->_delete_record('Rookie', $season);
            if($this->insert_many($data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }            
    }
    
    private function _set_place($array, $total_field) {
        if(!empty($array)) {
            //sort the array by total
            arsort($array);
            $i = 1;
            $previous = '';
            foreach($array as $row) {
                //pick the appropirate key to use in array
                if($row[$total_field]) {
                    //determine if there is a tie and increment place according
                    if($previous == $row[$total_field]) {
                        $place = $place;
                        $previous = $previous;
                    } else {
                        $place = $i;
                        $previous = $row[$total_field];
                    }
                    //add place back into array
                    $row['place'] = $place;
                }
                $result[] = $row;
                $i++;
            }
            //return array for insert
            return $result;
        } else {
            return array();
        }     
    }
    
    private function _get_max_fs($user_id, $dog_id, $type, $season) {
        //query to get the highest scored out of database (includes second round if present)
        $this->db->select('MAX(fs_total_1) AS fs1, MAX(fs_total_2) AS fs2', FALSE);
        $this->db->join('division', 'competition_result.division_id = division.id AND division.freestyle = 1 AND division.points_type IS NOT NULL');
        $this->db->where('competition_id IN (SELECT competition.id FROM competition JOIN competition_type ON (competition.competition_type_id = competition_type.id AND competition_type.type = "'.$type.'") WHERE season = "'.$season.'")', NULL, FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->where('canine_id', $dog_id);
        $query = $this->db->get('competition_result');
        $result = $query->result();
        $total = 0.0;
        //determine if second round is higher than first and return result
        if(!empty($result[0]->fs1) || !empty($result[0]->fs2)) {
            if($result[0]->fs1 > $result[0]->fs2) {
                $total = $result[0]->fs1;
            } else {
                $total = $result[0]->fs2;
            }
        }
        return $total;
    }
    
    private function _get_max_tc($user_id, $dog_id, $type, $season) {
        //returns highest round for toss and catch. (included round 2 if found)
        $this->db->select('MAX(tc_total_1) AS tc1, MAX(tc_total_2) AS tc2', FALSE);
        $this->db->join('division', 'competition_result.division_id = division.id AND division.freestyle = 0 AND division.points_type IS NOT NULL');
        $this->db->where('competition_id IN (SELECT competition.id FROM competition JOIN competition_type ON (competition.competition_type_id = competition_type.id AND competition_type.type = "'.$type.'") WHERE season = "'.$season.'")', NULL, FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->where('canine_id', $dog_id);
        $query = $this->db->get('competition_result');
        $result = $query->result();
        $total = 0.0;
        //determine if round 1 was higher than round 2
        if(!empty($result[0]->tc1) || !empty($result[0]->tc2)) {
            if($result[0]->tc1 > $result[0]->tc2) {
                $total = $result[0]->tc1;
            } else {
                $total = $result[0]->tc2;
            }
        }
        return $total;
    }
    
    private function _delete_record($type, $season) {
        //deletes records based on type and season.
        $this->db->where('type', $type);
        $this->db->where('season', $season);
        if($this->db->delete('standing')) {
            return true;
        } else {
            return false;
        }
    }

}


?>
