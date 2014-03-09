<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Points_guide_model extends MY_Model {

    
    public $_table = 'points_guide';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'place',
            'label' => 'Place',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'type',
            'label' => 'Type',
            'rules' => 'required|xss_clean'),        
        array(
            'field' => 'points',
            'label' => 'Points',
            'rules' => 'required|xss_clean')
    );
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');    
    
    public function get_select() {
        $data[''] = 'Please select...';
        $data['Open'] = 'Open';
        $data['Advanced'] = 'Advanced';
        $data['Intermediate'] = 'Intermediate';
        $data['Novice'] = 'Novice';
        return $data;
    }
    
    public function get_types() {
        return array('Open', 'Advanced', 'Intermediate', 'Novice');
    }
    
    public function get_points($type, $place) {
        $this->db->select('points_guide.points');
        $this->db->where('points_guide.type', $type);
        $this->db->where('points_guide.place', $place);
        $query = $this->db->get('points_guide');
        $points = $query->result();
        if(!empty($points[0])) {
            return $points[0]->points;
        } else {
            return '1';
        }
    }
    
    
}
?>
