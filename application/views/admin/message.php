<?php $message = $this->session->flashdata('message'); ?>
<?php if(!empty($message)): ?>
<div id="session-message">
    <?php echo $this->session->flashdata('message'); ?>
</div>
    <script type="text/javascript">
        $('#session-message').show().fadeOut(8000);
    </script>
<?php endif; ?>

<div id="dialog-confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 id="myModalLabel">Alert</h3>
    </div>
    <div class="modal-body">
        <p>Are you sure you want to delete?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <a id="continue_button" href="#" class="btn btn-primary">Continue</a>
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
        $(document).ready(function() {
            $('#pleaseWaitDialog').on('shown', function() {
                $('#pleaseWaitDialog').modal().css({
                    'margin-top': function () {
                        return window.pageYOffset-($(this).height() / 4 );
                    }
                });                
            });
            $('#dialog-confirm').on('shown', function() {
                $('#dialog-confirm').modal().css({
                    'margin-top': function () {
                        return window.pageYOffset-($(this).height() / 2 );
                    }
                });                
            });            
        });
    </script>
        
