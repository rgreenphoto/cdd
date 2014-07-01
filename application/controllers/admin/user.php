<?php

/*
 * Russ Green rgreen@rgreenphotography.com
 */


class User extends Admin_Controller {
    
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library(array('form_validation', 'ion_auth'));
    }
    
    
    public function index($group_id = '1') {
        $this->data['title'] = 'Users';
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/admin/autocomplete.js');
        $this->load->model('group_model');
        $this->data['user_list'] = $this->group_model->stats();

        $this->load->library('pagination');
        
        $config['base_url'] = base_url().'admin/user/index/'.$group_id;
        $config['total_rows'] = $this->user_model->get_count($group_id);
        $config['per_page'] = 20;
        $config['uri_segment'] = 5;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5):'0';
        $this->data['users'] = $this->user_model->get_by_group($group_id, $config['per_page'], $page);
        $this->data['group_id'] = $group_id;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['main'] = 'admin/user/index';
        $this->load->view('admin/layout', $this->data);
        
    }
    
    
	//create a new user
    public function add() {
        $this->data['title'] = "Add User";
        $this->data['hidden'] = array();
        //grab groups dropdown
        $this->load->model('group_model');
        $this->data['groups'] = $this->group_model->dropdown('description');
        $this->data['in_groups'] = array();
                
        //we didn't set this in the model for a reason
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('group_id', 'Group', 'required');
        
        
        if(!empty($_POST) && $this->user_model->validate($_POST)) {
            if ($this->form_validation->run() == true) {
                $username = $this->input->post('username');
                $email    = $this->input->post('email');
                $password = $this->input->post('password');
                $_POST['full_name'] = $_POST['first_name'].' '.$_POST['last_name'];
                $_POST['formal_name'] = $_POST['last_name'].', '.$_POST['first_name'];

                $additional_data = $this->set_post_options($_POST);
//                echo '<pre>';
//                print_r($additional_data);
//                echo '</pre>';
                
                $id = $this->ion_auth->register($username, $password, $email, $additional_data, $additional_data['group_id']);
                
                if(!empty($id)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect('admin/user/edit/'.$id, 'refresh'); 
                } else {
                    $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                }
            }           
        }
  
        $this->data['main'] = 'admin/user/edit';

        $this->load->view('admin/layout', $this->data);
    }
    	//edit a user
    public function edit($id) {
		
        $this->data['title'] = "Edit User";
        
        //grab groups dropdown
        $this->load->model('group_model');
        $this->data['groups'] = $this->group_model->dropdown('description');
        
        $this->data['hidden'] = array('id' => $id);

        //$user = $this->ion_auth->user($id)->row();
        $user = $this->user_model->with('canine')->get($id);
        $in_groups = $this->ion_auth->get_users_groups($id)->result();
        if(!empty($in_groups)) {
            foreach($in_groups as $group) {
                $groups[$group->id] = $group->id;
            }
        }
        $this->data['in_groups'] = $groups;
        
        if (!empty($_POST) && $this->user_model->validate($_POST)) {
            $this->form_validation->set_rules('group_id', 'Group', 'required');
            $_POST['full_name'] = $_POST['first_name'].' '.$_POST['last_name'];
            $_POST['formal_name'] = $_POST['last_name'].', '.$_POST['first_name'];
            $options = $this->set_post_options($_POST);
            
            if(empty($_POST['demo_team'])) {
                $options['demo_team'] = 0;
            }
               
            //update the password if it was posted
            $password = $this->input->post('password');
            if (!empty($password)) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
                $options['password'] = $this->input->post('password');
                if($this->form_validation->run() === FALSE) {
                    $this->session->set_flashdata('message', 'Passwords did not match');
                    redirect('admin/user/edit/'.$user->id);
                }
                
            } else {
                unset($options['password']);
                unset($options['password_confirm']);
            }
            
            
            if($this->ion_auth->update($user->id, $options)) {
                if(!empty($options['group_id'])) {
                    foreach($this->data['groups'] as $k=>$v) {
                        $this->ion_auth->remove_from_group($k, $user->id);
                    }
                    
                    foreach($options['group_id'] as $row) {
                        $this->ion_auth->add_to_group($row['id'], $user->id);
                    }
                    
                }
                
                
                $this->session->set_flashdata('message', 'Record Saved');
                redirect('admin/user/');
            }
            
            
        }

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['user'] = $user;

        if(isset($user->family_id)) {
            $this->data['family'] = $this->user_model->get_family($user);
        }


        $this->data['main'] = 'admin/user/edit';
        $this->load->view('admin/layout', $this->data);
    }
    
    public function import() {
        $this->data['main'] = 'admin/user/import';
        $this->load->view('admin/layout', $this->data);
    }
    
    public function quick_search() {
        $results = $this->user_model->quick_search($_GET['term']);
        echo json_encode($results);
    }
    
    public function page_test() {
        echo '<pre>';
        print_r($_POST);
        
//$results = $this->user_model->quick_search($_GET['term']);
        
//        /echo $_GET['term'];
        //echo json_encode($results);
    }
    
    public function fix_name() {
        $users = $this->user_model->get_all();
        if(!empty($users)) {
            foreach($users as $user) {
                $id = $user->id;
                $options = array('first_name' => $user->first_name, 'last_name' => $user->last_name);
                if($this->user_model->update($id, $options)) {
                    $flag = true;
                }
            }
        }
    }
    
    
  public function do_upload() {
      $config['upload_path'] = './uploads/users/';
      $config['allowed_types'] = 'xlsx';
      $config['max_size'] = '2000';
      $config['file_name'] = $_FILES['file']['name'];
      
      $this->upload->initialize($config);
      
      
      if(!$this->upload->do_upload('file')) {
          log_message('error', $this->upload->display_errors());
          
      } else {
          $this->load->library('excel');
          $file_data = $this->upload->data();
          $file = FCPATH.'/uploads/users/'.$file_data['file_name'];
          $file_type = PHPExcel_IOFactory::identify($file);
          $filterSubset = new MyReadFilter();
          $this->reader = PHPExcel_IOFactory::createReader($file_type);
          $this->reader->setReadFilter($filterSubset);
          $this->excel = $this->reader->load($file);
          $sheetData = $this->excel->getActiveSheet()->toArray(null,true,true,true);          
          $this->user_model->import($sheetData);

          $array = array('file' => $file_data['file_name']);
          header('Content-type: application/json');  
          echo json_encode($array);          
      }
      
  }     
    
    public function print_summary($group_id) {
        $this->load->helper('csv');
        $this->load->model('group_model');
        $group = $this->group_model->get($group_id);
        $users = $this->group_model->print_summary($group_id);
        if(!empty($users)) {
            array_to_csv($users, $group->name.'_summary.csv');
        }  
    }
    
    private function _get_csrf_nonce() {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }
    
    

    private function _valid_csrf_nonce() {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
	}

    private function _set_groups($groups) {
        $string = '';
        foreach($groups as $item) {
            $string .= $item->description.', ';
        }
        return substr_replace(rtrim($string), '', -1);        
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
