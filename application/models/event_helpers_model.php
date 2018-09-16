<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Event_helpers_model extends MY_Model {
    public $_table = 'event_helpers';

    protected $soft_delete = FALSE;

    public $protected_attributes = array('id');

    public $validate = array(
        array(
            'field' => 'competition_id',
            'label' => 'Competition ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'user_id',
            'label' => 'User ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'position_id',
            'label' => 'Position',
            'rules' => 'required|xss_clean')
    );

    public $before_create = array('created', 'modified');

    public $before_update = array('modified');

    public $belongs_to = array('user', 'position', 'competition');

}


?>