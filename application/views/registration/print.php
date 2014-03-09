<!DOCTYPE html> 
<html>
    <head> 
        <title><?php if(!empty($site_info)) echo $site_info->site_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Colorado Disc Dogs - Frisbee Dogs Club in Colorado">
        <meta name="keywords" content="frisbee,dog,dogs,frisbee dog,frisbee dogs,disc,disc dog,disc dogs,colorado,colorado frisbee dogs,frisbee dogs show,frisbee dog show,frisbee dog entertainment,frisbee dogs entertainment,frisbee dogs halftime,frisbee halftime shows,frisbee dog demo,frisbee dog demos,frisbee dogs demo">        
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/paw-icon.png" type="image/png" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-responsive.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/datepicker/css/datepicker.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/font_awesome/css/font-awesome.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/master.css"/>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/global.js"></script>
        
    </head>
    <body>
<table class="table table-striped">
        <thead>
            <tr>
                <th>Event/Competition</th>
                <th>Date</th>
                <th>Dog</th>
                <th>Human</th>
                <th>Division</th>
                <th>Entry Fee</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; if(!empty($registrations)) foreach($registrations as $row): ?>
                <tr>
                    <td><?php echo $row->competition->name; ?></td>
                    <td><?php echo $row->competition->date; ?></td>
                    <td><?php echo $row->canine->name; ?></td>
                    <td><?php echo $row->user->full_name; ?></td>
                    <td><?php echo $row->division->name; ?></td>
                    <td><?php echo $row->fees; ?></td>
                </tr>
            <?php $total = $total + $row->fees; ?>    
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>Total: <?php echo $total; ?>.00</th>
        </tfoot>
    </table>
    </body>
</html>