<div class="row">
    <h2>Cup Standings</h2>
    <p class="text-info">Cup standings are listed below. You can also run calculations to update standings after competitions. Please note, this is a large calculation and may take a minute or two to process.</p>
</div>
<div class="row">
    <div class="btn-group">
        <button id="Cup" class="btn btn-warning popup"><i class="icon-refresh"></i> Calculate Cup Standings</button>
        <button id="RRR" class="btn btn-success popup"><i class="icon-refresh"></i> Calculate Red Rocket Standings</button>
        <button id="Hershey" class="btn btn-primary popup"><i class="icon-refresh"></i> Calculate Hershey Standings</button>
    </div>
    <p class="text-warning">Please note that you do not need to calculate Rookie of the Year. It's based on cup standings and is generated with cup calculation</p>
</div>
<br />
<div class="row">
    <ul class="nav nav-pills">
        <li class="<?php if($type == 'Cup') echo 'active'; ?>"><a href="<?php echo base_url(); ?>admin/standing/index/<?php echo $season; ?>/Cup">Cup Standings</a></li>
        <li class="<?php if($type == 'Rookie') echo 'active'; ?>"><a href="<?php echo base_url(); ?>admin/standing/index/<?php echo $season; ?>/Rookie">Rookie Standings</a></li>
        <li class="<?php if($type == 'RRR') echo 'active'; ?>"><a href="<?php echo base_url(); ?>admin/standing/index/<?php echo $season; ?>/RRR">Red Rocket Rider Standings</a></li>
        <li class="<?php if($type == 'Hershey') echo 'active'; ?>"><a href="<?php echo base_url(); ?>admin/standing/index/<?php echo $season; ?>/Hershey">Hershey Standings</a></li>
    </ul>
</div>
<br />
<div class="row">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <?php if(!empty($seasons)) foreach($seasons as $row): ?>
                <li <?php if($season == $row) echo 'class="active"'; ?>><a href="<?php echo base_url(); ?>admin/standing/index/<?php echo $row; ?>/<?php echo $type; ?>"><?php echo $row; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <table class="table table-hover table-striped table-bordered footable" id="standingtable" data-page-size="300" data-filter="#filter">
                <caption><input id="filter" type="text" class="form-control" placeholder="Search"></caption>
            <?php if($type == 'Cup' || $type == 'Rookie'): ?>
                <thead>
                    <tr>
                        <th data-type="numeric">Place</th>
                        <th>Handler</th>
                        <th>Dog</th>
                        <th data-type="numeric">Points</th>
                        <th data-type="numeric">Comps</th>
                        <th data-sort-ignore="true">Drop</th>
                    </tr>
                </thead>
            <?php endif; ?>
            <?php if($type != 'Cup' && $type != 'Rookie'): ?>
                <thead>
                    <tr>
                        <th data-type="numeric">Place</th>
                        <th>Handler</th>
                        <th>Dog</th>
                        <th>Skyhoundz</th>
                        <th>UFO</th>
                        <th>Total</th>
                        <th>Award Points</th>
                    </tr>
                </thead>
            <?php endif; ?>
                <tbody>
                <?php if(!empty($standings)) foreach($standings as $standing): ?>
                    <tr>
                        <td><?php echo $standing['place']; ?></td>
                        <td><?php echo $standing['handler']; ?></td>
                        <td><?php echo $standing['dog']; ?></td>
                        <?php if($type == 'Cup' || $type == 'Roockie'): ?>
                        <td><?php echo $standing['total']; ?></td>
                        <td><?php echo $standing['comps']; ?></td>
                        <td><?php echo $standing['drop'];?></td>
                        <?php endif; ?>
                        <?php if($type != 'Cup' && $type != 'Rookie'): ?>
                        <td><?php echo $standing['sky']; ?></td>
                        <td><?php echo $standing['ufo']; ?></td>
                        <td><?php echo $standing['total']; ?></td>
                        <td><?php echo $standing['award']; ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>  
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     <?php echo form_open(base_url().'admin/standing/standings', array('id' => 'calculate_form')); ?>
     <input type="hidden" id="type" name="type" />
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Calculate <span id="type_label"></span> Standings</h4>
      </div>
      <div class="modal-body">
          <div id="formDiv">
            <label for="season">Season</label>
            <select name="season" class="form-control">
                <?php if(!empty($seasons)) foreach($seasons as $row): ?>
                <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                <?php endforeach; ?>
            </select>
          </div>
          <div id="loaderDiv" style="display:none;">
              <h5>Calculating...</h5>
            <div class="progress progress-striped active">
              <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">Processing</span>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-cdd">Calculate</button>
      </div>
    <?php echo form_close(); ?> 
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).ready(function(){
        $('.popup').click(function() {
            id = $(this).attr('id');
            $('#myModal').modal('toggle');
            $('#type').val(id);
            $('#type_label').text(id);
        });
        $('#calculate_form').submit(function(){
            $('#formDiv').hide();
            $('#loaderDiv').show();
        });
    });
</script>