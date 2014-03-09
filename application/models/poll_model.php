<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Poll_model extends MY_Model {
    public $_table = 'poll';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'start_date',
            'label' => 'Start Date',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'end_date',
            'label' => 'End Date',
            'rules' => 'required|xss_clean')
    );
    
    public $has_many = array('poll_option', 'poll_response');

    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public $after_get = array('date');
    
    public function date($row) {
        if($row->start_date) {
            $row->start_date_pretty = date('m/d/Y', strtotime($row->start_date));
        }
        if($row->end_date) {
            $row->end_date_pretty = date('m/d/Y', strtotime($row->end_date));
        }
        $this->load->model('user_model');
        if(!empty($row->created)) {
            $row->created = date('m/d/Y g:s A', strtotime($row->created));
            $row->created_by = $this->user_model->get_username($row->created_by);
        }
        if(!empty($row->modified)) {
            $row->modified = date('m/d/Y g:s A', strtotime($row->modified));
            $row->modified_by = $this->user_model->get_username($row->modified_by);
        }          
        return $row;
    }
    
    public function get_active() {
        $date = date('Y-m-d');
        $this->db->where('end_date >=', $date);
        $this->db->limit(1);
        $query = $this->db->get('poll');
        return $query->result();        
    }
    
    public function get_stats($limit = 1) {
        $this->load->model('poll_response_model');
        $this->db->limit($limit);
        $query = $this->db->get('poll');
        $polls = $query->result();

        if(!empty($polls)) {
            $i=0;
            foreach($polls as $poll) {
                $stats[$i] = new stdClass();
                $stats[$i]->name = $poll->name;
                $stat = $this->poll_response_model->calculate($poll->id);
                if(!empty($stat)) {
                    $stats[$i]->stats = $stat;
                }
                $i++;
            }
        }
        return $stats;
    }
      
}


?>
