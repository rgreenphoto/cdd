<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Points_guide extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('points_guide_model'));
        $this->load->helper(array('form'));
        $this->load->library(array('table'));
    }
    
    
    public function index($type = '') {
        empty($type)? $type = 'Open': $type;
        
        $this->data['title'] = 'Add Points';
        $this->data['attributes'] = array('class' => 'form-horizontal');
        $this->data['hidden'] = array('type' => $type);
        
        $this->data['type'] = $type;
        $this->data['types'] = $this->points_guide_model->get_types();
        
        $this->data['current'] = $this->points_guide_model->order_by('place')->get_many_by(array('type' => $type));
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);
            if($this->points_guide_model->insert($options)) {
                $this->session->set_flashdata('message', 'Record Added');
                redirect('admin/points_guide');
            } else {
                $this->session->set_flashdata('message', 'Could not save record.');
                redirect('admin/points_guide');
            }
        }
        
        $this->data['main'] = 'admin/points_guide/index';
        $this->load->view('admin/layout', $this->data);
    }
    
    public function delete($id) {
        if(!empty($id)) {
            if($this->points_guide_model->delete($id)) {
                $this->session->set_flashdata('message', 'Record deleted.');
                redirect('admin/points_guide');
            } else {
                $this->session->set_flashdata('message', 'Could not delete record.');
                redirect('admin/points_guide');
            }
        } else {
            $this->session->set_flashdata('message', 'No record could be found');
            redirect('admin/points_guide');
        }
    }
}
?>
