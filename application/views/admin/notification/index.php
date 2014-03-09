<h3><?php echo $title; ?></h3>
<table class="table table-bordered table-hover table-striped footable toggle-circle toggle-medium" data-page-navigation=".page" data-page-size="25" data-filter="#filter">
    <caption>
        <div class="row">
            <div class="col-lg-11 col-xs-8">
                <input id="filter" type="text" class="form-control" placeholder="Search">
            </div>
            <div class="col-lg-1 col-xs-2">
                <a href="<?php echo base_url(); ?>admin/notification/add" class="btn btn-cdd">Add <i class="icon-plus"></i></a>
            </div>
        </div>
        <br />
    </caption>
    <thead>
        <tr>
            <th data-hide="all">&nbsp;</th>
            <th data-toggle="true">Group</th>
            <th>Subject</th>
            <th data-sort-initial="true">Created</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($notifications)) foreach($notifications as $message): ?>
        <tr>
            <td>
                <div class="row">
                    <div class="col-lg-3">Subject: </div>
                    <div class="col-lg-9"><?php echo $message->subject; ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">Body: </div>
                    <div class="col-lg-9"><?php echo $message->body; ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">Created: </div>
                    <div class="col-lg-9"><?php echo $message->created; ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">Created By: </div>
                    <div class="col-lg-9"><?php echo $message->created_by; ?></div>
                </div>            
            </td>
            <td><?php echo !empty($message->group->description)?$message->group->description:'All Users'; ?></td>
            <td><?php echo $message->subject; ?></td>
            <td><?php echo $message->created; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" align="center"><div class="page hide-if-no-paging"></div></td>
        </tr>
    </tfoot>
</table>

