<h2><?php echo $title; ?></h2>
<p>See your disc order history and place orders when bulk order season starts.</p>
<div class="row">
    <div class="col-lg-7">
        <?php if(!empty($disc_type)): ?>
        <table class="table table-condensed table-bordered table-hover table-striped footable toggle-circle toggle-medium">
            <thead>
                <tr class="warning">
                    <th>Disc Type</th>
                    <th>Disc Color</th>
                    <th># of Discs</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($disc_type as $disc): ?>
                <tr>
                    <td>
                        <input type="hidden" id="<?php echo $disc->id; ?>_name" value="<?php echo $disc->name; ?>" />
                        <?php echo $disc->name; ?>
                    </td>
                    <td>
                        <select name="<?php echo $disc->id; ?>_color" class="form-control" id="<?php echo $disc->id; ?>_color_selected">
                            <?php foreach($disc->color_dropdown as $k=>$v): ?>
                            <option value="<?php echo str_replace(' ', '_', $v); ?>"><?php echo $v; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="<?php echo $disc->id; ?>_total_discs" class="form-control amount_selected" id="<?php echo $disc->id; ?>_amount_selected" data="<?php echo $disc->id; ?>">
                            <?php foreach($disc->amount_dropdown as $k=>$v): ?>
                            <option value="<?php echo str_replace(' ', '_', $v); ?>"><?php echo $v; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="<?php echo $disc->id; ?>" value="<?php echo $disc->price; ?>" id="<?php echo $disc->id; ?>" />
                        <?php echo $disc->price; ?>
                    </td>
                    <td>
                        <div class="col-lg-8">
                            <input type="text" name="<?php echo $disc->id; ?>_total" id="<?php echo $disc->id; ?>_total" class="form-control input-sm disabled" />
                        </div>
                        <a href="#" data="<?php echo $disc->id; ?>" class="btn btn-xs btn-cdd add_disc">Add <i class="icon-plus"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-4">
        <table class="table table-condensed table-bordered table-hover table-striped footable toggle-circle toggle-medium">
            <thead>
                <tr class="danger">
                    <th data-toggle="true">Type</th>
                    <th data-hide="all">Color</th>
                    <th># of Discs</th>
                    <th>Total</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody id="cart">
                <?php if(!empty($orders)) foreach($orders as $order): ?>
                <tr id="id_<?php echo $order->id; ?>">
                    <td><?php echo $order->disc_type->name; ?></td>
                    <td><?php echo $order->color; ?></td>
                    <td><?php echo $order->total_discs; ?></td>
                    <td><?php echo $order->total; ?></td>
                    <td><a href="#" class="btn btn-xs btn-danger remove_disc" data="<?php echo $order->id; ?>" >Remove <i class="icon-remove"></i></a></td>
                </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.footable').footable();
    
    //perform math for total per disc type
    $('.amount_selected').change(function(e) {
        e.preventDefault();
        type = $(this).attr('data');
        amount = $(this).val();
        price = $('#' + type).val();
        grand_total = amount * price;
        gt = grand_total.toFixed(2);
        $('#' + type + '_total').val(gt);
    });
    
    //add disc type to cart
    $('.add_disc').click(function(e) {
        e.preventDefault();
        type = $(this).attr('data');
        name = $('#' + type + '_name').val();
        amount = $('#' + type + '_amount_selected').val();
        total = $('#' + type + '_total').val();
        color = $('#' + type + '_color_selected').val();
        
        $.ajax({
            type: "POST", 
            async: false, 
            url: '<?php echo base_url(); ?>disc_order/add',   
            data: {
                disc_type_id: type,
                color: color,
                total_discs: amount,
                total: total
            },
            success: function(data){
                result = $.parseJSON(data);
                new_row = '<tr id="id_' + result.id + '">';
                new_row = new_row + '<td>' + name + '</td>';
                new_row = new_row + '<td>' + color.replace("_", " ");color + '</td>';
                new_row = new_row + '<td>' + amount + '</td>';
                new_row = new_row + '<td>' + total + '</td>';
                new_row = new_row + '<td><a href="#" class="btn btn-xs btn-danger remove_disc" data="' + result.id +  '" >Remove <i class="icon-remove"></i></a></td>';
                new_row = new_row + '</tr>';
                $('#cart').append(new_row).trigger('footable_redraw');;
                $('#' + type + '_color_selected').prop('selectedIndex',0);
                $('#' + type + '_amount_selected').prop('selectedIndex',0);
                $('#' + type + '_total').val('');
                if(result.success_message) {
                    $('#freeow').freeow("Success", result.success_message, {
                        classes: ["gray"],
                        autoHide: true
                    });
                }
                //have to bind click function to get new items to fire
                $('.remove_disc').bind("click", function(e) {
                    e.preventDefault();
                    row = $(this);
                    remove_discs(row);
                });
            },
            error: function(){alert('error');}
        }); 
        
    });
    
    //create click event for items already in cart when returning
    $('.remove_disc').click(function(e) {
        e.preventDefault();
        remove_discs(this);
    });
    
    function remove_discs(item) {
            row = $(item).attr('data');
            $.ajax({
                type: "POST",
                async: false,
                url: '<?php echo base_url(); ?>disc_order/delete',
                data: {
                    id: row
                },
                success: function(data) {
                    result = $.parseJSON(data);
                    $('#id_' + result.id).remove();
                    if(result.success_message) {
                        $('#freeow').freeow("Success", result.success_message, {
                            classes: ["gray"],
                            autoHide: true
                        });
                    }
                },
                error: function(){alert('error');}
            });
    }
});


</script>