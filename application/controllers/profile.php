<?php

/* Russ Green rgreen@rgreenphotography.com
 * This class is the Public implementation of User
 */


class Profile extends Public_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('user_model', 'canine_model'));
        $this->load->library(array('form_validation'));
        $this->privacy_options = array('Public');
        if(!empty($this->data['the_user']) && $this->data['the_user']->group_id == '3') {
            $this->privacy_options = array('Public', 'Member');
        }        
    }
    
    
    
    public function index() {
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/plupload/js/plupload.full.js', base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        $this->data['title'] = 'Member Profiles';
        $this->data['users'] = $this->user_model->with('canine')->order_by('last_name')->get_many_in('privacy', $this->privacy_options);
        $this->data['main'] = 'user/index';
        $this->load->view('secondary_layout', $this->data);        
    }
    
    
    public function view($slug) {
        $options = array('slug' => $slug);
        $this->data['user'] = $this->user_model->with('standing')->get_by($options);
        if(in_array($this->data['user']->privacy, $this->privacy_options)) {
            //grab dogs seperate for better score gathering
            $this->load->model('canine_model');
            $options = array('user_id' => $this->data['user']->id);
            $this->data['canines'] = $this->canine_model->with('competition_result')->get_many_by($options);
            $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
            $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');        
            $this->data['main'] = 'user/view';
            $this->data['page_image'] = '';
            $this->data['page_image'] = ''.base_url().'uploads/profiles/'.$this->data['user']->profile_image;
            $this->data['title'] = $this->data['user']->first_name.' '.$this->data['user']->last_name;
            $this->load->view('photo_layout', $this->data);            
        } else {
            $this->session->set_flashdata('notavailable', 'Profile Not Found.');
            redirect('profile/');
        }       
        
    }
    
    public function demo() {
        $this->data['title'] = 'Demo Team Profiles';
        $this->data['cms_content'] = $this->page_model->get_page('Demo-Team');
        $users = $this->user_model->with('canine')->order_by('last_name')->get_many_in('privacy', $this->privacy_options);
        
        if(!empty($users)) {
            foreach($users as $row) {
                if($row->demo_team == '1') {
                    $this->data['users'][] = $row;
                }
            }
        }
        
        $this->data['main'] = 'user/index';
        $this->load->view('demo_layout', $this->data);        
    }
   
}

?>
