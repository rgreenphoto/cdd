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
        $this->js = array(base_url().'assets/js/jmath.js',base_url().'assets/js/jquery.smooth-scroll.min.js',base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/admin/scoreCore.js');
        
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
    

    public function export_results($competition_id) {
        $this->load->helper('text');
        $competition = $this->competition_model->get($competition_id);
        $this->load->model('competition_type_model');
        $labels = $this->competition_type_model->set_labels($competition->competition_type_id);
        //get divisions
        $divisions = $this->division_model->get_many_by(array('competition_type_id' => $competition->competition_type_id, 'dual !=' => 2));

        if(!empty($divisions)) {
            //set up Excel doc
            $excel = new PHPExcel();
            $excel->getProperties()->setCreator('Disc Dog Score System');
            $excel->getProperties()->setTitle($competition->name);

            $i=0;
            $alpha = 'A';
            foreach($divisions as $division) {
                $results = $this->competition_result_model->get_results_by_division($competition_id, $division->id);
                $excel->createSheet(NULL, $i);
                $excel->setActiveSheetIndex($i);
                $excel->getActiveSheet()->setTitle(url_title(character_limiter(str_replace('Skyhoundz', '', $division->name), 29), ' '));
                $excel->getActiveSheet()->setCellValue('A1', 'Place');
                $excel->getActiveSheet()->setCellValue('B1', 'Handler');
                $excel->getActiveSheet()->setCellValue('C1', 'Canine');
                $excel->getActiveSheet()->setCellValue('D1', $labels['fs_labels'][0]);
                $excel->getActiveSheet()->setCellValue('E1', $labels['fs_labels'][1]);
                $excel->getActiveSheet()->setCellValue('F1', $labels['fs_labels'][2]);
                $excel->getActiveSheet()->setCellValue('G1', $labels['fs_labels'][3]);
                $excel->getActiveSheet()->setCellValue('H1', 'FS Total');
                $excel->getActiveSheet()->setCellValue('I1', $labels['fs_labels'][0]);
                $excel->getActiveSheet()->setCellValue('J1', $labels['fs_labels'][1]);
                $excel->getActiveSheet()->setCellValue('K1', $labels['fs_labels'][2]);
                $excel->getActiveSheet()->setCellValue('L1', $labels['fs_labels'][3]);
                $excel->getActiveSheet()->setCellValue('M1', 'FS Total');
                $excel->getActiveSheet()->setCellValue('N1', 'T1_Catches');
                $excel->getActiveSheet()->setCellValue('O1', 'TC1');
                $excel->getActiveSheet()->setCellValue('P1', 'T2_Catches');
                $excel->getActiveSheet()->setCellValue('Q1', 'TC2');
                $excel->getActiveSheet()->setCellValue('R1', 'Total');
                if(!empty($results)) {
                    $row = 2;
                    foreach($results as $result) {
                        $excel->getActiveSheet()->setCellValue('A'.$row, $result->place);
                        $excel->getActiveSheet()->setCellValue('B'.$row, $result->full_name);
                        $excel->getActiveSheet()->setCellValue('C'.$row, $result->name);
                        $excel->getActiveSheet()->setCellValue('D'.$row, $result->fs_1_1);
                        $excel->getActiveSheet()->setCellValue('E'.$row, $result->fs_2_1);
                        $excel->getActiveSheet()->setCellValue('F'.$row, $result->fs_3_1);
                        $excel->getActiveSheet()->setCellValue('G'.$row, $result->fs_4_1);
                        $excel->getActiveSheet()->setCellValue('H'.$row, $result->fs_total_1);
                        $excel->getActiveSheet()->setCellValue('I'.$row, $result->fs_1_2);
                        $excel->getActiveSheet()->setCellValue('J'.$row, $result->fs_2_2);
                        $excel->getActiveSheet()->setCellValue('K'.$row, $result->fs_3_2);
                        $excel->getActiveSheet()->setCellValue('L'.$row, $result->fs_4_2);
                        $excel->getActiveSheet()->setCellValue('M'.$row, $result->fs_total_2);
                        $excel->getActiveSheet()->setCellValue('N'.$row, $result->tc_cat_1);
                        $excel->getActiveSheet()->setCellValue('O'.$row, $result->tc_total_1);
                        $excel->getActiveSheet()->setCellValue('P'.$row, $result->tc_cat_2);
                        $excel->getActiveSheet()->setCellValue('Q'.$row, $result->tc_total_2);
                        $excel->getActiveSheet()->setCellValue('R'.$row, $result->total);
                        $row++;
                    }
                }
                $alpha++;
                $i++;
            }
        }
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $write->save('./uploads/results.xls');
        $file = file_get_contents('./uploads/results.xls');
        unlink('./uploads/results.xls');
        force_download($competition->name.'.xls', $file);
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
    
    public function edit($id, $division_id, $view = 'tc') {
        $division = $this->division_model->get($division_id);
        $this->data['division'] = $division;

        $existing = $this->competition_result_model->with('competition')->with('user')->with('canine')->with('division')->get($id);

        $this->load->model('competition_type_model');

        $this->data['hidden'] = array(
            'id' => $existing->id,
            'dual' => $existing->dual, 
            'user_id' => $existing->user->id, 
            'canine_id' => $existing->canine->id,
            'division_id' => $existing->division->id,
            'competition_id' => $existing->competition->id,
            'freestyle' => $existing->division->freestyle,
            'dual' => $existing->dual
        );
        $this->data['labels'] = $this->competition_type_model->set_labels($existing->competition->competition_type_id);
        if(!empty($existing)) {
            $item = $this->_set_fields($existing);
            $this->data['item'] = $item;
            if($existing->division->id == 5) {
                $this->data['pairs'] = $this->_get_pairs($existing->user->id, $existing->canine->id, $existing->competition->id);
            }
        } 
        
        if(!empty($_POST)) {
            unset($_POST['calculate_scores']);
            $options = $this->competition_result_model->set_options($_POST);

            if($this->competition_result_model->update($id, $options)) {
                if($options['dual'] == '1' && isset($options['tc_total_1'])) {
                    $data = array(
                        'tc_cat_1' => $options['tc_cat_1'],
                        'tc_total_1' => $options['tc_total_1']
                    );
                    //get the id of other dual division
                    $dual_array = array('competition_id' => $options['competition_id'], 'canine_id' => $options['canine_id'], 'division_id !=' => $options['division_id'], 'dual' => '1');
                    $dual = $this->competition_result_model->get_by($dual_array);
                    //update second record
                    $this->competition_result_model->update($dual->id, $data);
                }
                $this->competition_result_model->calculate_scores($options['competition_id'], $options['division_id']);
                $this->competition_result_model->calculate_overall_placement($options['competition_id'], $options['division_id']);
                $this->session->set_flashdata('message', 'Result updated');
                redirect('admin/competition_result/running/'.$options['competition_id'].'/'.$division->id);
            }
        }

        $this->data['main'] = 'admin/competition_result/layout';
        switch($view) {
            case 'fs':
                $this->data['internal_view'] = 'admin/competition_result/elements/fs';
                $this->data['order_view'] = 'fs_order';
                break;
            case 'tc':
                $this->data['internal_view'] = 'admin/competition_result/elements/tc';
                $this->data['order_view'] = 'tc_order';
                break;
            case 'tc_vertical':
                $this->data['internal_view'] = 'admin/competition_result/elements/tc_vertical';
                $this->data['order_view'] = 'tc_order';
                break;
            case 'edit':
                $this->data['internal_view'] = 'admin/competition_result/edit';
                $this->data['order_view'] = $existing->division->freestyle == 1?'fs_order':'tc_order';
                break;
        }
        $this->load->view('admin/scorekeep', $this->data);
    }


    public function running($competition_id, $division_id) {
        $this->data['competition'] = $this->competition_model->with('competition_type')->get_by(array('id' => $competition_id));        
        $this->data['division'] = $this->division_model->get($division_id);
        
        if($this->data['division']->freestyle == '1') {
            $type = 'fs_order';
        } else {
            $type = 'tc_order';
        }
        $this->data['teams'] = $this->competition_result_model->get_teams($competition_id, $division_id);

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
       $this->competition_result_model->calculate_scores($competition_id, $division_id);
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

   public function delete($id, $competition_id, $division_id) {
       try {
           $this->competition_result_model->delete($id);
           $this->session->set_flashdata('message', 'Team has been scratched');
           redirect('admin/competition_result/running/'.$competition_id.'/'.$division_id);
       } catch(Exception $e) {
           echo '<pre>';
           print_r($e);
           die(0);
       }
   }



    public function import($competition_id) {
        $this->data['form_open'] = 'admin/competition_result/import/'.$competition_id;
        $this->data['competition_id'] = $competition_id;
        $this->data['main'] = 'admin/competition_result/import';
        $this->load->view('admin/layout', $this->data);
    }


    public function import_file() {
        $this->load->model('competition_type_model');
        $competition_id = $_POST['competition_id'];
        $file_name = $_POST['file_name'];
        $test_import = $_POST['test_import'];

        $competition = $this->competition_model->get($competition_id);

        $competition_type = $this->competition_type_model->with('division')->get($competition->competition_type_id);

        $this->load->library('excel');
        $file = FCPATH.'/uploads/competition_result/'.$file_name;
        $file_type = PHPExcel_IOFactory::identify($file);
        $filterSubset = new MyReadFilter();
        $this->reader = PHPExcel_IOFactory::createReader($file_type);
        $this->reader->setReadFilter($filterSubset);
        $this->excel = $this->reader->load($file);
        $sheetData = $this->excel->getActiveSheet()->toArray(null,true,true,true);



        $map = $this->_map_import();
        $division_map = $this->_map_division($competition_type->division);
        $this->load->model(array('user_model', 'canine_model'));
        $html = '';
        if(!empty($sheetData)) {
            //do normal import
            if($test_import == 0) {
                try {
                    $html .= $this->_process_import($sheetData, $map, $division_map, $competition_id);
                    //now process placement, club placement and cup point for each division
                    foreach($division_map as $k=>$v) {
                        $this->competition_result_model->calculate_overall_placement($competition_id, $v);
                        $this->competition_result_model->calculate_club_placement($competition_id, $v);
                        $this->competition_result_model->calculate_cup_points($competition_id, $v);
                    }
                } catch(Exception $e) {
                    echo '<pre>';
                    print_r($e);
                    die('We died a terrible death');
                }
            } else {
                //test import
                $html .= $this->_test_import($sheetData, $map, $division_map);
            }

        }
        echo json_encode(array('html' => $html));

    }


    public function do_upload() {

        $config['upload_path'] = './uploads/competition_result/';
        $config['allowed_types'] = 'xls';
        $config['max_size'] = '60000';
        $config['file_name'] = $_FILES['file']['name'];

        $this->upload->initialize($config);


        if(!$this->upload->do_upload('file')) {
            log_message('error', $this->upload->display_errors());

        } else {
            $this->load->library('excel');
            $file_data = $this->upload->data();
            $file = FCPATH.'/uploads/competition_result/'.$file_data['file_name'];
            $array = array('file' => $file);
            header('Content-type: application/json');
            echo json_encode($array);
        }

    }

    private function _process_import($data, $map, $division_map, $competition_id) {
        $this->load->model('competition_model');
        $competition = $this->competition_model->get($competition_id);
        $competition_type_id = $competition->competition_type_id;
        $this->load->model('division_model');
        $dual_tc_division = $this->division_model->get_by(array('competition_type_id' => $competition_type_id, 'dual' => 1, 'freestyle' => 0));
        $dual_tc_division_id = $dual_tc_division->id;
        $html = '';

        foreach($data as $row) {
            if(!empty($row[$map['name']])) {
                $tc_data = $this->_process_tc($row, $map);
                $user = $this->_process_user($row[$map['name']]);
                $existing_canines = !empty($user->canine)?$user->canine:array();
                $canine = $this->_process_canine($user->id,$row[$map['canine']], $existing_canines);
                $division_id = $division_map[$row[$map['division']]];

                $result_row = array(
                    'competition_id' => $competition_id,
                    'division_id' => $division_id,
                    'user_id' => $user->id,
                    'canine_id' => $canine->id,
                    'fs_1_1' => $row[$map['fs_1_1']],
                    'fs_2_1' => $row[$map['fs_2_1']],
                    'fs_3_1' => $row[$map['fs_3_1']],
                    'fs_4_1' => $row[$map['fs_4_1']],
                    'cr_1' => $row[$map['cr_1']],
                    'deduct_1' => $row[$map['deduct_1']],
                    'fs_total_1' => $row[$map['fs_total_1']],
                    'tc_cat_1' => $tc_data['tc_cat_1'],
                    'tc_total_1' => $tc_data['tc_total_1'],
                    'fs_1_2' => $row[$map['fs_1_2']],
                    'fs_2_2' => $row[$map['fs_2_2']],
                    'fs_3_2' => $row[$map['fs_3_2']],
                    'fs_4_2' => $row[$map['fs_4_2']],
                    'cr_2' => $row[$map['cr_2']],
                    'deduct_2' => $row[$map['deduct_2']],
                    'fs_total_2' => $row[$map['fs_total_2']],
                    'tc_cat_2' => $tc_data['tc_cat_2'],
                    'tc_total_2' => $tc_data['tc_total_2'],
                    'tc_total' => $row[$map['tc_total']],
                    'fs_total' => $row[$map['fs_total']],
                    'total' => $row[$map['total']]
                );
                if(!empty($result_row)) {
                    try {
                        $competition_result = $this->competition_result_model->insert($result_row);
                        $html .= '<div class="alert alert-info">We added results for '.$user->full_name.' & '.$canine->name.' ('.$canine->id.') ';
                        if($row[$map['division']]  == 'Open') {
                            $result_row = array(
                                'competition_id' => $competition_id,
                                'division_id' => $dual_tc_division_id,
                                'user_id' => $user->id,
                                'canine_id' => $canine->id,
                                'tc_cat_1' => $tc_data['tc_cat_1'],
                                'tc_total_1' => $tc_data['tc_total_1'],
                                'tc_cat_2' => $tc_data['tc_cat_2'],
                                'tc_total_2' => $tc_data['tc_total_2'],
                                'tc_total' => $row[$map['tc_total']],
                                'total' => $tc_data['tc_total']
                            );
                            $competition_result = $this->competition_result_model->insert($result_row);
                            $html .= ' Added to OTC as well. ';
                        }
                        $html .= '</div>';
                    } catch(Exception $e) {
                        $html .= '<div class="alert alert-danger">An excpetion has occured with '.$user->full_name.' & '.$canine->name.'</div>';
                    }
                }

            }
        }
        return $html;
    }


    private function _process_user($user) {
        $name_array = explode(' ', $user);
        $first_name = $name_array[0];
        $last_name = isset($name_array[2])?$name_array[2]:$name_array[1];
        $user = $this->user_model->with('canine')->get_by(array('first_name' => $first_name, 'last_name' => $last_name));
        if(empty($user)) {
            $user_data = array('first_name' => $first_name, 'last_name' => $last_name);
            $user_id = $this->user_model->insert($user_data);
            $user = $this->user_model->with('canine')->get($user_id);
        }
        return $user;
    }

    private function _process_canine($user_id, $canine_name, $existing_canines = array()) {
        $canine = array();
        if(!empty($existing_canines)) {
            $found = false;
            foreach($existing_canines as $row) {
                if($row->name == $canine_name) {
                    $existing_canine = $row;
                    $found = true;
                }
            }
            if($found !== false) {
                $canine = $existing_canine;
            } else {
                $dog_data = array('user_id' => $user_id, 'name' => $canine_name);
                $canine_id = $this->canine_model->insert($dog_data);
                $canine = $this->canine_model->get($canine_id);
            }
        } else {
            $dog_data = array('user_id' => $user_id, 'name' => $canine_name);
            $canine_id = $this->canine_model->insert($dog_data);
            $canine = $this->canine_model->get($canine_id);
        }

        return $canine;

    }

    private function _process_tc($data, $map) {
        $result['tc_cat_1'] = '';
        $result['tc_total_1'] = $data[$map['tc_total_1']];
        $result['tc_cat_2'] = '';
        $result['tc_total_2'] = $data[$map['tc_total_2']];
        $result['tc_total'] = $data[$map['tc_total']];


        for($i=1; $i<=10; $i++) {
            if(!empty($data[$map['t1_'.$i]])) {
                $result['tc_cat_1'] .= $data[$map['t1_'.$i]].',';
            }
            if(!empty($data[$map['t2_'.$i]])) {
                $result['tc_cat_2'] .= $data[$map['t2_'.$i]].',';
            }
        }

        $result['tc_cat_1'] = rtrim($result['tc_cat_1'], ',');
        $result['tc_cat_2'] = rtrim($result['tc_cat_2'], ',');
        return $result;
    }

    //this function simply tests the import row and creates an HTML stream for viewing results, it sucks and I know it.
    private function _test_import($data, $map, $division_map) {
        $html = '';
        //loop through each record and test for insert
        foreach($data as $row) {

            if(!empty($row[$map['name']])) {
                $html .= '<div class="well">';
                $html .= '<h3>Testing: '.$row[$map['name']].' & '.$row[$map['canine']].' for division '.$division_map[$row[$map['division']]].' </h3>';
                if($row[$map['division']] == 'Open') {
                    $html .= '<h4>We also need to add an OTC record</h4>';
                }
                //run a couple of checks to see if we already have this user in the system.
                $name_array = explode(' ', $row[$map['name']]);
                $first_name = $name_array[0];
                $last_name = $name_array[1];
                if(isset($name_array[2])) {
                    $last_name = $name_array[2];
                }

                $user = $this->user_model->with('canine')->get_by(array('first_name' => $first_name, 'last_name' => $last_name));
                if(!empty($user)) {
                    $html .= '<h4>We found user '.$user->first_name.'</h4>';
                    if(!empty($user->canine)) {
                        $found = false;
                        $ul = '';
                        foreach($user->canine as $canine) {
                            if($row[$map['canine']] == $canine->name) {
                                $existing_canine = $canine;
                                $found = true;
                            } else {
                                $ul .= '<li>'.$canine->name.'</li>';
                            }
                        }
                        if($found !== false) {
                            $html .= '<h5>We found canine '.$existing_canine->name.'</h5>';
                        } else {
                            $html .= '<div class="alert alert-danger" role="alert">';
                            $html .= '<p>We could not find this canine '.$row[$map['canine']].'. </p><p>Please review the list of canines for this user and see if there is a slight variant in names. If so, update the spreadsheet being uploaded to reflect the name in our system.';
                            $html .= '<ul>'.$ul.'</ul>';
                            $html .= '</div>';
                        }
                    }

                } else {
                    $html .= '<div class="alert alert-danger" role="alert">';
                    $options = array('first_name' => $name_array[0], 'last_name' => $name_array[1], 'canine' => $row[$map['canine']]);
                    $html .= '<p>We need to add '.$row[$map['name']].' and '.$row[$map['canine']].'</p>';
                    $html .= '</div>';
                }
                $html .= '</div>';
            }
        }

        return $html;

    }

    private function _map_division($divisions) {
        //$division_maps = array();
        foreach($divisions as $division) {
            $division_maps[$division->import_code] = $division->id;
        }
        return $division_maps;
    }


    private  function _map_import() {
        $map = array(
            'division' => 'A',
            'name' => 'B',
            'canine' => 'C',
            'cr_1' => 'D',
            'fs_1_1' => 'E',
            'fs_2_1' => 'F',
            'fs_3_1' => 'G',
            'fs_4_1' => 'H',
            'deduct_1' => 'I',
            'fs_total_1' => 'J',
            'cr_2' => 'K',
            'fs_1_2' => 'L',
            'fs_2_2' => 'M',
            'fs_3_2' => 'N',
            'fs_4_2' => 'O',
            'deduct_2' => 'P',
            'fs_total_2' => 'Q',
            't1_1' => 'R',
            't1_2' => 'S',
            't1_3' => 'T',
            't1_4' => 'U',
            't1_5' => 'V',
            't1_6' => 'W',
            't1_7' => 'X',
            't1_8' => 'Y',
            't1_9' => 'Z',
            't1_10' => 'AA',
            'tc_total_1' => 'AB',
            't2_1' => 'AC',
            't2_2' => 'AD',
            't2_3' => 'AE',
            't2_4' => 'AF',
            't2_5' => 'AG',
            't2_6' => 'AH',
            't2_7' => 'AI',
            't2_8' => 'AJ',
            't2_9' => 'AK',
            't2_10' => 'AL',
            'tc_total_2' => 'AM',
            'fs_total' => 'BQ',
            'tc_total' => 'BR',
            'total' => 'BU'
        );
        return $map;
    }




    private function _set_fields($existing) {
        $item = $existing;
        $tc_scores_1 = explode(',', $existing->tc_cat_1);

        $tc_scores_2 = explode(',', $existing->tc_cat_2);
        if(!empty($tc_scores_1)) {
            for($i=1; $i<=10; $i++) {
                $item->{"tc_1_$i"} = (isset($tc_scores_1[$i-1])  ? $tc_scores_1[$i-1]: NULL);
                if(!empty($tc_scores_2)) {
                    $item->{"tc_2_$i"} = (isset($tc_scores_2[$i-1]) ? $tc_scores_2[$i-1]: NULL);
                }
            }
        }
       return $item;
   }

   private function _get_pairs($user_id, $canine_id, $competition_id) {
       $this->load->model('registration_model');
       $options = array('user_id' => $user_id, 'canine_id' => $canine_id, 'competition_id' => $competition_id, 'division_id' => 5);
       $pairs = $this->registration_model->get_by($options);
       if(!empty($pairs)) {
           return $pairs->pairs;
       }
       return false;
   }
       
}



include APPPATH.'/third_party/PHPExcel/IOFactory.php';
class MyReadFilter implements PHPExcel_Reader_IReadFilter
{
    public function readCell($column, $row, $worksheetName = '') {
        // Read rows 1 to 7 and columns A to E only
        if ($row >= 2) {
            if (in_array($column,range('A','0'))) {
                return true;
            }
        }
        return false;
    }
}
?>
