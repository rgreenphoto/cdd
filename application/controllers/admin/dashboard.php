<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Dashboard extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['title'] = 'System Dashboard';
        $this->load->library(array('table'));
        $this->load->helper(array('download', 'csv'));
        
    }
    
    
    public function index() {
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        //grab registration information
        $this->load->model('competition_model');
        $this->data['competition'] = $this->competition_model->next_event();
        $this->data['comp_reg'] = $this->competition_model->stats('2');
        
        //grab user stats by group
        $this->load->model('group_model');
        $this->data['user_list'] = $this->group_model->stats();
        
        //grab poll data
        $this->load->model(array('poll_model', 'poll_response_model'));
        $poll = $this->poll_model->get_stats(3);
        $this->data['polls'] = $this->poll_model->get_stats(3); //$this->poll_response_model->calculate($poll[0]->id);
        //load up some basic stats
        $this->data['main'] = 'admin/dashboard/index';
        $this->load->view('admin/layout', $this->data); 
        
    }
    
    public function summary($group_id) {
        $this->load->model('group_model');
        $user_list = $this->group_model->get_members($group_id);
        
        if(!empty($user_list)) {
            $i=0;
            foreach($user_list as $row) {
                $this->data['users'][$i]['last_name'] = $row->last_name;
                $this->data['users'][$i]['first_name'] = $row->first_name;
                $this->data['users'][$i]['email'] = $row->email;
                $this->data['users'][$i]['membership_date'] = $row->membership_date;
                $this->data['users'][$i]['edit'] = '<a href="'.base_url().'admin/user/edit/'.$row->id.'" class="btn btn-primary">Edit <i class="icon-edit"></i></a>';
                $i++;
            }
        }
        
        $header = array('Last Name', 'First Name', 'Email', 'Membership Date', 'Action');
        // Set the headings
        $this->table->set_heading($header);
        $tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" id="usertable">' );
        $this->table->set_template($tmpl);         
        
        $this->data['title'] = 'User Details';
        $this->data['main'] = 'admin/dashboard/summary';
        $this->load->view('admin/layout', $this->data);
    }
    
    public function gameday($competition_id) {
        $this->load->model(array('competition_model', 'competition_result_model', 'registration_model'));        
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js', base_url().'assets/js/admin/autocomplete.js');
        $this->data['competition'] = $this->competition_model->with('competition_type')->get_by(array('id' => $competition_id));        
        $this->load->model('division_model');
        $this->data['divisions'] = $this->division_model->order_by('name')->get_many_by('competition_type_id', $this->data['competition']->competition_type_id);
        $this->data['competitors'] = $this->competition_result_model->check_table_status($competition_id);
        $this->data['forms'] = $this->registration_model->get_forms($this->data['competition'], $this->data['divisions']);
        $this->data['main'] = 'admin/dashboard/gameday';
        $this->load->view('admin/layout', $this->data);
    }
    
}




?>
