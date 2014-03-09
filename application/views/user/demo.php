<div class="row-fluid">
    <span class="span12">
        <span class="lead"><?php if(!empty($cms_content)) echo $cms_content->description; ?></span>
    </span>
</div>
<hr class="featurette-divider">
<?php $i=0; if(!empty($users)) foreach($users as $row): ?>
    <?php 
        if($i%2==0) {
            $class = 'pull-right';
        } else {
            $class = 'pull-left';
        }
    ?>
    
    <div class="featurette clickable" id="<?php echo $row->id; ?>">
        <img class="featurette-image <?php echo $class; ?>" src="<?php echo base_url(); ?>assets/images/cdd_logo.png">
        <h2 class="featurette-heading"><?php echo $row->full_name; ?></h2>
        <p class="lead"><?php echo $row->teaser; ?></p>
    </div>
    <hr class="featurette-divider">
<?php $i++; endforeach; ?>
<script>
    $(document).ready(function() {
       $('.clickable').click(function(){
          var user = $(this).attr('id');
          window.location = '<?php echo base_url(); ?>profile/view/' + user + ''; 
       }); 
    });

</script>

