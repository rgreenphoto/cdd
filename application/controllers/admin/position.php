<?php

/*
 * Russ Green rgreen@rgreenphotography.com
 */

class Position extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('position_model'));
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css', base_url().'/assets/css/bootstrap-datetimepicker.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js', base_url().'assets/js/moment.min.js', base_url().'assets/js/bootstrap-datetimepicker.min.js');
    }

    public function index() {
        $this->data['title'] = 'Volunteer Jobs';
        $this->data['positions'] = $this->position_model->get_all();
        $this->data['main'] = 'admin/position/index';
        $this->load->view('admin/layout', $this->data);
    }

    public function add() {
        $this->data['title'] = 'Add Position';
        $this->data['hidden'] = array();
        if(!empty($_POST)) {
            $options = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );

            if($this->position_model->insert($options)) {
                $this->session->set_flashdata('message', 'Record Saved');
                redirect('admin/position');
            }
        }
        $this->data['main'] = 'admin/position/edit';
        $this->load->view('admin/layout', $this->data);
    }    
    
    public function edit($id) {
        $this->data['title'] = 'Edit Position';
        
        $this->data['hidden'] = array('id' => $id);
        $this->data['position'] = $this->position_model->get($id);

        if(!empty($_POST)) {
           $options = $this->set_post_options($_POST);
           if($this->position_model->update($id, $options)) {
               $this->session->set_flashdata('message', 'Record updated');
               redirect('admin/position/edit/'.$id);
           } else {
               $this->session->set_flashdata('message', 'Could not update record');
               redirect('admin/position/edit/'.$id);
           }
            
        }
        $this->data['main'] = 'admin/position/edit';
        $this->load->view('admin/layout', $this->data); 
    }


    public function delete($id) {
        if(!empty($id)) {
            if($this->position_model->delete($id)) {
                $this->session->set_flashdata('message', 'Record Deleted');
                redirect('admin/position/');
            } else {
                $this->session->set_flashdata('message', 'Could not delete record.');
                redirect('admin/position/edit/'.$id);
            }
        } else {
            $this->session->set_flashdata('message', 'ID for this item is missing.');
            redirect('admin/position/edit/'.$id);
        }
    }
}


?>
