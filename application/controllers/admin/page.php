<?php

/*
 * Russ Green rgreen@rgreenphotography.com
 */


class Page extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('page_model'));
        $this->load->helper(array('form', 'string'));
        $this->load->library(array('table')); 
        
    }
    
    
    public function index() {
        $this->data['title'] = 'Site Content';
        $this->data['contents'] = $this->page_model->get_all();
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');        
        $this->data['main'] = 'admin/page/index';
        $this->load->view('admin/layout', $this->data);        
        
        
    }
    
    public function add() {
        $this->data['title'] = 'Add Content';
        $this->data['hidden'] = array();        
        if(!empty($_POST)) {
            $options = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            
            if($this->page_model->insert($options)) {
                $this->session->set_flashdata('message', 'Record Saved');
                redirect('admin/page');
            }         
        }
        $this->data['main'] = 'admin/page/edit';
        $this->load->view('admin/layout', $this->data);              
    }
    
    
    public function edit($id) {
        $this->data['title'] = 'Edit Content';
        $this->data['id'] = $id;
        $this->data['hidden'] = array('id' => $id);
        $this->data['page'] = $this->page_model->with('user')->get($id);        
        if(!empty($_POST)) {
            $options = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            
            if($this->page_model->update($id, $options)) {
                $this->session->set_flashdata('message', 'Record Saved');
                redirect('admin/page');
            }            
        } else {
            $this->data['main'] = 'admin/page/edit';
            $this->load->view('admin/layout', $this->data);             
        }  
        
    }
    
    public function delete($id) {
        if(!empty($id)) {
            if($this->page_model->delete($id)) {
                $this->session->set_flashdata('message', 'Record Deleted');
                redirect('admin/page');
            } else {
                $this->session->set_flashdata('message', 'Could not delete record.');
                redirect('admin/page');
            }
        } else {
            $this->session->set_flashdata('message', 'ID for this item is missing.');
            redirect('admin/page');
        }
    } 
    
}
?>
