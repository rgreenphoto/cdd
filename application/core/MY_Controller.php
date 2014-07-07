<?php

/*
 * Russ Green (russ@engrain.com)
 * Various Base Controller Methods
 *
 *
 */
class Main_Controller extends CI_Controller {
    //Class-wide variable to store user object in.
    public $the_user;
    public function __construct() {
        parent::__construct();
        //leave this off so profiler doesn't run
        //$this->output->enable_profiler(TRUE);
        if ( function_exists( 'date_default_timezone_set' ) ) {
            date_default_timezone_set('America/Denver');        
        }
        $this->data['display_social'] = true;
        $this->load->library('cart');
        $this->load->model('site_info_model');
        $this->site_info = $this->site_info_model->get_site();
        $this->data['site_info'] = $this->site_info;
        $this->data['mobile'] = ($this->agent->is_mobile())?$this->agent->mobile():'';
        
        if($this->ion_auth->logged_in() && empty($this->the_user)) {
            //Put User in Class-wide variable
            $this->the_user = $this->ion_auth->user()->row(); 
            $this->data['the_user'] = $this->the_user;
            
            //load messages
            $this->load->model('user_inbox_model');
            $this->data['unread_messages'] = $this->user_inbox_model->get_unread($this->the_user->id);
            
            $this->load->model('canine_model');
            $this->data['the_dogs'] = $this->canine_model->get_many_by(array('user_id' => $this->the_user->id)); 
            $this->the_dogs = $this->data['the_dogs'];
            if(!empty($this->the_user)) {
                //grab any incomplete registrations
                $this->load->model('registration_model');
                $this->registrations = $this->registration_model->user_registration($this->the_user->id);
                if(!empty($this->registrations)) {
                    $this->reg_incomplete = '1';
                } 
                //grab the user's groups and set flags based on those groups
                $groups = $this->ion_auth_model->get_users_groups($this->the_user->id);
                $groups = $groups->result();
//                //set flags
                if(!empty($groups)) {
                    $i=0;
                    foreach($groups as $row) {
                        $this->data['the_user']->groups[$i] = new stdClass();
                        $this->data['the_user']->groups[$i]->group_id = $row->id;
                        $this->data['the_user']->groups[$i]->description = $row->description;
                        if($row->id == '1') {
                            $this->data['the_user']->is_admin = true;
                        }
                        if($row->id == '2') {
                            $this->data['the_user']->group_id = $row->id;
                            $this->data['the_user']->group = $row->description;
                        }
                        if($row->id == '3') {
                            $this->data['the_user']->group_id = $row->id;
                            $this->data['the_user']->group = $row->description;
                        }
                        $i++;
                    }
                }
                if(!empty($this->the_user->family_id)) {
                    $this->load->model('user_model');
                    $options = array('family_id' => $this->the_user->family_id, 'id !=' => $this->the_user->id);
                    $this->data['the_family'] = $this->user_model->get_many_by($options);
                    $this->the_family = $this->data['the_family'];
                }
            }
            $this->load->model('poll_model');
            $this->data['active_poll'] = $this->poll_model->get_active();            
        }
        //$this->output->enable_profiler(TRUE);
        //function to randomly grab an image from the slideshow folder
        $this->load->helper('directory');
        $files = directory_map('./assets/images/slideshow');
        $count = count($files) - 1;
        $rand = rand(0, $count);
        $this->data['page_image'] = base_url().'/assets/images/slideshow/'.$files[$rand];
        //generate sidebar content menu
        $this->load->model('page_model');
        $this->data['menu'] = $this->page_model->get_menu();
    }
    
    public function set_form_options($array) {
        if(!empty($array)) {
            $type = 'text';
            foreach($array as $name) {
                if($name == 'password' || $name == 'password_confirm') {
                    $type = 'password';
                } else {
                    $type = 'text';
                }
                $this->data[$name] = array(
                    'id' => $name,
                    'name' => $name,
                    'value' => $this->input->post($name),
                    'type' => $type,
                    'class' => 'form-control'
                );
            }
        }     
    }
    
    public function set_post_options($array) {
        $options = array();
        if(!empty($array)) {
            foreach($array as $k=>$v) {
                if($k != 'submit' && $k != 'Submit' && $k != 'id' && $k != 'division_fee' && $k != 'poll_options' && $k != 'previous_description' && $k != 'previous_fees') {
                    $options[$k] = $this->input->post($k);
                }
            }
        }       
        return $options;
    }
    
    public function js_load($files) {
        $this->js = '';
        if(!empty($files)) {
            foreach($files as $file) {
                $this->js .= "<script type=\"text/javascript\" src=\"{$file}\"></script>\n\r";
            }
        }
    }
    
}

class Public_Controller extends Main_Controller {

    public function __construct() {
        parent::__construct();
        
        //$this->output->enable_profiler(TRUE);
        
        if ($this->ion_auth->logged_in()) {
            //create an empty object to get rid of warning
            if(!isset($data)) {
                $data = new stdClass();
            }
            
            //grab dogs for this user
           //$this->load->model('canine_model');
            //$data->the_dogs = $this->canine_model->get_dogs($this->the_user->id);
            //Load $the_user in all views
            $this->load->vars($data);            
       }              
    }
}

class Member_Controller extends Main_Controller {
    //Class-wide variable to store user object in.
    public function __construct() {
        parent::__construct(); 
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('members', 'users'))) {
            //create an empty object to get rid of warning
            if(!isset($data)) {
                $data = new stdClass();
            }
            //$this->output->enable_profiler(TRUE);
            //grab dogs for this user
            $this->load->model('canine_model');
            $data->the_dogs = $this->canine_model->get_dogs($this->the_user->id);
            
            $this->load->model('poll_model');
            $data->active_poll = $this->poll_model->get_active();
            
            //Load $the_user in all views
            $this->load->vars($data);
            
            
        } else {
            redirect('auth/login');
        }      
    }    
}



class Admin_Controller extends Main_Controller {

    public function __construct() {
        parent::__construct();
        //Check if user is in admin group
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            //create an empty object to get rid of warning
            
                  
            //Put User in Class-wide variable
            if(empty($this->the_user)) {
                $this->the_user = $this->ion_auth->user()->row();
                $this->data['the_user'] = $this->the_user;
            }
              
        } else {
            redirect('admin/auth/login');
        }
        
        $debug = $this->config->item('log_threshold');
        //$this->output->enable_profiler(TRUE);
        if($debug == 4) {
            //$this->output->enable_profiler(TRUE);
            //$this->email->print_debugger();
        }
        //load up the upload library so we can use it everywhere
        
        //set up cinfig variable for upload
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|xlsx|csv|xls|doc|docx';
        $config['max_size'] = '1000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $this->load->library('upload');   
    }    
}
?>
