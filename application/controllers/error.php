<?php

/*
 * Russ Green (russ@engrain.com)
 * 
 * 
 * 
 */

class Error extends Main_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->data['main'] = 'error-404';
        $this->data['title'] = 'The coolest page ever';
        $this->load->model('competition_model');
        $this->data['event'] = $this->competition_model->next_event();
        $this->load->view('secondary_layout', $this->data);
    }
}

?>
