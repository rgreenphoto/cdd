<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="container-fluid">
                <div class="row">
                    <button type="button" class="close reg-window"  aria-hidden="true">&times;</button>
                </div>
                <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6">
                    <?php $date = date('m/d/Y g:i A'); if(!empty($the_user) && $event->registration_start <= $date && $event->registration_end >= $date): ?>
                        <?php $this->load->view('competition/elements/form'); ?>
                    <?php endif; ?>
                </div>
                <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6">
                    <table class="table table-striped table-bordered table-condensed" id="registered-teams">
                        <tr class="info">
                            <th>Human</th>
                            <th>Dog</th>
                            <th>Division</th>
                            <th>Fee</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody id="holding">
                        <?php if(!empty($registrations)) foreach($registrations as $row): ?>
                            <tr id="<?php echo $row->id; ?>">
                                <td><?php echo $row->user->first_name.' '.$row->user->last_name; ?></td>
                                <td><?php echo $row->canine->name; ?></td>
                                <td><?php echo $row->division->name; ?></td>
                                <td><?php echo $row->fees; ?></td>
                                <td><a href="#" data="<?php echo base_url(); ?>registration/delete_ajax/<?php echo $row->id; ?>" class="btn btn-sm btn-cdd delete" alt="Delete?"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3"><a href="<?php echo base_url(); ?>registration/done/1/0" class="btn btn-primary btn-xs pull-right">Pay at event</a></th>
                            <th><a href="<?php echo base_url(); ?>registration/complete" class="btn btn-xs btn-success pull-right" id="complete-reg">PayPal</a></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        current_user = '<?php if(!empty($the_user)) echo $the_user->id; ?>';
        current_username = '<?php if(!empty($the_user)) echo $the_user->first_name.' '.$the_user->last_name; ?>';
        $('#division_id').change(function() {
            val = $('#division_id').val();
            if(val == '5') {
                $('#pairs_partner').show();
            }
        });

        $('#new_id').change(function() {
            id = $('#new_id').val();
            value = $("#new_id option:selected").text();
            if(id == '') {
                $('#user_id').val(current_user);
                $('#current-user').html(current_username);
                $('#new_dog').hide();
                $('#new_canine_id').empty();
            } else {
                //get list of dogs as well and populate drop down
                $.ajax({
                    type: "POST",
                    async: false,
                    url: '<?php echo base_url(); ?>canine/get',
                    data: {
                        user_id: id
                    },
                    success: function(data){
                        result = $.parseJSON(data);
                        options = $('#canine_id');
                        options.empty();
                        options.append('<option>Please select family dog</option>');
                        $.each(result, function() {
                            option = $('<option></options>').attr('value', this.id).text(this.name);
                            options.append(option);
                        });
                        $('#canine_id').effect('highlight');
                    },
                    error: function(){alert('error');}
                });

                $('#user_id').val(id);
                $('#current-user').html(value);
            }
        });

        $('#register-form').submit(function(e){//
            e.preventDefault();
            var form = $('#register-form');
            var data = form.serializeArray();
            var user_id = $('#user_id').val();
            var division_id = $('#division_id').val();
            var canine_id = $('#canine_id').val();
            var pairs = $('#pairs').val();
            flag = '1';

            if(user_id == '') {
                $('#error-info p').html('Please select a family member');
                $flag = '0';
            }

            if(division_id == '') {
                $('#error-info p').html('Please select a division');
                flag = '0';
            }

            if(canine_id == '') {
                $('#error-info p').html('Please select a dog');
                flag = '0';
            }

//            if(new_id) {
//                user_id = new_id;
//            }

//            if(canine_id == '0') {
//                if(new_canine_id == '') {
//                    $('#error-info p').html('Please select a dog');
//                    flag = '0';
//                } else {
//                    canine_id = new_canine_id;
//                }
//            }

            if(flag == '1') {
                $('#loader').show();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: '<?php echo base_url(); ?>registration/add',
                    data: data,
                    success: function(data){
                        data = $.parseJSON(data);
                        if(data == 'Already in the system') {
                            $('#error-info p').html('This dog is already registered in this division');
                            $('#loader').hide();
                        } else {
                            options = '';
                            $('#actions').show();
                            $('#holding').append(data);
                            $('#collapse').show();
                            $("#holding" ).effect('highlight');
                            $('#complete-reg').show();
                            $('#loader').hide();
                            $('#registered-teams').show();
                            $('#error-info p').html('');
//                            $('#register-form').reset();
                            $('#freeow').freeow("Registration", "Your registration has been added", {
                                classes: ["gray"],
                                autoHide: true
                            });
                            $('.delete').click(function(e) {
                                e.preventDefault();
                                url = $(this).attr('data');
                                $.ajax({
                                   type: "POST",
                                   url: url,
                                   success: function(data) {
                                       data = $.parseJSON(data);
                                       $('#freeow').freeow("Registration", "You registration has been deleted", {
                                           classes: ["gray"],
                                           autoHide: true
                                       });
                                       $('#'+data.id).remove();
                                   }
                                });
                            });
                        }
                    },
                    error: function(){alert('error');}
                });
            }
        });
        $('.delete').click(function(e) {
            e.preventDefault();
            url = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: url,
                success: function(data) {
                    data = $.parseJSON(data);
                    $('#freeow').freeow("Registration", "You registration has been deleted", {
                        classes: ["gray"],
                        autoHide: true
                    });
                    $('#'+data.id).remove();
                }
            });
        });
    });
</script>





           