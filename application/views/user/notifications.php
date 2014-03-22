<h2><?php echo $title; ?></h2>
<p>The Colorado Disc Dogs will from time to time, need to send important messages to it's members. You can view all messages sent here. As well, you can also elect to receive an email when messages are sent.
    You can change this option on your <a href="<?php echo base_url(); ?>user/settings">Account Settings</a> page.</p>
<table class="table table-hover table-striped footable toggle-arrow-small toggle-small" data-page-navigation=".page" data-page-size="10" data-filter="#filter">
    <thead>
        <tr class="active">
            <th data-hide="all">&nbsp;</th>
            <th data-toggle="true">Subject</th>
            <th>Date</th>
            <th data-sort-ignore="true">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($messages)) foreach($messages as $message): ?>
        <tr id="<?php echo $message->id; ?>" class="clickable <?php if($message->read == 0) echo 'warning'; ?>">
            <td><?php echo $message->notification->body; ?></td>
            <td><?php echo $message->notification->subject; ?></td>
            <td><?php echo $message->date_sent; ?></td>
            <td><a href="<?php echo base_url(); ?>notification/delete/<?php echo $message->id; ?>" class="btn btn-sm btn-danger">Delete <i class="icon-minus-sign"></i></a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" align="center"><div class="page hide-if-no-paging"></div></td>
        </tr>
    </tfoot> 
</table>



<script>
$(document).ready(function() {
        $('.footable').footable().bind({
//            'footable_row_expanded': function(e) {
//                console.log(e);
//                //return confirm('Are you sure?');
//            }
        });
        $('.clickable').click(function() {
            var id = $(this).attr('id');
            var url = '<?php echo base_url(); ?>notification/mark_read/' + id;
            $.ajax({
                url: url,
                success: function(data) {
                    var results = $.parseJSON(data);
                    if(results.unread_messages == 0) {
                        $('#unread_messages').hide();
                    } else {
                        $('#unread_messages').text(results.unread_messages);
                    }
                    $('#'+id).removeClass('warning');
                }
            });
        });
});

</script>
