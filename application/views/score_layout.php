<!DOCTYPE html> 
<html>
    <head> 
        <title><?php if(!empty($site_info)) echo $site_info->site_title; ?> - <?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/paw-icon.png" type="image/png" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <?php if(!empty($this->css)) foreach($this->css as $css): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>"/>
        <?php endforeach; ?>        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/master.css"/>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <?php if(!empty($this->js)) foreach($this->js as $js): ?>
        <script type="text/javascript" src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/global.js"></script>
        
    </head>
    <body>       
        <?php $this->load->view('header'); ?>
        <?php $this->load->view('message'); ?>
                    <div class="container">
                        <div class="col-lg-12">
                            <?php $this->load->view($main);?> 
                        </div>
                    </div>                     
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43238720-1', 'coloradodiscdogs.com');
  ga('send', 'pageview');

</script>        
    </body>   
</html>  

 
 
