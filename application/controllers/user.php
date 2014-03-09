<?php

/* Russ Green rgreen@rgreenphotography.com
 */
class User extends Member_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library(array('upload', 'form_validation'));
        $this->load->helper(array('download'));
        $this->data['display_social'] = false;
    }
    
    public function index() {
        $options = array('privacy' => 'Public');
        if(!empty($this->data['group_member'])) {
            $array = array('privacy' => 'Member');
            array_push($options, $array);
        }
        $this->data['users'] = $this->user_model->with('canine')->get_many_by($options);
        $this->data['main'] = 'user/index';
        $this->load->view('secondary_layout', $this->data);
        
    }
    
    public function edit() {
        $this->data['title'] = 'Edit User';
        //already have the user stored in object, we'll just use that for this section
        $this->data['attributes'] = array('method' => 'post');
        $this->data['hidden'] = array('id' => $this->the_user->id);
        
        if (!empty($_POST) && $this->user_model->validate($_POST)) {
            $options = $this->set_post_options($_POST);
            if($this->ion_auth->update($this->the_user->id, $options)) {                                
                $this->session->set_flashdata('message', 'Record Saved');
                redirect('user/edit');
            }       
        }       
        
        $this->data['main'] = 'user/edit';
        $this->load->view('secondary_layout', $this->data);
        
  }
  
  public function change_password() {
        //update the password if it was posted
        $password = $this->input->post('password');
        if (!empty($password)) {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
            $options['password'] = $this->input->post('password');
            if($this->form_validation->run() === TRUE) {
                try {
                    $this->ion_auth->update($this->the_user->id, $options);
                    $this->session->set_flashdata('message', 'Password changed');
                    redirect('user/edit/#tab_passwd');
                } catch (Exception $ex) {
                    $this->session->set_flashdata('error_message', 'Danger Will Robinson');
                    redirect('user/edit/#tab_passwd');
                }
                
            }

        }       
  } 
  
  public function member() {
      if($this->the_user->group_id != '3') {
          redirect('/error/security_violation');
      }
        $this->data['display_social'] = false;
        $id = $this->the_user->id;
        $this->data['title'] = 'Edit Bio';
      
        $this->data['user'] = $this->user_model->with('standing')->get($id);
        $this->data['page_image'] = base_url().'uploads/profiles/'.$this->data['user']->profile_image;
        $this->load->model('canine_model');
        $options = array('user_id' => $id);
        $this->data['canines'] = $this->canine_model->with('competition_result')->get_many_by($options);        
        
        $groups = $this->ion_auth_model->get_users_groups($id);
        $groups = $groups->result();
        //set flags
        if(!empty($groups)) {
            foreach($groups as $row) {
                if($row->name == 'users') {
                    $this->data['group_user'] = 1;
                }
                if($row->name == 'members') {
                    $this->data['group_member'] = 1;
                }
            }
        }      
        $this->set_form_options(array(
            'member_bio'
        ));      
        
        $this->data['member_bio']['class'] = 'col-lg-12';
        $this->data['member_bio']['rows'] = '6';
        
        
        if(!empty($this->the_user->teaser)) {
            $this->data['teaser']['value'] = $this->the_user->teaser;
        }
        
        if(!empty($this->the_user->member_bio)) {
            $this->data['member_bio']['value'] = $this->the_user->member_bio;
            $this->data['member_bio']['class'] = 'form-control';
        }
        
        $this->data['attributes'] = array('class' => 'form');
        $this->data['hidden'] = array();      
      
        if (!empty($_POST)) {
            $options = $this->set_post_options($_POST);         
            if($this->user_model->update($this->the_user->id, $options)) {                                
                $this->session->set_flashdata('message', 'Record Saved');
                redirect('user/member');
            }       
        }       
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/plupload/js/plupload.full.js', base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');              
        $this->data['main'] = 'user/member';
        $this->load->view('photo_layout', $this->data);
  }
  
  public function bio() {
      $id = $this->the_user->id;
        if (!empty($_POST)) {
            $options = $this->set_post_options($_POST);             
            $new_bio = $_POST['member_bio'];
            if($this->user_model->update($this->the_user->id, $options)) {                                
                echo $new_bio;
            }    
        }       
  }
  
  public function scores() {
      $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
      $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js');      
      $id = $this->the_user->id;
      $this->data['title'] = 'Score History';
      $this->data['user'] = $this->user_model->with('competition_result')->get($id);
      $this->data['main'] = 'user/scores';
      $this->load->view('score_layout', $this->data);
  }

  public function score_sheets() {
      $season = date('Y');
  
      $this->data['attributes'] = array('class' => 'form-horizontal');
      $this->data['hidden'] = array();
      
      
      
      //grab the competitions for this season
      $this->load->model(array('competition_model'));
      $comps = $this->competition_model->get_event($season);
      if(!empty($comps)) {
          $this->data['competitions'][''] = 'Select Competition';
          foreach($comps as $row) {
              $this->data['competitions'][$row->id] = $row->name.' ('.$row->date.')';
          }
      }
      $this->data['title'] = 'Print Score Sheets';
      $this->data['main'] = 'user/score_sheets';
      $this->load->view('secondary_layout', $this->data);
      if(!empty($_POST)) {
          $this->load->model('competition_result_model');
          $user_id = $this->the_user->id;
          $canine_id = $this->input->post('canine_id');
          $competition_id = $this->input->post('competition_id');
          $division_id = $this->input->post('division_id');
          $results_options = array(
              'user_id' => $user_id,
              'canine_id' => $canine_id,
              'competition_id' => $competition_id,
              'division_id' => $division_id,);
          $results = $this->competition_result_model->with('user')->with('canine')->with('division')->get_by($results_options);
          if(!empty($results)) {
              $this->load->library('word');
              $file_in = './uploads/templates/'.$results->division->template;
              $template = $this->word->loadTemplate($file_in);
              $template->setValue('handlerName', (!empty($results->user->full_name) ? $results->user->full_name: ''));
              $template->setValue('street', (!empty($results->user->address) ? $results->user->address: ''));
              $template->setValue('city', (!empty($results->user->city) ? $results->user->city: ''));
              $template->setValue('state', (!empty($results->user->state) ? $results->user->state: ''));
              $template->setValue('zip', (!empty($results->user->zip) ? $results->user->zip: ''));
              $template->setValue('email', (!empty($results->user->email) ? $results->user->email: ''));
              $template->setValue('division', (!empty($results->division) ? $results->division: ''));
              $template->setValue('dog', (!empty($results->canine->name) ? $results->canine->name: ''));
              $template->setValue('event_date', (!empty($results->date) ? $results->date: ''));
              $template->setValue('dog_id', (!empty($results->canine_id) ? $results->canine_id: ''));
              $template->setValue('age', (!empty($results->canine->age) ? $results->canine->age: ''));
              
              //explode the toss and catch scores
              $tc_scores_1 = explode(',', $results->tc_cat_1);
              $template->setValue('t1', (!empty($tc_scores_1[0]) ? $tc_scores_1[0]: ''));
              $template->setValue('t2', (!empty($tc_scores_1[1]) ? $tc_scores_1[1]: ''));
              $template->setValue('t3', (!empty($tc_scores_1[2]) ? $tc_scores_1[2]: ''));
              $template->setValue('t4', (!empty($tc_scores_1[3]) ? $tc_scores_1[3]: ''));
              $template->setValue('t5', (!empty($tc_scores_1[4]) ? $tc_scores_1[4]: ''));
              $template->setValue('t6', (!empty($tc_scores_1[5]) ? $tc_scores_1[5]: ''));
              $template->setValue('t7', (!empty($tc_scores_1[6]) ? $tc_scores_1[6]: ''));
              $template->setValue('t8', (!empty($tc_scores_1[7]) ? $tc_scores_1[7]: ''));
              $template->setValue('t9', (!empty($tc_scores_1[8]) ? $tc_scores_1[8]: ''));
              $template->setValue('t10', (!empty($tc_scores_1[9]) ? $tc_scores_1[9]: ''));
              $template->setValue('tt', (!empty($results->tc_total_1) ? $results->tc_total_1: ''));
              $tc_scores_2 = explode(',', $results->tc_cat_2);
              $template->setValue('t21', (!empty($tc_scores_2[0]) ? $tc_scores_2[0]: ''));
              $template->setValue('t22', (!empty($tc_scores_2[1]) ? $tc_scores_2[1]: ''));
              $template->setValue('t23', (!empty($tc_scores_2[2]) ? $tc_scores_2[2]: ''));
              $template->setValue('t24', (!empty($tc_scores_2[3]) ? $tc_scores_2[3]: ''));
              $template->setValue('t25', (!empty($tc_scores_2[4]) ? $tc_scores_2[4]: ''));
              $template->setValue('t26', (!empty($tc_scores_2[5]) ? $tc_scores_2[5]: ''));
              $template->setValue('t27', (!empty($tc_scores_2[6]) ? $tc_scores_2[6]: ''));
              $template->setValue('t28', (!empty($tc_scores_2[7]) ? $tc_scores_2[7]: ''));
              $template->setValue('t29', (!empty($tc_scores_2[8]) ? $tc_scores_2[8]: ''));
              $template->setValue('t210', (!empty($tc_scores_2[9]) ? $tc_scores_2[9]: ''));
              $template->setValue('tt2', (!empty($results->tc_total_2) ? $results->tc_total_2: ''));
              $template->setValue('f1', (!empty($results->fs_1_1) ? $results->fs_1_1: ''));
              $template->setValue('f2', (!empty($results->fs_2_1) ? $results->fs_2_1: ''));
              $template->setValue('f3', (!empty($results->fs_3_1) ? $results->fs_3_1: ''));
              $template->setValue('f4', (!empty($results->fs_4_1) ? $results->fs_4_1: ''));
              $template->setValue('ft', (!empty($results->fs_total_1) ? $results->fs_total_1: ''));
              $template->setValue('f12', (!empty($results->fs_1_2) ? $results->fs_1_2: ''));
              $template->setValue('f22', (!empty($results->fs_2_2) ? $results->fs_2_2: ''));
              $template->setValue('f32', (!empty($results->fs_3_2) ? $results->fs_3_2: ''));
              $template->setValue('f42', (!empty($results->fs_4_2) ? $results->fs_4_2: ''));
              $template->setValue('ft2', (!empty($results->fs_total_2) ? $results->fs_total_2: ''));
              $template->setValue('t', (!empty($results->total) ? $results->total: ''));
              $new_file = $template->save('savefile.docx');
                if(is_file($new_file)) {
                    $data = file_get_contents($new_file);
                    unlink($new_file);
                    force_download('Skyhoundz_Reg_Forms.docx', $data);
                } else {
                    $this->session->set_flashdata('message', 'Could not generate document.');
                    redirect('/user/score_sheets/');
                }   
          } else {
              $this->session->set_flashdata('message', 'No results found');
              redirect('user/score_sheets');
          }
          
          
      }
      
      

//      $id = $this->the_user->id;   
  }  
  
  public function settings() {
      if($this->the_user->group_id != '3') {
          redirect('/error/security_violation');
      }
      
        $id = $this->the_user->id;
        $this->data['title'] = 'Privacy Settings';
       
        $this->data['user'] = $this->user_model->get($id);     
        $groups = $this->ion_auth_model->get_users_groups($id);
        $groups = $groups->result();
        //set flags
        if(!empty($groups)) {
            foreach($groups as $row) {
                if($row->name == 'users') {
                    $this->data['group_user'] = 1;
                }
                if($row->name == 'members') {
                    $this->data['group_member'] = 1;
                }
            }
        }      
        $this->data['attributes'] = array('class' => 'form-horizontal');
        $this->data['hidden'] = array();      
      
        if (!empty($_POST)) {
            $options = $this->set_post_options($_POST);                 
            if($this->user_model->update($this->the_user->id, $options)) {                                
                $this->session->set_flashdata('message', 'Account Settings Updated');
                redirect('user/settings');
            }
        }       
        $this->data['main'] = 'user/privacy';
        $this->load->view('secondary_layout', $this->data);        
  }
  
  
  
  public function do_upload($user_id) {
      $config['upload_path'] = './uploads/profiles/';
      $config['allowed_types'] = 'jpg|png|gif|JPG|jpeg';
      $config['max_size'] = '20000000';
      $config['file_name'] = $user_id.'_'.$_FILES['file']['name'];
      
      $this->upload->initialize($config);
      
      
      if(!$this->upload->do_upload('file')) {
          log_message('error', $this->upload->display_errors());
          echo json_encode('File to large');
          
      } else {
          $file = $this->upload->data();
          $data = array('profile_image' =>  $file['file_name']);
          if(!$this->user_model->update($user_id, $data)) {
              echo 'Oops';
          } else {
              $array = array('file' => $file['file_name']);
              //echo 'awesome';
              header('Content-type: application/json');  
              echo json_encode($array);
          }
          
      }
      
  }
  
  public function get_image($user_id) {
      $image = $this->user_model->get($user_id);
      if(!empty($image)) {
          echo $image->profile_image;
      } else {
          $image = 'Error';
          echo json_encode($image);
      }
  }
  
  public function family() {
      if(!empty($this->data['the_family'])) {
          $i=0;
          foreach($this->data['the_family'] as $row) {
              $this->data['family'][$i]['name'] = $row->full_name;
              $i++;
          }
      }
      $this->data['main'] = 'user/family';
      $this->load->view('secondary_layout', $this->data);
  }
  
  public function add_family() {
      if(!empty($this->data['the_user']->family_id)) {
          if(!empty($_POST)) {
              $data = $this->set_post_options($_POST);
              $new_id = $this->user_model->get_next_member_id();
              $data['member_id'] = $new_id[0]->member_id;
              $data['family_id'] = $this->data['the_user']->family_id;
              if($this->user_model->insert($data, TRUE)) {
                  redirect('user/family');
              } else {
                  echo 'No Go';
              }
          }
      }
      $this->data['main'] = 'user/add_family';
      $this->load->view('secondary_layout', $this->data);   
  } 
}
?>
