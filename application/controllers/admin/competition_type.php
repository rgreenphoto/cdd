<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Competition_type extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('competition_type_model'));
        $this->load->library(array('form_validation'));
    }
    
    public function index() {
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        $this->data['title'] = 'Competition Types';
        $this->data['competition_types'] = $this->competition_type_model->with('division')->get_all();        
        $this->data['main'] = 'admin/competition_type/index';
        $this->load->view('admin/layout', $this->data);
        
    }

    public function add() {        
        $this->data['types'] = array('NULL' => 'Please select...', 'Skyhoundz' => 'Skyhoundz', 'UFO' => 'UFO');
        $this->data['type'] = '';
        
        $this->data['name'] = array(
            'id' => 'name',
            'name' => 'name'
        );
        
        $this->data['image'] = array(
            'id' => 'image',
            'name' => 'image'
        );
        
        $this->data['large_image'] = array(
            'id' => 'large_image',
            'name' => 'large_image'
        );
        
        $this->data['multiplier'] = array(
            'id' => 'multiplier',
            'name' => 'multiplier',
            'class' => 'span3'
        );
        
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);
            if(!empty($_FILES) && !empty($_FILES['image']['name'])) {
                $options['image'] = 'uploads/'.$this->_do_upload($id, 'image');
            }
            if(!empty($_FILES) && !empty($_FILES['large_image']['name'])) {
                $options['large_image'] = 'uploads/'.$this->_do_upload($id, 'large_image');
            }
            if($this->competition_type_model->insert($options)) {
                $this->session->set_flashdata('message', 'Record saved.');
                redirect('admin/competition_type/');
            } else {
                $this->session->set_flashdata('message', 'Could not save record at this time.');
                redirect('admin/competition_type/add/');
            }   
        }
        $this->data['title'] = 'Add Competition Type';
        $this->data['main'] = 'admin/competition_type/edit';
        $this->load->view('admin/layout', $this->data);  
    }    
        
    public function edit($id) {
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        $this->data['competition_type'] = $this->competition_type_model->with('division')->get($id);
        $this->data['hidden'] = array('id' => $id);
        $this->data['competition_id'] = $id;
       
        $this->data['attributes'] = array();
        
        $this->data['types'] = array('NULL' => 'Please select...', 'Skyhoundz' => 'Skyhoundz', 'UFO' => 'UFO');
        $this->data['type'] = $this->data['competition_type']->type;
        
        if(!empty($_POST)) {
            $options = $this->set_post_options($_POST);
            if(!empty($_FILES) && !empty($_FILES['image']['name'])) {
                $options['image'] = 'uploads/'.$this->_do_upload($id, 'image');
            }
            if(!empty($_FILES) && !empty($_FILES['large_image']['name'])) {
                $options['large_image'] = 'uploads/'.$this->_do_upload($id, 'large_image');
            }
            if($this->competition_type_model->update($id, $options)) {
                $this->session->set_flashdata('message', 'Record saved.');
                redirect('admin/competition_type/');
            } else {
                $this->session->set_flashdata('message', 'Could not save record at this time.');
                redirect('admin/competition_type/edit/'.$id);
            }   
        }
        $this->data['title'] = 'Edit Competition Type';
        $this->data['main'] = 'admin/competition_type/edit';
        $this->load->view('admin/layout', $this->data);
        
        
    }
    
    
  private function _do_upload($id, $type) {
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'jpg|png|gif';
      $config['max_size'] = '20000000';
      $config['file_name'] = $id.'_'.$_FILES[$type]['name'];
      
      $this->upload->initialize($config);
      
      if(!$this->upload->do_upload($type)) {
          log_message('error', $this->upload->display_errors());
          return $this->upload->display_errors();
      } else {
          $file = $this->upload->data();
          return $file['file_name'];
      }
      
  }     
}
?>
