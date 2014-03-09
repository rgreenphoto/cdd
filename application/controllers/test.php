<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Test extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function html() {
//        $this->load->library('pdf');
//        $this->pdf->load_view('test/ufo');
//        $this->pdf->render();
//        $this->pdf->stream("ufo.pdf");
        $this->load->view('test/ufo');
    }

    public function slug_users() {
        $this->load->model('user_model');
        $users = $this->user_model->get_all();
        if(!empty($users)) {
            foreach($users as $user) {
                $data['slug'] = strtolower(url_title($user->full_name));
                if($this->user_model->update($user->id, $data)) {
                    echo 'Saved: '.$data['slug'].'<br />';
                } else {
                    echo 'Not Saved: '.$data['slug'].'<br />';
                }
            }
        }
        
    }
    
    public function slug_competitions() {
        $this->load->model('competition_model');
        $competitions = $this->competition_model->get_all();
        if(!empty($competitions)) {
            foreach($competitions as $comp) {
               $date = str_replace("/", "-", $comp->date); 
               $slug =  strtolower(url_title($comp->name).'-'.url_title($date));
               $options = array('slug' => $slug);
               if($this->competition_model->update($comp->id, $options, true)) {
                   echo 'Saved: '.$options['slug'].'<br />';
               } else {
                   echo 'Not Saved: '.$options['slug'].'<br />';
               }
            }
        }
    }
    
    public function slug_divisions() {
        $this->load->model('division_model');
        $divisions = $this->division_model->get_all();
        if(!empty($divisions)) {
            foreach($divisions as $division) {
                $options = array('slug' => strtolower(url_title($division->name)));
                if($this->division_model->update($division->id, $options, true)) {
                    echo 'Saved: '.$options['slug'].'<br />';
                } else {
                    echo 'Not Saved: '.$options['slug'].'<br />';
                }
            }
        }
    }


    

    public function test() {
        print 4<< 5;
        print 6+4 * 9-3;

    }
}
?>
