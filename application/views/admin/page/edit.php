<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/page">Site Content</a></li>
    <li class="active"><?php echo $title; ?></li>
</ul>
<h2><?php echo $title; ?></h2>
<?php echo form_open(current_url(), '', $hidden); ?>
    <div class="row">
        <div class="col-lg-6">
            <label for="name">Page Title <span class="text-danger"><?php echo form_error('name'); ?></span></label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo !empty($page->name) ? $page->name: ''; ?>" />
        </div>
        <div class="col-lg-6">
            <?php if(!empty($page) && $page->automated == 1): ?>
            <p class="text-danger">This page includes automatically generated content. This content could be results, schedules or other data.</p>
            <?php endif; ?>
        </div>
    </div>   
    <br />
    <div class="row">
        <div class="col-lg-12">
            <label for="description">Page Content <span class="text-danger"><?php echo form_error('description'); ?></span></label>
            <textarea name="description" cols="500"><?php echo !empty($page->description) ? $page->description: ''; ?></textarea>            
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-6 text-warning">
            <?php if(!empty($page->created)): ?>
                <p class="pull-right">Created By: <?php echo $page->created_by; ?> (<?php echo date('l, F jS Y g:iA', strtotime($page->created)); ?>)</p>
            <?php endif; ?>                  
        </div>
        <div class="col-lg-6 text-warning">
            <?php if(!empty($page->modified)): ?>
                <p class="pull-right">Modified By: <?php echo $page->modified_by; ?> (<?php echo date('l, F jS Y g:iA', strtotime($page->modified)); ?>)</p>
            <?php endif; ?>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-12">
            <?php echo form_submit('submit', $title, 'class="btn btn-cdd pull-right"'); ?>
        </div>
    </div>    
<?php echo form_close(); ?> 


<div class="control-group">

</div>


                      
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