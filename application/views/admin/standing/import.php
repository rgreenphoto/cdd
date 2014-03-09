<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plupload/js/plupload.full.js"></script>
<h1>Upload Standings in Excel format</h1>
<!--<form id="form" name="options">-->
<?php echo form_open_multipart($form_open); ?>
<input type="text" name="url" id="url" />
    <div class="row-fluid">
        <span class="span4"><?php echo form_dropdown('type', $types, '', 'id=type'); ?></span>
        <span class="span4"><?php echo form_dropdown('season', $years, '', 'id=season'); ?></span>
    </div>
    <?php echo form_error('icon'); echo form_label('File', 'file'); echo form_upload('file'); ?>
    <input type="submit" name="submit" value="submit" />
    
<!--    <div class="row-fluid" id="upbtn" style="display:none;">
        <span class="span7">
            <div id="output-panel">
                <img id="spinner" src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" style="display:none;" />
            </div>
            <button id="open-uploader" class="btn btn-primary pull-right">Browse to Excel File (xlsx)  <i class="icon-table"></i></button>
        </span>
    </div>-->
</form>


<script>
$(document).ready(function() {
   $('#form').change(function() {
       type = $('#type').val();
       season = $('#season').val();
       if(type && season) {
           $('#upbtn').show();
           $('#url').val('<?php echo base_url(); ?>admin/standing/do_upload/' + type + '/' + season + '/');
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
        runtimes : 'html5,html4',
        browse_button : 'open-uploader',
        max_file_size : '80000',
        url : "<?php echo base_url(); ?>admin/standing/do_upload/",
        filters : [
            {title : "Excel Files (.xlsx)", extensions : "xlsx"}
        ]
      });
      
      
      
      uploader.bind('Init', function(up, params) {
        if (uploader.features.dragdrop) {
          
          var target = $("drop-target");
          
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
        $('#spinner').show();
        $('#open-uploader').hide();
        up.start();
        
        for (var i in files) {
          $('debug').innerHTML += '<div id="' + files[i].id + '">' + files[i].id + ' - ' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
        }
      });

	uploader.bind('Error', function(up, err) {
		$('#output-panel').append("<div>Error: " + err.code +
			", Message: " + err.message +
			(err.file ? ", File: " + err.file.name : "") +
			"</div>"
		);

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file) {
            $('#output-panel').html('<h3>Success</h3>');
	});      
      
    </script>