<div class="container">
    <div class="row">
        <h2><?php echo $title; ?></h2>
    </div>
    <div class="row">
        <h3><?php echo $poll->name; ?></h3>
        <p>Please select your option. You can change your response until the poll closes</p>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <p>Poll closes: <?php echo $poll->end_date; ?></p>
        </div>
        <div class="col-xs-12 col-lg-3">
            <span id="votes"><?php if(!empty($poll_response->votes)) echo $poll_response->votes; ?></span> Votes       
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-xs-12 col-lg-12">
            <fieldset <?php if(date('m/d/Y') > $poll->end_date) echo 'disabled'; ?>>
                <?php echo form_open(); ?>
                <input type="hidden" id="poll_id" name="poll_id" value="<?php echo $poll->id; ?>" />
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $the_user->id; ?>" />
                <input type="hidden" id="existing_id" name="existing_id" value="<?php if(!empty($response)) echo $response->id; ?>" />
                <div class="col-lg-12" id="response-group">
                    <?php if(!empty($poll_response)) foreach($poll_response->results as $row): ?>
                    <div class="radio">
                        <label id="<?php echo $row->poll_option_id; ?>label" class="poll_response <?php if(!empty($response) && $response->poll_option_id == $row->poll_option_id) echo 'poll_selected'; ?> col-xs-12">
                            <input type="radio" name="response" class="selection" value="<?php echo $row->poll_option_id; ?>" <?php if(!empty($response) && $response->poll_option_id == $row->poll_option_id) echo 'checked'; ?> />
                            <span id="<?php echo $row->poll_option_id; ?>text"><?php echo $row->text; ?></span> <span id="<?php echo $row->poll_option_id; ?>percent"><?php echo $row->percent; ?>%</span> <span id="<?php echo $row->poll_option_id; ?>count">(<?php echo $row->count; ?>)</span>
                        </label>            
                    </div>
                    <?php endforeach; ?>                
                </div>
                <?php echo form_close(); ?>                
            </fieldset>            
        </div>
    </div>    
</div>
<script>
    $(document).ready(function() {
        $('.selection').change(function() {
           response = $(this).val();
           user_id = $('#user_id').val();
           poll_id = $('#poll_id').val();
           existing_id = $('#existing_id').val();
           
          $('input:radio[name=response]').each(function(){
                if($(this).is(":checked")) {
                    $(this).parent().addClass('poll_selected');
                } else {
                    $(this).parent().removeClass('poll_selected');
                }   
          });
           
           
            $.ajax({
                type: "POST", 
                async: false, 
                url: '<?php echo base_url(); ?>poll_response/respond',   
                data: {
                    user_id: user_id,
                    poll_id: poll_id,
                    response: response,
                    existing_id: existing_id
                },
                success: function(data){
                    result = $.parseJSON(data);
                    html = '';
                    $.each(result.results.results, function() {
                        $('#'+ this.poll_option_id + 'text').html(this.text);
                        $('#' + this.poll_option_id + 'percent').html(this.percent + '%');
                        $('#' + this.poll_option_id + 'count').html('(' + this.count + ')');
                    });                  
                    $('#existing_id').val(result.existing_id);
                    $('#votes').html(result.results.votes)
                },
                error: function(){alert('error');}
            });           
           
       }); 
    });
    
</script>

