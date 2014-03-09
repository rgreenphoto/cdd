<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Page_model extends MY_Model {
    
    public $_table = 'page';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'isHome',
            'label' => 'Home',
            'rules' => 'xss_clean'),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'description',
            'label' => 'Page Content',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'xss_clean'),
        array(
            'field' => 'start_date',
            'label' => 'Start Date',
            'rules' => 'xss_clean'),
        array(
            'field' => 'end_date',
            'label' => 'End Date',
            'rules' => 'xss_clean')
    );
    
    public $before_create = array('created', 'modified', 'slug');
    
    public $before_update = array('modified');
    
    public $after_get = array('convert_date');
    
    
    
    
    public function slug($row) {
        if(is_object($row)) {
            $row->slug = strtolower(url_title($this->input->post('name')));
        } else {
            $row['slug'] = strtolower(url_title($this->input->post('name')));
        }

        return $row;
    }
    
    
    public function convert_date($row) {
        $this->load->model('user_model');
        if(is_object($row)) {
            if(!empty($row->created)) {
                $row->created = date('m/d/Y g:s A', strtotime($row->created));
                $row->created_by = $this->user_model->get_username($row->created_by);
            }
            if(!empty($row->modified)) {
                $row->modified = date('m/d/Y g:s A', strtotime($row->modified));
                $row->modified_by = $this->user_model->get_username($row->modified_by);
            }
        } else {
            if(!empty($row['created'])) {
                $row['created'] = date('m/d/Y', strtotime($row['created']));
                $row['created_by'] = $this->user_model->get_username($row['created_by']);
            }
            if(!empty($row['modified'])) {
                $row['modified'] = date('m/d/Y g:s A', strtotime($row['modified']));
                $row['modified_by'] = $this->user_model->get_username($row['modified_by']);
            }
        }
        
        return $row;
    }
   
    
    public function get_select() {
        $this->db->select('id, name');
        $this->db->where('deleted', '0');
        $query = $this->db->get('page');
        $items = $query->result_array();
        $data = array('' => 'Please select...');
        if(!empty($items)) {
            foreach($items as $row) {
                $data[$row['id']] = $row['name'];
            }
        }
        
        return $data;
    }
    
    public function get_menu() {
        $this->db->select('id, name, slug');
        $this->db->where('deleted', '0');
        $this->db->where('automated', '0');
        $query = $this->db->get('page');
        $items = $query->result();
        return $items;
    }
    
    public function get_page($slug) {
        $this->db->where('slug', $slug);
        $query = $this->db->get('page');
        $page = $query->result();
        if($page) {
            return $page[0];
        } else {
            return false;
        }
        
    }
    
    
}

?>
