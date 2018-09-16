<?php

/* Russ Green rgreen@rgreenphotography.com
 */

class Pool extends Public_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('challongeapi'));
    }

    public function index() {

        $api_key = 'QHBqJfquiJhKm6nfhV6nodI5u2QgS7xqYSgXGW1l';
        $chall = new ChallongeAPI($api_key);
        $chall->verify_ssl = false;
        $t = $chall->getTournaments();

        echo '<pre>';
        print_r($chall);
        die();
//        $url = "https://rgreenphoto:{$api_key}@api.challonge.com/v1/tournaments.json";
//        $tournaments = file_get_contents($url);
//        echo '<pre>';
//        print_r($tournaments);
//        die();
        $this->data = array();
        $this->data['main'] = 'pool/index';
        $this->load->view('login_layout', $this->data);
    }


}

?>