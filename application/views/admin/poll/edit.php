<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/poll">Polls</a></li>
    <li class="active"><?php echo $title; ?></li>
</ul>
<!--<pre><?php print_r($poll); ?></pre>-->
<?php if(!empty($error_message)): ?>
<div class="alert alert-error">
    <?php echo $error_message; ?>
</div>
<?php endif; ?>
<div class="control-group">
<?php echo form_open(current_url(), '', $hidden); ?>
    <fieldset>
        <div class="row">
            <div class="col-lg-4">
                <label for="name">Poll Name <span class="text-danger"><?php echo form_error('name'); ?></span></label>
                <input id="name" type="text" name="name" class="form-control" value="<?php echo !empty($poll->name) ? $poll->name: '' ?>" />        
            </div>
            <div class="col-lg-4">
                <label for="start_date">Start Date <span class="text-danger"><?php echo form_error('start_date'); ?></span></label>
                <input id="start_date" type="text" name="start_date" class="form-control" value="<?php echo !empty($poll->start_date) ? $poll->start_date: '' ?>" />          
            </div>
            <div class="col-lg-4">
                <label for="end_date">End Date <span class="text-danger"><?php echo form_error('end_date'); ?></span></label>
                <input id="end_date" type="text" name="end_date" class="form-control" value="<?php echo !empty($poll->end_date) ? $poll->end_date: '' ?>" />                 
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-8">
                <label for="description">Description <span class="text-danger"><?php echo form_error('description'); ?></span></label>
                <textarea name="description" class="form-control"><?php echo !empty($poll->description)?$poll->description: ''; ?></textarea>
            </div>
            <div class="col-lg-4">
                <br />
                <button type="button" id="add_options" class="btn btn-cdd"><i class="icon-plus"></i> Add Option</button>
                <button type="submit" name="submit" class="btn btn-cdd"><i class="icon-save"></i> Save Poll</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label>Response Options</label>
            </div>
            <div class="col-lg-9">
                <p id="messages" class="text-success">&nbsp;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?php if(!empty($poll->poll_option)) foreach($poll->poll_option as $option): ?>
                <div id="option_<?php echo $option->id; ?>" class="row">
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="input_<?php echo $option->id; ?>"value="<?php echo $option->text; ?>" />
                    </div>
                    <div class="col-lg-4">
                        <div class="btn-group">
                            <button type="button" data="<?php echo $option->id; ?>" id="save_<?php echo $option->id; ?>" class="save_button btn btn-success">Save</button>
                            <button type="button" data="<?php echo $option->id; ?>" id="delete_<?php echo $option->id; ?>" class="delete_button btn btn-danger">Delete</button>
                        </div>
                    </div>                     
                </div>
                <br />
                <?php endforeach; ?>                
            </div>            
            <div class="col-lg-6">
                <div id="poll_options_area"></div>
            </div>
        </div>        
    </fieldset>
<?php echo form_close(); ?>
</div>
<script>
    $(document).ready(function() {
        $("#start_date").datepicker({
            format: 'yyyy-mm-dd'
        });        
        $("#end_date").datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#add_options').click(function() {
            html = '<input type="text" name="poll_options[]" class="form-control" placeholder="Response" /><br />';
            html += '<br />';
            $('#poll_options_area').append(html);
        });
        $('.save_button').click(function() {
            id = $(this).attr('data');
            text = $('#input_' + id).val();
             $.ajax({
                type: "POST", 
                async: false, 
                url: '<?php echo base_url(); ?>admin/poll/updateOption',   
                data: {
                    id: id,
                    text: text
                },
                success: function(data){
                    result = $.parseJSON(data);
                    $('#messages').text(result.message).effect('highlight');
                },
                error: function(){alert('error');}
            });                           
        });
        
        
        $('.delete_button').click(function() {
            id = $(this).attr('data');
            $.ajax({
                type: "POST",
                async: false,
                url: '<?php echo base_url(); ?>admin/poll/deleteOption',
                data: {
                    id: id
                },
                success: function(data) {
                    result = $.parseJSON(data);
                    $('#messages').text(result.message).effect('highlight');
                    $('#option_' + id).hide('slide', {direction: 'left'}, 'slow');
                },
                error: function(){alert('error');}
            });

        });
    });
</script>