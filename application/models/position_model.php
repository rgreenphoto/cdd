<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Position_model extends MY_Model {
    public $_table = 'position';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'name',
            'label' => 'Position Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'description',
            'label' => 'Position Description',
            'rules' => 'xss_clean')
    );
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    //public $after_get = array('convert_date');
    
    public $has_many = array('event_helpers');

    public $belongs_to = array('user', 'position',  'competition');
    
}


?>
