<!DOCTYPE html> 
<html>
    <head> 
        <title><?php if(!empty($site_info)) echo $site_info->site_title; ?> - ADMIN AREA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.4/themes/base/jquery-ui.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/freeow/freeow.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/datepicker/css/datepicker.css"/>
        <?php if(!empty($this->css)) foreach($this->css as $css): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>"/>
        <?php endforeach; ?>
<!--        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/admin/master.css"/>-->
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.10.4/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.freeow.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/tiny_mce/tiny_mce.js"></script>
        <?php if(!empty($this->js)) foreach($this->js as $js): ?>
        <script type="text/javascript" src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/admin/global.js"></script>
    </head>
    <body>
        <?php $this->load->view('message'); ?>
        
            <div class="row">
                <div class="col-lg-12">
                    <div class="container">
                        <?php $this->load->view($main);?>
                    </div>
                </div>
            </div>
        <div class="container">

        </div>
    </body>   
</html>