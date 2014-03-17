<div class="row">
    <div class="col-lg-9">
        <h3><a href="<?php echo base_url(); ?>competition/view/<?php echo $competition[0]->slug; ?>"><?php if(!empty($competition[0]->name)) echo $competition[0]->name; ?></a> - Live Results</h3>    
    </div>
    <div class="col-lg-3">      
        <div class="btn-group pull-right">
            <button id="spinner" style="display:none;" type="button" class="btn btn-cdd"><img src="<?php echo base_url(); ?>assets/images/dog-loader.gif" class="img-responsive" /></button>
            <div class="btn-group">
                <button type="button" class="btn btn-cdd dropdown-toggle" data-toggle="dropdown">
                    Select Division <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <?php if(!empty($divisions)) foreach($divisions as $row): ?>
                    <li roll="presentation"><a class="request" data="<?php echo $row->id; ?>"><?php echo $row->name; ?></a></li>
                    <?php endforeach; ?>            
                </ul>                 
            </div>
            
        </div>
    </div>
</div>
<hr />
<div class="row">
    <div id="fetch" class="col-lg-12" style="display:none;"><h4>Fetching...</h4></div>
    <div id="target" class="col-lg-12">
    </div>
</div>
<script>
    $(document).ready(function() {        
        $('.request').click(function() {
            division_id = $(this).attr('data');
            get_results(division_id);
        });        
    });
    
function get_results(division_id) {
    $.ajax({
        url: '<?php echo base_url(); ?>result/get_results/<?php echo $competition[0]->id; ?>/' + division_id,
        beforeSend: function() {
            //$('#target').fadeOut();
            $('#spinner').toggle();
            $('#fetch').toggle();
        },
        success: function(data) {
            $('#target').html(data);
            $('.footable').effect("highlight", 1000);
            $('#spinner').toggle();
            $('#fetch').toggle();
            $('.footable').footable();
        }
    });
}
</script>