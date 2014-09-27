<div class="row">
    <div class="col-lg-12">
        <h3><i class="icon-dashboard"></i> <?php echo $title; ?></h3>
        <p>The dashboard provides a quick glance at important information. User and member stats are in the table to the right. The current years competitions are listed below with links to all registration forms.
        Using the menu to the left, you can add, edit or delete current site content. For example, to edit a competition click the Competition List link. Search or filter to find the competition, then select the edit button.</p>        
    </div>
</div>
<div class="row">
    <?php echo $this->load->view('admin/dashboard/widgets/user_summary'); ?>
    <?php echo $this->load->view('admin/dashboard/widgets/reg_summary'); ?>
    <?php echo $this->load->view('admin/dashboard/widgets/poll_summary'); ?>
</div>
<div class="row">
    <?php echo $this->load->view('admin/dashboard/widgets/notification_summary'); ?>
</div>