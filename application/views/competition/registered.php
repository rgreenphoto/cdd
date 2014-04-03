<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>competition/view/<?php echo $competition->slug; ?>"><?php echo $competition->name; ?></a></li>
    <li class="active">Registered Teams</li>
</ul>
<h3><img src="<?php echo base_url(); ?><?php echo $competition->competition_type->image; ?>" /> <?php echo $competition->name; ?></h3>
<?php if(!empty($forms)) foreach($forms->registrations as $division): ?>
<div class="panel-group" id="<?php echo $division->division_id; ?>">
    <div class="panel panel-default accordion">
        <div class="panel-heading">
            <?php if(!empty($division->teams)) {
                $new_chev = 'minus';
            } else {
                $new_chev = 'plus';
            }?>
            <a class="accordion-toggle" data-toggle="collapse" data-parent="<?php echo $division->division_id; ?>" href="#collapse<?php echo $division->division_id; ?>"><?php echo $division->division; ?> - <?php echo count($division->teams); ?><span id="chev_<?php echo $division->division_id; ?>" class="fa fa-<?php echo $new_chev; ?> pull-right"></span></a>
        </div>
        <div data="<?php echo $division->division_id; ?>" id="collapse<?php echo $division->division_id; ?>" class="panel-collapse collapse <?php if(!empty($division->teams)) echo 'in'; ?>">
            <div class="panel-body">
                <?php if(!empty($division->teams)): ?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Handler</th>
                        <th>Dog</th>
                    </thead>
                    <tbody>
                        <?php foreach($division->teams as $reg): ?>
                        <tr>
                            <td><?php echo $reg->user->full_name; ?><?php if(!empty($reg->pairs)) echo '/'.$reg->pairs; ?></td>
                            <td><?php echo $reg->canine->name; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
