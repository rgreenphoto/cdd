<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Notification extends Member_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('user_inbox_model'));
        $this->data['display_social'] = false;
    }
    
    public function index() {
        $user_id = $this->data['the_user']->id;
        $this->data['title'] = 'Messages';
        $this->data['messages'] = $this->user_inbox_model->with('notification')->order_by('date_sent', 'DESC')->get_many_by(array('user_id' => $user_id));
        $this->data['main'] = 'user/notifications';
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js');
        $this->load->view('secondary_layout', $this->data);
    }
    
    public function mark_read($id) {
        //set fail message overwrite on success
        $json_array['message'] = 'Could not update.';
        $message = $this->user_inbox_model->get($id);
        $message->read = 1;
        unset($message->created);
        unset($message->created_by);
        unset($message->date_sent);
        if($this->user_inbox_model->update($id, $message)) {
            $json_array['message'] = 'Updated';
            $json_array['unread_messages'] = $this->user_inbox_model->get_unread($this->data['the_user']->id);
        }
        echo json_encode($json_array);
    }
    
    public function delete($id) {
        if($this->user_inbox_model->delete($id)) {
               $this->session->set_flashdata('message', 'Message Deleted');
               redirect('notification');
        } else {
               $this->session->set_flashdata('message', 'Could not delete message');
               redirect('notification');
        }
    }
    
}
?>
