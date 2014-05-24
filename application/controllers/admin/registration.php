<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Registration extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('registration_model', 'competition_model', 'competition_result_model'));
        $this->load->library(array('excel'));
        $this->load->helper(array('download', 'csv'));
    }    
    
    public function quick_add_form($competition_id, $user_id = '') {
        $this->data['competitors'] = $this->competition_result_model->check_table_status($competition_id);
        $this->data['hidden'] = array('competition_id' => $competition_id);
        if(!empty($competition_id)) {
            $this->load->model(array('competition_model', 'division_model'));
            $competition = $this->competition_model->get($competition_id);
            if(!empty($competition)) {
                //grab divisions
                $this->data['divisions'] = $this->division_model->get_full_list($competition->competition_type_id);
                $this->data['competition_name'] = $competition->name;
                $this->data['competition_id'] = $competition->id;
            }
        }
        if(!empty($user_id)) {
            $this->data['user_id'] = $user_id; 
            $this->data['hidden']['user_id'] = $user_id;
            $this->data['user'] = $this->user_model->with('canine')->get($user_id);
            //check for existing registrations
            $options = array('competition_id' => $competition_id, 'user_id' => $user_id);
            $this->data['registrations'] = $this->registration_model->with('canine')->with('division')->get_many_by($options);
        }
        $this->data['main'] = 'admin/registration/quick_add';
        $this->load->view('admin/registration/quick_add', $this->data);
    }
    
    public function quick_add() {
        if(!empty($_POST)) {
            if($this->registration_model->quick_add($_POST)) {
                echo json_encode(array('message' => 'Success'));
            } else {
                echo json_encode(array('error_message' => 'Fail'));
            }
        }
    }

    public function generate_mailmerge($competition_id) {
        $registrations = $this->registration_model->get_mailmerge($competition_id);
        if(!empty($registrations)) {
            array_to_csv($registrations, 'mailmerge.csv');
        }       
    }
    
    public function generate_list($competition_id) {
        $competition = $this->competition_model->get($competition_id);
        $registrations = $this->registration_model->get_list($competition);
        if(!empty($registrations)) {
            array_to_csv($registrations, $competition->name.'.csv');
        }  
    }
 
    public function generate_user_registration($competition_id) {
        $division = $this->registration_model->get_forms_by_user($competition_id);        
        if(!empty($division)) {
            $this->load->library('word');
            $file_in = './uploads/templates/SkyhoundzChampionshipsQualifierCompetitorRegistrationForm.docx';
            $template = $this->word->loadTemplate($file_in);
            if(!empty($division->users)) {
                $i = 0;
                foreach($division->users as $row) {

                    if($i > 0) {
                        $template->AddPage();
                    }

                    $template->setValue('first_name', (!empty($row->first_name) ? $row->first_name: ''));
                    $template->setValue('last_name', (!empty($row->last_name) ? $row->last_name: ''));
                    $template->setValue('handlerName', (!empty($row->full_name) ? $row->full_name: ''));
                    $template->setValue('phone', (!empty($row->phone) ? $row->phone: ''));
                    $template->setValue('email', $row->email);;
                    $template->setValue('address', $row->address.' '.$row->city.' '.$row->state.' '.$row->zip);
                    $template->setValue('event_name', $row->competition->name);
                    $template->setValue('event_location', $row->competition->location);
                    $template->setValue('event_date', $row->competition->date);
                    if(!empty($row->registrations)) {
                        $d=1;
                        foreach($row->registrations as $dogs) {
                            if(!empty($dogs->canine->name) && $dogs->canine->name != '') {
                                $template->setValue('dog'.$d, $dogs->canine->name);
                                $template->setValue($d.'_age', $dogs->canine->age);
                                $template->setValue($d.'_breed', $dogs->canine->breed);
                                $template->setValue('division_'.$d, $dogs->division->name);                                
                                $d++;
                            }

                              
                        }
                    }
                    
                    $i++;                         
                }
            }                
            //$file_name = str_replace(' ', '_', str_replace(')', '',str_replace('(', '', str_replace(',', '', str_replace('.', '', $row->competition->name))))).'_'.$row->competition->date.'_'.str_replace(')', '', str_replace('(', '', $division->name));
            //$file_out = '/uploads/'.$file_name.'.docx';
            $new_file = $template->save('savefile.docx');
                if(is_file($new_file)) {
                    $data = file_get_contents($new_file);
                    unlink($new_file);
                    force_download('Skyhoundz_Reg_Forms.docx', $data);
                } else {
                    $this->session->set_flashdata('message', 'Could not generate document.');
                    redirect('/admin/gameday/'.$competition_id);
                }
            
        } else {
            $this->session->set_flashdata('message', 'No forms to print');
            redirect('/admin/gameday/'.$competition_id);
        }        
    }
    
    
    public function generate_forms($competition_id, $division_id) {
        //up memory in case we have large files
        ini_set("memory_limit","96550M");
        $this->load->model(array('competition_result_model', 'competition_fee_model'));
        $division = $this->competition_result_model->get_forms_by_division($competition_id, $division_id);

        if(!empty($division)) {
            $this->load->library('word');
            $file_in = './uploads/templates/'.$division->template;
            $template = $this->word->loadTemplate($file_in);
            if(!empty($division->registrations)) {
                $i = 0;
                foreach($division->registrations as $row) {
                    if($i > 0) {
                        $template->AddPage();
                    }
                    $template->setValue('first_name', (!empty($row->user->first_name) ? $row->user->first_name: ''));
                    $template->setValue('last_name', (!empty($row->user->last_name) ? $row->user->last_name: ''));
                    $template->setValue('handlerName', (!empty($row->user->full_name) ? $row->user->full_name: ''));
                    $template->setValue('phone', (!empty($row->user->phone) ? $row->user->phone: ''));
                    $template->setValue('email', (!empty($row->user->email) ? $row->user->email: ''));
                    $template->setValue('fee', (!empty($row->fees) ? $row->fees: ''));
                    $address = '';
                    if(!empty($row->user->address)) $address .= $row->user->address.' ';
                    if(!empty($row->user->city)) $address .= $row->user->city.' ';
                    if(!empty($row->user->state)) $address .= $row->user->state.' ';
                    if(!empty($row->user->zip)) $address .= $row->user->zip.' ';
                    $template->setValue('street', (!empty($row->user->address) ? $row->user->address: ''));
                    $template->setValue('city', (!empty($row->user->city) ? $row->user->city: ''));
                    $template->setValue('state', (!empty($row->user->state) ? $row->user->state: ''));
                    $template->setValue('zip', (!empty($row->user->zip) ? $row->user->zip: ''));
                    $template->setValue('address', $address);
                    $template->setValue('division', "{$division->name}");
                    $template->setValue('dog', $row->canine->name);
                    $template->setValue('dog_id', (!empty($row->canine->dog_id) ? $row->canine->dog_id: ''));
                    if(!empty($row->canine->age)) {
                        $template->setValue('age', $row->canine->age);
                    } else {
                        $template->setValue('age', '');
                    }
                    if(!empty($row->canine->breed)) {
                        $template->setValue('breed', $row->canine->breed);
                    } else {
                        $template->setValue('breed', '');
                    }
                    if(!empty($row->pairs)) {
                        $template->setValue('pairs', $row->pairs);
                    }

                    $template->setValue('event_name', $division->competition->name);
                    $template->setValue('event_location', $division->competition->location);
                    $template->setValue('event_date', $division->competition->date);
                    $template->setValue('event_date_2', $division->competition->date);
                    $template->setValue('running_order', '');
                    $template = $this->_set_score_fields($template);
                    $i++;                         
                }
            }                
            $file_name = str_replace(' ', '_', str_replace(')', '',str_replace('(', '', str_replace(',', '', str_replace('.', '', $division->competition->name))))).'_'.$division->competition->date.'_'.str_replace(')', '', str_replace('(', '', $division->name));
            //$file_out = '/uploads/'.$file_name.'.docx';
            $new_file = $template->save('savefile.docx');
                if(is_file($new_file)) {
                    $data = file_get_contents($new_file);
                    unlink($new_file);
                    force_download($file_name.'.docx', $data);
                } else {
                    $this->session->set_flashdata('message', 'Could not generate document.');
                    redirect('/admin/gameday/'.$competition_id);
                }
            
        } else {
            $this->session->set_flashdata('message', 'No forms to print');
            redirect('/admin/gameday/'.$competition_id);
        } 
    }
    
    
    public function edit($id) {
        $this->data['title'] = 'Edit Registration';
        //grab registration details and addition details based on results
        $registration = $this->registration_model->with('user')->with('canine')->with('competition')->with('division')->get($id);
        $this->data['registration'] = $registration;
        //grab divisions for this competition type
        if(!empty($registration->competition->competition_type_id)) {
            $this->data['divisions'] = $this->division_model->get_full_list($registration->competition->competition_type_id);
        }

        if(!empty($_POST)) {
            //save method
            $options = $this->set_post_options($_POST);
                //need to alter the competition_result table in case we already set it up.
                $this->load->model(array('competition_result_model'));
                $this->competition_result_model->adjust_scores($options, $registration);
            if($this->registration_model->update($id, $options)) {
                $this->session->set_flashdata('success_message', 'Record Saved');
                redirect('admin/gameday/'.$options['competition_id']);
            }
        } else {
            //view method
            $this->data['form_open'] = 'admin/registration/edit/'.$id;
            $this->data['attributes'] = array('method' => 'post');
            $this->data['hidden'] = array(
                'competition_id' => $registration->competition->id,
                'user_id' => $registration->user_id,
                'canine_id' => $registration->canine_id,
                'dual' => $registration->dual);
            $this->data['main'] = 'admin/registration/edit';
            $this->load->view('admin/layout', $this->data);
        }
        
    }
    
    public function delete($id, $competition_id, $user_id, $canine_id, $division_id) {
        //grab competition id for redirect
        if(!empty($id)) {
            $this->load->model('competition_result_model');
            $competition_result_data = array('user_id' => $user_id, 'canine_id' => $canine_id, 'division_id' => $division_id);
            $this->competition_result_model->delete_by($competition_result_data);
            if($this->registration_model->delete($id)) {
                $this->session->set_flashdata('message', 'Record Deleted.');
                redirect('admin/gameday/'.$competition_id);
            } else {
                $this->session->set_flashdata('message', 'Could not delete record.');
                redirect('admin/gameday/'.$competition_id);
            }
        } else {
            $this->session->set_flashdata('message', 'No ID to delete');
            redirect('admin/gameday/'.$competition_id);
        }        
        
    }

   public function generate_spreadsheet($competition_id) {
       $competition = $this->competition_model->get($competition_id);
       $registrations = $this->registration_model->sort_divisions($competition->id);
       $this->load->helper('text');
       if(!empty($registrations)) {
           $excel = new PHPExcel();
           $i=0;
           foreach($registrations as $k=>$v) {
               $excel->createSheet(NULL, $i);
               $excel->setActiveSheetIndex($i);
               $excel->getActiveSheet()->setTitle(url_title(character_limiter(str_replace('Skyhoundz', '', $k), 29), ' '));
               $excel->getActiveSheet()->setCellValue('A1', 'user_id');
               $excel->getActiveSheet()->setCellValue('B1', 'canine_id');
               $excel->getActiveSheet()->setCellValue('C1', 'competition_id');
               $excel->getActiveSheet()->setCellValue('D1', 'division_id');
               $excel->getActiveSheet()->setCellValue('E1', 'score');
               $excel->getActiveSheet()->setCellValue('F1', 'Handler');
               $excel->getActiveSheet()->setCellValue('G1', 'Canine');
               $excel->getActiveSheet()->setCellValue('H1', 'FS1');
               $excel->getActiveSheet()->setCellValue('I1', 'FS2');
               $excel->getActiveSheet()->setCellValue('J1', 'FS3');
               $excel->getActiveSheet()->setCellValue('K1', 'FS4');
               $excel->getActiveSheet()->setCellValue('L1', 'FS Total');
               $excel->getActiveSheet()->setCellValue('M1', 'T1_Catches');
               $excel->getActiveSheet()->setCellValue('N1', 'TC1');
               $excel->getActiveSheet()->setCellValue('O1', 'T2_Catches');
               $excel->getActiveSheet()->setCellValue('P1', 'TC2');
               $excel->getActiveSheet()->setCellValue('Q1', 'TC Total');
               $excel->getActiveSheet()->setCellValue('R1', 'Total');
               if(is_array($v)) {
                   $a= '2';
                   foreach($v as $row) {
                       $excel->getActiveSheet()->setCellValue('A'.$a, $row['user_id']);
                       $excel->getActiveSheet()->setCellValue('B'.$a, $row['canine_id']);
                       $excel->getActiveSheet()->setCellValue('C'.$a, $row['competition_id']);
                       $excel->getActiveSheet()->setCellValue('D'.$a, $row['division_id']);
                       $excel->getActiveSheet()->setCellValue('E'.$a, $row['results']);
                       $excel->getActiveSheet()->setCellValue('F'.$a, $row['handler']);
                       $excel->getActiveSheet()->setCellValue('G'.$a, $row['canine']);
                       $excel->getActiveSheet()->setCellValue('L'.$a, '=PRODUCT(SUM(H'.$a.':K'.$a.'), 3)');
                       $excel->getActiveSheet()->setCellValue('Q'.$a, '=SUM(N'.$a.', P'.$a.')');
                       $excel->getActiveSheet()->setCellValue('R'.$a, '=SUM(L'.$a.', N'.$a.', P'.$a.')');
                       if($row['freestyle'] != '1') {
                           $excel->getActiveSheet()->getColumnDimension('H')->setVisible(false);
                           $excel->getActiveSheet()->getColumnDimension('I')->setVisible(false);
                           $excel->getActiveSheet()->getColumnDimension('J')->setVisible(false);
                           $excel->getActiveSheet()->getColumnDimension('K')->setVisible(false);
                           $excel->getActiveSheet()->getColumnDimension('L')->setVisible(false);
                       }
                       $a++;
                   }
               }
               $excel->getActiveSheet()->getColumnDimension('A')->setVisible(false);
               $excel->getActiveSheet()->getColumnDimension('B')->setVisible(false);
               $excel->getActiveSheet()->getColumnDimension('C')->setVisible(false);
               $excel->getActiveSheet()->getColumnDimension('D')->setVisible(false);
               $excel->getActiveSheet()->getColumnDimension('E')->setVisible(false);
               $i++;
           }
           $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
           $write->save('./uploads/spreadsheet.xls');
           $file = file_get_contents('./uploads/spreadsheet.xls');
           unlink('./uploads/spreadsheet.xls'); 
           force_download($competition->name.'.xls', $file);           
       }
   }    

    private function _get_running_order($registration, $division) {
        $this->load->model('competition_result_model');
        $options = array(
            'user_id' => $registration->user->id,
            'canine_id' => $registration->canine_id,
            'competition_id' => $division->competition->id,
            'division_id' => $division->id
        );
        $running_order = $this->competition_result_model->get_by($options);
        if(!empty($running_order)) {
            return $running_order->fs_order;
        }
    }


    private function _set_score_fields($template) {
        //this function simply sets score fields in the form to blank
        $template->setValue('t1', '');
        $template->setValue('t2', '');
        $template->setValue('t3', '');
        $template->setValue('t4', '');
        $template->setValue('t5', '');
        $template->setValue('t6', '');
        $template->setValue('t7', '');
        $template->setValue('t8', '');
        $template->setValue('t9', '');
        $template->setValue('t10', '');
        $template->setValue('tt', '');
        $template->setValue('t21', '');
        $template->setValue('t22', '');
        $template->setValue('t23', '');
        $template->setValue('t24', '');
        $template->setValue('t25', '');
        $template->setValue('t26', '');
        $template->setValue('t27', '');
        $template->setValue('t28', '');
        $template->setValue('t29', '');
        $template->setValue('t210', '');
        $template->setValue('tt2', '');
        $template->setValue('f1', '');
        $template->setValue('f2', '');
        $template->setValue('f3', '');
        $template->setValue('f4', '');
        $template->setValue('ft', '');
        $template->setValue('f12', '');
        $template->setValue('f22', '');
        $template->setValue('f32', '');
        $template->setValue('f42', '');
        $template->setValue('ft2', '');
        $template->setValue('t', '');
        return $template;
    }    
}
?>
