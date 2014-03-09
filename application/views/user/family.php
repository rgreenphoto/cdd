<div class="row">
    <div class="col-lg-12">
        <h2>Family Members</h2>
        <p>Here is a list of family members. You can quickly add new family using the form below.</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                </tr>                
            </thead>
            <tbody>
                <?php if(!empty($family)) foreach($family as $row): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <p>Enter new family members with this quick form.</p>
        <?php echo form_open('user/add_family', array('class' => 'form-inline'), array()); ?>
        <fieldset>
            <div class="control-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" name="first_name" />
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" name="last_name" />
                <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
            </div>
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</div>    


