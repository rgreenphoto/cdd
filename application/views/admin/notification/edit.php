<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/notification">Notification Center</a></li>
    <li class="active"><?php echo $title; ?></li>
</ul>
<div class="container">
<p>Use the form below to send message to CDD web site users. You must select a 'group', these are the people who will receive the message.
Please note that users have the option to receive these message in email as well. When creating the body of the messages, it's best not to use images. Formatted text and links are acceptable.</p>
<?php echo form_open(current_url(), '', $hidden); ?>
    <div class="row">
        <div class="col-lg-10">
            <label for="category">Group: <span class="text-danger"><?php echo form_error('group_id'); ?></span></label>
            <select name="group_id" class="form-control">
                <option value="">Select User Group</option>
                <option value="0">All Users</option>
                <?php if(!empty($groups)) foreach($groups as $group): ?>
                    <?php if($group->name != 'admin'): ?>
                    <option value="<?php echo $group->id; ?>"><?php echo $group->description; ?> (<?php echo $group->num_users; ?>)</option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-10">
            <label for="subject">Subject: <span class="text-danger"><?php echo form_error('subject'); ?></span></label>
            <input id="subject" type="text" name="subject" class="form-control" value="<?php echo !empty($message->subject) ? $message->subject: '' ?>" />        
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-10">
            <label for="body">Body: <span class="text-danger"><?php echo form_error('body'); ?></span></label>
            <textarea name="body" class="form-control"><?php echo !empty($message->body)?$message->body: ''; ?></textarea>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-10">
            <button type="submit" name="submit" class="btn btn-cdd pull-right"><i class="icon-save"></i> Send Message</button>
        </div>
    </div>
<?php echo form_close(); ?>
</div>
<script>
 $(window).bind('load', function() {
     tinyMCE.init({
            mode : "textareas",
            theme : "advanced",
            width: "100%",
            theme_advanced_resizing : true,
            theme_advanced_resizing_use_cookie : false,
            plugins : "paste",
            theme_advanced_buttons3_add : "pastetext,pasteword,selectall"

    }); 
});

</script>