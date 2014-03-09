<?php
/* Russ Green rgreen@rgreenphotography.com
 */
class Competition_result extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('user_model', 'competition_result_model', 'canine_model', 'competition_model', 'division_model'));
        $this->load->library(array('excel'));
        $this->load->helper(array('download'));
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        
    }
    
    public function index($competition_id, $division_id = '') {
        $this->data['title'] = 'Competition Results';
        
        if(!empty($competition_id)) {
            $this->data['competition'] = $this->competition_model->with('competition_type')->get($competition_id);
            $options = array('competition_type_id' => $this->data['competition']->competition_type_id, 'dual !=' => 2);
            $this->data['divisions'] = $this->division_model->order_by('name')->get_many_by($options);
            if(empty($division_id)) {
                $division_id = $this->data['divisions'][0]->id;
            }
            $this->data['division'] = $this->division_model->get_by(array('competition_type_id' => $this->data['competition']->competition_type_id, 'id' => $division_id));
            $options = array('division_id' => $this->data['division']->id, 'competition_id' => $this->data['competition']->id);
            $this->data['competition_result'] = $this->competition_result_model->order_by('place')->get_many_by($options);
        } else {
            $this->data['message'] = '';
        }
        $this->data['main'] = 'admin/competition_result/index';
        $this->load->view('admin/layout', $this->data);        
    }
    

    public function competitior_setup($competition_id) {
        //grab all the registrations for this competition
        $this->load->model(array('registration_model'));
        $registrations = $this->registration_model->sort_divisions($competition_id);
        if($this->competition_result_model->competitor_setup($registrations)) {
            $this->session->set_flashdata('message', 'Competitor set up complete');
            redirect('admin/gameday/'.$competition_id);
        } else {
            $this->session->set_flashdata('message', 'Could not complete competitor set up');
            redirect('admin/gameday/'.$competition_id);
        }       
    }     
    
    public function edit($id, $division_id) { 
        $this->data['breadcrumb'] = $this->division_model->get($division_id);
        
        $existing = $this->competition_result_model->with('competition')->with('user')->with('canine')->with('division')->get($id);
        $this->load->model('competition_type_model');
        $this->data['labels'] = $this->competition_type_model->set_labels($existing->competition->competition_type_id);

        $this->data['hidden'] = array(
            'dual' => $existing->dual, 
            'user_id' => $existing->user->id, 
            'canine_id' => $existing->canine->id,
            'division_id' => $existing->division->id,
            'competition_id' => $existing->competition->id);
        $this->data['dual'] = $existing->dual;
        $this->data['division_id'] = $division_id;
        if(!empty($existing)) {
            $item = $this->_set_fields($existing);
            $this->data['id'] = $existing->id;
            
            $this->data['item'] = $item;//$this->competition_result_model->set_form($item);
        } 
        
        if(!empty($_POST)) {
            $calculate_scores = $this->input->post('calculate_scores');
            //unset so we don't try to insert it with other data
            unset($_POST['calculate_scores']);
            $options = $this->competition_result_model->set_options($_POST);
            if($this->competition_result_model->update($id, $options)) {
                if($options['dual'] == '1') {
                    $tc_scores = explode(',', $options['tc_cat_1']);
                    if(!empty($tc_scores)) {
                        $tc_total = '0';
                        $tc_cat = '';
                        foreach($tc_scores as $k=>$v) {
                            $tc_total += $v;
                            $tc_cat .= $v.',';
                        }
                        $tc_cat_1 = rtrim($tc_cat, ',');
                    }
                    $data = array(
                        'tc_cat_1' => $tc_cat_1,
                        'tc_total_1' => $tc_total                            
                    );
                    //get the id of other dual division
                    $dual_array = array('competition_id' => $options['competition_id'], 'canine_id' => $options['canine_id'], 'division_id !=' => $options['division_id'], 'dual' => '1');
                    $dual = $this->competition_result_model->get_by($dual_array);
                    //update second record
                    $this->competition_result_model->update($dual->id, $data);
                }
                if($calculate_scores == 'Yes') {
                    $this->competition_result_model->calculate_scores($options['competition_id'], $options['division_id']);
                }
                $this->competition_result_model->calculate_overall_placement($options['competition_id'], $options['division_id']);
                $this->session->set_flashdata('message', 'Result updated');
                redirect('admin/competition_result/running/'.$options['competition_id'].'/'.$division_id);
            }
        }
        
        $this->data['main'] = 'admin/competition_result/elements/tc';
        if($existing->division->freestyle == 1) {
            $this->data['main'] = 'admin/competition_result/elements/fs';
        }
        $this->load->view('admin/layout', $this->data);
        
        
    }
    public function running($competition_id, $division_id) {
        $this->data['competition'] = $this->competition_model->with('competition_type')->get_by(array('id' => $competition_id));        
        $this->data['division'] = $this->division_model->get($division_id);
        
        if($this->data['division']->freestyle == '1') {
            $type = 'fs_order';
        } else {
            $type = 'tc_order';
        }
 
        if(!empty($division_id)) {
            $this->data['teams'] = $this->competition_result_model->get_teams($competition_id, $division_id);                   
        } else {
            $this->session->set_flashdata('message', 'No division selected');
            redirect('admin/competition_result/gameday/'.$competition_id);
        }
        $this->data['division_id'] = $division_id;
        $this->data['main'] = 'admin/competition_result/running';
        $this->load->view('admin/layout', $this->data);
        
    }
    
    public function p_running($competition_id, $division_id) {        
        $this->data['teams'] = $this->competition_result_model->get_teams($competition_id, $division_id);
        $this->data['competition'] = $this->competition_model->with('competition_type')->get_by(array('id' => $competition_id));
        $this->data['division'] = $this->division_model->get($division_id);
        $this->data['main'] = 'admin/competition_result/print/running';
        $this->load->library('pdf');
        $this->pdf->load_view('admin/competition_result/print/running', $this->data);
        $this->pdf->render();
        $this->pdf->stream($this->data['division']->name."_running_order.pdf");                
    }
    
   public function shuffle($competition_id, $division_id) {
        $division = $this->division_model->get($division_id);
        
        if($division->freestyle == '1') {
            $type = 'fs_order';
        } else {
            $type = 'tc_order';
        }
        
        if($this->competition_result_model->running_order($competition_id, $division_id, $type)) {
            $this->session->set_flashdata('message', 'Shuffle Complete');
            redirect('admin/competition_result/running/'.$competition_id.'/'.$division_id);    
        } else {
            $this->session->set_flashdata('message', 'Could not shuffle');
            redirect('admin/competition_result/running/'.$competition_id.'/'.$division_id);
        }         
   } 
    
    public function set_order() {
        //sets the running order for this division
        $order = $this->input->post('order');
        $competition_id = $this->input->post('competition_id');
        $division_id = $this->input->post('division_id');
        $freestyle = $this->input->post('freestyle');
        if($freestyle == '1') {
            $type = 'fs_order';
            $query_type = 'competition_result.fs_order';
        } else {
            $type = 'tc_order';
            $query_type = 'competition_result.tc_order';
        }
        $set_order = explode(',', $order);
        if(!empty($set_order)) {
            $i=1;
            foreach($set_order as $k=>$v) {
                $flag = false;
                $options = array($type => $i);
                if($this->competition_result_model->update($v, $options, TRUE)) {
                    $flag = true;
                }
                $i++;
            }
        }
        
        if($flag != false) {
            $return = $this->competition_result_model->get_teams($competition_id, $division_id);
            if(!empty($return)) {
                $i=0;
                foreach($return as $result) {
                    $results[$i]['id'] = $result->id;
                    if($freestyle == '1') {
                        $results[$i]['order'] = $result->fs_order;
                    } else {
                        $results[$i]['order'] = $result->tc_order;
                    }
                    
                    $results[$i]['human'] = $result->user->full_name;
                    $results[$i]['canine'] = '';
                    if(!empty($result->canine->name)) {
                        $results[$i]['canine'] = $result->canine->name;
                    }
                    $results[$i]['user_id'] = $result->user->id;
                    $results[$i]['canine_id'] = '';
                    if(!empty($result->canine->id)) {
                        $results[$i]['canine_id'] = $result->canine->id;
                    }
                    $results[$i]['division_id'] = $division_id;
                    $results[$i]['division'] = $result->division->name;
                    $results[$i]['progress'] = (!empty($result->fs_total_1) ? 'FS1 ': '');
                    $results[$i]['progress'] .= (!empty($result->fs_total_2) ? 'FS2 ': '');
                    $results[$i]['progress'] .= (!empty($result->tc_total_1) ? 'TC1 ': '');
                    $results[$i]['progress'] .= (!empty($result->tc_total_2) ? 'TC2 ': '');
                    $i++;
                }
            }
            
            echo json_encode($results);
        } else {
            $return = 'Failed';
            echo json_encode($return);
        }
    }
    
   public function placement($competition_id, $division_id) {
       //set memory limit in case we generate a large file.
       ini_set("memory_limit","96550M");
       //$this->competition_result_model->calculate_scores($competition_id, $division_id);
       $this->competition_result_model->calculate_overall_placement($competition_id, $division_id);
       $this->competition_result_model->calculate_club_placement($competition_id, $division_id);
       $this->competition_result_model->calculate_cup_points($competition_id, $division_id);
       $this->data['division'] = $this->division_model->get($division_id);
       $this->data['competition'] = $this->competition_model->get($competition_id);
       $this->data['results'] = $this->competition_result_model->with('canine')->with('user')->order_by('place')->get_many_by(array('competition_id' => $competition_id, 'division_id' => $division_id));
       $this->load->library('pdf');
       $this->pdf->load_view('admin/competition_result/print/placement', $this->data);
       $this->pdf->render();
       $this->pdf->stream($this->data['division']->name."_standings.pdf");          
       
   }
   
   private function _set_fields($existing) {
        $item = $existing;
        $tc_scores_1 = explode(',', $existing->tc_cat_1);
        $tc_scores_2 = explode(',', $existing->tc_cat_2);
        if(!empty($tc_scores_1)) {
            for($i=1; $i<=10; $i++) {
                $item->{"tc_1_$i"} = (!empty($tc_scores_1[$i-1]) ? $tc_scores_1[$i-1]: '');
                if(!empty($tc_scores_2)) {
                    $item->{"tc_2_$i"} = (!empty($tc_scores_2[$i-1]) ? $tc_scores_2[$i-1]: '');
                }
            }
        } 
        return $item;
   }
       
}
?>
