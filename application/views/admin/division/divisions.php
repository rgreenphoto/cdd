<div class="row">
    <div class="col-lg-12 col-xs-11">
        <p class="text-info">Listed below are the divisions available for this event type. Leave the field blank if that division is not offered. Enter 0.00 if the division is offered at no charge.</p>
    </div>
</div>
<br />
<div class="row">
<?php $i=0; if(!empty($divisions)) foreach($divisions as $row): ?>
    <div class="col-lg-4 col-xs-10">
        <label><?php echo $row->name; ?>:</label>
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input class="form-control" id="division_fee_<?php echo $row->id; ?>" name="division_fee[<?php echo $row->id; ?>]" style="text-align: right;" type="text" <?php if(!empty($competition_fee[$row->name])) echo 'value="'.$competition_fee[$row->name]['fee'].'"' ?>>
        </div>
    </div>  
<?php $i++; endforeach; ?>    
</div>