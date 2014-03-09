<h2 id="page-heading"><?php echo $title; ?></h2>
<div class="row-fluid">
    <span class="span12">
    <?php 
        echo $this->table->generate($users); 
    ?>        
    </span>
</div>
<script>
$(document).ready(function() {
    $('#usertable, .dataTable').dataTable({
        "sPaginationType": "full_numbers",
        "iDisplayLength": 100
    });    
});
</script>



