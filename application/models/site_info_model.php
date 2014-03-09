<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Site_info_model extends MY_Model {
    public $_table = 'site';
    
    protected $soft_delete = TRUE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'site_title',
            'label' => 'Site Title',
            'rules' => 'xss_clean'),
        array(
            'field' => 'site_name',
            'label' => 'Site name',
            'rules' => 'xss_clean'),
        array(
            'field' => 'site_description',
            'label' => 'Site Description',
            'rules' => 'xss_clean'),
        array(
            'field' => 'site_terms',
            'label' => 'Site Term and Conditions',
            'rules' => 'xss_clean'),
        array(
            'field' => 'site_url',
            'label' => 'Site URL',
            'rules' => 'xss_clean'),
        array(
            'field' => 'site_email',
            'label' => 'Site Email',
            'rules' => 'xss_clean')
    );
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');    
    
    
    
    public function get_site() {
        $query = $this->db->get('site');
        return $query->row();
    }
    
    
    
}


?>
