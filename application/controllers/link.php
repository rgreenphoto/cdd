<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Link extends Public_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('link_model');
        
    }
    
    
    public function index() {
        $this->data['pages'] = $this->link_model->order_by('name')->get_all();
        $this->data['title'] = 'Clubs';
        $this->data['main'] = 'link/index';
        $this->load->view('photo_layout', $this->data);            
    }
    
    
}
?>
