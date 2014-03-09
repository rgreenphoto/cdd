<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Poll_response extends Member_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('poll_response_model'));
    }
    
    public function respond() {
        $poll_id = $this->input->post('poll_id');
        $user_id = $this->input->post('user_id');
        $poll_option_id = $this->input->post('response');
        $existing_id = $this->input->post('existing_id');

        $data = array(
            'poll_id' => $poll_id,
            'user_id' => $user_id,
            'poll_option_id' => $poll_option_id
        );
        if(!empty($existing_id)) {
            if($this->poll_response_model->update($existing_id, $data)) {
                $responses['existing_id'] = $existing_id;
            }
        } else {
            if($this->poll_response_model->insert($data)) {
                $responses['existing_id'] = $this->db->insert_id();
            }
        }
        //grab existing responses
        $responses['results'] = $this->poll_response_model->calculate($poll_id);
        echo json_encode($responses);
    }
}
?>
