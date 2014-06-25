<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Competition_result_model extends MY_Model {
    public $_table = 'competition_result';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'competition_id',
            'label' => 'Competition ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'division_id',
            'label' => 'Division ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'user_id',
            'label' => 'User ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'canine_id',
            'label' => 'Canine ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'fs_order',
            'label' => 'Order',
            'rules' => 'xss_clean'),
        array(
            'field' => 'tc_order',
            'label' => 'Order',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_1_1',
            'label' => 'FS 1',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_2_1',
            'label' => 'FS 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_3_1',
            'label' => 'FS 3',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_4_1',
            'label' => 'FS 4',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_5_1',
            'label' => 'FS 5',
            'rules' => 'xss_clean'),
        array(
            'field' => 'cr_1',
            'label' => 'Catch Ratio',
            'rules' => 'xss_clean'),
        array(
            'field' => 'tc_cat_1',
            'label' => 'TC Catch 1',
            'rules' => 'xss_clean'),
        array(
            'field' => 'tc_total',
            'label' => 'Toss and Catch Total',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_total_1',
            'label' => 'FS Total',
            'rules' => 'xss_clean'),        
        array(
            'field' => 'fs_1_2',
            'label' => 'Fs 1 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_2_2',
            'label' => 'FS 2 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_3_2',
            'label' => 'FS 3 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_4_2',
            'label' => 'FS 4 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_5_2',
            'label' => 'FS 5 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'cr_2',
            'label' => 'Catch Ratio 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'tc_cat_2',
            'label' => 'TC Catch 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fs_total_2',
            'label' => 'FS Total 2',
            'rules' => 'xss_clean'),
        array(
            'field' => 'total',
            'label' => 'Total Score',
            'rules' => 'xss_clean'),
        array(
            'field' => 'place',
            'label' => 'Place',
            'rules' => 'xss_clean'),
        array(
            'field' => 'cup_points',
            'label' => 'Cup Points',
            'rules' => 'xss_clean'),
        array(
            'field' => 'cdd_place',
            'label' => 'CDD Place',
            'rules' => 'xss_clean')
    );
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public $belongs_to = array('user', 'canine', 'division', 'registration', 'competition');
    
    public $after_get = array('names');
    
    public function competition_fee($row) {
        if(is_object($row)) {
            $this->load->model('competition_fee_model');
            $options = array('competition_id' => $row->competition_id, 'division_id' => $row->division_id);
            $fees = $this->competition_fee_model->get_by($options);
            $row->fees = $fees;
        }
        return $row;
    }
    
    public function names($row) {
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
            if(!empty($row->division_id)) {
                $this->db->select('name');
                $this->db->where('id', $row->division_id);
                $query = $this->db->get('division');
                $division = $query->result();
                if(!empty($division)) {
                    $row->division = $division[0]->name;
                }                
            }            
            if(!empty($row->competition_id)) {
                $this->db->select('name, location, date, season');
                $this->db->where('id', $row->competition_id);
                $query = $this->db->get('competition');
                $competition = $query->result();
                if(!empty($competition)) {
                    $row->competition = $competition[0]->name;
                    $row->location = $competition[0]->location;
                    $row->date = $competition[0]->date;
                    $row->season = $competition[0]->season;
                }                
            }            
        }
        return $row;
    }
    
    public function get_scores_by_member($user_id, $canine_id, $competitions) {
        $this->db->select('competition_result.id AS competition_result_id, competition_result.place, division.id AS division_id, division.points_type');
        $this->db->select('competition_result.user_id AS user_id, competition_result.canine_id as canine_id');
        $this->db->join('division', 'division.id = competition_result.division_id');
        $this->db->where('competition_result.user_id', $user_id);
        $this->db->where('competition_result.canine_id', $canine_id);
        $this->db->where('division.points_type !=', 'NULL');
        $this->db->where_in('competition_result.competition_id', $competitions);
        $this->db->order_by('competition_result.user_id');
        $this->db->order_by('competition_result.place');
        $query = $this->db->get('competition_result');
        return $query->result();
    }

    
    public function get_forms_by_division($competition_id, $division_id) {
        //first grab competition object
        $this->load->model(array('competition_model', 'competition_result_model'));
        $competition = $this->competition_model->get($competition_id);
        
        //now build the division object
        $this->load->model('division_model');
        $division = $this->division_model->order_by('name')->get_by('id', $division_id);

        $options = array('competition_id' => $competition_id, 'division_id' => $division_id);
        $registrations = $this->registration_model->with('user')->with('canine')->with('competition')->get_many_by($options);        
        $data = new stdClass();
        $data = $division;
        $data->competition = $competition;
        $data->registrations = $registrations;        
        return $data;
    }
    
    public function competitor_setup($registrations) {
        //run through all the registrations and see if we need to create a record on competition_result
        if(!empty($registrations)) {
            foreach($registrations as $k=>$v) {
               //this checks to see if we're a duplicate or not
               if(is_array($v)) {
                   foreach($v as $row) {
                       $data[] = $this->_check_and_set($row);
                       $competition_id = $row['competition_id'];
                   }
               } else {
                   $data[] = $this->_check_and_set($v);
                   $competition_id = $v['competition_id'];
               }
            }
           if(!empty($data)) {
               $this->insert_many($data);
               $this->generate_running_orders($competition_id);
           }
            return true;
        } else {
            return false;
        }
    }
    
    public function setup_card($options) {
        $data = $this->_check_and_set($options);
        if($this->insert($data)) {
            return true;
        }
        return false;
    }
    
    public function calculate_overall_placement($competition_id, $division_id) {
        $new_results = $this->order_by('total', 'desc')->get_many_by(array('competition_id' => $competition_id, 'division_id' => $division_id));
        $i=1;
        $previous = '';
        foreach($new_results as $row) {
            if($previous == $row->total) {
                $place = isset($place)?$place:'1';
                $previous = $previous;
            } else {
                $place = $i;
                $previous = $row->total;
            }
            $i++;           
            $options = array('place' => $place);
            $this->competition_result_model->update($row->id, $options, true);
           
        }  
        return true; 
    }
    
    public function calculate_club_placement($competition_id, $division_id) {
        //calculate the CDD Place that exludes non-members
        $results = $this->order_by('total', 'desc')->get_many_by(array('competition_id' => $competition_id, 'division_id' => $division_id));
        
        $i=1;
        $previous = '';
        if(!empty($results)) {
            foreach($results as $row) {
                //first let's check member status
                if($this->ion_auth->in_group(array('members', 'provisional'), $row->user_id)) {
                    if(!empty($row->total)) {
                        if($previous == $row->total) {
                            $place = $place;
                            $previous = $previous;
                        } else {
                            $place = $i;
                            $previous = $row->total;
                        }
                        $i++;           
                        $options = array('cdd_place' => $place);
                        $this->competition_result_model->update($row->id, $options, true);                        
                    }
                }                
            }
        }    
    }
    
    public function calculate_cup_points($competition_id, $division_id) {
        $flag = 'true';
        //grab the points guide for this division
        $this->load->model(array('division_model', 'points_guide_model'));
        $points_guide = $this->division_model->get($division_id);

        if(!empty($points_guide->points_type)) {
            $this->db->select('DISTINCT(cdd_place)');
            $this->db->where('competition_id', $competition_id);
            $this->db->where('division_id', $division_id);
            $this->db->where('cdd_place !=', 'NULL');
            $this->db->order_by('cdd_place');
            $query = $this->db->get('competition_result');
            $results = $query->result();

            if(!empty($results)) {
                $i=0;
                $place_count = array();
                foreach($results as $row) {
                    $options = array('cdd_place' => $row->cdd_place, 'competition_id' => $competition_id, 'division_id' => $division_id);
                    $count = $this->competition_result_model->count_by($options);
                    $place_count[$i]['place'] = $row->cdd_place;
                    $place_count[$i]['count'] = $count;
                    if($count > 1) {
                        $count_place = $row->cdd_place;
                        for($a=1; $a<=$count; $a++) {
                            if($a == 1) {
                                $count_place - 1;
                            } else {
                                $count_place++;
                            }
                            $place_count[$i]['tie'][$a] = $count_place;
                        }
                    }
                    $i++;
                }
                if(!empty($place_count)) {
                    $i=0;
                    foreach($place_count as $r) {
                        $options = array('place' => $r['place'], 'type' => $points_guide->points_type);
                        $points = $this->points_guide_model->get_by($options);
                        if(!empty($points)) {
                            $final['points'] = $points->points;
                        } else {
                            $final['points'] = 1;
                        }
                        $final['count'] = $r['count'];
                        $final['place'] = $r['place'];
                        if(!empty($r['tie'])) {
                            $new_points = 0.00;
                            foreach($r['tie'] as $k=>$v) {
                                $multi_options = array('place' => $v, 'type' => $points_guide->points_type);
                                $multi_points = $this->points_guide_model->get_by($multi_options);
                                $new_points +=  $multi_points->points;
                            }

                            $final['points'] = ($new_points / $r['count']);
                        }
                        $flag = 'false';
                        $update_options = array(
                            'cup_points' => $final['points']);
                        $this->db->where('competition_id', $competition_id);
                        $this->db->where('division_id', $division_id);
                        $this->db->where('cdd_place', $final['place']);
                        if($this->db->update('competition_result', $update_options)) {
                            $flag = 'true';
                        }
                    }
                }
            }
            if($flag == 'true') {
                return true;
            } else {
                return false;
            }

        } else {
            //if points type is empty we don't care, move along and pass a true
            return true;
        }

    }
    
    
    public function calculate_scores($competition_id, $division_id) {
        $results = $this->with('user')->get_many_by(array('competition_id' => $competition_id, 'division_id' => $division_id));        
        $competition = $this->competition_model->with('competition_type')->get($competition_id);
        if(!empty($results)) {
            //let's get the totals squared away.
            $flag = '';
            foreach ($results as $row) {
               $total = 0.0; 
               $total += ($row->fs_total_1 != '' ? ($row->fs_total_1 * $competition->competition_type->multiplier): 0.0); 
               $total += ($row->tc_total_1 != '' ? $row->tc_total_1: 0.0);
               $total += ($row->fs_total_2 != '' ? $row->fs_total_2: 0.0);
               $total += ($row->tc_total_2 != '' ? $row->tc_total_2: 0.0);
               $options = array('total' => $total);
               if($this->competition_result_model->update($row->id, $options, true)) {
                   $flag = 'true';
               } else {
                   $flag = 'false';
               }                
            }
            if($flag == 'true') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function set_options($options) {

        if(!empty($options)) {
            //first clean up empty fields
            foreach($options as $k=>$value) {
                if(empty($value) && $value !== '0') {
                    unset($options[$k]);
                }
            }
            $tc_cat_1 = '';
            $tc_cat_2 = '';
            for($i=1; $i<=10; $i++) {
                if(isset($options['tc_1_'.$i])) {
                    $tc_cat_1 .= $options['tc_1_'.$i].',';
                    unset($options['tc_1_'.$i]);
                }
                if(isset($options['tc_2_'.$i])) {
                    $tc_cat_2 .= $options['tc_2_'.$i].',';
                    unset($options['tc_2_'.$i]);
                }
            }
            if(!empty($tc_cat_1)) $options['tc_cat_1'] = rtrim($tc_cat_1, ',');
            if(!empty($tc_cat_2)) $options['tc_cat_2'] = rtrim($tc_cat_2, ',');

        }
        unset($options['round']);
        unset($options['submit']);
        unset($options['freestyle']);
        return $options;
    }
    
    public function generate_running_orders($competition_id) {
        $competition = $this->competition_model->get($competition_id);
        $divisions = $this->division_model->get_many_by(array('competition_type_id' => $competition->competition_type_id, 'dual !=' => 2));
                
        foreach($divisions as $division) {
            $type = ($division->freestyle == '1')?'fs_order':'tc_order';
            $this->running_order($competition_id, $division->id, $type);
        }
    }
    
    
    public function running_order($competition_id, $division_id, $type) {
        $teams = $this->get_teams($competition_id, $division_id);
        if(!empty($teams)) {
            shuffle($teams);          
            $i=1;
            foreach($teams as $row) {
                $options = array($type => $i);
                $this->update($row->id, $options, true);
                $i++;
            }
        }  
        return true;
    }

    public function get_teams($competition_id, $division_id) {
       //returns an array for teams on division also takes care of advanced and open condition
        $competition = $this->competition_model->with('competition_type')->get_by(array('id' => $competition_id));
        //let's select the division and see if it's dual.
        $division = $this->division_model->get($division_id);
        if($division->freestyle == '1') {
            $type = 'competition_result.fs_order';
        } else {
            $type = 'competition_result.tc_order';
        }

        if(!empty($division)) {
            $all_teams = array();
            $team_options = array('competition_id' => $competition_id, 'division_id' => $division->id);
            $teams = $this->competition_result_model->with('user')->with('canine')->with('division')->order_by($type)->get_many_by($team_options);
            if(!empty($teams)) {
                $all_teams = array_merge($all_teams, $teams);
            }
            //this condition will be met with Advanced divisions. We need to add Open only teams to the running order
            if($division->dual == 1 && $division->freestyle == 0) {
                $open_options = array('competition_type_id' => $competition->competition_type_id, 'freestyle' => '1');
                $open_division = $this->division_model->get_by($open_options);
                //add addition teams to running order
                $open_team_options = array('competition_id' => $competition_id, 'division_id' => $open_division->id, 'dual' => '0');
                $teams = $this->competition_result_model->with('user')->with('canine')->with('division')->order_by($type)->get_many_by($open_team_options);                 
                if(!empty($teams)) {
                    foreach($teams as $row) {
                        if($row->dual != '1') {
                            $new_teams[] = $row;
                        }
                    }
                    $all_teams = array_merge($all_teams, $new_teams);
                }
            }
        }
        if($division->freestyle == '1') {
            usort($all_teams, function ($a, $b) { return $a->fs_order - $b->fs_order; });
        } else {
            usort($all_teams, function ($a, $b) { return $a->tc_order - $b->tc_order; });
        } 
        return $all_teams;
   }
   
   public function adjust_scores($registration, $old_division) {
       //run a check
       $options = array(
           'competition_id' => $registration['competition_id'],
           'user_id' => $registration['user_id'],
           'canine_id' => $registration['canine_id'],
           'division_id' => $old_division->id);
       $results = $this->get_by($options);
       if(!empty($results) && $results->dual != 1) {
           $results_options = array(
               'division_id' => $registration['division_id']
           );
           if($this->update($results->id, $results_options)) {
               return true;
           }
       } elseif(!empty($results) && $results->dual == 1) {
           //what to do with dual
           
       }
       
 
   }
    
    public function set_form($options) {
        if(!empty($options)) {
            foreach($options as $k=>$v) {
                $item[$k] = $v;
            }
            return $item;
        }
    }
    
    public function check_order($competition_id, $division_id, $type) {
        //checks to see if the sort value is set to 0 
        $this->db->select_min($type);
        $this->db->where('competition_id', $competition_id);
        $this->db->where('division_id', $division_id);
        $query = $this->db->get('competition_result');
        $result = $query->result();
        if($result[0]->$type == 0) {
            //return true for no sort order set
            return true;
        } else {
            //return false for sort order set
            return $result[0]->$type;
        }
    }
    
    public function check_table_status($competition_id) {
        //return true if there are records in the table
        $this->db->where('competition_id', $competition_id);
        $this->db->limit(1);
        $query = $this->db->get('competition_result');
        $result = $query->result();
        if(!empty($result)) {
            return true;
        }
        return false;
    }
    
    private function _check_and_set($row) {
        $existing_options = array(
            'user_id' => $row['user_id'],
            'canine_id' => $row['canine_id'],
            'division_id' => $row['division_id'],
            'competition_id' => $row['competition_id']);
        $existing = $this->get_by($existing_options);            
        if(empty($existing)) {
            //we need more logic
            //get division info
            $this->load->model('division_model');
            $division = $this->division_model->get($row['division_id']);
            $type = 'tc_order';
            if($division->freestyle == 1) {
                $type = 'fs_order';
                
            }
            $max_running = $this->get_next_running($row['competition_id'], $division->id, $type);
            $data = array(
                'user_id' => $row['user_id'],
                'canine_id' => $row['canine_id'],
                'competition_id' => $row['competition_id'],
                'division_id' => $row['division_id'],
                'dual' => !empty($row['dual'])?$row['dual']:0,
                ''.$type.'' => $max_running);
            //set tc_order
            if(isset($row['not_dual']) && $division->freestyle == 1) {
                
            }

        }
        if(!empty($data)) {
            return $data;
        }
        return false;
    }
    
    
    private function get_next_running($competition_id, $division_id, $type) {
        $this->db->select_max(''.$type.'');
        $this->db->where('competition_id', $competition_id);
        $this->db->where('division_id', $division_id);
        $this->db->limit(1);
        $query = $this->db->get('competition_result');
        $result = $query->row();
        if(!empty($result->$type)) {
            return $result->$type + 1;
        } else {
            return 1;
        }
    }

}
?>
