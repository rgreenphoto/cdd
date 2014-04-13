<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Competition_model extends MY_Model {
    public $_table = 'competition';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'competition_type_id',
            'label' => 'Competition Type',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'event_id',
            'label' => 'Event ID',
            'rules' => 'xss_clean'),
        array(
            'field' => 'date',
            'label' => 'Date',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'season',
            'label' => 'Season',
            'rules' => 'xss_clean'),
        array(
            'field' => 'cup_points',
            'label' => 'Cup Points Eligible',
            'rules' => 'xss_clean'),        
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'event_description',
            'label' => 'Competition Description',
            'rules' => 'xss_clean'),
        array(
            'field' => 'external_reg_link',
            'label' => 'External Registration Link',
            'rules' => 'xss_clean'),
        array(
            'field' => 'registration_start',
            'label' => 'Registration Start Date',
            'rules' => 'xss_clean'),
        array(
            'field' => 'registration_end',
            'label' => 'Registration End Date',
            'rules' => 'xss_clean'),
        array(
            'field' => 'online_registration',
            'label' => 'Online Registration',
            'rules' => 'xss_clean'),
        array(
            'field' => 'discount',
            'label' => 'Discount',
            'rules' => 'xss_clean'),
        array(
            'field' => 'discount_percent',
            'label' => 'Discount Percent',
            'rules' => 'xss_clean'),         
        array(
            'field' => 'location',
            'label' => 'Location',
            'rules' => 'xss_clean'),
        array(
            'field' => 'lat_long',
            'label' => 'Latitude/Longitude',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hotel_name',
            'label' => 'Hotel Name',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hotel_description',
            'label' => 'Hotel Description',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hotel_addesss',
            'label' => 'Hotel Address',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hotel_city',
            'label' => 'Hotel City',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hotel_state',
            'label' => 'Hotel State',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hotel_zip',
            'label' => 'Hotel Zip',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hotel_phone',
            'label' => 'Hotel Phone',
            'rules' => 'xss_clean'),
        array(
            'field' => 'hotel_lat_long',
            'label' => 'Hotel Lat/Long',
            'rules' => 'xss_clean'),
        array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'xss_clean')
    );
    
    public $before_create = array('created', 'modified', 'date', 'lat_long', 'slug');
    
    public $before_update = array('modified', 'date', 'lat_long', 'slug');
    
    public $after_get = array('convert_date');
    
    public $has_many = array('competition_fee', 'registration', 'competition_result');
    
    public $belongs_to = array('competition_type');
    
    public function slug($row) {
        if(is_object($row)) {
            if(!empty($row->name) && !empty($row->date)) {
                $row->slug = strtolower(url_title($row->name.'-'.$row->date));
            }
        } else {
            if(!empty($row['name']) && !empty($row['date'])) {
                $row['slug'] = strtolower(url_title($row['name'].'-'.$row['date']));
            }
        }
        return $row;
    }
    
    
    public function date($row) {
        if(is_object($row)) {
            if(!empty($row->date)) {
                $row->date = date('Y-m-d', strtotime($row->date));
                
            }
        } else {
            if(!empty($row['date'])) {
                $row['date'] = date('Y-m-d', strtotime($row['date']));
            }
        }
        return $row;
    }
    
    public function lat_long($row) {
        if(is_object($row)) {
            if(!empty($row->lat_long)) {
                $row->lat_long = str_replace('(', '', str_replace(')', '', $row->lat_long));
            }
            if(!empty($row->hotel_lat_long)) {
               $row->hotel_lat_long = str_replace('(', '', str_replace(')', '', $row->hotel_lat_long)); 
            }
        } else {
            if(!empty($row['lat_long'])) {
                $row['lat_long'] = str_replace('(', '', str_replace(')', '', $row['lat_long']));
            }
            if(!empty($row['hotel_lat_long'])) {
                $row['hotel_lat_long'] = str_replace('(', '', str_replace(')', '', $row['hotel_lat_long']));
            }
        }
        return $row;
    }
    
    public function convert_date($row) {
        if(is_object($row)) {
            if(!empty($row->date)) {
                $row->convert_date = date('m/d/Y', strtotime($row->date));
                $row->long_date = date('l F jS Y', strtotime($row->date));         
            }
            $this->load->model('user_model');
            if(!empty($row->created)) {
                $row->created = (!empty($row->created) ? date('m/d/Y g:s A', strtotime($row->created)): '');
                //$row->created_by = (!empty($row->created_by) ? $this->user_model->get_username($row->created_by): '');
            }
            if(!empty($row->modified)) {
                $row->modified = date('m/d/Y g:s A', strtotime($row->modified));
                //$row->modified_by = (!empty($row->modified_by) ? $this->user_model->get_username($row->modified_by): '');
            }            
        } else {
            if(!empty($row['date'])) {
                $row['date'] = date('m/d/Y', strtotime($row['date']));
                $row['long_date'] = date('1 F js Y', strtotime($row['date']));
            }
        }
        return $row;
    }
    
    public function event_menu($competition_type = '') {
        $this->db->select('DISTINCT(season) as year');
        if(empty($competition_type)) {
            $this->db->where_not_in('competition_type_id', '6');
        } else {
            $this->db->where_in('competition_type_id', '6');
        }
        $this->db->order_by('season', 'desc');
        $query = $this->db->get('competition');
        return $query->result();
    }
    
    public function get_event($year) {
        $this->db->select('competition.*, competition_type.image');
        $this->db->where('season', $year);
        $this->db->join('competition_type', 'competition.competition_type_id = competition_type.id');
        $this->db->where('deleted', '0');
        $this->db->where_not_in('competition_type_id', array('6'));
        $this->db->order_by('date', 'asc');
        $query = $this->db->get('competition');
        return $query->result();
        
    }
    
    public function stats($limit = 1) {
        $this->db->select('competition.name AS name, competition.id, (SELECT COUNT(user_id) FROM registration WHERE registration.competition_id = competition.id AND registration.deleted = 0 ) AS num_user');
        $date = date('Y-m-d');
        $this->db->where('date >=', $date);
        $this->db->where('competition.deleted', '0');
        $this->db->where('competition.competition_type_id !=', 6);
        $this->db->order_by('date');
        $this->db->limit($limit);
        $query = $this->db->get('competition');
        return $query->result();
    }
    
    public function registered($id) {
        //get unique divisions
        $this->db->select('DISTINCT(division_id) as division_id');
        $this->db->where('competition_id', $id);
        $query = $this->db->get('registration');
        $division_id = $query->result();
        if(!empty($division_id)) {
            $i=0;
            foreach($division_id as $row) {
                $data = new stdClass();
                $this->db->select('name, id');;
                $this->db->where('id', $row->division_id);
                $query = $this->db->get('division');
                $division = $query->result();
                
                $this->load->model('registration_model');
                $options = array('division_id' => $row->division_id);
                $regs = $this->registration_model->with('canine')->with('user')->get_many_by($options);
                
                $comp = $this->competition_model->get($id);
                
                
                $data->id = $division[0]->id;
                $data->name = $division[0]->name;
                $data->competition = $comp;
                $data->registered = $regs;
            }
            return $data;
        }
    }
    
    public function next_event() {
        //$this->db->select('SELECT * FROM `competition` WHERE `date` >= CURDATE() AND deleted = 0 ORDER BY `date` LIMIT 1');
        $date = date('Y-m-d');
        $this->db->where('date >=', $date);
        $this->db->where('deleted', '0');
        $this->db->where('competition_type_id !=', 6);
        $this->db->order_by('date');
        $this->db->limit(1);
        $query = $this->db->get('competition');
        return $query->result();
    }
    
    
    public function import($sheet) {
        $this->load->model('competition_type_model');
        if(!empty($sheet)) {
            foreach($sheet as $item) {
                if(!empty($item['A']) && !empty($item['F'])) {
                    //grab competition type id
                    $options = array('name' => $item['F']);
                    $competition_type = $this->competition_type_model->get_by($options);
                    $data = array(
                        'competition_type_id' => $competition_type->id,
                        'event_id' => $item['A'],
                        'name' => $item['E'],
                        'date' => $item['C'],
                        'season' => $item['B']
                    );
                   if($this->competition_model->insert($data, TRUE)) {
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
    
}


?>
