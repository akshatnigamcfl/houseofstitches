<!-- Approve Modal — rendered FIRST so it's always in the DOM -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Define User Role</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="approve_uid"/>
                <div class="form-group">
                    <label>Select Role</label>
                    <select class="form-control" id="approve_role">
                        <option value="1">Agent</option>
                        <option value="2">Distributor</option>
                        <option value="3">Wholeseller</option>
                        <option value="4">Retailer</option>
                    </select>
                </div>
                <div class="form-group" id="approve_userlist_wrap" style="display:none;">
                    <select class="form-control" id="approve_userlist"></select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Percent (%)</label>
                            <input type="text" class="form-control" id="approve_pcent" placeholder="%"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Remark</label>
                            <input type="text" class="form-control" id="approve_remark" placeholder=""/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="var uid=document.getElementById('approve_uid').value,role=document.getElementById('approve_role').value,pcent=document.getElementById('approve_pcent').value,rmark=document.getElementById('approve_remark').value,agent=document.getElementById('approve_userlist').value;if(!pcent){alert('Percent field is required.');return;}jQuery.post('<?= base_url('admin/approve'); ?>',{id:uid,role:role,pcent:pcent,rmark:rmark,agent:agent},function(){jQuery('#approveModal').modal('hide');location.reload();});">Save changes</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.status {
    color: white;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 600;
    cursor: pointer;
}
.active   { background-color: #28a745; }
.pending  { background-color: #ffc107; color: #000; }
.deactive { background-color: #dc3545; }
</style>

<div id="users">
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-3px;"> Admin Users</h1>
    <hr>
    <?php if (validation_errors()) { ?>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
    <?php } ?>
    <?php if ($this->session->flashdata('result_add')) { ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
    <?php } ?>
    <?php if ($this->session->flashdata('result_delete')) { ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
    <?php } ?>

    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_users" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add new user</a>
    <div class="clearfix"></div>

    <?php if ($users->result()) { ?>
        <div class="row">
            <div class="col-md-12">
                <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/import'); ?>">
                    <label>Select Excel File</label>
                    <input type="file" name="file" accept=".xls, .xlsx, .csv" required>
                    <input type="submit" name="import" class="btn btn-info" style="margin-left:20%; margin-top:-4%;" value="Import">
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped custab" id="admin-user1">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>GST</th>
                        <th>PAN</th>
                        <th>Status</th>
                        <th>Approve/Reject</th>
                        <th>Registration Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; foreach ($Allusers->result() as $user) { $i++; ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= isset($user->username) ? $user->username : $user->name; ?></td>
                        <td><?= $user->email; ?></td>
                        <td><?php
                            if ($user->type == '1') { echo 'Agent'; }
                            elseif ($user->type == '2') { echo 'Distributor'; }
                            elseif ($user->type == '3') { echo 'Wholeseller'; }
                            else { echo 'Retailer'; }
                        ?></td>
                        <td><?= isset($user->gst) ? $user->gst : ''; ?></td>
                        <td><?= isset($user->pan) ? $user->pan : ''; ?></td>
                        <td><?php
                            if ($user->status == '1') {
                                echo '<span class="status active"  data-attr="'.$user->id.'">Active</span>';
                            } elseif ($user->status == '2') {
                                echo '<span class="status pending" data-attr="'.$user->id.'">Pending</span>';
                            } else {
                                echo '<span class="status deactive" data-attr="'.$user->id.'">Rejected</span>';
                            }
                            if ($i == 100) { return false; }
                        ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-success" onclick="document.getElementById('approve_uid').value=<?= (int)$user->id; ?>;document.getElementById('approve_pcent').value='';document.getElementById('approve_remark').value='';document.getElementById('approve_role').value='1';document.getElementById('approve_userlist_wrap').style.display='none';jQuery('#approveModal').modal('show');">Approve</button>
                                <button type="button" class="btn btn-danger" onclick="if(confirm('Reject this user?')){jQuery.post('<?= base_url('admin/reject'); ?>',{id:<?= (int)$user->id; ?>},function(){location.reload();});}">Reject</button>
                            </div>
                        </td>
                        <td><?= !empty($user->last_login) ? date('d.m.Y - H:i:s', $user->last_login) : '-'; ?></td>
                        <td class="text-center">
                            <a href="?delete=<?= $user->id ?>" class="confirm-delete">Delete</a>
                            &nbsp;
                            <a href="?edit=<?= $user->id ?>">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No users found!</div>
    <?php } ?>

    <!-- add edit users modal -->
    <div class="modal fade" id="add_edit_users" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        <h4 class="modal-title">Add Administrator</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit" value="<?= isset($_GET['edit']) ? (int)$_GET['edit'] : '0' ?>">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Notifications</label>
                            <input type="text" name="notify" class="form-control" value="<?= isset($_POST['notify']) ? htmlspecialchars($_POST['notify']) : '' ?>" placeholder="1 = yes, 0 = no">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div><!-- /#users -->

<script>
jQuery(document).ready(function($) {
    $('#approve_role').on('change', function() {
        $.ajax({
            url: '<?= base_url("admin/adminusers/get_data"); ?>',
            type: 'POST',
            data: { option_id: $(this).val() },
            dataType: 'text',
            success: function(res) {
                $('#approve_userlist_wrap').show();
                $('#approve_userlist').html(res);
            }
        });
    });
    <?php if (isset($_GET['edit'])) { ?>
    $('#add_edit_users').modal('show');
    <?php } ?>
});
</script>
