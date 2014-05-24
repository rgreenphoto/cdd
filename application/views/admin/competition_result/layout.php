<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/gameday/<?php echo $item->competition->id; ?>">Dashboard</a></li>
    <li><a href="<?php echo base_url(); ?>admin/competition_result/running/<?php echo $item->competition->id; ?>/<?php echo $breadcrumb->id; ?>"><?php echo $breadcrumb->name; ?> - Running Order</a></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-condensed table-bordered">
            <thead>
            <tr class="info">
                <th>Order</th>
                <th>Human</th>
                <th>Canine</th>
                <th>Division</th>
            </tr>
            </thead>
            <tbody>
            <tr class="active">
                <td><?php echo $item->$order_view; ?></td>
                <td><?php echo $item->user->full_name; ?> <?php if($breadcrumb->id == 5) echo '& '.$pairs; ?></td>
                <td><?php echo $item->canine->name; ?></td>
                <td><?php echo $item->division->name; ?><?php if($dual == '1') echo ' (Dual)'; ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view($internal_view); ?>