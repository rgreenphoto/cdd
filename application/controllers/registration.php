<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Registration extends Public_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('registration_model', 'user_model', 'competition_result_model'));
        $this->data['display_social'] = false;
    }


    public function volunteer() {
        $this->load->model(array('event_helpers_model'));
        if(!empty($_POST)) {
            foreach($_POST['position'] as $k=>$v) {
                $data['user_id'] = $this->input->post('user_id');
                $data['competition_id'] = $this->input->post('competition_id');
                $data['position_id'] = $v;
                $existing = $this->event_helpers_model->get_by($data);
                if(!$existing) {
                    $this->event_helpers_model->insert($data);
                    $flag = true;
                }
            }
        }
        if($flag == true) {
            //$new_data = $this->event_helpers_model->with('position')->get_many_by(array('competition_id' => $data['competition_id'], 'user_id' => $data['user_id']));
            echo json_encode(array('message' => 'Success'));
        } else {
            echo json_encode(array('message' => 'Failed '));
        }
    }
    
    public function complete() {
        if(isset($this->the_user->family_id)) {
            $options['family_id'] = $this->the_user->family_id;
        } else {
            $options['user_id'] = $this->the_user->id;
        }
        
        $options['complete'] = 0;
        $options['isPaid'] = 0;
        $outstanding = $this->registration_model->get_many_by($options);
        
        if(!empty($outstanding)) {
            $i=0;
            foreach($outstanding as $row) {
                $this->data['registrations'][$i] = $this->registration_model->with('canine')->with('competition')->with('division')->with('user')->get($row->id);
                $i++;
            }            
            
        } else {
            $this->data['message'] = 'No registrations to complete';
        }
        $this->data['main'] = 'registration/complete';
        $this->load->view('secondary_layout', $this->data);
        
    }
    
    
    public function add() {
        $user_id = $this->input->post('user_id');
        $canine_id = $this->input->post('canine_id');
        $division_id = $this->input->post('division_id');
        $competition_id = $this->input->post('competition_id');

        if(!empty($user_id) && !empty($canine_id) && !empty($division_id) && !empty($competition_id)) {
            $this->load->model('user_model');
            $user = $this->user_model->get($user_id);
            $this->load->model('canine_model');
            $dog = $this->canine_model->get_by('id', $canine_id);
            $this->load->model('division_model');
            $division = $this->division_model->get_by('id', $division_id);
            $this->load->model('competition_fee_model');
            $options = array('division_id' => $division_id, 'competition_id' => $competition_id);
            $comp = $this->competition_fee_model->get_by($options);
            
            //check to see if reg is already in system
            $options = array('user_id' => $user_id, 'canine_id' => $canine_id, 'division_id' => $division_id, 'competition_id' => $competition_id);
            $registered = $this->registration_model->get_by($options);
            if(!empty($registered)) {
                echo json_encode('Already in the system');
            } else {
                $_POST['fees'] = $comp->fee;
                $_POST['complete'] = 0;
                $_POST['isPaid'] = 0;
                if(!empty($user->family_id)) {
                    $_POST['family_id'] = $user->family_id;
                }
                unset($_POST['new_id']);
                $data = $this->set_post_options($_POST);
                if($this->registration_model->insert($data)) {
                    $id = $this->db->insert_id();
                    $message = '<tr id="'.$id.'">';
                    $message .= '<td>'.$user->full_name.'</td>';
                    $message .= '<td>'.$dog->name.'</td>';
                    $message .= '<td>'.$division->name.'</td>';
                    $message .= '<td>'.$comp->fee.'</td>';
                    $message .= '<td><a href="#" data="'.base_url().'registration/delete_ajax/'.$id.'" class="btn btn-sm btn-cdd delete"><i class="fa fa-trash-o"></i></a></td>';
                    $message .= '</tr>';
                    echo json_encode($message);
                } else {
                    $message = 'Could not save at this time';
                    return $message;
                }                
            }
        } else {
            echo json_encode('Could not save at this time');
        }    
    }
    
    public function done($complete, $isPaid) {
        if(isset($this->the_user->family_id)) {
            $options['family_id'] = $this->the_user->family_id;
        } else {
            $options['user_id'] = $this->the_user->id;
        }        
        
        $options['complete'] = '0';
        $options['isPaid'] = '0';
        $registrations = $this->registration_model->with('canine')->with('competition')->with('division')->with('user')->get_many_by($options);
        if(!empty($registrations)) {
           $flag = 'false'; 
           foreach($registrations as $row) {
                $i=0;
                if($this->registration_model->mark_complete($row->id, $complete, $isPaid)) {
                    $flag = 'true';
                }                   
           }
        }
        if(isset($flag) && $flag == 'true') {
            $this->session->set_flashdata('success_message', 'Thank you, see you at the event!');
            redirect('registration/history');
        } else {
            $this->session->set_flashdata('error_message', 'Could not complete transaction, please try again.');
            redirect('registration/complete');
        }  
    }
    
    public function p() {
        $user_id = $this->the_user->id;
        $options = array('user_id' => $user_id);
        $this->data['registrations'] = $this->registration_model->with('canine')->with('competition')->with('division')->with('user')->get_many_by($options);
        $this->load->view('registration/print', $this->data);
    }
    
    public function history() {
        $user_id = $this->the_user->id;
        $options = array('user_id' => $user_id);
        $this->data['registrations'] = $this->registration_model->with('canine')->with('competition')->with('division')->order_by('competition_id')->get_many_by($options);
        $this->data['main'] = 'registration/history';
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js');
        $this->load->view('secondary_layout', $this->data);
    }
    
    
    public function delete($id, $rowid = '') {
        if($this->registration_model->delete($id)) {
            $this->session->set_flashdata('success_message', 'Record deleted');
            redirect('registration/complete');
        } else {
            $this->session->set_flashdata('error_message', 'Could not remove, please try again');
            redirect(''.$_SERVER['HTTP_REFERER'].'');
        }
    }

    public function delete_ajax($id) {
        if($this->registration_model->delete($id)) {
            $message = 'Deleted';
            $array = array('message' =>$message, 'id' => $id);
            echo json_encode($array);
        } else {
            return false;
        }
    }


    public function quick_add() {
        $this->load->model(array('registration_model'));
        if(!empty($_POST)) {
            if($this->registration_model->quick_add($_POST)) {
                echo json_encode(array('message' => 'Success'));
            } else {
                echo json_encode(array('error_message' => 'Fail'));
            }
        }
    }


    public function quick_add_form($competition_id, $group_id = '', $user_id = '') {
        $this->data['hidden'] = array('competition_id' => $competition_id);
        if(!empty($competition_id)) {
            $this->load->model(array('competition_model', 'division_model'));
            $competition = $this->competition_model->get($competition_id);
            if(!empty($competition)) {
                //grab divisions
                $this->data['divisions'] = $this->division_model->get_full_list($competition->competition_type_id);
                $this->data['competition_name'] = $competition->name;
                $this->data['competition_id'] = $competition->id;
            }
        }
        if(!empty($user_id)) {
            $this->data['user_id'] = $user_id;
            $this->data['group_id'] = $group_id;
            $this->data['hidden']['user_id'] = $user_id;
            $this->data['user'] = $this->user_model->with('canine')->get($user_id);
            //check for existing registrations
            $options = array('competition_id' => $competition_id, 'user_id' => $user_id);
            $this->data['registrations'] = $this->registration_model->with('canine')->with('division')->get_many_by($options);
        }
        $this->data['main'] = 'registration/quick_add';
        $this->load->view('registration/quick_add', $this->data);
    }

    public function quick_user_search() {
        $results = $this->user_model->quick_search($_GET['term']);
        echo json_encode($results);
    }
    
}



?>
