<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Region_model extends MY_Model {
    public $_table = 'region';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');

    public $validate = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'description',
            'label' => 'Club Info',
            'rules' => 'required|xss_clean')
    );
    
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public function get_select() {
        $this->db->select('id, name');
        $query = $this->db->get('region');
        $result = $query->result();
        $data[''] = 'Please select...';
        if(!empty($result)) {
            foreach($result as $row) {
                $data[$row->id] = $row->name;
            }
        }
        
        return $data;
    }
    
    
}

?>