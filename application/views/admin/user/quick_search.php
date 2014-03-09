 <style>
.ui-autocomplete-loading {
    background: white url('<?php echo base_url(); ?>assets/images/dog-loader.gif') right center no-repeat;
}
</style>
<input type="hidden" id="competition_id" value="<?php echo $competition_id; ?>" />
<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/competition_result/gameday/<?php echo $competition_id; ?>">Game Day Dashboard</a></li>
    <li class="active"><?php echo $competition_name; ?></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <p class="lead">1. Use the search box to check to see if the user is already in the system.</p>
        <p>The list below contains all users in the system. User may have competed in the past, if so we want to make sure we're using their current information. 
            Start typing in the full name, or try their email address. The list will narrow based on your search. If you find the user listed below, select the 'Register User' button. A list of dogs with be provided for this user and you can select a division to enter them for this event.</p>
        <p>If results do not return a sufficient match, enter a new user with the link below the table.</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-condensed table-bordered table-striped table-hover footable toggle-circle toggle-medium">
            <caption>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ui-widget">
                            <input id="filter" type="text" class="form-control" placeholder="Search">
                            <p id="filter-description"></p>
                        </div>
                    </div>
                </div>
                <br />
            </caption>
            <thead>
                <tr>
                    <th data-toggle="true">Name</th>
                    <th data-hide="phone">Email</th>
                    <th>&nbsp</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($users)) foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user->full_name; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/user/quick_add/<?php echo $competition_id.'/'.$user->id; ?>" class="btn btn-sm btn-warning">Register User <i class="icon-plus"></i></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" align="center"><?php echo $links; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>    
</div>
<br />
<div class="row">
    <div class="col-lg-12">
        <p class="lead">2. If user not found in search about, add them here. Double check before entering any new users. <a href="<?php echo base_url(); ?>admin/user/quick_add/<?php echo $competition_id; ?>" class="btn btn-warning">Add User <i class="icon-plus"></i></a></p>
    </div>
</div>
<script>
    $(document).ready(function() {       
       $('#filter').autocomplete({
           source: "<?php echo base_url(); ?>admin/user/page_test",
           minLength: 2,
           select: function (event, ui) {
               competition_id = $('#competition_id').val();
               window.location = '<?php echo base_url(); ?>admin/user/quick_add/' + competition_id + '/' + ui.item.id;
           }
       }).data("ui-autocomplete")._renderItem = function(ul, item) {
           return $("<li>").append("<a>" + item.first_name + " " + item.last_name + "</a>").appendTo(ul);
       };        
    });
</script> 