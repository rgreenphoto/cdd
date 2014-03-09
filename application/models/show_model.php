<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Show_model extends MY_Model {
    public $_table = 'shows';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'name',
            'label' => 'Show Title',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'description',
            'label' => 'Show Description',
            'rules' => 'xss_clean'),
        array(
            'field' => 'date',
            'label' => 'Show Date',
            'rules' => 'required|xss_clean'),         
        array(
            'field' => 'location',
            'label' => 'Location',
            'rules' => 'xss_clean'),
        array(
            'field' => 'lat_long',
            'label' => 'Latitude/Longitude',
            'rules' => 'xss_clean'),
        array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'xss_clean')
    );
    
    public $before_create = array('created', 'modified', 'date', 'lat_long', 'slug');
    
    public $before_update = array('modified', 'date', 'lat_long');
    
    public $after_get = array('convert_date');
    
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
                $row->date = date('m/d/Y', strtotime($row->date));
                $row->long_date = date('l F jS Y', strtotime($row->date));         
            }
            $this->load->model('user_model');
            if(!empty($row->created)) {
                $row->created = (!empty($row->created) ? date('m/d/Y g:s A', strtotime($row->created)): '');
                $row->created_by = (!empty($row->created_by) ? $this->user_model->get_username($row->created_by): '');
            }
            if(!empty($row->modified)) {
                $row->modified = date('m/d/Y g:s A', strtotime($row->modified));
                $row->modified_by = (!empty($row->modified_by) ? $this->user_model->get_username($row->modified_by): '');
            }            
        } else {
            if(!empty($row['date'])) {
                $row['date'] = date('m/d/Y', strtotime($row['date']));
                $row['long_date'] = date('1 F js Y', strtotime($row['date']));
            }
        }
        return $row;
    }
    
    
}


?>
