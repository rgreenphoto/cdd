<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Notification extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('notification_model', 'group_model'));
    }
    
    public function index() {
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        $this->data['title'] = 'Notification';
        //get messages
        $this->data['notifications'] = $this->notification_model->with('group')->get_all();
        $this->data['main'] = 'admin/notification/index';
        $this->load->view('admin/layout', $this->data);
    }
    
    public function add() {
        $this->data['title'] = 'Create Notification';
        $this->data['hidden'] = array();
        $this->data['groups'] = $this->group_model->stats();
        
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);
            if($this->notification_model->insert($options)) {
                $group_id = $options['group_id'];
                $notification_id = $this->db->insert_id();
                $this->_send_inbox($notification_id, $group_id);
                $this->session->set_flashdata('message', 'Notification Created');
                redirect('admin/notification');
            }             
        }
        $this->data['main'] = 'admin/notification/edit';
        $this->load->view('admin/layout', $this->data);        
    }
    
    private function _send_inbox($notification_id, $group_id) {
        $this->load->model('user_inbox_model');
        //grab all users based on group if set to 0, send to both members, general users and provisional members
        if($group_id != 0) {
            $users = $this->group_model->get_members($group_id);
            foreach($users as $user) {
                $n_options = array(
                    'notification_id' => $notification_id,
                    'user_id' => $user->id,
                    'date_sent' => date('Y-m-d H:i:s'));
                $this->user_inbox_model->insert($n_options);
                if($user->email_notifications == 1) {
                    $this->send_email($notification_id, $user->id, $user->email);
                }
            }            
        }        
    }
    
    public function test_email() {
        $this->_send_email('1', '431', 'russell.green@comcast.net');
    }
    
    
    private function _send_email($notification_id, $user_id, $email) {
        $this->load->library('email');
        //get contents of notification
        $message = $this->notification_model->get($notification_id);
        if(!empty($message) && !empty($email)) {
            $this->email->clear();
            $data['body'] = $message->body;
            $data['unsubscribe'] = base_url().'unsubscribe/'.$user_id;
            $body = $this->load->view('admin/notification/email', $data, true);
            $this->email->from('admin@coloradodiscdogs.com', 'Colorado Disc Dogs');
            $this->email->to($email);
            $this->email->subject($message->subject);
            $this->email->message($body);
            if($this->email->send()) {
                $data = array('user_id' => $user_id, 'notification_id' => $notification_id, 'date' => date('Y-m-d H:i:s'));
                $this->db->insert('email_stats', $data);
            } else {
                log_message('email', 'Could not send note '.$notification_id.' to user '.$user_id);
            }
        }
    }
      
}
?>
