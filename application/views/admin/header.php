<div class="navbar navbar-default navbar-cdd navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".header-menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>admin/"><?php echo $this->data['site_info']->site_title; ?></a>
        </div>
        <div class="navbar-collapse collapse navbar-ex3-collapse header-menu">
            <?php if(!empty($the_user)): ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle navbar-link" href="#" data-toggle="dropdown"><i class="icon-calendar"></i> Competitions</a>
                        <ul id="admin-menu" class="dropdown-menu" role="menu">
                            <li role="presentation" class="dropdown-header">Competitions</li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/competition/">View All</a></li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/competition/add">Add</a></li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/standing">Standings</a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation" class="dropdown-header">Competition Types</li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/competition_type/">View All</a></li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/points_guide">Points Guide</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle navbar-link" data-toggle="dropdown" href="#"><i class="icon-globe"></i> Site Content</a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation" class="dropdown-header" role="menu">Site Content</li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/page">Content List</a></li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/show">Demo Schedule</a></li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/link">Clubs & Organizations</a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation" class="dropdown-header">Notifications & Polls</li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/notification">Notifications</a></li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/poll">Polls</a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation" class="dropdown-header">Site Options and Configuration</li>
                            <li role="presentation"><a href="<?php echo base_url(); ?>admin/site_info/">Configuration</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url(); ?>admin/user"><i class="icon-group"></i> Users</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown user-control">
                        <a href="#" class="dropdown-toggle navbar-link" data-toggle="dropdown"><?php echo $the_user->username; ?> <i class="icon-cog icon-white"></i></a>
                        <ul id="admin-menu" class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li><a href="<?php echo base_url(); ?>">View Site</a></li>
                            <li><a href="<?php echo base_url(); ?>admin/user/edit/<?php echo $the_user->id; ?>">Edit Profile</a></li>
                            <li><a href="<?php echo base_url(); ?>admin/auth/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

