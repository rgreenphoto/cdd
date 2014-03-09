<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Canine extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('table'));
        $this->load->model(array('canine_model', 'user_model'));
    }
    
    
    public function add($user_id) {
        $this->data['title'] = 'Add Canine';
        $this->data['hidden'] = array('user_id' => $user_id, 'rescue' => '0');
        $this->data['attributes'] = array('class' => 'form-horizontal');
        
        $this->data['user'] = $this->user_model->with('canine')->get($user_id);
        //set up form variable
        $this->set_form_options(array('name', 'date_of_birth', 'breed', 'rescue', 'rescue_group','bio'));
        
        $this->data['date_of_birth']['class'] = 'date';
        $this->data['rescue']['type'] = 'checkbox';
        $this->data['rescue']['value'] = 1;
        $this->data['rescue_group']['class'] = 'span8';
        
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);
            
            if($this->canine_model->insert($options)) {
                $this->session->set_flashdata('message', 'Record Added');
                redirect('admin/user/edit/'.$user_id);
            }            
            
        } 
        
        $this->data['main'] = 'admin/canine/edit';
        $this->load->view('admin/layout', $this->data);        
    }
    
    public function edit($canine_id) {
        $this->data['title'] = 'Edit Canine';   
        $this->data['canine'] = $this->canine_model->get($canine_id);
        $this->data['hidden'] = array('id' => $canine_id, 'user_id' => $this->data['canine']->user_id, 'rescue' => '0');
        $this->data['attributes'] = array('class' => 'form-horizontal');
        $this->data['id'] = $canine_id;
        $this->data['user'] = $this->user_model->with('canine')->get($this->data['canine']->user_id);
        //set form options
        $this->set_form_options(array('name', 'date_of_birth', 'breed', 'rescue', 'rescue_group','bio'));
        
        //for edit form, just tack on the value once the array is created.
        $this->data['name']['value'] = $this->data['canine']->name;
        $this->data['date_of_birth']['value'] = $this->data['canine']->date_of_birth;
        $this->data['date_of_birth']['class'] = 'date';
        $this->data['breed']['value'] = $this->data['canine']->breed;
        $this->data['rescue']['type'] = 'checkbox';
        $this->data['rescue']['value'] = 1;
        if($this->data['canine']->rescue == 1) $this->data['rescue']['checked'] = 'checked';
        $this->data['rescue_group']['value'] = $this->data['canine']->rescue_group;
        $this->data['rescue_group']['class'] = 'span8';
        $this->data['bio']['value'] = $this->data['canine']->bio;
        
        
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);            
            if($this->canine_model->update($this->data['id'], $options)) {
                $this->session->set_flashdata('message', 'Record Saved.');
                redirect('admin/canine/edit/'.$this->data['canine']->id);
            } 
        }
        $this->data['main'] = 'admin/canine/edit';
        
        $this->load->view('admin/layout', $this->data);
        
    }
       
    
    public function delete($id) {
        if(!empty($id)) {
            if($this->canine_model->delete($id)) {
                $this->session->set_flashdata('message', 'Record Deleted.');
                redirect('admin/user');
            } else {
                $this->session->set_flashdata('message', 'Could not delete record.');
                redirect('admin/user');
            }
        } else {
            $this->session->set_flashdata('message', 'No ID to delete');
            redirect('admin/user');
        }
    }
    public function import() {
        
        $this->data['main'] = 'admin/canine/import';
        $this->load->view('admin/layout', $this->data);
    }    
  public function do_upload() {
      $config['upload_path'] = './uploads/canines/';
      $config['allowed_types'] = 'xlsx';
      $config['max_size'] = '2000';
      $config['file_name'] = $_FILES['file']['name'];
      
      $this->upload->initialize($config);
      
      
      if(!$this->upload->do_upload('file')) {
          log_message('error', $this->upload->display_errors());
          
      } else {
          $this->load->library('excel');
          $file_data = $this->upload->data();
          $file = FCPATH.'/uploads/canines/'.$file_data['file_name'];
          $file_type = PHPExcel_IOFactory::identify($file);
          $filterSubset = new MyReadFilter();
          $this->reader = PHPExcel_IOFactory::createReader($file_type);
          $this->reader->setReadFilter($filterSubset);
          $this->excel = $this->reader->load($file);
          $sheetData = $this->excel->getActiveSheet()->toArray(null,true,true,true);          
          $this->canine_model->import($sheetData);

          $array = array('file' => $file_data['file_name']);
          header('Content-type: application/json');  
          echo json_encode($array);          
      }
      
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
