<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Disc_type_model extends MY_Model {
    public $_table = 'disc_type';
    
    protected $soft_delete = FALSE;
   
    public $protected_attributes = array('id');
    
    public $validate = array(
        array(
            'field' => 'name',
            'label' => 'Disc Name',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'description',
            'label' => 'Disc Description',
            'rules' => 'xss_clean'),
        array(
            'field' => 'color',
            'label' => 'Available Colors',
            'rules' => 'required|xss_clean'),
        array(
            'field' => 'price',
            'label' => 'Available Colors',
            'rules' => 'required|xss_clean')
    );
    
    public $after_get = array('create_color_dropdown', 'create_amount_dropdown');
    
    
    
    public function create_color_dropdown($row) {
        if(!empty($row->color)) {
            $color_array = explode(',', $row->color);
            $new_array = array('' => 'Select Color');
            foreach($color_array as $k=>$v) {
                $new_array[$v] = $v;
            }
            $row->color_dropdown = $new_array;
        }
        return $row;
    }
    
    public function create_amount_dropdown($row) {
        if(!empty($row)) {
            $amount_array = array('' => 'Select Amount');
            $num = 25;
            while($num <= 250) {
                $amount_array[$num] = $num;
                $num += 25;
            }
            $row->amount_dropdown = $amount_array;
        }
        return $row;
    }
      
}


?>
