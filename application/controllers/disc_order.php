<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Disc_order extends Member_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('disc_order_model', 'disc_type_model'));
    }
    
    
    public function index() {
        $user_id = $this->the_user->id;
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        $this->data['display_social'] = false;
        $this->data['orders'] = $this->disc_order_model->with('disc_type')->order_by('created')->get_many_by(array('user_id' => $user_id));
        $this->data['disc_type'] = $this->disc_type_model->get_all();
        $this->data['title'] = 'Disc Orders';
        $this->data['main'] = 'disc_order/index';
        $this->load->view('secondary_layout', $this->data);            
    }
     
    public function add() {
        $json = array();
        if(!empty($_POST)) {
            $options['user_id'] = $this->the_user->id;
            $options['disc_type_id'] = $_POST['disc_type_id'];
            $options['color'] = str_replace('_', ' ', $_POST['color']);
            $options['total_discs'] = $_POST['total_discs'];
            $options['total'] = $_POST['total'];
            if($this->disc_order_model->insert($options)) {
                $id = $this->db->insert_id();
                $json['id'] = $id;
                $json['success_message'] = 'Discs Added';
            }
        }
        echo json_encode($json);
    }
    
    public function delete() {
        $json = array();
        if(!empty($_POST)) {
            $id = $_POST['id'];
            if($this->disc_order_model->delete($id)) {
                $json['id'] = $id;
                $json['success_message'] = 'Discs Removed';
            } else {
                $json['message'] = 'Could not delete';
            }
        }
        echo json_encode($json);
    }
    
}
?>
