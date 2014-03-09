<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Poll_option_model extends MY_Model {
    public $_table = 'poll_options';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array();
    
    public $validate = array(
        array(
            'field' => 'poll_id',
            'label' => 'Poll ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'text',
            'label' => 'Answer',
            'rules' => 'required|xss_clean')
    );
    
    public $belongs_to = array('poll');
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
      
}


?>
