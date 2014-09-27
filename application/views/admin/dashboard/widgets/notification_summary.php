<div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">Subscriptions</div>
        <div class="panel-body">
            <h5>Total Sunscriptions: <span class="label label-primary"><?php if(!empty($notification_stats['count']))  echo $notification_stats['count']; ?></span></h5>
            <table class="table table-striped table-hover footable toggle-circle toggle-medium">
                <thead>
                <tr>
                    <th data-toggle="true">User</th>
                    <th data-hide="all">Email</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($notification_stats['users'])) foreach($notification_stats['users'] as $user): ?>
                    <tr>
                        <td><?php echo $user['full_name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>