<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Registration_model extends MY_Model {
    public $_table = 'registration';
    
    protected $soft_delete = TRUE;
   
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
            'field' => 'competition_id',
            'label' => 'Competition ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'division_id',
            'label' => 'Division',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'family_id',
            'label' => 'Family ID',
            'rules' => 'xss_clean'),
        array(
            'field' => 'pairs',
            'label' => 'Pairs Partner',
            'rules' => 'xss_clean'), 
        array(
            'field' => 'complete',
            'label' => 'Complete',
            'rules' => 'xss_clean'),
        array(
            'field' => 'fees',
            'label' => 'Fees',
            'rules' => 'xss_clean'),
        array(
            'field' => 'isPaid',
            'label' => 'Paid in full',
            'rules' => 'xss_clean'),
        array(
            'field' => 'sort',
            'label' => 'Running Order',
            'rules' => 'xss_clean'),
        array(
            'field' => 'isScratch',
            'label' => 'Scratched',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hasRun',
            'label' => 'Has Run?',
            'rules' => 'xss_clean')
    );
    
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public $belongs_to = array('canine', 'division', 'user', 'competition');
    
    //public $after_get = array('names');
    
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
                    $row->handler = $user[0]->first_name.' '.$user[0]->last_name;
                }
            }
        }
        return $row;
    }
    
    public function quick_add($options) {
       $this->load->model(array('user_model', 'registration_model', 'canine_model', 'competition_result_model', 'competition_fee_model', 'division_model'));
       //get fees
       $fee_options = array('competition_id' => $options['competition_id'], 'division_id' => $options['division_id']);
       $fee = $this->competition_fee_model->get_by($fee_options);
       
       //set up reg data info
       $reg_data['division_id'] = $options['division_id'];
       $reg_data['competition_id'] = $options['competition_id'];
       $reg_data['complete'] = 1;
       $reg_data['isPaid'] = 1;
       $reg_data['fees'] = !empty($fee->fee)?$fee->fee:'';
       
       //if we need to add a new user 
       if(empty($options['user_id'])) {
           try {
               $reg_info = $this->user_model->quick_add($options);
               $reg_data['user_id'] = $reg_info['user_id'];
               $reg_data['canine_id'] = $reg_info['canine_id'];
               unset($options);
           } catch (Exception $ex) {
               echo '<pre>';
               print_r($ex);
               die();
           }   
       }
       
       if(!empty($options['canine']) && empty($options['canine_id'])) {
           $canine_data = array('user_id' => $options['user_id'], 'name' => $options['canine']);
           try  {
               $this->canine_model->insert($canine_data);
               $reg_data['canine_id'] = $this->db->insert_id();
               $reg_data['user_id'] = $options['user_id'];
           } catch (Exception $ex) {
               echo '<pre>';
               print_r($ex);
               die();
           }           
       } else {
           $reg_data['user_id'] = $options['user_id'];
           $reg_data['canine_id'] = $options['canine_id'];
       }
       if($this->registration_model->insert($reg_data)) {
           $id = $this->db->insert_id();
           if(!empty($options['create_result'])) {
               //check the division for dual
               $division = $this->division_model->get($reg_data['division_id']);
               if($division->dual != 2) {
                   $reg_data['not_dual'] = true;
                   $this->competition_result_model->setup_card($reg_data);
               } else {
                   //if this is a dual division create setup card for each division
                   $dual_divisions = $this->division_model->get_many_by(array('competition_type_id' => $division->competition_type_id, 'dual' => 1));
                   foreach($dual_divisions as $dd) {
                       $reg_data['division_id'] = $dd->id;
                       $this->competition_result_model->setup_card($reg_data);
                   }
               }              
           }
           return true;
       } else {
           return false;
       }       
    }
    
    
    public function check_incomplete($user_id) {
        $this->db->where('registration.user_id', $user_id);
        $this->db->where('registration.complete', '0');
        $this->db->where('registration.deleted', '0');
        $query = $this->db->get('registration');
        $result = $query->result();
        if(!empty($result)) {
            $ret = '1';
            return $ret;
        } else {
            return false;
        }      
    }
    
    public function user_registration($user_id) {
        $this->db->where('registration.user_id', $user_id);
        $this->db->join('competition', 'registration.competition_id = competition.id AND competition.date >= '.date('Y-m-d').'');
        $this->db->where('registration.deleted', '0');
        $this->db->where('registration.complete', '0');
        $this->db->from('registration');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
      
    public function mark_complete($id, $complete, $isPaid) {
        $data = array('complete' => $complete, 'isPaid' => $isPaid);
        $this->db->where('id', $id);
        if($this->db->update('registration', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_basic_stats($competition_id) {
        return $this->registration_model->count_by(array('competition_id' => $competition_id));
    }


    public function get_forms($competition, $divisions) {        
        //now build the division object
        $grand_total = 0;
        $total_reg = 0;
        //now grab registrations for that division and competition
        if(!empty($divisions)) {
            $i=0;
            foreach($divisions as $division) {
                $data->registrations[$i]->division = $division->name;
                $data->registrations[$i]->division_id = $division->id;
                $options = array('competition_id' => $competition->id, 'division_id' => $division->id);
                $registrations = $this->with('user')->with('canine')->get_many_by($options);
                $data->registrations[$i]->total = count($registrations);
                $data->registrations[$i]->teams = $registrations;
                foreach($registrations as $row) {
                    $grand_total += $row->fees;
                }
                $total_reg += $data->registrations[$i]->total;
                $i++;
            }
        }
        $data->grand_total = $grand_total;
        $data->total_reg = $total_reg;
        return $data;
        
    }
    public function get_forms_by_user($competition_id) {
        //first grab competition object
        $this->load->model('competition_model');
        $competition = $this->competition_model->get($competition_id);
        $this->db->select('DISTINCT(user_id)');
        $this->db->where('competition_id', $competition_id);
        $this->db->where('deleted', '0');
        $query = $this->db->get('registration');
        $result = $query->result();
        
        if(!empty($result)) {
            $i=0;
            foreach($result as $row) {
                $this->load->model('user_model');
                $user = $this->user_model->get($row->user_id);
                $users[$i] = $user;
                $users[$i]->competition = $competition;
                $options = array('user_id' => $row->user_id, 'competition_id' => $competition_id);
                $users[$i]->registrations = $this->with('canine')->with('division')->get_many_by($options);
                $i++;
            }
        }
        $data = new stdClass();
        //$data = $division;
        $data->users = $users;        
        return $data;
    }
    
    public function get_mailmerge($competition_id) {
        $division = $this->registration_model->get_forms_by_user($competition_id);

        if(!empty($division)) {
            $data[0]['event_id'] = 'Event ID';
            $data[0]['handler_id'] = 'Handler ID';
            $data[0]['human'] = 'Handler Name';
            $data[0]['address'] = 'Address';
            $data[0]['phone'] = 'Phone';
            $data[0]['email'] = 'Email';
            $total_dog_rows = $this->_get_max_teams($division->users);
            for($i=1; $i<= $total_dog_rows; $i++) {
                $data[0]['dog_id_'.$i] = 'Dog ID'.$i;
                $data[0]['dog_name_'.$i] = 'Dog Name '.$i;
                $data[0]['division_'.$i] = 'Division '.$i;
            }
            foreach($division->users as $reg) {
                $data[$i]['event_id'] = $reg->competition->id;
                $data[$i]['handler_id'] = $reg->id;
                $data[$i]['handlerName'] = $reg->full_name;
                $data[$i]['address'] = $reg->address.' '.$reg->city.' '.$reg->state.' '.$reg->zip;
                $data[$i]['phone'] = !empty($reg->phone)?$reg->phone:' ';
                $data[$i]['email'] = !empty($reg->email)?$reg->email:' ';
                if(!empty($reg->registrations)) {
                    for($num=1; $num<= $total_dog_rows; $num++) {
                        $key = $num - 1;
                        $data[$i]['dog_id_'.$num] = !empty($reg->registrations[$key]->canine_id)?$reg->registrations[$key]->canine_id:' ';
                        $data[$i]['dog_name_'.$num] = !empty($reg->registrations[$key]->canine->name)?$reg->registrations[$key]->canine->name:' ';
                        $data[$i]['division_'.$num] = !empty($reg->registrations[$key]->division->name)?$reg->registrations[$key]->division->name:' ';
                    }
                }
                $i++;
            }
        }
        return $data;
    }

    private function _get_max_teams($users) {
        $total = 0;
        foreach($users as $reg) {
            $current = count($reg->registrations);
            if($current > $total)  {
                $total = $current;
            }
        }
        return $total;
    }

    public function get_list($competition) {
        $options = array('competition_id' => $competition->id);
        $regs = $this->with('division')->with('user')->with('canine')->order_by('user_id')->get_many_by($options);        
        if(!empty($regs)) {
            $data[0]['competition'] = $competition->name;
            $data[1]['human'] = 'HandlerName';
            $data[1]['dog'] = 'DogName';
            $data[1]['division'] = 'Division';
            $data[1]['isPaid'] = 'Paid';
            $data[1]['fee'] = 'Fee';
            $i=2;
            foreach($regs as $row) {
                $previous_id = $row->user->id;
                $total = 0;
                $data[$i]['human'] = $row->user->full_name;
                if(!empty($row->canine)) {
                    $data[$i]['dog'] = $row->canine->name;
                } else {
                    $data[$i]['dog'] = '';
                }
                $data[$i]['division'] = $row->division->name;
                $paid = 'No';
                if($row->isPaid == '1') {
                    $paid = 'Yes';
                }
                $data[$i]['isPaid'] = $paid;
                $data[$i]['fees'] = ''.$row->fees.'';
                $i++;
            }
        }
        
        return $data;
    }
    public function sort_divisions($competition_id) {
        $this->load->model(array('competition_model'));
        $competition = $this->competition_model->get($competition_id);
        $registrations = $this->with('division')->with('canine')->with('user')->get_many_by(array('competition_id' => $competition->id));
        $open_division = $this->division_model->get_by(array('competition_type_id' => $competition->competition_type_id, 'freestyle' => '1'));
        $advanced_division = $this->division_model->get_by(array('competition_type_id' => $competition->competition_type_id, 'freestyle' => '0', 'dual' => '1'));
        $divisions = array();
        if(!empty($registrations)) {
            foreach($registrations as $row) {
                if($row->division->dual == '2') {
                    $divisions[$open_division->name][] = array(
                        'handler' => $row->user->full_name,
                        'canine' => $row->canine->name,
                        'division_id' => $open_division->id,
                        'user_id' => $row->user_id,
                        'canine_id' => $row->canine_id,
                        'competition_id' => $competition->id,
                        'division' => $open_division->name,
                        'dual' => '1',
                        'results' => '1',
                        'freestyle' => '1'
                    );
                    $divisions[$advanced_division->name][] = array(
                        'handler' => $row->user->full_name,
                        'canine' => $row->canine->name,
                        'division_id' => $advanced_division->id,
                        'user_id' => $row->user_id,
                        'canine_id' => $row->canine_id,
                        'competition_id' => $competition->id,
                        'division' => $advanced_division->name,
                        'dual' => '1',
                        'results' => '1',
                        'freestyle' => '0'
                    );
                } else {
                    $divisions[$row->division->name][] = array(
                        'handler' => $row->user->full_name,
                        'canine' => $row->canine->name,
                        'division_id' => $row->division->id,
                        'user_id' => $row->user_id,
                        'canine_id' => $row->canine_id,
                        'competition_id' => $competition->id,
                        'division' => $row->division->name,
                        'dual' => '0',
                        'results' => '1',
                        'freestyle' => $row->division->freestyle
                    );
                    if($row->division->freestyle == 1) {
                        if(!empty($dvanced_division)) {
                            $divisions[$advanced_division->name][] = array(
                                'handler' => $row->user->full_name,
                                'canine' => $row->canine->name,
                                'division_id' => $advanced_division->id,
                                'user_id' => $row->user_id,
                                'canine_id' => $row->canine_id,
                                'competition_id' => $competition->id,
                                'division' => $advanced_division->name,
                                'dual' => '0',
                                'results' => '0',
                                'freestyle' => '0'
                            );   
                        }
                    }
                }
            }
            
        }
        return $divisions;
        
    }
    
    private function _total_by_division($competition_id, $division_id) {
        $this->db->where('competition_id', $competition_id);
        $this->db->where('division_id', $division_id);
        $this->db->where('deleted', '0');
        return $this->db->count_all_results('registration');
    }
   
}

?>
