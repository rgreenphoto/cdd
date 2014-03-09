<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Link_model extends MY_Model {
    public $_table = 'link';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'link_type_id',
            'label' => 'Category',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'region_id',
            'label' => 'Region',
            'rules' => 'xss_clean'),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'url',
            'label' => 'URL',
            'rules' => 'xss_clean'),
        array(
            'field' => 'description',
            'label' => 'Club Info',
            'rules' => 'required|xss_clean')
    );
    
    public $belongs_to = array('region', 'link_type');
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    

    
    public function get_select() {
        $this->db->select('id, name');
        $query = $this->db->get('club');
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
