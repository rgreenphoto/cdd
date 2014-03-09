<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plupload/js/plupload.full.js"></script>
<h1>Upload Users in Excel format</h1>
<button id="open-uploader" class="btn btn-primary">Browse to Excel File (xlsx)  <i class="icon-table"></i></button>
<div id="output-panel"></div>

   



    <script type="text/javascript">
      // Custom example logic
//      function $(id) {
//        return document.getElementById(id);
//      }
    
      var uploader = new plupload.Uploader({
        runtimes : 'html5,html4',
        browse_button : 'open-uploader',
        max_file_size : '10mb',
        url : "<?php echo base_url(); ?>admin/user/do_upload/",
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
        
        up.start();

        for (var i in files) {
          $('debug').innerHTML += '<div id="' + files[i].id + '">' + files[i].id + ' - ' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
        }
      });
	uploader.bind('UploadProgress', function(up, file) {
                $('#output-panel').html('<img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" />');
                $('#' + file.id + " b").html(file.percent + "%");
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
//            $.ajax({
//                url: '<?php echo base_url(); ?>user/get_image/<?php //echo $user->id; ?>',
//                success: function(data){
//                    console.log(data);
//                }
//            });
	});      
      
    </script>