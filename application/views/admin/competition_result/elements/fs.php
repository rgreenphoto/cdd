<div class="row">
    <div class="col-lg-12">
        <h5>Freestyle</h5>
        <table class="table table-bordered table-condensed table-striped">
            <thead>
                <tr>
                    <th>Round</th>
                    <th>FS 1</th>
                    <th>FS 2</th>
                    <th>FS 3</th>
                    <th>FS 4</th>
                    <th>Catch Ratio</th>
                    <th>Deduct</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="success">
                    <td>1</td>
                    <td><?php echo form_input('fs_1_1', $item['fs_1_1'], 'class="fs_1" id="fs_1_1"'); ?></td>
                    <td><?php echo form_input('fs_2_1', $item['fs_2_1'], 'class="fs_1" id="fs_2_1"'); ?></td>
                    <td><?php echo form_input('fs_3_1', $item['fs_3_1'], 'class="fs_1" id="fs_3_1"'); ?></td>
                    <td><?php echo form_input('fs_4_1', $item['fs_4_1'], 'class="fs_1" id="fs_4_1"'); ?></td>
                    <td><?php echo form_input('cr_1', $item['cr_1'], 'class="cr_1" id="cr_1"'); ?></td>
                    <td><?php echo form_input('deduct_1', $item['deduct_1'], 'class="fs_1" id="deduct_1"'); ?></td>
                    <td><?php echo form_input('fs_total_1', $item['fs_total_1'], 'class="" id="fs_total_1"'); ?></td>
                </tr>                
                <tr class="info">
                    <td>2</td>
                    <td><?php echo form_input('fs_1_2', $item['fs_1_2'], 'class="span4 fs_2" id="fs_1_2"'); ?></td>
                    <td><?php echo form_input('fs_2_2', $item['fs_2_2'], 'class="span4 fs_2" id="fs_2_2"'); ?></td>
                    <td><?php echo form_input('fs_3_2', $item['fs_3_2'], 'class="span4 fs_2" id="fs_3_2"'); ?></td>
                    <td><?php echo form_input('fs_4_2', $item['fs_4_2'], 'class="span4 fs_2" id="fs_4_2"'); ?></td>
                    <td><?php echo form_input('cr_1', $item['cr_1'], 'class="span4 cr_1" id="cr_1"'); ?></td>
                    <td><?php echo form_input('deduct_2', $item['deduct_2'], 'class="span4 fs_2" id="deduct_2"'); ?></td>
                    <td><?php echo form_input('fs_total_2', $item['fs_total_2'], 'class=span4 id="fs_total_2"'); ?></td>
                </tr>                
            </tbody>
        </table>
    </div>
</div>