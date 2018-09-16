<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/position/">Positions</a></li>
</ul>
<?php echo form_open_multipart(current_url()); ?> 
    <fieldset>
        <div class="row">
            <div class="col-lg-12 col-xs-10">
                <legend><?php echo $title; ?></legend>
                <p class="text-info">Add basic information about this volunteer position.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-xs-10">
                <label for="name">Name: <?php echo form_error('name'); ?></label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo !empty($position) ? $position->name: ''; ?>" />
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-12 col-xs-11">
                <textarea id="description" name="description"><?php echo !empty($position) ? $position->description: ''; ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xs-10">
                <?php echo form_submit('submit', 'Save', 'class="btn btn-cdd pull-right"'); ?>              
            </div>
        </div>
        <br />
    </fieldset>
<?php echo form_close(); ?>

<script type="text/javascript">
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