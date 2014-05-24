<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Competition_type_model extends MY_Model {
    public $_table = 'competition_type';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'type',
            'label' => 'Type',
            'rules' => 'xss_clean'),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'image',
            'label' => 'Image',
            'rules' => 'xss_clean'),
        array(
            'field' => 'large_image',
            'label' => 'Large Image',
            'rules' => 'xss_clean'),
        array(
            'field' => 'multiplier',
            'label' => 'Freestyle Multiplier',
            'rules' => 'xss_clean'),        
        array(
            'field' => 'freestyle_labels',
            'label' => 'Freestyle Labels',
            'rules' => 'xss_clean')        
    );
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public $has_many = array('division');
    
    
    public function get_select() {
        $query = $this->db->get('competition_type');
        $result = $query->result();
        $data[] = 'Please Select...';
        if(!empty($result)) {
            foreach($result as $row) {
                $data[$row->id] = $row->name;
            }
        }
        
        return $data;
    }
    
    public function set_labels($competition_type_id) {
        $ct = $this->get($competition_type_id);
        $return = array();
        if(!empty($ct->tc_labels)) {
            $tc_labels = explode(',', $ct->tc_labels);
            //always add FF = Foot Fault
            //always add NC = No Catch
            $return['tc_labels']['airbonus'] = $ct->tc_airbonus;
            $return['tc_labels']['no_catch_group'] = array('0' => 'NC', '1' => 'FF');
            $return['tc_labels']['catch_group'] = array();
            //if out of bounds set add it to options
            if($ct->tc_outofbounds == 1) {
                array_push($return['tc_labels']['no_catch_group'], 'OB');
            }
            foreach($tc_labels as $label) {
                array_push($return['tc_labels']['catch_group'], $label);
            }
        }
        if(!empty($ct->freestyle_labels)) {
            $return['fs_labels'] = explode(',', $ct->freestyle_labels);
        }
        return $return;
    }
    
    
    
}


?>
