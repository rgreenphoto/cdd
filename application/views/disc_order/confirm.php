<h2>Disc Order Details</h2>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-bordered table-striped">
            <thead>
                <tr>
                    <th>Disc Type/Brand</th>
                    <th>Color</th>
                    <th># of Discs</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($order)) foreach($order as $row): ?>
                <tr>
                    <td><?php echo $row->disc_type->name; ?></td>
                    <td><?php echo $row->color; ?></td>
                    <td><?php echo $row->total_discs; ?></td>
                    <td><?php echo $row->total; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2"><span class="pull-right">Totals</span></th>
                    <th><?php echo !empty($stats->total_discs)?$stats->total_discs:''; ?></th>
                    <th><?php echo !empty($stats->total)?$stats->total:''; ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

    <div class="row">
        <div class="col-lg-10">
            <div class="pull-right">
                <a href="<?php echo base_url(); ?>disc_order/print_summary" class="btn btn-cdd">Print Invoice <i class="icon-print"></i></a>
            </div>
        </div>
        <div class="col-lg-2">
            <?php if(isset($paypal)): ?>
                <form id="paypal" class="paypal-button" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                    <input value="buynow" name="button" type="hidden">
                    <input value="Colorado Disc Dogs Bulk Order" name="item_name" type="hidden">
                    <input value="<?php echo !empty($stats->total)?$stats->total:''; ?>" name="amount" type="hidden">
                    <input value="_xclick" name="cmd" type="hidden">
                    <input value="KBGBNQ8YMJB66" name="business" type="hidden">
                    <input value="JavaScriptButton_buynow" name="bn" type="hidden">
                    <input src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" type="image">
                </form>
            <?php endif; ?>
        </div>
    </div>