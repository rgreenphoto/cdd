<div class="row">
                            <div class="col-lg-10">
                                <div class="alert alert-danger">
                                    Please make sure your password is strong, unique and contains all the required fields I need to add.
                                </div>    
                            </div>
                        </div>
                        <form action="<?php echo base_url(); ?>user/change_password" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="password">Password (if changing) <?php echo form_error('password'); ?></label>
                                <input type="password" class="form-control" name="password" value="" />                   
                            </div>
                            <div class="col-lg-6">
                                <label for="password_confirm">Password Confirm <?php echo form_error('password_confirm'); ?></label>
                                <input type="password" class="form-control" name="password_confirm" />                   
                            </div>    
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo form_submit('submit', 'Save New Password', 'class="btn btn-cdd pull-right"'); ?>
                            </div>
                        </div>
                        </form>