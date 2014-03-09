<div class="col-lg-12">
    <span><?php if(!empty($cms_content)) echo $cms_content->description; ?></span>
</div>
<ul class="nav nav-tabs text-success hidden-xs">
    <li class="<?php if($type == 'Cup') echo 'active'; ?>"><a href="<?php echo base_url(); ?>standing/<?php echo $season; ?>/Cup">Colorado Cup (State Championship Series)</a></li>
    <li class="<?php if($type == 'Rookie') echo 'active'; ?>"><a href="<?php echo base_url(); ?>standing/<?php echo $season; ?>/Rookie">Rookie of the Year Award</a></li>
    <li class="<?php if($type == 'RRR') echo 'active'; ?>"><a href="<?php echo base_url(); ?>standing/<?php echo $season; ?>/RRR">Red Rocket Rider Freestyle Award</a></li>
    <li class="<?php if($type == 'Hershey') echo 'active'; ?>"><a href="<?php echo base_url(); ?>standing/<?php echo $season; ?>/Hershey">Hershey Memorial Award</a></li>
</ul>
<div class="dropdown hidden-md hidden-lg">
    <a class="btn btn-cdd" data-toggle="dropdown" href="#">Select Series <span class="glyphicon glyphicon-chevron-down"></span></a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a href="<?php echo base_url(); ?>standing/<?php echo $season; ?>/Cup">Colorado Cup (State Championship Series)</a></li>
        <li><a href="<?php echo base_url(); ?>standing/<?php echo $season; ?>/Rookie">Rookie of the Year Award</a></li>
        <li><a href="<?php echo base_url(); ?>standing/<?php echo $season; ?>/RRR">Red Rocket Rider Freestyle Award</a></li>
        <li><a href="<?php echo base_url(); ?>standing/<?php echo $season; ?>/Hershey">Hershey Memorial Award</a></li>                
    </ul>    
</div>
<div class="col-lg-5">
    <h4><?php echo $header; ?> - <?php echo date('Y'); ?></h4>   
</div>
<div class="col-lg-7">
    <div class="col-lg-4">
        <select name="year" id="standingYear" class="form-control">
            <option value="">Previous Seasons</option>
            <?php if(!empty($seasons)) foreach($seasons as $k=>$v): ?>
            <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-lg-8">
        <input id="filter" type="text" class="form-control" placeholder="Search">
    </div>
</div>
<?php $this->load->view('standing/'.$table_view); ?>
<script>
    $(document).ready(function() {
       $('.footable').footable();
       $('#standingYear').change(function(){
          var event = $(this).val();
          if(event) {
              window.location = '<?php echo base_url(); ?>standing/' + event + ''; 
          }
       }); 
    });
    
</script> 
   