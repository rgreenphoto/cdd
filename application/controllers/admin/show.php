<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Show extends Admin_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('show_model'));
        $this->load->library(array('form_validation'));
    }
    
    public function index() {
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        //get show
        $this->data['shows'] = $this->show_model->order_by('date')->get_all();
        $this->data['title'] = 'Demos & Shows';
        $this->data['main'] = 'admin/show/index';
        $this->load->view('admin/layout', $this->data);
    }
    
   public function add() {
       $this->data['title'] = 'Add Demo or Show';

       if(!empty($_POST)) {
           $options = $this->set_post_options($_POST);
           if($this->show_model->insert($options)) {
               $this->session->set_flashdata('message', 'Record Added');
               redirect('admin/show');
           }            
       }
       $this->data['main'] = 'admin/show/edit';
       $this->load->view('admin/layout', $this->data);       
   }

   public function edit($id) {
       $this->data['title'] = 'Edit Show';
       $this->data['show'] = $this->show_model->get($id);
       if(empty($this->data['show'])) {
           $this->session->set_flashdata('message', 'Could not find event. Please add one.');
           redirect('admin/show/add');
       }       
       
       if(!empty($_POST)) {
           $options = $this->set_post_options($_POST);
           if($this->show_model->update($id, $options)) {
               $this->session->set_flashdata('message', 'Record Updated');
               redirect('admin/show');
           }
       }
       $this->data['main'] = 'admin/show/edit';
       $this->load->view('admin/layout', $this->data);  
   }
   
    public function delete($id) {
        if(!empty($id)) {
            if($this->show_model->delete($id)) {
                $this->session->set_flashdata('message', 'Record Deleted');
                redirect('admin/show');
            } else {
                $this->session->set_flashdata('message', 'Could not delete record.');
                redirect('admin/show');
            }
        } else {
            $this->session->set_flashdata('message', 'ID for this item is missing.');
            redirect('admin/show');
        }
    }
}


