<?php

/*
 * Russ Green rgreen@rgreenphotography.com
 */

class Division extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('division_model', 'points_guide_model', 'competition_type_model'));
        $this->data['dual_categories'] = array('0' => 'Not Dual', '1' => 'Dual Division', '2' => 'Registration Category Only');
        $this->data['yes_no'] = array('1' => 'Yes', '0' => 'No');
    }
    
    public function add($competition_type_id) {
        $this->data['title'] = 'Add Division';
        //grab points scale for divisions
        $this->data['points'] = $this->points_guide_model->get_select();
        
        $this->data['hidden'] = array(
            'competition_type_id' => $competition_type_id);

        $this->data['division']->competition_type = $this->competition_type_model->get($competition_type_id);
        $this->data['name'] = array(
            'id' => 'name',
            'name' => 'name'
        );
        
        $this->data['type'] = '';
        $this->data['freestyle'] = '';
        $this->data['dual'] = '';
        
        if(!empty($_POST)) {
           $options = $this->set_post_options($_POST);
           if($_FILES && $_FILES['template']['name']) {
               $options['template'] = $this->_do_upload($id);
           }
           if($this->division_model->insert($options)) {
               $this->session->set_flashdata('message', 'Record updated');
               redirect('admin/competition_type/edit/'.$competition_type_id);
           } else {
               $this->session->set_flashdata('message', 'Could not update record');
               redirect('admin/division/edit/'.$id);
           }
            
        }
        $this->data['main'] = 'admin/division/edit';
        $this->load->view('admin/layout', $this->data); 
    }    
    
    public function edit($id) {
        $this->data['division'] = $this->division_model->with('competition_type')->get($id);
        $this->data['title'] = 'Edit Division';
        //grab points scale for divisions
        $this->data['points'] = $this->points_guide_model->get_select();
        
        $this->data['hidden'] = array(
            'competition_type_id' => $this->data['division']->competition_type_id);
        
        $this->data['name'] = array(
            'id' => 'name',
            'name' => 'name',
            'value' => $this->data['division']->name
        );
        
        $this->data['freestyle'] = $this->data['division']->freestyle;
        $this->data['dual'] = $this->data['division']->dual;
        
        $this->data['type'] = $this->data['division']->points_type;
        
        if(!empty($_POST)) {
           $options = $this->set_post_options($_POST);
           if($_FILES && $_FILES['template']['name']) {
               $options['template'] = $this->_do_upload($id);
           }
           if($this->division_model->update($id, $options)) {
               $this->session->set_flashdata('message', 'Record updated');
               redirect('admin/competition_type/edit/'.$this->data['division']->competition_type_id);
           } else {
               $this->session->set_flashdata('message', 'Could not update record');
               redirect('admin/division/edit/'.$id);
           }
            
        }
        $this->data['main'] = 'admin/division/edit';
        $this->load->view('admin/layout', $this->data); 
    }
    
    public function get_divisions() {
        $competition_type_id = $this->input->post('competition_type_id');
        if(!empty($competition_type_id)) {
            $options = array('competition_type_id' => $competition_type_id);
            $this->data['divisions'] = $this->division_model->get_many_by($options);
            $this->load->model('competition_fee_model');
            $competition_id = $this->input->post('competition_id');
            if(!empty($competition_id)) {
                $options = array('competition_id' => $competition_id);
                $this->data['competition_fees'] = $this->competition_fee_model->get_many_by($options);
                if(!empty($this->data['competition_fees'])) {
                   foreach($this->data['competition_fees'] as $row) {
                       $this->data['competition_fee'][$row->name]['fee'] = $row->fee;
                   }
                }            
            }
            
            $this->load->view('admin/division/divisions', $this->data);
        }  
    }

    public function delete($id, $competition_type_id) {
        if(!empty($id)) {
            if($this->division_model->delete($id)) {
                $this->session->set_flashdata('message', 'Record Deleted');
                redirect('admin/competition_type/edit/'.$competition_type_id);
            } else {
                $this->session->set_flashdata('message', 'Could not delete record.');
                redirect('admin/competition_type/edit/'.$competition_type_id);
            }
        } else {
            $this->session->set_flashdata('message', 'ID for this item is missing.');
            redirect('admin/competition_type/edit/'.$competition_type_id);
        }
    }
    
  private function _do_upload($id) {
      $config['upload_path'] = './uploads/templates/';
      $config['allowed_types'] = 'docx|doc';
      $config['max_size'] = '20000000';
      $config['file_name'] = $id.'_'.$_FILES['template']['name'];
      $config['overwrite'] = TRUE;
      
      $this->upload->initialize($config);
      
      if(!$this->upload->do_upload('template')) {
          log_message('error', $this->upload->display_errors());
          $file = $this->upload->data();
          return $file['file_type'];
      } else {
          $file = $this->upload->data();
          return $file['file_name'];
      }
      
  }     
}


?>
