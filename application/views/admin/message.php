<div id="freeow" class="freeow freeow-top-right"></div>
<?php
    $success_message = $this->session->flashdata('success_message');
    $error_message = $this->session->flashdata('error_message');
    $message = $this->session->flashdata('message');
?>

<div id="dialog-confirm" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel">Alert</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete?</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
                <a id="continue_button" href="#" class="btn btn-primary">Yes</a>
            </div>
        </div>
    </div>
</div>
<div id="pleaseWaitDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-header">
        <h1>Processing...</h1>
    </div>
    <div class="modal-body">
        <div class="progress progress-striped active">
            <div class="bar" style="width: 100%;"></div>
        </div>
    </div>
    <div class="modal-footer">
        <p>Please wait for completion.</p>
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

        
