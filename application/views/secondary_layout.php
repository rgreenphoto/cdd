<!DOCTYPE html> 
<html xmlns:fb="http://ogp.me/ns/fb#">
    <head> 
        <title><?php if(!empty($site_info)) echo $site_info->site_title; ?> - <?php if(!empty($title)) echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Colorado Disc Dogs - Frisbee Dog Club in Colorado. Please join us for fun in sun playing disc with your canine hero.">
        <meta name="keywords" content="frisbee,dog,dogs,frisbee dog,frisbee dogs,disc,disc dog,disc dogs,colorado,colorado frisbee dogs,frisbee dogs show,frisbee dog show,frisbee dog entertainment,frisbee dogs entertainment,frisbee dogs halftime,frisbee halftime shows,frisbee dog demo,frisbee dog demos,frisbee dogs demo">        
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/paw-icon.png" type="image/png" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/freeow/freeow.css"/>
        <?php if(!empty($this->css)) foreach($this->css as $css): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>"/>
        <?php endforeach; ?>        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/master.css"/>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.freeow.min.js"></script>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "951709a5-a3d7-429b-90da-6975df5d80e8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>        
        <?php if(!empty($this->js)) foreach($this->js as $js): ?>
        <script type="text/javascript" src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>       
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/global.js"></script>       
    </head>
    <body>
        <?php $this->load->view('message'); ?>
        <?php $this->load->view('header'); ?>
                <div class="col-xs-12 col-lg-10 col-lg-push-2">
                    <?php $this->load->view($main);?>
                    <?php if($display_social === true): ?>
                    <br />
                    <div class="row">
                        <?php $this->load->view('social'); ?>
                    </div>
                    <?php endif; ?>
                </div>                
                <div class="hidden-md hidden-sm hidden-xs col-lg-2 col-lg-pull-10">
                    <?php $this->load->view('menu'); ?>
                </div>
       <?php $this->load->view('footer'); ?>
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

 
 
