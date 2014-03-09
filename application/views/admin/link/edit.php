<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin">Home</a></li>
    <li><a href="<?php echo base_url(); ?>admin/link">Links</a></li>
    <li class="active"><?php echo $title; ?></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <?php echo form_open(current_url(), $attributes, $hidden); ?>
        <fieldset>
            <legend>Link Details</legend>
            <div class="row">
                <div class="col-lg-5">
                    <label for="link_type_id">Category <span class="text-danger"><?php echo form_error('link_type_id'); ?></span></label>
                    <select name="link_type_id" class="form-control">
                        <?php if(!empty($link_types)) foreach($link_types as $type): ?>
                        <option value="<?php echo $type->id; ?>" <?php if(!empty($link) && $link->link_type_id == $type->id) echo 'selected'; ?>><?php echo $type->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-lg-5">
                    <label for="name">Name <span class="text-danger"><?php echo form_error('name'); ?></span></label>
                    <input type="text" name="name" class="form-control" value="<?php if(!empty($link) && !empty($link->name)) echo $link->name; ?>" />           
                </div>
                <div class="col-lg-5">
                    <label for="url">URL: <span class="text-danger"><?php echo form_error('url'); ?></span></label>
                    <input type="text" name="url" class="form-control" value="<?php if(!empty($link) && !empty($link->url)) echo $link->url; ?>" />
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-lg-12">
                    <label for="description">Description <span class="text-danger"><?php echo form_error('description'); ?></span></label>
                    <textarea name="description"><?php if(!empty($link) && !empty($link->description)) echo $link->description; ?></textarea>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-lg-2 col-lg-offset-10">
                    <?php echo form_submit('submit', $title, 'class="btn btn-cdd pull-right"'); ?>
                </div>
            </div>
        </fieldset>    
        <?php echo form_close(); ?>        
    </div>
</div>
<br />

  
<script type="text/javascript" >
tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        width: "100%",
        theme_advanced_resizing : true,
        theme_advanced_resizing_use_cookie : false,
        plugins : "paste",
        theme_advanced_buttons3_add : "pastetext,pasteword,selectall",
        
});
</script>