<div class="navbar navbar-default navbar-cdd navbar-fixed-top">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".header-menu">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo $this->data['site_info']->site_title; ?></a>
    </div>
    <div class="navbar-collapse collapse navbar-ex3-collapse header-menu">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo base_url(); ?>competition" class="navbar-link"><i class="icon-calendar-empty"></i> Schedule</a></li>
        <li><a href="<?php echo base_url(); ?>result"><i class="icon-list-ol"></i> Results</a></li>
        <li><a href="<?php echo base_url(); ?>standing"><i class="icon-trophy"></i> Standings</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <?php if(!empty($the_user)): ?>
        <?php if($the_user->group_id == '3'): ?>
          <li>
              <a href="<?php echo base_url(); ?>notification">
               Messages <i class="icon-envelope"></i>
              <span id="unread_messages" class="label label-success"><?php echo $this->data['unread_messages']; ?></span>
              </a>
          </li>
        <?php endif; ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Member Info <i class="icon-cogs"></i></a>
          <ul class="dropdown-menu">
              <?php if(!empty($the_user->is_admin)): ?>
              <li><a href="<?php echo base_url(); ?>admin"><i class="icon-cog"></i> Admin</a></li>
              <?php endif; ?>
              <?php if(!empty($active_poll)): ?>
              <li><a href="<?php echo base_url(); ?>poll/response/<?php echo $active_poll[0]->id; ?>"><i class="icon-check"></i> Poll: <?php echo $active_poll[0]->name; ?></a></li>
              <?php endif; ?>
              <li><a href="<?php echo base_url(); ?>user/edit"><i class="icon-user"></i> Handler and Dog Info</a></li>
              <?php if($the_user->group_id == '3'): ?>
              <li><a href="<?php echo base_url(); ?>user/member"><i class="icon-picture"></i> Edit Profile</a></li>
              <li><a href="<?php echo base_url(); ?>user/scores"><i class="icon-trophy"></i> Score History</a></li>
              <li><a href="<?php echo base_url(); ?>registration/history"><i class="icon-book"></i> Registration History</a></li>
              <li><a href="<?php echo base_url(); ?>user/settings"><i class="icon-lock"></i> Account Settings</a></li>
              <?php endif; ?>
            <li class="divider"></li>
            <li><a href="<?php echo base_url(); ?>auth/logout"><i class="icon-signout"></i> Logout</a></li>
          </ul>
        </li>
      <?php endif; ?>
      <?php if(empty($the_user)): ?>
        <li>
            <form action="<?php echo base_url(); ?>auth/login" method="post" role="form" class="form-inline">
                <input type="hidden" name="previous_page" value="<?php echo (!empty($_SERVER['PATH_INFO']) ? base_url().''.ltrim($_SERVER['PATH_INFO'], '/'): base_url()); ?>" />
                <div class="form-group col-sm-4">
                    <label class="sr-only" for="identity">Email</label>
                    <input type="email" class="form-control input-sm" placeholder="email" id="identity" name="identity">
                </div>
                <div class="form-group col-sm-4">
                    <label class="sr-only" for="password">Password</label>
                    <input type="password" class="form-control input-sm" placeholder="password" id="password" name="password">
                </div>
              <button type="submit" class="btn btn-sm btn-success">Login</button>
              <a href="<?php echo base_url(); ?>auth/forgot_password" class="btn btn-sm btn-cdd-yellow">Forgot Password</a>
            </form>
        </li>
        <li></li>
      <?php endif; ?>  
      </ul>
    </div><!--/.nav-collapse -->
</div>
