<div class="row">
    <div class="col-lg-12">
        <h2>Registration History</h2>
        <p>Your online registration history is listed below. Each column is sortable and the search box can help narrow your search.</p>
        <table class="table table-condensed table-bordered table-striped footable toggle-circle toggle-medium" data-page-navigation=".page" data-page-size="20" data-filter="#filter">
            <caption>
                <div class="row">
                    <div class="col-lg-4 col-xs-5 pull-right">
                        <input id="filter" type="text" class="form-control" placeholder="Search">
                    </div>
                </div>
                <br />
            </caption> 
            <thead>
                <tr class="active">
                    <th data-toggle="true" data-sort-initial="descending">Date</th>
                    <th>Competition</th>
                    <th data-hide="phone">Division</th>
                    <th>Dog</th>
                    <th data-hide="phone, tablet">Fee</th>
                    <th data-hide="phone, tablet">Paid Online</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($registrations)) foreach($registrations as $row): ?>
                <tr>
                    <td><?php echo $row->competition->date; ?></td>
                    <td><?php echo $row->competition->name; ?></td>
                    <td><?php echo $row->division->name; ?></td>
                    <td><?php echo $row->canine->name; ?></td>
                    <td><?php echo $row->fees; ?></td>
                    <td><?php $paid = 'No'; if($row->isPaid == 1) $paid = 'Yes'; echo $paid; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" align="center"><div class="page hide-if-no-paging"></div></td>
                </tr>
            </tfoot> 
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.footable').footable();
});
</script>