<div class="container">
    <div class="row">
        <div class="col-lg-12 well">
            <h3>Error: 404 Page could not be found.</h3>
        </div>       
    </div>
    <?php if(!empty($event)): ?>
    <div class="row">
        <div class="col-lg-12 well">
            <p>You should come visit us at our next event. <strong><?php echo $event[0]->name; ?> <i><?php echo date('m/d/Y', strtotime($event[0]->date)); ?></i></strong>
            <a href="<?php echo base_url(); ?>/competition/view/<?php echo $event[0]->id; ?>" class="btn btn-success">Event Details</a></p>
        </div>         
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <p class="lead">This is a cool video. Not sure if it's the coolest video ever, but it's pretty darn good.</p>
            <iframe width="420" height="315" src="http://www.youtube.com/embed/LvswNDAAZCU" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>    
</div>
