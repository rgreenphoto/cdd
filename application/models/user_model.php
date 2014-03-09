<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class User_model extends MY_Model {
    
    var $_table = 'users';
        
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'username',
            'label' => 'username',
            'rules' => 'xss_clean'),
        array(
            'field' => 'first_name',
            'label' => 'First name',
            'rules' => 'xss_clean'),
        array(
            'field' => 'last_name',
            'label' => 'Last name',
            'rules' => 'xss_clean'),
        array(
            'field' => 'full_name',
            'label' => 'Full name',
            'rules' => 'xss_clean'),
        array(
            'field' => 'formal_name',
            'label' => 'Formal name',
            'rules' => 'xss_clean'),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'valid_email|xss_clean'),
        array(
            'field' => 'email_notifications',
            'label' => 'Email Notifications',
            'rules' => 'xss_clean'),
        array(
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'xss_clean'),
        array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'xss_clean'
        ),
        array(
            'field' => 'city',
            'label' => 'City',
            'rules' => 'xss_clean'
        ),
        array(
            'field' => 'state',
            'label' => 'State',
            'rules' => 'xss_clean'
        ),
        array(
            'field' => 'zip',
            'label' => 'Zip',
            'rules' => 'xss_clean'
        ),
        array(
            'field' => 'member_bio',
            'label' => 'Member Bio',
            'rules' => 'xss_clean'),
        array(
            'field' => 'privacy',
            'label' => 'Privacy',
            'rules' => 'xss_clean'),
        array(
            'field' => 'teaser',
            'label' => 'Teaser',
            'rules' => 'xss_clean'),
        array(
            'field' => 'terms',
            'label' => 'Terms',
            'rules' => 'xss_clean'),
        array(
            'field' => 'profile_image',
            'label' => 'Profile Image',
            'rules' => 'xss_clean'),
        array(
            'field' => 'membership_date',
            'label' => 'Membership date',
            'rules' => 'xss_clean'),
        array(
            'field' => 'rookie_year',
            'label' => 'Rookie Year',
            'rules' => 'xss_clean'
        ),
        array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'xss_clean'
        )
    );
    
    
    public $before_create = array('name_formats', 'member','created', 'modified');
    
    public $before_update = array('name_formats','modified');
    
    public $has_many = array('canine', 'competition_result', 'standing');
    
    
    public function name_formats($row) {
        if(is_object($row)) {
            if(!empty($row->first_name) && !empty($row->last_name)) {
                $row->formal_name = $row->last_name.', '.$row->first_name;
                $row->full_name = $row->first_name.' '.$row->last_name;
            } 
        } else {
            if(!empty($row['first_name']) && !empty($row['last_name'])) {
                $row['formal_name'] = $row['last_name'].', '.$row['first_name'];
                $row['full_name'] = $row['first_name'].' '.$row['last_name'];
            }
        }
        return $row;
    }
    
    
    public function get_username($id) {
        $this->db->select('username, first_name, last_name');
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        $result = $query->result();
        return $result[0]->first_name.' '.$result[0]->last_name;
    }
    
    public function member($row) {
        if(is_object($row)) {
            $row->member_id = $this->get_next_member_id();
        }
        return $row;
    }
    
    public function get_next_member_id() {
        $this->db->select_max('member_id', 'member_id');
        $query = $this->db->get('users');
        return $query->result();
    }
    
    public function add_to_group($user_id, $group_id) {
        $options = array('user_id' => $user_id, 'group_id' => $group_id);
        if($this->db->insert('users_groups', $options)) {
            return true;
        }
        return false;
    }

    public function import($sheet) {
        if(!empty($sheet)) {
            foreach($sheet as $item) {                
                if(!empty($item['A'])) {
                    $data['member_id'] = $item['A'];
                    $data['first_name'] = $item['B'];
                    $data['last_name'] = $item['C'];
                    $data['address'] = $item['D'];
                    $data['city'] = $item['E'];
                    $data['state'] = $item['F'];
                    $data['zip'] = $item['G'];
                    if($item['I'] != '0' && $item['I'] != '') {
                        $data['family_id'] = $item['I'];
                    } else {
                        $data['family_id'] = NULL;
                    }
                    $data['phone'] = $item['J'];
                    $data['cell_phone'] = $item['K'];
                    $data['email'] = $item['L'];
                   if($this->user_model->insert($data, TRUE)) {
                       $user_id = $this->db->insert_id();
                       if($item['H'] == '0') {
                           $group_id = '3';
                       } else {
                           $group_id = '2';
                       }
                       $groups = array(
                           'user_id' => $user_id,
                           'group_id' => $group_id
                       );
                       if($this->db->insert('users_groups', $groups)) {
                           $flag = true;
                       } else {
                           $flag = false;
                       }
                   } else {
                       $flag = false;
                   }
                }
            }
            if($flag == true) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function import_add($name, $member_id) {
        $name_array = explode(' ', $name);
        $first_name = $name_array[0];
        $last_name = $name_array[1];
        $data = array('first_name' => $first_name, 'last_name' => $last_name, 'member_id' => $member_id);
        if($this->insert($data, true)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    public function unsubscribe($user_id) {
        if(!empty($user_id)) {
            $data = array('email_notifications' => 0);
            $this->db->where('id', $user_id);
            if($this->db->update('users', $data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function get_count($group_id) {
        $this->db->from('users');
        $this->db->join('users_groups', "users_groups.user_id = users.id AND users_groups.group_id = {$group_id}");
        $this->db->join('groups', "groups.id = users_groups.group_id");
        $this->db->where('users.id !=', '1');
        return $this->db->count_all_results();
    }
    
    public function quick_search($term) {
        $terms = explode(' ', $term);
        $this->db->select('id, first_name, last_name');
        $this->db->from('users USE INDEX(full_name) ');
        $this->db->like('full_name', $term);
        $this->db->order_by('last_name');
        $query = $this->db->get();
        $result = $query->result();
        if(!empty($result)) {
            return $result;
        }
        return false;
    }
    
    public function quick_add($options) {
           $data = array(
               'first_name' => $options['first_name'],
               'last_name' => $options['last_name'],
               'email' => $options['email']);
           if($this->user_model->insert($data)) {
               $id = $this->db->insert_id();
               //add user to group default to General User / if memeber, update user record after
               $group_data = array(
                   'user_id' => $id,
                   'group_id' => '2'
               );
               $this->db->insert('users_groups', $group_data);

               $canine_data  = array(
                   'name' => $options['canine'],
                   'user_id' => $id);
               if($this->canine_model->insert($canine_data)) {
                   $canine_id = $this->db->insert_id();
               }
           }
    }
    
    
    public function get_by_group($group_id, $limit, $offset) {
        $this->db->select('users.*, groups.description', TRUE);
        $this->db->from('users');
        $this->db->join('users_groups', "users_groups.user_id = users.id AND users_groups.group_id = {$group_id}");
        $this->db->join('groups', "groups.id = users_groups.group_id");
        $this->db->where('users.id !=', '1');
        $this->db->order_by('users.last_name');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $result = $query->result();
        if(!empty($result)) {
            return $result;
        }
        return false;
    }
    
    
}

?>
