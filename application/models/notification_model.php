<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Notification_model extends MY_Model {
    public $_table = 'notification';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'group_id',
            'label' => 'Group',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'body',
            'label' => 'Body',
            'rules' => 'required|xss_clean')
    );
    
    
    public $belongs_to = array('group');

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
        return $row;
    }
    
    
    public function getStats() {
        $this->load->model(array('message_category_model', 'message_status_model'));
        $categories = $this->message_category_model->get_all();
        $return = array();
        if(!empty($categories)) {
            foreach($categories as $category) {
                $options = array('message_category_id' => $category->id);
                $count = $this->count_by($options);
                $array['count'] = $count;
                $array['category'] = $category->name;
                $array['message_category_id'] = $category->id;
                $return[] = $array;
            }
        }
        return $return;
    }
    
    public function getByCategory($message_category_id) {
        $options = array('message_category_id' => $message_category_id);
        $messages = $this->order_by('created', 'DESC')->get_many_by($options);
        return $messages;
    }

      
}


?>
