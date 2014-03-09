<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Page extends Public_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('page_model');
        
    }
    
    
    public function index($slug = '') {
        if(!empty($slug)) {
            $options = array('slug' => $slug);
            $this->data['page_content'] = $this->page_model->get_by($options);
            if(!empty($this->data['page_content'])) {
                $this->data['title'] = $this->data['page_content']->name;
                $this->data['main'] = 'page/index';
                $this->load->view('photo_layout', $this->data);                 
            } else {
                redirect('404');
            }
           
            
        } else {
            
            $this->load->view('layout', $this->data);
        }
    }
    
    public function unsubscribe($user_id) {
        if(!empty($user_id)) {
            $this->load->model('user_model');
            if($this->user_model->unsubscribe($user_id)) {
                $this->data['message'] = 'You have been unsubscribed';
            } else {
                $this->data['message'] = 'Could not unsubscribe, please contact admin@coloradodiscdogs.com';
            }
        } else {
            $this->data['message'] = 'No proper user provided';
        }
        $this->data['main'] = 'user/unsubscribe';
        $this->load->view('secondary_layout', $this->data);
    }
}
?>
