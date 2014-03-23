<!DOCTYPE html> 
<html>
    <head> 
        <title><?php if(!empty($site_info)) echo $site_info->site_title; ?> - Content</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Colorado Disc Dogs - High Energy performace team available to perform at your next event. Please contact us for more details.">
        <meta name="keywords" content="frisbee,dog,dogs,frisbee dog,frisbee dogs,disc,disc dog,disc dogs,colorado,colorado frisbee dogs,frisbee dogs show,frisbee dog show,frisbee dog entertainment,frisbee dogs entertainment,frisbee dogs halftime,frisbee halftime shows,frisbee dog demo,frisbee dog demos,frisbee dogs demo">        
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/paw-icon.png" type="image/png" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/freeow/freeow.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/master.css"/>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.freeow.min.js"></script>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "951709a5-a3d7-429b-90da-6975df5d80e8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/global.js"></script>
        
    </head>
    <body>                
        <?php $this->load->view('header'); ?>
        <?php $this->load->view('message'); ?>
                <div class="col-xs-12 col-md-10 col-lg-10 col-lg-push-2">
                    <div id="myCarousel" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="active item">
                                <img src="<?php echo base_url(); ?>assets/images/demoshow/1.jpg" />
                                  <div class="container">
                                    <div class="carousel-caption-inner">
                                      <h1><?php echo $title; ?></h1>
                                    </div>
                                  </div>                
                            </div>
                           <div class="item">
                                <img src="<?php echo base_url(); ?>assets/images/demoshow/2.jpg" />
                                  <div class="container">
                                    <div class="carousel-caption-inner">
                                      <h1><?php echo $title; ?></h1>
                                    </div>
                                  </div>                
                            </div>
                           <div class="item">
                                <img src="<?php echo base_url(); ?>assets/images/demoshow/3.jpg" />
                                  <div class="container">
                                    <div class="carousel-caption-inner">
                                      <h1><?php echo $title; ?></h1>
                                    </div>
                                  </div>                
                            </div>
                           <div class="item">
                                <img src="<?php echo base_url(); ?>assets/images/demoshow/4.jpg" />
                                  <div class="container">
                                    <div class="carousel-caption-inner">
                                      <h1><?php echo $title; ?></h1>
                                    </div>
                                  </div>                
                            </div>                                    
                           <div class="item">
                                <img src="<?php echo base_url(); ?>assets/images/demoshow/5.jpg" />
                                  <div class="container">
                                    <div class="carousel-caption-inner">
                                      <h1><?php echo $title; ?></h1>
                                    </div>
                                  </div>                
                            </div>                                    
                           <div class="item">
                                <img src="<?php echo base_url(); ?>assets/images/demoshow/6.jpg" />
                                  <div class="container">
                                    <div class="carousel-caption-inner">
                                      <h1><?php echo $title; ?></h1>
                                    </div>
                                  </div>                
                            </div>                                                         
                        </div>
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                    <?php $this->load->view($main); ?>
                </div>
            <div class="hidden-xs col-md-2 col-lg-2 col-lg-pull-10">
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

 
 
