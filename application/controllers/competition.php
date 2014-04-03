<?php

/* Russ Green rgreen@rgreenphotography.com
 * Handles Front End Competition functionality
 */

class Competition extends Public_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('competition_model', 'competition_fee_model', 'division_model'));
        $this->load->library(array('table'));
        //TO-DO - move this to only the methods that need it, no need to load not used JS files.
        $this->js = array(
            'http://maps.google.com/maps/api/js?sensor=false&amp;language=en',
            ''.base_url().'assets/js/gmap3.min.js'
        );
    }
    
    public function index($year = '') {
        //default to current year if not included
        if(empty($year)) {
            $year = date('Y');
        }
        $this->data['year'] = $year;
        $this->data['competitions'] = $this->competition_model->get_event($year);
        $this->data['main'] = 'competition/index';
        $this->load->model('page_model');
        $this->data['cms_content'] = $this->page_model->get_page('competitions');
        $this->data['title'] = 'Events '.$year;
        
        $this->load->view('photo_layout', $this->data);
    }
    
    public function view($slug) {
        //check for numeric url (no slug) and create 301 redirect
        if(is_numeric($slug)) {
            $event = $this->competition_model->get($slug);
            if(!empty($event)) {
                redirect('competition/view/'.$event->slug, 'location', 301);
            } else {
                redirect('error404', 'location', 404);
            }
        }
        $this->data['event'] = $this->competition_model->with('competition_type')->get_by('slug', $slug);
        $this->data['title'] = $this->data['event']->name;
        $this->data['divisions'] = $this->competition_fee_model->order_by('division_id')->get_many_by('competition_id', $this->data['event']->id);
        $this->load->model('registration_model');

        if(!empty($this->the_user)) {
            if(empty($this->the_user->family_id)) {
                $options = array('registration.user_id' => $this->the_user->id, 'registration.competition_id' => $this->data['event']->id);
                $this->data['registrations'] = $this->registration_model->with('canine')->with('user')->with('division')->get_many_by($options);
            } else {
                $options = array('registration.family_id' => $this->the_user->family_id, 'registration.competition_id' => $this->data['event']->id);
                $this->data['registrations'] = $this->registration_model->with('canine')->with('user')->with('division')->get_many_by($options);                
            }
        }
        $this->data['registration_total'] = $this->registration_model->get_basic_stats($this->data['event']->id);
        
        
        $this->data['main'] = 'competition/view';
        $this->load->view('secondary_layout', $this->data);
    }
    
    public function demos() {
        $this->data['title'] = 'Demo Team';
        if(empty($year)) {
            $year = date('Y');
        }
        
        //displays the years available in the db.
        $this->data['event_menu'] = $this->competition_model->event_menu('6');
        $this->data['year'] = $year;        
        $this->data['cms_content'] = $this->page_model->get_page('Demo-Team');
        $options = array('Public');
        if(!empty($this->data['group_member'])) {
            $options = array('Public', 'Member');
            //array_push($options, $array);
        }        
        
        $options = array('competition_type_id' => '6');
        $this->data['demos'] = $this->competition_model->with('competition_type')->get_many_by($options);
        
        $this->data['main'] = 'competition/demos';
        $this->load->view('demo_layout', $this->data);
    }
    
    public function registered($slug) {
        //check for numeric url (no slug) and create 301 redirect
        if(is_numeric($slug)) {
            $event = $this->competition_model->get($slug);
            if(!empty($event)) {
                redirect('competition/registered/'.$event->slug, 'location', 301);
            } else {
                redirect('error404', 'location', 404);
            }
        }        
        $this->data['competition'] = $this->competition_model->with('competition_type')->get_by(array('slug' => $slug));
        $this->load->model('division_model');
        $this->data['divisions'] = $this->division_model->get_many_by(array('competition_type_id' => $this->data['competition']->competition_type->id));
        $this->load->model('registration_model');
        $this->data['forms'] = $this->registration_model->get_forms($this->data['competition'], $this->data['divisions']);
        $this->data['title'] = $this->data['competition']->name;
        $this->data['main'] = 'competition/registered';
        $this->load->view('secondary_layout', $this->data);
    }
    
    
}

?>
