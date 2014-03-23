<!DOCTYPE html> 
<html>
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Colorado Disc Dogs - Frisbee Dog Club in Colorado. Please join us for fun in sun playing disc with your canine hero.">
        <meta name="keywords" content="frisbee,dog,dogs,frisbee dog,frisbee dogs,disc,disc dog,disc dogs,colorado,colorado frisbee dogs,frisbee dogs show,frisbee dog show,frisbee dog entertainment,frisbee dogs entertainment,frisbee dogs halftime,frisbee halftime shows,frisbee dog demo,frisbee dog demos,frisbee dogs demo">        
        <title><?php if(!empty($site_info)) echo $site_info->site_title; ?></title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/paw-icon.png" type="image/png" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/freeow/freeow.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/master.css"/>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.3.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.freeow.min.js"></script>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "951709a5-a3d7-429b-90da-6975df5d80e8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/global.js"></script>
    </head>
    <body>          
    <?php $this->load->view('header'); ?>
    <?php $this->load->view('message'); ?>
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="<?php echo base_url(); ?>assets/images/slideshow/4.jpg"/>
                </div>
                <div class="item">
                    <img src="<?php echo base_url(); ?>assets/images/slideshow/6.jpg" />                     
                </div>
                <div class="item">
                    <img src="<?php echo base_url(); ?>assets/images/slideshow/7.jpg" />    
                </div>
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <img class="img-rounded img-responsive" src="<?php echo base_url(); ?>assets/images/CDD-Club-Banner.png">
                        </div>
                        <div class="panel-body">
                            <div class="list-group">
                                <?php if(!empty($upcoming_events)) foreach($upcoming_events as $event): ?>
                                <a href="<?php echo base_url(); ?>competition/view/<?php echo $event->slug; ?>" class="list-group-item">
                                    <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                                    <img src="<?php echo base_url(); ?><?php echo $event->competition_type->image; ?>" class="img-responsive" />
                                    <h4 class="list-group-item-heading"><?php echo $event->name; ?></h4>
                                    <h5 class="list-group-item-heading"><?php echo $event->long_date; ?></h5>
                                    <p class="list-group-item-text"><?php echo $event->location; ?></p>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <a href="<?php echo base_url(); ?>competition/" class="btn btn-cdd btn-xs pull-right">View All <i class="fa fa-calendar"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-cdd">
                        <div class="panel-heading">
                            <h4 class="text-center">Performance Team</h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-8 col-xs-8">
                                <img src="<?php echo base_url(); ?>assets/images/rocky_mntn_cover.gif" class="img-thumbnail img-responsive">
                            </div>
                            <p>We have appeared on NBC, ESPN, ESPN2, USA Network, Animal Planet, TBS, and other national and local networks. Our demo teams have performed at NFL, MLB, NBA, MLS, NCAA, and NLL halftimes. The Colorado Disc Dogs also donate a considerable amount of time each year supporting local and national charities and humane organizations.</p>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-cdd-orange">
                        <div class="panel-heading">
                            <h4 class="text-center">Current Top 5 Cup Points</h4>
                        </div>
                        <div class="panel-body"></div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="container marketing">
            <div class="row featurette">
              <div class="col-md-7">
                <h2 class="featurette-heading">Colorado Disc Dogs. <span class="muted">Fly high and land softly.</span></h2>
                <p class="lead">The Colorado Disc Dogs club started in 1994 and gives Frisbee dog enthusiasts a chance to gather as a group and ply our hobby. We get together at least once a month during the season, exchanging ideas, tips, stories, and information about the sport, as well as practicing with our dogs in a fun, comfortable atmosphere.</p>      
              </div>
              <div class="col-md-5">
                  
              </div>
            </div>
            <hr class="featurette-divider">
            <div class="row featurette">
                <div class="col-md-5">
                    
                </div>
                <div class="col-md-7">
                    <h2 class="featurette-heading">Competitions <span class="muted">and the Colorado Cup.</span></h2>
                    <p class="lead">We also run competitions, playdays and training seminars each year so that Colorado dog owners can enjoy the fun and benefits that playing with a Frisbee dog can bring. Among our ranks are World Champions, Regional and World Finalists, National Champions, National Distance Champions, the Colorado State Champion, and many others. </p>      
                </div>            
            </div>
            <div class="row featurette">
                <div class="col-md-12">
                    <?php $this->load->view('social'); ?>
                </div>
            </div>       
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

 
 
