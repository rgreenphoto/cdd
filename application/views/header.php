<nav class="navbar navbar-default navbar-cdd navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo $this->data['site_info']->site_title; ?></a>
        </div>
        <div class="collapse navbar-collapse" id="header-menu">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url(); ?>competition"><i class="fa fa-clock-o fa-spin fa-fw"></i> Schedule</a></li>
                <li><a href="<?php echo base_url(); ?>result"><i class="fa fa-star-o fa-spin fa-fw"></i> Results</a></li>
                <li><a href="<?php echo base_url(); ?>standing"><i class="fa fa-trophy fa-fw"></i> Standings</a></li>
                <li><a href="<?php echo base_url(); ?>show"><i class="fa fa-video-camera fa-fw"></i> Demo Team</a></li>
            </ul>
            <!-- if not logged in show form -->
            <?php if(empty($the_user)): ?>
            <form action="<?php echo base_url(); ?>auth/login" method="post" class="navbar-form navbar-right" role="form">
                <div class="form-group">
                    <label class="sr-only" for="identity">Email</label>
                    <input type="email" class="form-control input-sm" placeholder="email" id="identity" name="identity">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="password">Password</label>
                    <input type="password" class="form-control input-sm" placeholder="password" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-xs btn-success">Login</button>
                <a href="<?php echo base_url(); ?>auth/forgot_password" class="btn btn-xs btn-info">Forgot Password</a>
            </form>
            <?php endif; ?>
            <?php if(!empty($the_user)): ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden-md hidden-sm"><a href="<?php echo base_url(); ?>user/<?php echo $the_user->group_id == '3'?'member':'edit'; ?>"><?php echo $the_user->full_name; ?></a></li>
                <li><a href="<?php echo base_url(); ?>notification">Messages <i class="fa fa-inbox"></i> <span id="unread_messages" class="text-danger"><?php echo ($this->data['unread_messages'] != 0)?$this->data['unread_messages']:''; ?></span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Member Info <i class="fa fa-cog fa-spin"></i></a>
                    <ul class="dropdown-menu">
                        <?php if(!empty($the_user->is_admin)): ?>
                        <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-cog fa-fw"></i> Admin</a></li>
                        <?php endif; ?>
                        <?php if(!empty($active_poll)): ?>
                        <li><a href="<?php echo base_url(); ?>poll/response/<?php echo $active_poll[0]->id; ?>"><i class="fa fa-check fa-fw"></i> Poll: <?php echo $active_poll[0]->name; ?></a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo base_url(); ?>user/edit"><i class="fa fa-user fa-fw"></i> Handler and Dog Info</a></li>
                        <?php if($the_user->group_id == '3'): ?>
                        <li><a href="<?php echo base_url(); ?>user/member"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Profile</a></li>
                        <li><a href="<?php echo base_url(); ?>user/scores"><i class="fa fa-trophy fa-fw"></i> Score History</a></li>
                        <li><a href="<?php echo base_url(); ?>registration/history"><i class="fa fa-book fa-fw"></i> Registration History</a></li>
                        <li><a href="<?php echo base_url(); ?>user/settings"><i class="fa fa-lock fa-fw"></i> Account Settings</a></li>
                        <?php endif; ?>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>