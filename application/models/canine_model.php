<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Canine_model extends MY_Model {

    
    public $_table = 'canine';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $sort = 'name';
    
    public $sort_dir = 'ASC';
    
    public $validate = array(
        array(
            'field' => 'user_id',
            'label' => 'User ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'date_of_birth',
            'label' => 'Date',
            'rules' => 'xss_clean'),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'breed',
            'label' => 'Breed',
            'rules' => 'xss_clean'),
        array(
            'field' => 'rescue',
            'label' => 'Rescue',
            'rules' => 'xss_clean'),
        array(
            'field' => 'rescue_group',
            'label' => 'Rescue Group',
            'rules' => 'xss_clean'),
        array(
            'field' => 'bio',
            'label' => 'Bio',
            'rules' => 'xss_clean'),
        array(
            'field' => 'image',
            'label' => 'Image',
            'rules' => 'xss_clean'),
        array(
            'field' => 'display_profile',
            'label' => 'Display Profile',
            'rules' => 'xss_clean'),
        array(
            'field' => 'show_rescue',
            'label' => 'Show Rescue',
            'rules' => 'xss_clean'),
        array(
            'field' => 'memorial',
            'label' => 'Memorial',
            'rules' => 'xss_clean')
    );
    
    public $before_create = array('created', 'modified', 'date');
    
    public $before_update = array('modified', 'date');
    
    public $after_get = array('convert_date', 'set_flags');
    
    public $belongs_to = array('user');
    
    public $has_many = array('competition_result');
    
    public function date($row) {
        if(is_object($row)) {
            if(!empty($row->date_of_birth)) {
                $row->date_of_birth = date('Y-m-d', strtotime($row->date_of_birth));
            }
        } else {
            if(!empty($row['date_of_birth'])) {
                $row['date_of_birth'] = date('Y-m-d', strtotime($row['date_of_birth']));
            }
        }
        return $row;
    }
    
    public function set_flags($row) {
        if(is_object($row)) {
            if(!empty($row->rescue)) {
                if($row->rescue == '0') {
                    $row->rescue = 'No';
                } else {
                    $row->rescue = 'Yes';
                }                
            }
        }
        return $row;
    }
    
    public function convert_date($row) {
        if(is_object($row)) {
            $row->age = '';
            if(!empty($row->date_of_birth)) {
                $row->age = $this->set_age($row->date_of_birth);
                $row->date_of_birth = date('m/d/Y', strtotime($row->date_of_birth));
            }
        } else {
            if(!empty($row['date_of_birth'])) {
                $row['date_of_birth'] = date('m/d/Y', strtotime($row['date_of_birth']));
            }
        }
        
        return $row;
    }
    
    private function set_age($dob) {
        return floor((time() - strtotime($dob)) / 31556926);
    }
    
    public function get_dogs($user_id) {
        $this->db->select('id, name');
        $this->db->where('user_id', $user_id);
        $this->db->where('deleted !=', '1');
        $this->db->order_by('name');
        $query = $this->db->get('canine');
        $result = $query->result();
        $data = array();
        if(!empty($result)) {
            $data[] = 'Please select dog';
            foreach($result as $row) {
                $data[$row->id] = $row->name;
            }
        }
        
        return $data;
    }
    
    public function add_image($canine_id, $image) {
        $data = array('image' => $image);
        $this->db->where('id', $canine_id);
        if($this->db->update('canine', $data)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function add_dogs($user_id, $dogs, $other_name) {
        $new_dogs = array();
        if(!empty($dogs)) {
            $i=0;
            foreach($dogs as $k=>$v) {
                $new_dogs[$i]['user_id'] = $user_id;
                $new_dogs[$i]['name'] = $v;
                $i++;
            }
        }
        if(!empty($other_name)) {
            $other['user_id'] = $user_id;
            $other['name'] = $other_name;
            array_push($new_dogs, $other);
        }
        if(!empty($new_dogs)) {
            try {
                $this->canine_model->insert_many($new_dogs);
                return true;
            } catch (Exception $ex) {
                echo '<pre>';
                print_r($ex);
                die();
            }
        }
    }
    
    public function import($sheet) {
        $this->load->model('user_model');
        if(!empty($sheet)) {
            foreach($sheet as $item) {
                //grab the user id
                if($item['A'] != '') {
                    $options = array('member_id' => $item['A']);
                    $user = $this->user_model->get_by($options);
                    $data = array(
                        'user_id' => $user->id,
                        'dog_id' => $item['B'],
                        'name' => $item['C'],
                        'breed' => $item['E'],
                        );
                    if($item['F'] == 'F') {
                        $data['gender'] = 'Female';
                    } else {
                        $data['gender'] = 'Male';
                    }
                    if(!empty($item['G'])) {
                        $data['date_of_birth'] = $item['G'];
                    }
//                    echo '<pre>';
//                    print_r($data);
//                    echo '</pre>';
                    if($this->canine_model->insert($data, TRUE)) {
                        $flag = true;
                    } else {
                        $flag = false;
                    }
                }
            }
            if($flag = true) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function import_add($name, $dog_id, $user_id) {
        $data = array('name' => $name, 'dog_id' => $dog_id, 'user_id' => $user_id);
        if($this->insert($data, true)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
}
?>
