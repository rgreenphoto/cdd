<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Site_info extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('site_info_model'));
        $this->load->helper(array('form', 'html5'));
        $this->load->library(array('form_validation', 'table'));
    }
    
    
    public function edit() {
        $this->data['title'] = 'Site Information';
        $id = $this->data['site_info']->id;
        
        $this->data['id'] = $id;
        $this->data['hidden'] = array('id' => $id);
        $this->data['attributes'] = array('class' => 'form-horizontal');
        $this->data['site'] = $this->site_info_model->get($id);
        
        
        $this->data['site_title'] = array(
            'id' => 'site_title',
            'name' => 'site_title',
            'value' => $this->data['site']->site_title
        );
        
        $this->data['site_name'] = array(
            'id' => 'site_name',
            'name' => 'site_name',
            'value' => $this->data['site']->site_name
        );
        $this->data['site_description'] = array(
            'id' => 'site_description',
            'name' => 'site_description',
            'value' => $this->data['site']->site_description,
            'rows' => 15,
            'cols' => 75
        );
        
        $this->data['site_url'] = array(
            'id' => 'site_url',
            'name' => 'site_url',
            'value' => $this->data['site']->site_url
        );
        
        $this->data['site_email'] = array(
            'id' => 'site_email',
            'name' => 'site_email',
            'value' => $this->data['site']->site_email
        
        );
        
        $this->form_validation->set_rules('site_title', 'Site Title', 'required');
        $this->form_validation->set_rules('site_name', 'Site Name', 'required');
        $this->form_validation->set_rules('site_description', 'Site Description', 'required');
        $this->form_validation->set_rules('site_url', 'Site URL', 'required');
        $this->form_validation->set_rules('site_email', 'Site Email', 'required');
        
        if($this->form_validation->run() === FALSE) {
            $this->data['main'] = 'admin/site_info/edit';
            $this->load->view('admin/layout', $this->data);
        } else {
            $options = array(
                'site_title' => $this->input->post('site_title'),
                'site_name' => $this->input->post('site_name'),
                'site_description' => $this->input->post('site_description'),
                'site_url' => $this->input->post('site_url'),
                'site_email' => $this->input->post('site_email')
            );
            
            if($this->site_info_model->update($id, $options)) {
                $this->session->set_flashdata('message', 'Site information saved.');
                redirect('admin/site_info/edit/'.$id);
            }
        }       
    }
   
}


?>
