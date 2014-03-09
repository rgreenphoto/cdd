<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Poll extends Member_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('poll_model', 'poll_response_model'));
        
    }
    
    public function response($id) {
        $this->data['title'] = 'Polls';
        $this->data['poll'] = $this->poll_model->get($id);
        //check user response
        $data = array('user_id' => $this->the_user->id, 'poll_id' => $id);
        $this->data['response'] = $this->poll_response_model->get_by($data);
        // get totals
        $this->data['poll_response'] = $this->poll_response_model->calculate($id);
        
        $this->data['main'] = 'poll/response';
        $this->load->view('secondary_layout', $this->data); 
    }
    
}
?>
