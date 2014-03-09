<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Competition_fee_model extends MY_Model {
    public $_table = 'competition_fee';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'competition_id',
            'label' => 'Competition ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'division_id',
            'label' => 'Division ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'fee',
            'label' => 'Competition Description',
            'rules' => 'required|xss_clean')
    );
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public $after_get = array('lookup');
    
    
    public function lookup($row) {
        //check for division ID 
        if(is_object($row)) {
            if(!empty($row->division_id)) {
                $this->db->select('name');
                $this->db->where('id', $row->division_id);
                $query = $this->db->get('division');
                $result = $query->result();
                if(!empty($result)) {
                    $row->name = $result[0]->name;
                }
            }
        }
        
        return $row;
    }
    
    
    
}


?>
