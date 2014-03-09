<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/datatable/media/css/jquery.dataTables.css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/datatable/media/js/jquery.dataTables.min.js"></script>
<div class="row-fluid">
    <span class="span12">
        <h2><?php echo $competition->name; ?></h2>
    </span>
</div>

<div class="row-fluid">
    <span class="span12">
    <?php $i=0; if(!empty($divisions)) foreach($divisions as $row): ?>
    <?php if($row->id != '5'): ?>    
        <div class="accordion" id="accordion<?php echo $row->id; ?>">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $row->id; ?>" href="#collapse<?php echo $row->id; ?>"><?php echo $row->name; ?><span id="chev" class="icon-chevron-down pull-right"></span></a>
                </div>
                <div id="collapse<?php echo $row->id; ?>" class="accordion-body collapse <?php if($i==0) echo 'in'; ?>">
                    <div class="accordion-inner">
                        <table class="dataTable">
                            <thead>
                                <tr>
                                    <th>Place</th>
                                    <th>Handler</th>
                                    <th>Dog</th>
                                    <?php if($row->freestyle == '1'): ?>
                                    <th>FS Total (1)</th>
                                    <th>FS Total (2)</th>
                                    <?php endif; ?>
                                    <th>TC Total (1)</th>
                                    <th>TC Total (2)</th>
                                    <th>Total</th>
                                    <th>CDD Place</th>
                                    <th>Cup Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($row->competition_result)) foreach($row->competition_result as $result): ?>
                                <tr>
                                    <td><?php echo $result->place; ?></td>
                                    <td><?php echo $result->handler; ?></td>
                                    <td><?php echo $result->canine; ?></td>
                                    <?php if($row->freestyle == '1'): ?>
                                    <td><?php echo ($result->fs_total_1 != '0.0' ? $result->fs_total_1: ''); ?></td>
                                    <td><?php echo ($result->fs_total_2 != '0.0' ? $result->fs_total_2: ''); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo $result->tc_total_1; ?></td>
                                    <td><?php echo ($result->tc_total_2 != '0.0' ? $result->tc_total_2: ''); ?></td>
                                    <td><?php echo $result->total; ?></td>
                                    <td><?php echo $result->cdd_place; ?></td>
                                    <td><?php echo $result->cup_points; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>           
            </div>
        </div>
        <?php endif; ?>
        <?php $i++; endforeach; ?>        
    </span>
</div>
<?php echo $this->load->view('social'); ?>
<script>
$(document).ready(function() {
    $('.dataTable').dataTable({
        "bPaginate": false,
        "bFilter": false
    });    
});

</script>
    