<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class User_inbox_model extends MY_Model {
    public $_table = 'user_inbox';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'user_id',
            'label' => 'User',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'notification_id',
            'label' => 'Notification',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'date_sent',
            'label' => 'Date Sent',
            'rules' => 'xss_clean'),
        array(
            'field' => 'read',
            'label' => 'Read',
            'rules' => 'xss_clean')
    );
    
    public $belongs_to = array('notification', 'user');

    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public $after_get = array('date');
    
    public function date($row) {
        $this->load->model('user_model');
        if(!empty($row->created)) {
            $row->created = date('m/d/Y g:s A', strtotime($row->created));
            $row->created_by = $this->user_model->get_username($row->created_by);
        }
        if(!empty($row->modified)) {
            $row->modified = date('m/d/Y g:s A', strtotime($row->modified));
            $row->modified_by = $this->user_model->get_username($row->modified_by);
        }
        if(!empty($row->date_sent)) {
            $row->date_sent = date('F j, Y, g:i a', strtotime($row->date_sent));
        }
        return $row;
    }
    
    public function get_unread($user_id) {
        $count = $this->count_by(array('user_id' => $user_id, 'read' => '0'));
        return $count;
    }
      
}


?>
