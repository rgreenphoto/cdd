<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>admin/gameday/<?php echo $item->competition->id; ?>" class="btn btn-md btn-info">Dashboard</a></li>
    <li><a href="<?php echo base_url(); ?>admin/competition_result/running/<?php echo $item->competition->id; ?>/<?php echo $breadcrumb->id; ?>" class="btn btn-md btn-primary"><?php echo $breadcrumb->name; ?> - Running Order</a></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <ul class="list-inline">
            <li><h2><span class="label label-primary"><?php echo $item->$order_view; ?></span></h2></li>
            <li><h2><span class="label label-warning"><?php echo $item->user->full_name; ?> <?php if($breadcrumb->id == 5) echo '& '.$pairs; ?></span></h2></li>
            <li><h2><span class="label label-warning"><?php echo $item->canine->name; ?></span></h2></li>
        </ul>
    </div>
</div>
<?php $this->load->view($internal_view); ?>