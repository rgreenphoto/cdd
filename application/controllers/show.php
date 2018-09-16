<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Show extends Public_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('show_model');
    }
    
    public function index() {
        $this->data['title'] = 'Demo Team';
        $this->data['cms_content'] = $this->page_model->get_page('Demo-Team');        
        $this->data['demos'] = $this->show_model->order_by('date', 'DESC')->get_all();
        $this->data['main'] = 'show/index';
        $this->load->view('demo_layout', $this->data);
    }
    
    public function view($slug) {
        $options = array('slug' => $slug);
        $this->data['demo'] = $this->show_model->get_by($options);
        $this->data['title'] = $this->data['demo']->name;
        $this->data['main'] = 'show/view';
        $this->load->view('demo_layout', $this->data);
    }
    
    
}
