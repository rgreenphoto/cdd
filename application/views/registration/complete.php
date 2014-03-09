<?php if(!empty($message)): ?>
<p><?php echo $message; ?></p>
<?php endif; ?>
<h2>Current Registrations</h2>
<div class="row">
    <div class="col-lg-12">
        <h5>Refund Policy</h5>
        <p>Please read and understand the following prior to approval of online payments to Colorado Disc Dogs (CDD). All payment made online are considered final. It is not the policy of Colorado Disc Dogs to issue monetary refunds. If the competitor cancels or does not show for the pre-paid event all pre-paid funds will be considered donations to the CDD. In cases of hardship, written requests can be submitted here <a href="mailto:admin@coloradodiscdogs.com?subject=Refund Request">request refund</a>. All requests for refunds or credit towards future CDD registrations will be evaluated on an individual basis. Written requests do not guarantee that a refund or credit will be issued. Any approved refunds may be subject to service and transaction charges. All persons approving of online payments certify that they have read, understand, and agree to the conditions presented above.</p>
    </div>
</div>
<div class="row">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Event/Competition</th>
                <th>Date</th>
                <th>Dog</th>
                <th>Human</th>
                <th>Division</th>
                <th>Entry Fee</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; $i=0; if(!empty($registrations)) foreach($registrations as $row): ?>
                <tr>
                    <td><?php echo $row->competition->name; ?></td>
                    <td><?php echo $row->competition->date; ?></td>
                    <td><?php echo $row->canine->name; ?></td>
                    <td><?php echo $row->user->full_name; ?><?php if(!empty($row->pairs)) echo '/'.$row->pairs; ?></td>
                    <td><?php echo $row->division->name; ?></td>
                    <td><?php echo $row->fees; ?></td>
                    <td><a href="<?php echo base_url(); ?>registration/delete/<?php echo $row->id; ?>/<?php if(!empty($rowid[$i])) echo $rowid[$i]; ?>" class="btn btn-danger btn-mini"><i class="icon-trash"></i> Remove</a></td>
                </tr>
            <?php if(!empty($row->fees)) $total = number_format($total + $row->fees, 2); ?>    
            <?php $i++; endforeach; ?>
        </tbody>
    </table>    
</div>
<div class="row">
    <div class="col-lg-10">
        <p class="text-danger">Payments with PayPal will open up a new window/tab to complete the transaction. All transactions are processed on the PayPal site and we do not collect any credit card information on this site.</p>
    </div>
    <div class="col-lg-2">
        <table class="table">
            <tbody>
                <tr>
                   <td>Total:</td> 
                   <td><?php echo $total; ?></td>
                </tr>
                <?php if($this->the_user->group_id == '3'): ?>
                <tr>
                    <td>Member Total:</td>
                    <td><?php $newprice = round($total * ((100-10) / 100), 2); $newprice = number_format($newprice, 2); echo $newprice; ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>        
    </div>
</div>
<div class="row">
    <div class="col-lg-1 pull-right">
            <form id="paypal" class="paypal-button" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                <input value="buynow" name="button" type="hidden">
                <input value="Colorado Disc Dogs Registrations" name="item_name" type="hidden">
                <input value="<?php if(!empty($newprice)) { echo $newprice; } else { echo $total; } ?>" name="amount" type="hidden">
                <input value="_xclick" name="cmd" type="hidden">
                <input value="KBGBNQ8YMJB66" name="business" type="hidden">
                <input value="JavaScriptButton_buynow" name="bn" type="hidden">
                <input src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" type="image">
            </form>        
    </div>
</div>
<script>
$(document).ready(function() {
    $('#paypal').submit(function(){
        window.location = "<?php echo base_url(); ?>registration/done/1/1";
    });
});


</script>
