<?php
    if(!empty($canine->image)) {
        $image_display = 'style=""';
        $uploader_display = 'style="display:none;"';
    } else {
        $image_display = 'style="display:none;"';
        $uploader_display = 'style=""';
    }
?>
<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?><?php echo $return_url; ?>">List of dogs</a></li>
    <li><a href="<?php echo base_url(); ?>canine/add/">Add New Dog</a></li>
</ul>
<div class="container-fluid">
<h2 class="subhead"><?php echo $title; ?></h2>    
    <?php echo form_open(current_url(), $attributes, $hidden); ?>
<fieldset>
    <div class="row">
        <div class="col-lg-4" id="displayprofile" data-toggle="tooltip" title="If this is a borrowed dog, or a dog you no longer play with leave this box un-checked.">
            <label class="checkbox-inline">
                <input type="checkbox" name="display_profile" id="display_profile" value="1" <?php if(!empty($display_profile['checked'])) echo 'checked'; ?> /> Display on Member Profile
            </label>  
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-5">
            <label for="name">Name <?php echo form_error('name'); ?></label>
            <input tye="text" name="name" class="form-control" value="<?php if(!empty($canine->name)) echo $canine->name; ?>" />
        </div>
        <div class="col-lg-5">
            <label for="breed">Breed <?php echo form_error('breed'); ?></label>
            <input type="text" name="breed" class="form-control" value="<?php if(!empty($canine->breed)) echo $canine->breed; ?>" />
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-5">
            <label class="radio-inline">
               <input type="radio" name="gender" value="Male" <?php if(!empty($canine->gender) && $canine->gender == 'Male') echo 'checked="checked"'; ?>>Male
            </label>
            <label class="radio-inline">
                <input type="radio" name="gender" value="Female" <?php if(!empty($canine->gender) && $canine->gender == 'Female') echo 'checked="checked"'; ?>>Female
            </label>
        </div>
        <div class="col-lg-5">
            <label for="date_of_birth">Date of Birth <?php echo form_error('date_of_birth'); ?></label>
            <input type="text" name="date_of_birth" class="form-control" value="<?php if(!empty($canine->date_of_birth)) echo $canine->date_of_birth; ?>" />
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-12">
            <label class="checkbox-inline" for="rescue">
                <input type="checkbox" id="rescue" name="rescue" value="1" <?php echo ($canine->rescue == 'Yes')?'checked':''; ?> />
                Rescue
            </label>
        </div>
    </div>
    <br />
    <div id="rescue_group_block" class="row" style="display:none">
        <div class="col-lg-12">
            <label form="rescue_group">Rescue Group <?php echo form_error('rescue_group'); ?></label>
            <input type="text" name="rescue_group" class="form-control" value="<?php if(!empty($canine->rescue_group)) echo $canine->rescue_group; ?>" />
        </div>
    </div>
</fieldset>  
<fieldset>
    <legend>Bio</legend>
    <div class="row">
        <div id="debug"></div>
    </div>
    <div class="row">
        <?php if($title == 'Edit Canine'): ?>
        <div class="col-lg-4">
            <div class="row">
                <div id="image-display" <?php echo $image_display; ?>>
                    <?php if(!empty($canine->image)): ?><img src="<?php echo base_url(); ?>uploads/profiles/<?php echo $canine->image; ?>" id="profile-image" class="img-responsive" /><?php endif; ?>
                </div>
                <div id="uploader" <?php echo $uploader_display; ?>>
                    <div id="drop-target-canine">Drag and drop a photo here or use the button below to manually upload.</div>
                    <img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" id="loader" style="display:none;" />        
                </div>   
            </div>
            <br />
            <div class="row">
                <div id="button-container"><a href="#" id="open-uploader" class="btn btn-small btn-cdd pull-right"><i class="fa fa-upload fa-fw"></i> Upload Profile Image</a></div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-lg-8">
            <?php echo form_error('bio'); ?>
            <textarea name="bio" class="form-control" rows="10"><?php if(!empty($canine->bio)) echo $canine->bio; ?></textarea>
        </div>
        <?php if($title == 'Add Canine'): ?>
        <div class="col-ld-10">
            <p class="text-error">Once you save your new dog, you will be able to upload photos.</p>
        </div>
        <?php endif; ?>
    </div>
    <br />
    <div class="row">
        <div class="col-ld-10">
            <div class="row">
                <div id="progress-bar" style="display:none;">
                    <div class="alert alert-info">
                        <div class="row">
                            <span class="col-ld-12">
                                <div class="progress" id="progress">
                                    <div id="bar" class="bar" style="width: 0%;"></div>
                                </div>                        
                            </span>
                        </div>
                        <div class="row">
                            <span class="col-lg-8">
                                <span id="text-progress">
                                    <p>Uploading File: <b id="text-bar"></b></p>
                                </span>                        
                            </span>
                            <span class="col-lg-4">
                                <div id="loader-container" style="display:none;">
                                    <p>Optimizing Image <img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" id="loader" /></p>
                                </div>                         
                            </span>
                        </div>
                    </div>
                </div>                
            </div>            
        </div>        
    </div>
</fieldset>
    <div class="form-actions">
        <button id="submit" type="submit" name="submit" class="btn btn-cdd pull-right"><i class="fa fa-floppy-o fa-fw"></i> Save</button>
    </div>    
    <?php echo form_close(); ?> 
</div>
            
<script type="text/javascript" >
    $(document).ready(function() {
        $('#displayprofile').tooltip({
            trigger: 'hover',
            placement: 'bottom',
            html: true
        });
        
        $("#rescue")
            .click(function () {
                options = '';
                if (this.checked) {
                    $('#rescue_group_block').show('fade', options, 2000);
                }
                else {
                    $('#rescue_group_block').hide('fade', options, 2000);
                }
            })
            .filter(function () {
                if(this.checked) {
                    $('#rescue_group_block').show();                    
                }
            });
            
    });
</script>
<script type="text/javascript">
      // Custom example logic
//      function $(id) {
//        return document.getElementById(id);
//      }
    
      var uploader = new plupload.Uploader({
        runtimes : 'html5, html4',
        drop_element: 'drop-target-canine',
        browse_button : 'open-uploader',
        container: 'button-container',
        max_file_size : '10mb',
        url : "<?php echo base_url(); ?>canine/do_upload/<?php if(!empty($canine->id)) echo $canine->id; ?>",
        filters : [
            {title : "Image Files", extensions : "jpg,gif,png,jpeg"}
        ]
      });
      
      
      
      uploader.bind('Init', function(up, params) {
        if (uploader.features.dragdrop) {
          
          var target = $("drop-target-canine");
          
          target.ondragover = function(event) {
            event.dataTransfer.dropEffect = "copy";
          };
          
          target.ondragenter = function() {
            this.className = "dragover";
          };
          
          target.ondragleave = function() {
            this.className = "";
          };
          
          target.ondrop = function() {
            this.className = "";
          };
        }
      });
uploader.init();
      uploader.bind('FilesAdded', function(up, files) {
        
        up.start();
        $('#progress-bar').show();
        $('#bar').attr('style', "width: 0%;");
        $('#text-bar').html("0%");
        $('#drop-target-canine').hide();       
        $('#debug').html();
        for (var i in files) {
          $('#debug').innerHTML += '<div>' + files[i].id + ' - ' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
        }
      });
	uploader.bind('UploadProgress', function(up, file) {
                $('#bar').attr('style', "width:" + file.percent + "%;");
                $('#text-bar').html(file.percent + "%");
	});

	uploader.bind('Error', function(up, err) {
		$('#debug').append("<div>Error: " + err.code +
			", Message: " + err.message +
			(err.file ? ", File: " + err.file.name : "") +
			"</div>"
		);

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file) {
            $('#loader-container').show();
            $.ajax({
                url: '<?php echo base_url(); ?>canine/get_image/<?php if(!empty($canine->id)) echo $canine->id; ?>',
                success: function(data){
                    $('#profile-image').attr('src', '<?php echo base_url(); ?>uploads/profiles/' + data);
                    $('#image-display').show();
                    $('#loader-container').hide();
                }
            });
	});      
      
    $('#open-uploader').click(function() {
//        $('#uploader').toggle();
//        $('#image-display').toggle();
    });
    
        
</script>