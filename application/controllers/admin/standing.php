<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Standing extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('standing_model', 'competition_model', 'group_model', 'canine_model', 'competition_result_model', 'points_guide_model', 'division_model'));
        $this->load->library(array('table'));
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/jmath.js',base_url().'assets/js/jquery.smooth-scroll.min.js',base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js');
    }
    
    public function index($season = '', $type = '') {
        //set some defaults just in case
        if(empty($season)) {
            $season = date('Y');
        }
        if(empty($type)) {
            $type = 'Cup';
        }
        
        $options = array('season' => $season, 'type' => $type);
        $this->data['standings'] = array();
        $standings = $this->standing_model->with('user')->with('canine')->order_by('place', 'ASC')->get_many_by($options);        

        //based on type create array for datatable and needed table headers
        switch($type) {
            case 'Cup':
            case 'Rookie':
                $header = array('Place', 'Handler', 'Dog', 'Points', 'Comps', 'Drop');
                if(!empty($standings)) {
                    $i=0;
                    foreach($standings as $standing) {
                        $this->data['standings'][$i]['place'] = $standing->place;
                        $this->data['standings'][$i]['handler'] = $standing->user->full_name;
                        $this->data['standings'][$i]['dog'] = !empty($standing->canine->name)?$standing->canine->name:'';
                        $this->data['standings'][$i]['total'] = $standing->total_points;
                        $this->data['standings'][$i]['comps'] = !empty($standing->comps)?$standing->comps:'';
                        $this->data['standings'][$i]['drop'] = $standing->lowest_competition;
                        $i++;
                    }
                }
                break;
            case 'RRR':
                $header = array('Place', 'Handler', 'Dog', 'Skyhoundz', 'UFO', 'Total', 'Award Points');
                if(!empty($standings)) {
                    $i=0;
                    foreach($standings as $standing) {
                        $this->data['standings'][$i]['place'] = $standing->place;
                        $this->data['standings'][$i]['handler'] = $standing->user->full_name;
                        $this->data['standings'][$i]['dog'] = $standing->canine->name;
                        $this->data['standings'][$i]['sky'] = $standing->r_hi_sky;
                        $this->data['standings'][$i]['ufo'] = $standing->r_hi_ufo;
                        $this->data['standings'][$i]['total'] = $standing->rrr_total;
                        $this->data['standings'][$i]['award'] = $standing->rrr_award;
                        $i++;
                    }
                }
                break;
            case 'Hershey':
                $header = array('Place', 'Handler', 'Dog', 'Skyhoundz', 'UFO', 'Total', 'Award Points');
                if(!empty($standings)) {
                    $i=0;
                    foreach($standings as $standing) {
                        $this->data['standings'][$i]['place'] = $standing->place;
                        $this->data['standings'][$i]['handler'] = $standing->user->full_name;
                        $this->data['standings'][$i]['dog'] = $standing->canine->name;
                        $this->data['standings'][$i]['sky'] = $standing->h_hi_sky;
                        $this->data['standings'][$i]['ufo'] = $standing->h_hi_ufo;
                        $this->data['standings'][$i]['total'] = $standing->hershey_total;
                        $this->data['standings'][$i]['award'] = $standing->hershey_award;
                        $i++;
                    }
                }
                break;       
        }

        $year = date('Y');
        $seasons = array();
        for($i=$year; $i>=2012; $i--) {
            array_push($seasons, $i);
        }
        $this->data['seasons'] = $seasons;
        $this->data['season'] = $season;
        $this->data['type'] = $type;
        $this->data['main'] = 'admin/standing/index';
        $this->load->view('admin/layout', $this->data);
    }
    
    public function standings() {
        if(!empty($_POST)) {
            $season = $this->input->post('season');
            $type = $this->input->post('type');
            switch($type) {
                case 'Cup':
                    $competitions = $this->competition_model->get_many_by(array('season' => $season, 'cup_points' => '1'));
                    if(!empty($competitions)) {
                      foreach($competitions as $competition) {
                          $divisions = $this->division_model->get_many_by(array('competition_type_id' => $competition->competition_type_id, 'points_type !=' => 'NULL'));
                          foreach($divisions as $division) {
                              $this->competition_result_model->calculate_club_placement($competition->id, $division->id);
                              $this->competition_result_model->calculate_cup_points($competition->id, $division->id);
                          }
                      }
                    }        
                    $members = $this->group_model->get_cup_members('3', '4');
                    $competitions = $this->competition_model->get_many_by(array('season' => $season, 'cup_points' => '1'));
                    if($this->standing_model->calculate($members, $competitions, $season)) {
                        $this->session->set_flashdata('message', 'Cup standing have been updated');
                    } else {
                        $this->session->set_flashdata('message', 'Could not calculate standings, please try again');
                    }
                    break;
                case 'RRR':
                    $members = $this->group_model->get_cup_members('3', '4');
                    if($this->standing_model->calculate_rrr($members, $season)) {
                        $this->session->set_flashdata('message', 'Red Rocket Rider has been updated');
                    } else {
                        $this->session->set_flashdata('message', 'Could not update Red Rocket Rider standing');
                    }
                    break;
                case 'Hershey':
                    $members = $this->group_model->get_cup_members('3', '4');
                    if($this->standing_model->calculate_hershey($members, $season)) {
                        $this->session->set_flashdata('message', 'Red Rocket Rider has been updated');
                    } else {
                        $this->session->set_flashdata('message', 'Could not update Red Rocket Rider standing');
                    }
                    break;
            }
            redirect('admin/standing/index/'.$season.'/'.$type);
        }
    }
}
?>
