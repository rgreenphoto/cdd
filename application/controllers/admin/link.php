<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Link extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('link_model', 'link_type_model'));
        $this->load->library(array('table'));
    }
    
    public function index() {
        $this->data['title'] = 'Club Information';
        $this->data['clubs'] = $this->link_model->with('region')->with('link_type')->get_all();
        $this->data['main'] = 'admin/link/index';
        $this->load->view('admin/layout', $this->data);
        
    }
    
    public function add() {
        $this->data['title'] = 'Add Club';
        $this->data['hidden'] = array();
        $this->data['attributes'] = array();
        $this->data['link_types'] = $this->link_type_model->get_all();
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);
            if($this->link_model->insert($options)) {
                $this->session->set_flashdata('message', 'Club information saved.');
                redirect('admin/link');
            }
        }
        $this->data['main'] = 'admin/link/edit';
        $this->load->view('admin/layout', $this->data);        

    }
    public function edit($id) {
        $this->data['title'] = 'Edit Club';
        $this->data['hidden'] = array('id' => $id);
        $this->data['attributes'] = array();  
        $this->data['link'] = $this->link_model->get($id);
        $this->data['link_types'] = $this->link_type_model->get_all();
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);      
            if($this->link_model->update($id,$options)) {
                $this->session->set_flashdata('message', 'Club information saved.');
                redirect('admin/link');
            }            
        }
        $this->data['main'] = 'admin/link/edit';
        $this->load->view('admin/layout', $this->data);   
    }    
    
    public function delete($id) {
        if(!empty($id)) {
            if($this->link_model->delete($id)) {
                $this->session->set_flashdata('message', 'Record Deleted');
                redirect('admin/club');
            } else {
                $this->session->set_flashdata('message', 'Could not delete record.');
                redirect('admin/club');
            }
        } else {
            $this->session->set_flashdata('message', 'ID for this item is missing.');
            redirect('admin/club');
        }
    }    
    
}

?>
