<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Disc_order_model extends MY_Model {
    public $_table = 'disc_order';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'user_id',
            'label' => 'User',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'disc_type_id',
            'label' => 'Disc Type',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'color',
            'label' => 'Disc Color',
            'rules' => 'xss_clean'),
        array(
            'field' => 'total_discs',
            'label' => '# of Discs',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'total',
            'label' => 'Total Dollar Amount',
            'rules' => 'xss_clean')
    );
    
    public $belongs_to = array('user', 'disc_type');
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public function stats($user_id, $season) {
        $return = new stdClass();
        $this->db->select_sum('total_discs');
        $this->db->select_sum('total');
        $this->db->where('user_id', $user_id);
        $this->db->where('season', $season);
        $query = $this->db->get('disc_order');
        $result = $query->result();
        if(!empty($result[0]->total_discs)) {
            $return->total_discs = $result[0]->total_discs;
        }
        if(!empty($result[0]->total)) {
            $return->total = $result[0]->total;
        }
        return $return;
        
    }
    
}


?>
