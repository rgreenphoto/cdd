<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Division_model extends MY_Model {

    
    public $_table = 'division';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'name',
            'label' => 'Division Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'competition_type_id',
            'label' => 'Competition Type',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'points_type',
            'label' => 'Points Category',
            'rules' => 'xss_clean'),
        array(
            'field' => 'template',
            'label' => 'Template',
            'rules' => 'xss_clean'),
        array(
            'field' => 'freestyle',
            'label' => 'Freestyle Division',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'categories',
            'label' => 'Freestyle Categories',
            'rules' => 'xss_clean'),
        array(
            'field' => 'dual',
            'label' => 'Dual',
            'rules' => 'xss_clean')        
    );
    
    public $has_many = array('competition_fee', 'competition_result');
    public $belongs_to = array('competition_type');
    
    public function get_list($competition_type_id) {
        $divisions = $this->get_many_by(array('competition_type_id' => $competition_type_id));
        $data = array();
        if(!empty($divisions)) {
            $data[''] = 'Select Division';
            foreach($divisions as $row) {
                if($row->dual != 2) {
                    $data[$row->id] = $row->name;
                }
            }
        }
        return $data;
    }
    public function get_full_list($competition_type_id) {
        $divisions = $this->get_many_by(array('competition_type_id' => $competition_type_id));
        $data = array();
        if(!empty($divisions)) {
            $data[''] = 'Select Division';
            foreach($divisions as $row) {
                $data[$row->id] = $row->name;
            }
        }
        return $data;
    }       
    
    
}
?>
