<?php

/* Russ Green rgreen@rgreenphotography.com
 */


class Disc_order extends Member_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('disc_order_model', 'disc_type_model'));
        $this->data['display_social'] = false;
    }
    
    
    public function index() {
        $user_id = $this->the_user->id;
        $this->css = array(base_url().'/assets/css/FooTable-2/css/footable.core.min.css');
        $this->js = array(base_url().'assets/js/FooTable-2/dist/footable.min.js',base_url().'assets/js/FooTable-2/dist/footable.filter.min.js', base_url().'assets/js/FooTable-2/dist/footable.sort.min.js', base_url().'assets/js/FooTable-2/dist/footable.paginate.min.js');
        $this->data['orders'] = $this->disc_order_model->with('disc_type')->order_by('created')->get_many_by(array('user_id' => $user_id));
        $this->data['disc_type'] = $this->disc_type_model->get_all();
        $this->data['title'] = 'Disc Orders';
        $this->data['stats'] = $this->disc_order_model->stats($user_id, date('Y'));
        $this->data['main'] = 'disc_order/index';
        $this->load->view('secondary_layout', $this->data);            
    }
     
    public function add() {
        $json = array();
        if(!empty($_POST)) {
            $options['user_id'] = $this->the_user->id;
            $options['disc_type_id'] = $_POST['disc_type_id'];
            $options['color'] = str_replace('_', ' ', $_POST['color']);
            $options['total_discs'] = $_POST['total_discs'];
            $options['total'] = $_POST['total'];
            $options['season'] = date('Y');
            if($this->disc_order_model->insert($options)) {
                $id = $this->db->insert_id();
                //get stats
                $stats = $this->disc_order_model->stats($this->the_user->id, date('Y'));
                $json['total_amount'] = !empty($stats->total)?$stats->total:'';
                $json['total_discs'] = !empty($stats->total_discs)?$stats->total_discs:'';
                $json['id'] = $id;
                $json['success_message'] = 'Discs Added';
            }
        }
        echo json_encode($json);
    }
    
    public function confirm($paypal = '') {
        $this->data['order'] = $this->disc_order_model->with('disc_type')->get_many_by(array('user_id' => $this->the_user->id, 'season' => date('Y'), 'complete' => 0));
        $this->data['stats'] = $this->disc_order_model->stats($this->the_user->id, date('Y'));
        if(!empty($paypal)) {
            $this->data['paypal'] = true;
        }
        if(!empty($this->data['order'])) {
            foreach($this->data['order'] as $order) {
                $data = array('complete' => 1);
                if(!empty($paypal)) {
                    $data['paypal'] = 1;
                }
                $this->disc_order_model->update($order->id, $data);
            }
            $this->load->library(array('pdf', 'email'));
            $this->pdf->load_view('disc_order/print', $this->data);
            $this->pdf->render();
            $output = $this->pdf->output();
            $file_name = './uploads/orders/'.$this->the_user->last_name.'BulkDiscOrder'.date('Y').'.pdf';
            file_put_contents($file_name, $output);
            if(file_exists($file_name)) {
                $this->email->from($this->site_info->email, 'CDD Admin');
                $this->email->to($this->the_user->email);
                $this->email->bcc('kerrysamet@gmail.com');
                $this->email->subject('CDD Bulk Disc Order '.date('Y'));
                $this->email->message($this->site_info->bulk_order_text);
                $this->email->attach($file_name);
            }
            
        }
        
        $this->data['main']  = 'disc_order/confirm';
        $this->load->view('secondary_layout', $this->data);
    }
    
    public function print_summary() {
        $this->data['order'] = $this->disc_order_model->with('disc_type')->get_many_by(array('user_id' => $this->the_user->id, 'season' => date('Y'), 'complete' => 0));
        $this->data['stats'] = $this->disc_order_model->stats($this->the_user->id, date('Y'));
        $this->load->library('pdf');
        $this->pdf->load_view('disc_order/print', $this->data);
        $this->pdf->render();
        $file_name = url_title($this->the_user->last_name.'BulkDiscOrder'.date('Y'));
        $this->pdf->stream($file_name.'.pdf');
    }
    
    public function delete() {
        $json = array();
        if(!empty($_POST)) {
            $id = $_POST['id'];
            if($this->disc_order_model->delete($id)) {
                $json['id'] = $id;
                $json['success_message'] = 'Discs Removed';
                $stats = $this->disc_order_model->stats($this->the_user->id, date('Y'));
                $json['total_amount'] = !empty($stats->total)?$stats->total:'';
                $json['total_discs'] = !empty($stats->total_discs)?$stats->total_discs:'';
            } else {
                $json['message'] = 'Could not delete';
            }
        }
        echo json_encode($json);
    }
    
}
?>
