<?php
    if(!empty($user->profile_image)) {
        $image_display = 'style=""';
        $uploader_display = 'style="display:none;"';
    } else {
        $image_display = 'style="display:none;"';
        $uploader_display = 'style=""';
    }
?>

<div id="upload-display" <?php echo $uploader_display; ?>>
    <div id="drop-target">Drag and drop a photo here or use the button below to manually upload.</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6">
                <div id="debug"></div>
                <div id="progress-bar" class="progress progress-striped active" style="display:none;">
                    <div id="bar" class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemaz="100" style="width: 45%">
                        <span id="text-progress">
                            <p><b id="text-bar"></b></p>
                        </span>               
                    </div>
                </div>                
            </div>
            <div id="button-container" class="col-lg-6">
                <div class="btn-group pull-right">
                    <a id="edit_bio" class="btn btn-sm btn-cdd"><i class="icon-edit"></i> Edit Bio</a>
                    <a id="view_dogs" class="btn btn-sm btn-cdd"><i class="icon-list"></i> View All Dogs</a>
                    <a href="#" id="open-uploader" class="btn btn-sm btn-cdd"><i class="icon-upload-alt"></i> Upload Profile Image</a>
                </div>                  
            </div>
        </div>
    </div>    
</div>
<br />
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            As a member of the Colorado Disc Dogs, you can maintain your own profile 
            page on the web-site. We've already added dogs you have played with in the past and this does 
            include borrowed dogs or dogs who are no longer with us. They're listed below your bio and accomplishments.
            Click the 'Edit' button under Bio to add a short bio of your history in the sport.
            You can visit the <a href="<?php echo base_url(); ?>user/privacy">Privacy Settings</a> to adjust who may view your Member Profile.       
        </div>    
    </div>    
</div>

<div id="bio" class="row">
    <div class="col-lg-12">
        <h3>Bio</h3>
        <div id="text"><?php echo $user->member_bio; ?></div>
        <div id="form" style="display:none;">
            <?php echo form_error('member_bio'); echo form_textarea($member_bio); ?>
            <div class="col-lg-9">
                <img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" id="bio-loader" style="display:none;" class="pull-right"/>
            </div>
            <div class="col-lg-3">
                <button id="save_bio" type="submit" class="btn btn-sm btn-cdd pull-right" data-loading-text="Saving..."><i class="icon-save"></i> Save</button>
            </div>    
        </div>        
    </div>
</div>
<br />
<div id="dogs" class="row" style="display:none">
    <div class="col-lg-12">
        <table id="view-all" class="table table-bordered table-condensed table-striped table-hover footable">
            <thead>
                <tr class="cdd">
                    <th>Dog</th>
                    <th>Displayed on Profile</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($canines)) foreach($canines as $row): ?>
                <tr>
                    <td><?php echo $row->name; ?></td>
                    <td><?php $display = 'No'; if($row->display_profile == '1') $display = 'Yes'; echo $display; ?></td>
                    <td><a href="<?php echo base_url(); ?>canine/edit/<?php echo $row->id; ?>" class="btn btn-cdd btn-sm"><i class="icon-edit"></i> Edit</a></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><a href="<?php echo base_url(); ?>canine/add" class="btn btn-cdd btn-xs pull-right"><i class="icon-plus"></i> Add Dog</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
        $('.footable').footable();

        pagination = $('.page ul').attr('class');
        if(!pagination) {
            $('.page ul').addClass('pagination pagination-sm');
        }
        
        $('#edit_bio').click(function() {
           $('.alert').alert('close');           
           $('#bio').show('slow');
           $('#dogs').hide('slow');
           $('#form').show();
           $('#text').hide();           
        });
        
        $('#view_dogs').click(function() {
           $('.alert').alert('close');
           $('#bio').hide('slow');
           $('#dogs').show('slow');
        });
        
        $('#save_bio').click(function() {
            m_bio = $('#member_bio').val();
            $('#bio-loader').show();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>user/bio/',
                data: { member_bio: m_bio },
                success: function(data){
                    $('#form').hide();
                    $('#text').html(data).show();
                    $('#bio-loader').hide();
                    $('#freeow').freeow("Success", "Bio saved.", {
                        classes: ["gray"],
                        autoHide: true
                    });
                }
            }); 
        });      
</script>
    <script type="text/javascript">
      var uploader = new plupload.Uploader({
        runtimes : 'html5, html4',
        drop_element: 'drop-target',
        browse_button : 'open-uploader',
        container: 'button-container',
        max_file_size : '20mb',
        url : "<?php echo base_url(); ?>user/do_upload/<?php echo $the_user->id; ?>",
        filters : [
            {title : "Image Files", extensions : "jpg,gif,png,jpeg"}
        ]
      });
      
      
      
      uploader.bind('Init', function(up, params) {
          
      });
      uploader.init();
      
      uploader.bind('FilesAdded', function(up, files) {
        up.start();
        $('#progress-bar').show();
        $('#bar').attr('style', "width: 0%;").attr('aria-valuenow', "0");
        $('#text-bar').html("Uploading File: 0%");
        for (var i in files) {
          $('#debug').innerHTML += '<div>' + files[i].id + ' - ' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
        }
      });
	uploader.bind('UploadProgress', function(up, file) {
                $('#bar').attr('style', "width:" + file.percent + "%;").attr('aria-valuenow', file.percent);
                $('#text-bar').html("Uploading File:" + file.percent + "%");
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
            $.ajax({
                url: '<?php echo base_url(); ?>user/get_image/<?php echo $user->id; ?>',
                beforeSend: function(e) {
                    $('#bar').attr('style', "width:55%;").attr('aria-valuenow', "55");
                    $('#text-bar').html("Loading New Image: 55%");
                },
                    
                success: function(data){
                    $('#profile-image').attr('src', '<?php echo base_url(); ?>uploads/profiles/' + data);
                    $('#debug').html('');
                    $('#drop-target').hide();
                    $('#bar').attr('style', "width:100%;").attr('aria-valuenow', "100");
                    $('#text-bar').html("Loading New Image: 100%");                   
                    $('#progress-bar').fadeToggle();
                }
            });
	});      
    </script>