<?php $notavailable = $this->session->flashdata('notavailable'); if(!empty($notavailable)): ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $notavailable; ?>
 </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <span class="lead">Check out some of our Colorado Disc Dog club members and their awesome high flying pups.</span>
    </div>
</div>
<hr />
<table class="table table-striped footable footable toggle-circle toggle-medium" data-page-navigation=".page" data-page-size="5" data-filter="#filter">
    <caption>
        <div class="row">
            <div class="col-lg-11 col-xs-8">
                <input id="filter" type="text" class="form-control" placeholder="Search">
            </div>
        </div>
        <br />
    </caption> 
    <thead>
        <tr>
            <th data-sort-ignore="true" class="col-sm-4">&nbsp;</th>
            <th class="col-sm-4">Human</th>
            <th class="col-sm-4">Dogs</th>
        </tr>
    </thead>
    <tbody>
    <?php if(!empty($users)) foreach($users as $row): ?>
        <?php if(empty($row->profile_image)) $row->profile_image = 'disc-mark.png'; ?>
        <tr id="<?php echo $row->slug; ?>" class="clickable">
            <td><img class="col-sm-5 img-responsive" src="<?php echo base_url(); ?>uploads/profiles/<?php echo $row->profile_image; ?>"></td>
            <td><?php echo $row->full_name; ?></td>
            <td>
                <?php if(!empty($row->canine)) foreach($row->canine as $dog): ?>
                <?php if($dog->display_profile == '1'): ?>
                    <?php echo $dog->name.'<br />'; ?>
                <?php endif; ?>
                <?php endforeach; ?>
            </td>
        </tr>
    <?php endforeach; ?>    
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" align="center"><div class="page hide-if-no-paging"></div></td>
        </tr>
    </tfoot> 
</table>
<script>
       $('.clickable').click(function(){
          var user = $(this).attr('id');
          window.location = '<?php echo base_url(); ?>profile/view/' + user + ''; 
       });
       $('.footable').footable();
        pagination = $('.page ul').attr('class');
        if(!pagination) {
            $('.page ul').addClass('pagination pagination-sm');
        }


</script>

