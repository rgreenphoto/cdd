<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Result extends Public_Controller {
    //controller for front end competition_result
    public function __construct() {
        parent::__construct();
        $this->load->model(array('competition_result_model', 'competition_model', 'division_model'));
        $this->load->library(array('table'));
    }
    
    public function index($year = '') {
        //default to current year if not included
        if(empty($year)) {
            $year = date('Y');
        }
        $this->data['event_menu'][''] = 'Previous Seasons';
        for($i=2012; $i<=date('Y'); $i++) {
            $this->data['event_menu'][$i] = $i;
        }
        
        //displays the years available in the db.
        //$this->data['event_menu'] = array('' => 'Previous Seasons', '2012' => '2012');
        $this->data['year'] = $year;
        $this->data['competitions'] = $this->competition_model->get_event($year);
        $this->load->model('page_model');
        $this->data['cms_content'] = $this->page_model->get_page('results');
        $this->data['title'] = $this->data['cms_content']->name;        
        $this->data['main'] = 'result/index';
        $this->data['title'] = 'Results '.$year;
        $this->load->view('photo_layout', $this->data);
    }
    
    public function view($slug, $division = null) {
        //301 redirect for pages previously using id as variable
        if(is_numeric($slug)) {
            $event = $this->competition_model->get($slug);
            if(!empty($event)) {
                redirect('result/view/'.$event->slug.'/'.$division, 'location', 301);
            } else {
                redirect('error404', 'location', 404);
            }
        }
        
        if(!empty($slug)) {
            //grab the competition with results
            $options = array('slug' => $slug);
            $this->data['competition'] = $this->competition_model->with('competition_type')->get_by($options);
            $options = array('competition_type_id' => $this->data['competition']->competition_type_id, 'dual !=' => 2);
            $this->data['divisions'] = $this->division_model->order_by('name')->get_many_by($options);
            if(empty($division)) {
                $division = $this->data['divisions'][0]->slug;
            }
            $this->data['division'] = $this->division_model->get_by(array('competition_type_id' => $this->data['competition']->competition_type_id, 'slug' => $division));
            $options = array('division_id' => $this->data['division']->id, 'competition_id' => $this->data['competition']->id);
            $this->data['competition_result'] = $this->competition_result_model->order_by('place')->get_many_by($options);
        } else {
            $this->data['message'] = '';
        }
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js');
        
        
        $this->data['main'] = 'result/view';
        $this->data['title'] = 'Results - '.$this->data['competition']->name;
        $this->load->view('photo_layout', $this->data);        
        
    }
    
    public function live($division_id = null) {
        //let's grab the competition->
        $this->data['competition'] = $this->competition_model->next_event();
        $this->data['title'] = 'Live Results - '.$this->data['competition'][0]->name;
        $options = array('competition_type_id' => $this->data['competition'][0]->competition_type_id, 'dual !=' => 2);
        $this->data['divisions'] = $this->division_model->order_by('name')->get_many_by($options);
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/countdown.js');
        
        $this->data['main'] = 'result/live';
        $this->load->view('score_layout', $this->data);        
        
    }
    
    public function get_results($competition_id, $division_id) {
        $this->data['division'] = $this->division_model->get($division_id);
        $this->data['results'] = $this->competition_result_model->get_teams($competition_id, $division_id);
        $view = $this->load->view('result/elements/table', $this->data);
        echo $view;
    }
    
    public function print_results($id) {
        $this->data['result'] = $this->competition_result_model->with('division')->get($id);
        $this->data['competition'] = $this->competition_model->with('competition_type')->get($this->data['result']->competition_id);
        $this->load->library('pdf');
        $this->pdf->load_view('result/print', $this->data);
        $this->pdf->render();
        $file_name = url_title($this->data['result']->handler.'-'.$this->data['result']->canine.'-'.$this->data['competition']->name.'-'.$this->data['competition']->date);
        $this->pdf->stream($file_name.'.pdf');
        //$this->load->view('result/print', $this->data);
    }
    
    
}


?>
