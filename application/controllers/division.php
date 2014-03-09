<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Division extends Main_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('division_model', 'competition_model'));
    }
    
    public function get_divisions() {
        $competition_id = $this->input->post('competition_id');
        $competition = $this->competition_model->get($competition_id);
        $competition_type_id = $competition->competition_type_id;
        if(!empty($competition_type_id)) {
            $options = array('competition_type_id' => $competition_type_id);
            $divisions = $this->division_model->get_many_by($options);
        }
        if(!empty($divisions)) {
          echo json_encode($divisions);
        } else {
          $error = 'Could not find dogs';
          echo json_encode($error);
        }        
  
    }
}

?>
