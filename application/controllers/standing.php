<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Standing extends Public_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('standing_model'));
        $this->load->library(array('table'));
        
    }
    
    
    public function index($season = '', $type = '') {
        if(empty($season)) {
            $season = date('Y');
        } 
        
        if(empty($type)) {
            $type = 'Cup';
        }
        $options = array('season' => $season, 'type' => $type);
        $standings = $this->standing_model->with('user')->with('canine')->order_by('place', 'ASC')->get_many_by($options);        
        
        switch($type) {
            case 'Cup':
            case 'Rookie':
                $this->data['table_view'] = 'cup';
                if(!empty($standings)) {
                    $i=0;
                    foreach($standings as $standing) {
                        $this->data['standings'][$i]->place = $standing->place;
                        $this->data['standings'][$i]->handler = $standing->user->full_name;
                        $this->data['standings'][$i]->canine = $standing->canine->name;
                        $this->data['standings'][$i]->total = $standing->total_points;
                        $this->data['standings'][$i]->comps = !empty($standing->comps)?$standing->comps:'';
                        $this->data['standings'][$i]->lowest_competition = $standing->lowest_competition;
                        $this->data['standings'][$i]->stats = $standing->stats;
                        $i++;
                    }
                }
                break;
            case 'RRR':
                $this->data['table_view'] = 'other';
                if(!empty($standings)) {
                    $i=0;
                    foreach($standings as $standing) {
                        $this->data['standings'][$i]->place = $standing->place;
                        $this->data['standings'][$i]->handler = $standing->user->full_name;
                        $this->data['standings'][$i]->canine = $standing->canine->name;
                        $this->data['standings'][$i]->sky = $standing->r_hi_sky;
                        $this->data['standings'][$i]->ufo = $standing->r_hi_ufo;
                        $this->data['standings'][$i]->total = $standing->rrr_total;
                        $this->data['standings'][$i]->award = $standing->rrr_award;
                        $i++;
                    }
                }
                break;
            case 'Hershey':
                $this->data['table_view'] = 'other';
                if(!empty($standings)) {
                    $i=0;
                    foreach($standings as $standing) {
                        $this->data['standings'][$i]->place = $standing->place;
                        $this->data['standings'][$i]->handler = $standing->user->full_name;
                        $this->data['standings'][$i]->canine = $standing->canine->name;
                        $this->data['standings'][$i]->sky = $standing->h_hi_sky;
                        $this->data['standings'][$i]->ufo = $standing->h_hi_ufo;
                        $this->data['standings'][$i]->total = $standing->hershey_total;
                        $this->data['standings'][$i]->award = $standing->hershey_award;
                        $i++;
                    }
                }
                break;       
        }
        
        $this->css = array(base_url().'assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js');        
        
        $this->data['seasons'] = array('2013', '2012');
        $this->data['season'] = $season;
        $this->load->model('page_model');
        $this->data['cms_content'] = $this->page_model->get_page('standings');
        $this->data['main'] = 'standing/index';
        $this->data['title'] = 'Colorado Cup Series';
        $this->data['type'] = $type;
        $this->data['header'] = $this->_set_page_header($type);
        $this->load->view('photo_layout', $this->data);
    }
    
    private function _set_page_header($type) {
        switch($type){
            case 'Cup':
                $header = 'Colorado Cup Standings';
                break;
            case 'Rookie':
                $header = 'Rookie of the Year';
                break;
            case 'RRR':
                $header = 'Red Rocket Rider';
                break;
            case 'Hershey':
                $header = 'Hershey';
                break;
        }
        return $header;
    }
}

?>
