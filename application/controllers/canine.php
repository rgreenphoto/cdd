<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Canine extends Member_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('table', 'upload'));
        $this->load->model(array('canine_model', 'user_model'));
        $this->data['display_social'] = false;
    }
    
    public function index() {
        $user_id = $this->the_user->id;
        $this->data['canines'] = $this->canine_model->get_many_by(array('user_id' => $user_id));
        $this->data['main'] = 'canine/index';
        $this->load->view('secondary_layout', $this->data);
    }
    
    
    public function add() {
        $this->data['title'] = 'Add Canine';
        $this->data['hidden'] = array('user_id' => $this->the_user->id, 'rescue' => '0');
        $this->data['attributes'] = array('class' => 'form-horizontal');
        $return_url = ($this->agent->referrer() == base_url().'user/edit')?'user/edit/#tab_dogs':'user/member';
        $this->data['return_url'] = $return_url;
        $this->data['user'] = $this->user_model->with('canine')->get($this->the_user->id);
                          
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);
            
            if($this->canine_model->insert($options)) {
                $this->session->set_flashdata('message', 'Record Added');
                redirect($return_url);
            }            
        } 
        
        $this->data['main'] = 'canine/edit';
        $this->load->view('secondary_layout', $this->data);        
    }
    
    public function edit($canine_id) {
        $this->js = array(base_url().'assets/js/plupload/js/plupload.full.js');      
        $this->data['title'] = 'Edit Canine'; 
        //set up return to either member info tab or member profile 
        $return_url = ($this->agent->referrer() == base_url().'user/edit')?'user/edit/#tab_dogs':'user/member';        

        $this->data['return_url'] = $return_url;
        $this->data['canine'] = $this->canine_model->get_by(array('user_id' => $this->the_user->id, 'id' => $canine_id));
        if(!empty($this->data['canine'])) {
            $this->data['hidden'] = array('id' => $canine_id, 'user_id' => $this->the_user->id, 'rescue' => '0');
            $this->data['attributes'] = array('method' => 'post');
            $this->data['id'] = $canine_id;

            if($this->data['canine']->display_profile == '1') $this->data['display_profile']['checked'] = 'checked';


            if(!empty($_POST)) {
                
                $options = $this->set_post_options($_POST);
                if($this->canine_model->update($this->data['id'], $options)) {
                    $this->session->set_flashdata('message', 'Record Saved.');
                    redirect($return_url);
                } 
            }
            $this->data['main'] = 'canine/edit';

            $this->load->view('secondary_layout', $this->data);            
        } else {
            redirect('security_breach');
        }
        

        
    }
    
  public function do_upload($canine_id) {
      $config['upload_path'] = './uploads/profiles/';
      $config['allowed_types'] = 'jpg|png|gif';
      $config['max_size'] = '20000000';
      $config['file_name'] = $canine_id.'_'.$_FILES['file']['name'];
      
      $this->upload->initialize($config);
      $this->output->enable_profiler(TRUE);
      
      if(!$this->upload->do_upload('file')) {
         log_message('error', $this->upload->display_errors());
          
      } else {
          $file = $this->upload->data();
          $data = array('image' =>  $file['file_name']);
          echo $canine_id;
          if(!$this->canine_model->add_image($canine_id, $file['file_name'])) {
              echo 'Oops';
          } else {
              $array = array('file' => $file['file_name']);
              //echo 'awesome';
              header('Content-type: application/json');  
              echo json_encode($array);
          }
          
      }
      
  }
  
  public function get() {
      $user_id = $this->input->post('user_id');
      $options = array('user_id' => $user_id);
      $canines = $this->canine_model->get_many_by($options);
      if(!empty($canines)) {
          echo json_encode($canines);
      } else {
          $error = 'Could not find dogs';
          echo json_encode($error);
      }
  }
    
  public function get_image($canine_id) {
      $image = $this->canine_model->get($canine_id);
      if(!empty($image)) {
          echo $image->image;
      } else {
          $image = 'Error';
          echo json_encode($image);
      }
  }    
       
}

?>
