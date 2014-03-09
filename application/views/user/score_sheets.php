<h3><?php echo $title; ?></h3>
<div class="row-fluid">
    <p>Use the menus below to select a competition, the division list will populate with the divisions for the competition.</p>
</div>
<div class="row-fluid">
    <div class="control-group">
        <?php echo form_open(current_url(), $attributes, $hidden); ?>
        <div class="row-fluid">
            <span class="span4">
                <?php echo form_label('Competition', 'competition_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo form_dropdown('competition_id', $competitions, '', 'id="competition_id"'); ?>
                </div>        
            </span>
            <span class="span4">
                <?php echo form_label('Division', 'division_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo form_dropdown('division_id', array('' => 'Division'), '', 'id="division_id"'); ?>
                </div>        
            </span>            
        </div>
        <br />
        <div class="row-fluid">
            <span class="span4">
                <?php echo form_label('Canine', 'canine_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo form_dropdown('canine_id', $the_dogs, '', 'id="canine_id"'); ?>
                </div>
            </span>
            <span class="span4">
                <?php echo form_submit('submit', 'Go', 'class="btn btn-primary pull-right"'); ?>
            </span>            
        </div>
        <?php echo form_close(); ?>        
    </div>
</div>
<script>
$(document).ready(function() {
    $('#competition_id').change(function() {
        competition_id = $('#competition_id').val();
        $.ajax({
            type: "POST", 
            async: false, 
            url: '<?php echo base_url(); ?>division/get_divisions',   
            data: {
                competition_id: competition_id
            },
            success: function(data){
                result = $.parseJSON(data);
                options = $('#division_id');
                $('#division_id').empty();
                $.each(result, function() {
                    options.append($("<option />").val(this.id).text(this.name));
                });                        
            },
            error: function(){alert('error');}
        });         
    });
    
});


</script>
