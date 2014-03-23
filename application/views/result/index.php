<div class="container-fluid">
    <div class="row">
        <?php if(!empty($cms_content)) echo $cms_content->description; ?>
    </div>
    <div class="row">
        <div class="col-lg-3 col-lg-push-9">
            <?php echo form_dropdown('year', $event_menu, '', 'id="resultYear" class="form-control"'); ?>
        </div>       
    </div>
    <br />
    <div class="row">
        <div class="list-group">
            <?php if(!empty($competitions)) foreach($competitions as $row): ?>
            <a href="<?php echo base_url(); ?>result/view/<?php echo $row->slug; ?>" class="list-group-item">
                <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                <?php if(!empty($row->image)) echo '<img src="'.base_url().''.$row->image.'">'; ?>
                <h4 class="list-group-item-heading"><?php echo $row->name; ?></h4>
                <p class="list-group-item-text"><?php echo date('m-d-Y', strtotime($row->date)); ?></p>
                <p class="list-group-item-text"><?php echo $row->location; ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
       $('#resultYear').change(function(){
          var event = $(this).val();
          if(event) {
              window.location = '<?php echo base_url(); ?>result/index/' + event + ''; 
          }
       }); 
    });

</script>







