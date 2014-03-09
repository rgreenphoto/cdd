<!DOCTYPE html> 
<html>
    <head> 
        <title><?php if(!empty($site_info)) echo $site_info->site_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Colorado Disc Dogs - Frisbee Dogs Club in Colorado">
        <meta name="keywords" content="frisbee,dog,dogs,frisbee dog,frisbee dogs,disc,disc dog,disc dogs,colorado,colorado frisbee dogs,frisbee dogs show,frisbee dog show,frisbee dog entertainment,frisbee dogs entertainment,frisbee dogs halftime,frisbee halftime shows,frisbee dog demo,frisbee dog demos,frisbee dogs demo">        
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/paw-icon.png" type="image/png" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-responsive.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/datepicker/css/datepicker.css"/>
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/freeow/freeow.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/master.css"/>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.freeow.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/global.js"></script>
        
    </head>
    <body>          
    <?php $this->load->view('header'); ?>
        <?php $this->load->view('message'); ?>
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
                <div class="active item">
                    <img src="<?php echo base_url(); ?>assets/images/slideshow/4.jpg"/>
                    <div class="ac_overlay"></div>
                      <div class="container">
                        <div class="carousel-caption pull-right">
                          <h1>Upcoming Events</h1>
                          <p class="lead">Check out the latest Colorado Disc Dogs events. Register for competitions and get ready to fly high.</p>
                          <a class="btn btn-small btn-success" href="<?php echo base_url(); ?>competition">Come out and play!</a>
                        </div>
                      </div>
                </div>
                <div class="item">
                    <img src="<?php echo base_url(); ?>assets/images/slideshow/6.jpg" />
                    <div class="ac_overlay"></div>
                      <div class="container">
                        <div class="carousel-caption">
                          <h1>Results</h1>
                          <p class="lead">A complete listing of results from the competition. Check out historical results as well.</p>
                          <a class="btn btn-small btn-success" href="<?php echo base_url(); ?>result">View Results</a>
                        </div>
                      </div>                     
                </div>
                <div class="item">
                    <img src="<?php echo base_url(); ?>assets/images/slideshow/7.jpg" />
                    <div class="ac_overlay"></div>
                      <div class="container">
                        <div class="carousel-caption pull-right">
                          <h1>Standings</h1>
                          <p class="lead">Check out the latest Colorado Cup Series standings!</p>
                          <a class="btn btn-small btn-success" href="<?php echo base_url(); ?>standing">Standings</a>
                        </div>
                      </div>                     
                </div>
            </div>
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>        
         
            <div class="container-fluid marketing">
                <div class="row-fluid">
                    <span class="span4 well">
                        <h2>Competitions</h2>
                        <p>A series of competitions are held annually. The series of events culminates with the awarding of the Colorado Cup. You don't have to be a member to play, but to earn Cup Points you need to join!</p>
                        <a href="<?php echo base_url(); ?>competition" class="btn btn-primary">View Schedule</a>
                    </span>
                    <span class="span4 well">
                        <h2>Results</h2>
                        <p>Check out the current standings for the Colorado Cup, results of individual events as well as historical summaries. When you register for an account, you will have complete access to personal score sheets.</p>
                        <a href="<?php echo base_url(); ?>result" class="btn btn-primary">View Results</a>
                    </span>
                    <span class="span4 well">
                        <h2>Standings</h2>
                        <p>Check out the latest standings for the Colorado Cup Series! Members compete every year for <a href="<?php echo base_url(); ?>page/top-honors">Top Honors</a> every year. Awards are giving for the top overall team, best freestyle team and best toss/catch team.</p>
                        <a href="<?php echo base_url(); ?>standing" class="btn btn-primary">Standings</a>
                    </span>
                </div>
              <hr class="featurette-divider">

              <div class="featurette">
                <img class="featurette-image pull-right" src="<?php echo base_url(); ?>assets/images/CDD-Club-Banner.png">
                <h2 class="featurette-heading">Colorado Disc Dogs. <span class="muted">Fly high and land softly.</span></h2>
                <p class="lead">The Colorado Disc Dogs club started in 1994 and gives Frisbee dog enthusiasts a chance to gather as a group and ply our hobby. We get together at least once a month during the season, exchanging ideas, tips, stories, and information about the sport, as well as practicing with our dogs in a fun, comfortable atmosphere.</p>
              </div>
              <hr class="featurette-divider">
              <div class="featurette">
                  <img src="<?php echo base_url(); ?>assets/images/rocky_mntn_cover.gif" class="featurette-image pull-left">
                  <h2 class="featurette-heading">Competitions <span class="muted">and the Colorado Cup.</span></h2>
                  <p class="lead">We also run competitions, playdays and training seminars each year so that Colorado dog owners can enjoy the fun and benefits that playing with a Frisbee dog can bring. Among our ranks are World Champions, Regional and World Finalists, National Champions, National Distance Champions, the Colorado State Champion, and many others. We have appeared on NBC, ESPN, espn2, USA Network, Animal Planet, TBS, and other national and local networks. Our demo teams have performed at NFL, MLB, NBA, MLS, NCAA, and NLL halftimes. The Colorado Disc Dogs also donate a considerable amount of time each year supporting local and national charities and humane organizations.</p>                  
              </div>
              <hr class="featurette-divider">
                <div class="featurette">
                    <span class="span6">
                        &nbsp;
                    </span>
                    <span class="span6 pull-right">
                        <?php echo $this->load->view('social'); ?>
                    </span>
                </div>
              <hr class="featurette-divider">
              <?php $this->load->view('footer'); ?>
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

 
 
