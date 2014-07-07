<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Group_model extends MY_Model {
    var $_table = 'groups';
        
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'name',
            'label' => 'name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'required|xss_clean')
    );
    
    
    public function stats() {
        $this->db->select('groups.id, groups.description, groups.name');
        $this->db->select('(SELECT COUNT(user_id) FROM users_groups JOIN users ON (users.id = users_groups.user_id AND users.deleted != 1) WHERE users_groups.group_id = groups.id AND users_groups.user_id != 1) AS num_users');
        $query = $this->db->get('groups');
        return $query->result();
    } 
    
    public function get_members($group_id) {
        $this->db->select('users.*');
        $this->db->join('users_groups', 'users.id = users_groups.user_id');
        $this->db->where('users_groups.group_id', $group_id);
        $this->db->order_by('users.last_name');
        $query = $this->db->get('users');
        return $query->result();  
    }
    
    public function get_cup_members($member, $provisional) {
        $this->db->select('users.*');
        $this->db->join('users_groups', 'users.id = users_groups.user_id');
        $this->db->where('users.id !=', 1);
        $this->db->where_in('users_groups.group_id', array($member, $provisional));
        $this->db->order_by('users.last_name');
        $query = $this->db->get('users');
        return $query->result();  
    }    
    
    public function print_summary($group_id) {
        $users = $this->get_members($group_id);
        $data = array();
        if(!empty($users)) {
            $i=0;
            foreach($users as $row) {
                $data[$i]['last_name'] = $row->last_name;
                $data[$i]['first_name'] = $row->first_name;
                $data[$i]['email'] = $row->email;
                $data[$i]['membership_date'] = $row->membership_date;
                $i++;
            }
            
            
        }
        return $data;
        
    }
    
      
}
?>
