<ul class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>competition/view/<?php echo $competition->slug; ?>"><?php echo $competition->name; ?></a></li>
    <li class="active">Registered Teams</li>
</ul>
<h3><img src="<?php echo base_url(); ?><?php echo $competition->competition_type->image; ?>" /> <?php echo $competition->name; ?></h3>
<?php if(!empty($forms)) foreach($forms as $division): ?>
<div class="panel-group" id="<?php echo $division->id; ?>">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php if(!empty($division->registrations)) {
                $new_chev = 'up';
            } else {
                $new_chev = 'down';
            }?>
            <a class="accordion-toggle" data-toggle="collapse" data-parent="<?php echo $division->id; ?>" href="#collapse<?php echo $division->id; ?>"><?php echo $division->name; ?> - <?php echo count($division->registrations); ?><span id="chev" class="icon-chevron-<?php echo $new_chev; ?> pull-right"></span></a>
        </div>
        <div id="collapse<?php echo $division->id; ?>" class="panel-collapse collapse <?php if(!empty($division->registrations)) echo 'in'; ?>">
            <div class="panel-body">
                <?php if(!empty($division->registrations)): ?>
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Handler</th>
                        <th>Dog</th>
                    </thead>
                    <tbody>
                        <?php foreach($division->registrations as $reg): ?>
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
