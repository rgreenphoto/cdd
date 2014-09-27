<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plupload/js/plupload.full.js"></script>
<h1>Upload Results in Excel format</h1>
<button id="open-uploader" class="btn btn-primary">Browse to Excel File (xlsx)  <i class="icon-table"></i></button>
<div id="output-panel" style="display:none;">
    <h3 id="message"></h3>
    <form id="import_results" name="import_result" action="/admin/competition_result/import_file/" method="POST">
        <input type="hidden" name="competition_id" id="competition_id" value="<?php echo $competition_id; ?>" />
        <input type="hidden" name="test_import" id="test_import" value="0" />
        <input type="text" name="file_name" id="file_name" />
        <button type="submit" data="1" name="submit" class="import_results btn btn-primary">Test Import</button>
        <button type="submit" data="0" name="submit" class="import_results btn btn-danger">Process Import</button>
    </form>
</div>
<div class="row">
    <div class="col-lg-10">
        <div id="test_results"></div>
    </div>
</div>

   



    <script type="text/javascript">

      $(document).ready(function() {
         $('.import_results').click(function(e) {
             e.preventDefault();
             var test_import = $(this).attr('data');
             $('#test_import').val(test_import);
             var form = $('#import_results');
             $.ajax({
                 type: "POST",
                 url: '<?php echo base_url(); ?>admin/competition_result/import_file/',
                 data: form.serializeArray(),
                 success: function(data) {
                     var result = $.parseJSON(data);
                     $('#test_results').html(result.html);
                 },
                 error: function(){alert('error');}
             });
         });
      });
    
      var uploader = new plupload.Uploader({
        runtimes : 'html5,html4',
        browse_button : 'open-uploader',
        max_file_size : '10mb',
        url : "<?php echo base_url(); ?>admin/competition_result/do_upload/",
        filters : [
            {title : "Excel Files (.xls)", extensions : "xls"}
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
        $('#message').html('Success');
        $('#output-panel').show();
        $('#file_name').val(file.name);
	});      
      
    </script>