<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Poll extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('poll_model', 'poll_option_model', 'poll_response_model'));
    }
    
    public function index() {
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        //get polls
        $polls = $this->poll_model->get_all();
        if(!empty($polls)) {
            $i=0;
            foreach($polls as $poll) {
                $this->data['polls'][$i] = $poll;
                $this->data['polls'][$i]->results = $this->poll_response_model->calculate($poll->id);
                $i++;
            }
        }
        $this->data['main'] = 'admin/poll/index';
        $this->load->view('admin/layout', $this->data);
    }
    
    
    public function add() {
        $this->data['title'] = 'Add Poll';
        $this->data['hidden'] = array();
        
        if(!empty($_POST)) {
            if(empty($_POST['poll_options'][0]) && empty($_POST['poll_options'][1])) {
                $this->data['error_message'] = 'Please select at least two responses';
            } else {
                $options = $this->set_post_options($_POST);
                if($this->poll_model->insert($options)) {
                    foreach($_POST['poll_options'] as $option) {
                        $data[] = array('poll_id' => $this->db->insert_id(), 'text' => $option);
                    }
                    if($this->poll_option_model->insert_many($data)) {
                        $this->session->set_flashdata('message', 'Poll saved.');
                        redirect('admin/poll');                        
                    }
                }                
            }            
        }
        $this->data['main'] = 'admin/poll/edit';
        $this->load->view('admin/layout', $this->data);        
    }
    
    public function edit($id) {
        $this->data['title'] = 'Edit Poll';
        $this->data['hidden'] = array('id' => $id);
        $this->data['poll'] = $this->poll_model->with('poll_option')->get($id);
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);
            if($this->poll_model->update($_POST['id'], $options)) {
                if(!empty($_POST['poll_options'])) {
                    foreach($_POST['poll_options'] as $option) {
                        $data[] = array('poll_id' => $_POST['id'], 'text' => $option);
                    }
                    if($this->poll_option_model->insert_many($data)) {
                        $this->session->set_flashdata('message', 'Poll saved.');                        
                    }                    
                }
                $this->session->set_flashdata('message', 'Poll Saved');
                redirect('admin/poll');
            }           
        }
        $this->data['main'] = 'admin/poll/edit';
        $this->load->view('admin/layout', $this->data);        
    }
    
    public function updateOption() {
        $message['message'] = 'No option to update.';
        $options = $this->set_post_options($_POST);
        if(!empty($options)) {
            if($this->poll_option_model->update($_POST['id'], $options, true)) {
                $message['message'] = 'Option Updated';
            } else {
                $message['message'] = 'Could not update option. Please try again.';
            }
        }
        
        echo json_encode($message);
    }
    
    public function deleteOption() {
        $message['message'] = 'No option to delete';
        if(!empty($_POST['id'])) {
            if($this->poll_option_model->delete($_POST['id'])) {
                $message['message'] = 'Option Deleted';
            } else {
                $message['message'] = 'Could not delete option. Please try again.';
            }
        }
        echo json_encode($message);
    }
    
    
}
?>
