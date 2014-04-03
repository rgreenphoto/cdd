<div class="cdd-nav-footer navbar navbar-inverse navbar-fixed-bottom hidden-lg" role="navigation">
    <div class="navbar-header">
        <a href="#">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <a class="navbar-brand" href="#" data-toggle="collapse" data-target=".footer-menu">More <span class="glyphicon glyphicon-chevron-up"></span></a>
    </div>
    <div class="collapse navbar-collapse footer-menu">
        <ul class="nav navbar-nav">
            <li><a href="<?php echo base_url(); ?>profile">Member Profiles</a></li>
            <li><a href="<?php echo base_url(); ?>club">Links</a></li>
            <?php if(!empty($menu)) foreach($menu as $row): ?>
                <li><a href="<?php echo base_url().'page/'.$row->slug.''; ?>"><?php echo $row->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
