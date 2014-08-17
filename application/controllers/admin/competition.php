<?php

/*
 * Russ Green rgreen@rgreenphotography.com
 */


class Competition extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('competition_model'));
        $this->load->library(array('form_validation'));
        $this->previous_year = date('Y', strtotime("-1 year"));
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css', base_url().'/assets/css/bootstrap-datetimepicker.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js', base_url().'assets/js/moment.min.js', base_url().'assets/js/bootstrap-datetimepicker.min.js');
        
    }
    
    public function index() {
        $this->data['title'] = 'Competition Management';
        //get competitions from the db
        $this->data['competitions'] = $this->competition_model->with('competition_type')->order_by('date', 'desc')->get_all();       
        $this->data['main'] = 'admin/competition/index';       
        $this->load->view('admin/layout', $this->data);
    }
    
   public function add() {
       $this->data['title'] = 'Add Competition';
       //grab competition types
       $this->load->model('competition_type_model');
       $this->data['competition_types'] = $this->competition_type_model->get_select();
       
       //grab divisions
       $this->load->model('division_model');
       $this->data['divisions'] = $this->division_model->get_all();
       $this->data['previous_comps'] = $this->competition_model->get_event($this->previous_year);

       if(!empty($_POST)) {
           $_POST['season'] = date('Y', strtotime($_POST['date']));
           $options = $this->set_post_options($_POST);
           if($this->competition_model->insert($options)) {
               $this->load->model('competition_fee_model');
               $competition_id = $this->db->insert_id();
               if(!empty($_POST['division_fee'])) {
                   foreach($_POST['division_fee'] as $k=>$v) {
                       if(!empty($v)) {                       
                           $data = array('competition_id' => $competition_id, 'division_id' => $k, 'fee' => $v);
                           $this->competition_fee_model->insert($data);
                       }
                   }
               } 
               $this->session->set_flashdata('message', 'Record Added');
               redirect('admin/competition');
           }            
       }
       $this->data['main'] = 'admin/competition/edit';
       $this->load->view('admin/layout', $this->data);       
   }
   
   public function edit($id) {
       $this->data['title'] = 'Edit Competition';
       $this->data['competition'] = $this->competition_model->get($id);
       if(empty($this->data['competition'])) {
           $this->session->set_flashdata('message', 'Could not find event. Please add one.');
           redirect('admin/competition/add');
       }
       
       //grab divisions
       $this->load->model('division_model');
       $this->data['divisions'] = $this->division_model->get_all();
       $this->data['previous_comps'] = $this->competition_model->get_event($this->previous_year);
       
       //grab clubs
       $this->load->model('competition_type_model');
       $this->data['competition_types'] = $this->competition_type_model->get_select();
       
       if(!empty($_POST)) {
           $_POST['season'] = date('Y', strtotime($_POST['date']));
           $options = $this->set_post_options($_POST);
           if($this->competition_model->update($id, $options)) {
               $this->load->model('competition_fee_model');
               if(!empty($_POST['division_fee'])) {
                   $this->competition_fee_model->delete_by(array('competition_id' => $this->input->post('id')));
                   foreach($_POST['division_fee'] as $k=>$v) {
                       if(!empty($v)) {
                           $data = array('competition_id' => $this->input->post('id'), 'division_id' => $k, 'fee' => $v);
                           $this->competition_fee_model->insert($data);
                       }
                   }                   
               }
               $this->session->set_flashdata('message', 'Record Updated');
               redirect('admin/competition');
           }
       }
       $this->data['main'] = 'admin/competition/edit';
       $this->load->view('admin/layout', $this->data);  
   }
   
    public function delete($id) {
        if(!empty($id)) {
            if($this->competition_model->delete($id)) {
                $this->session->set_flashdata('message', 'Record Deleted');
                redirect('admin/competition');
            } else {
                $this->session->set_flashdata('message', 'Could not delete record.');
                redirect('admin/competition');
            }
        } else {
            $this->session->set_flashdata('message', 'ID for this item is missing.');
            redirect('admin/competition');
        }
    }
    
    public function import() {
        $config['upload_path'] = './uploads/competitions/';
        $config['allowed_types'] = 'xlsx';
        $this->load->library('upload', $config);
        
        $this->data['form_open'] = 'admin/competition/import';
        $this->data['main'] = 'admin/competition/import';
        $this->load->view('admin/layout', $this->data);
    }


    
    public function manage($id) {
        //lets grab by registrations for a better set of joins
        $this->load->model(array('competition_result_model', 'division_model'));
        $options = array('competition_id' => $id);
        $this->data['id'] = $id;
        $this->data['competitors'] = $this->competition_result_model->with('division')->with('user')->with('canine')->get_many_by($options);
        $this->data['competition'] = $this->competition_model->with('competition_type')->order_by('date')->get_by(array('id' => $id));
        $this->data['divisions'] = $this->division_model->get_list($this->data['competition']->competition_type_id);
        $this->data['main'] = 'admin/competition/manage';
        $this->load->view('admin/layout', $this->data);
    }
    
    public function get_previous_description() {
        if(!empty($_POST['id'])) {
            $competition = $this->competition_model->get($_POST['id']);
            if(!empty($competition->event_description)) {
                echo json_encode(array('description' => $competition->event_description, 'message' => 'Success!'));
            } else {
                echo json_encode(array('message' => 'Could not find a description for this event'));
            }            
        } else {
            echo json_encode(array('message' => 'No competition provided'));
        }

    }

    
  public function do_upload() {
      $config['upload_path'] = './uploads/competitions/';
      $config['allowed_types'] = 'xlsx';
      $config['max_size'] = '2000';
      $config['file_name'] = $_FILES['file']['name'];
      
      $this->upload->initialize($config);
      
      
      if(!$this->upload->do_upload('file')) {
          log_message('error', $this->upload->display_errors());
          
      } else {
          $this->load->library('excel');
          $file_data = $this->upload->data();
          $file = FCPATH.'/uploads/competitions/'.$file_data['file_name'];
          $file_type = PHPExcel_IOFactory::identify($file);
          $filterSubset = new MyReadFilter();
          $this->reader = PHPExcel_IOFactory::createReader($file_type);
          $this->reader->setReadFilter($filterSubset);
          $this->excel = $this->reader->load($file);
          $sheetData = $this->excel->getActiveSheet()->toArray(null,true,true,true);          
          $this->competition_model->import($sheetData);

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
			if (in_array($column,range('A','I'))) {
				return true;
			}
		}
		return false;
	}
}


?>
