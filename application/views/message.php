<div id="freeow" class="freeow freeow-top-right"></div>  
<?php 
    $success_message = $this->session->flashdata('success_message');
    $error_message = $this->session->flashdata('error_message');
    $message = $this->session->flashdata('message');
?>    
<div id="dialog-confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 id="myModalLabel">Alert</h3>
    </div>
    <div class="modal-body">
        <p></p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <a id="continue_button" href="#" class="btn btn-primary">Continue</a>
    </div>
</div>
    
<script>
 $(window).bind('load', function() {
     var success_message = '<?php if(!empty($success_message)) echo $success_message; ?>';
     if(success_message) {
         $('#freeow').freeow("Success", success_message, {
             classes: ["gray"],
             autoHide: true
         });
     }
     var error_message = '<?php if(!empty($error_message)) echo $error_message; ?>';
     if(error_message) {
         $('#freeow').freeow("Error", error_message, {
             classes: ["gray", "error"],
             autoHide: false
         });
     }
     var message = '<?php if(!empty($message)) echo $message; ?>';
     if(message) {
         $('#freeow').freeow("Message", message, {
             classes: ["gray"],
             autoHide: true
         });
     }

     
 });   
    
    
</script>    
