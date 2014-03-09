<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Poll_response_model extends MY_Model {
    public $_table = 'poll_response';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array();
    
    public $validate = array(
        array(
            'field' => 'poll_id',
            'label' => 'Poll ID',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'poll_option_id',
            'label' => 'Answer',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'user_id',
            'label' => 'User',
            'rules' => 'required|xss_clean')        
    );
    
    public $belongs_to = array('poll_option');
    
    public $before_create = array('created', 'modified');
    
    public $before_update = array('modified');
    
    public function calculate($poll_id) {
        $this->load->model(array('poll_option_model'));
        //get total number of responses
        $total = $this->poll_response_model->count_by(array('poll_id' => $poll_id));
        
        //get answer options
        $options = $this->poll_option_model->get_many_by(array('poll_id' => $poll_id));
        
        $return = (object)array();
        if(!empty($options)) {
            $i=0;
            foreach($options as $row) {
                $votes = $this->poll_response_model->count_by(array('poll_id' => $poll_id, 'poll_option_id' => $row->id));
                $results[$i] = new stdClass();
                $results[$i]->count = $votes;
                $results[$i]->poll_option_id = $row->id;
                $results[$i]->text = $row->text;
                $results[$i]->percent = 0;
                if($votes != 0 && $total != 0) {
                    $results[$i]->percent = round(($votes / $total) * 100);
                }     
                $i++;
            }
            arsort($results);
            $return->votes = $total;
            $return->results = $results;
        }
        return $return;
    }
}
?>
