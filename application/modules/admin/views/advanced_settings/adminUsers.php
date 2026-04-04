<script>
function openApproveModal(uid, role) {
    var roleNames = {'1':'Agent','2':'Distributor','3':'Wholesaler','4':'Retailer'};
    var roleStr = String(role);
    jQuery('#approve_uid').val(uid);
    jQuery('#approve_role').val(roleStr);
    jQuery('#approve_role_label').text(roleNames[roleStr] || 'Retailer');
    jQuery('#approve_pcent').val('');
    jQuery('#approve_remark').val('');
    jQuery('#approve_agent').val('');
    if (roleStr === '1') {
        jQuery('#approve_pcent_wrap').show();
        jQuery('#approve_pcent_label').text('Commission (%)');
        jQuery('#approve_pcent').attr('placeholder', 'e.g. 5');
        jQuery('#approve_agent_wrap').hide();
    } else if (roleStr === '2' || roleStr === '3') {
        jQuery('#approve_pcent_wrap').show();
        jQuery('#approve_pcent_label').text('Margin (%)');
        jQuery('#approve_pcent').attr('placeholder', 'e.g. 10');
        jQuery('#approve_agent_wrap').hide();
    } else {
        jQuery('#approve_pcent_wrap').hide();
        jQuery('#approve_pcent').val('0');
        jQuery('#approve_agent_wrap').show();
    }
    jQuery('#approveModal').modal('show');
}
function openEditPublicUser(btn) {
    var d = jQuery(btn).data();
    jQuery('#epu_id').val(d.id);
    jQuery('#epu_name').val(d.name);
    jQuery('#epu_phone').val(d.phone);
    jQuery('#epu_email').val(d.email);
    jQuery('#epu_address').val(d.address);
    jQuery('#epu_pan').val(d.pan);
    jQuery('#epu_gst').val(d.gst);
    jQuery('#epu_type').val(String(d.type));
    jQuery('#epu_pcent').val(d.pcent);
    jQuery('#epu_remark').val(d.remark);
    jQuery('#epu_status').val(String(d.status));
    jQuery('#epu_agents').val(d.agents || '');
    jQuery('#editPublicUserModal').modal('show');
}
function saveEditPublicUser() {
    var id = jQuery('#epu_id').val();
    jQuery.post('<?= base_url('admin/editPublicUser') ?>', {
        id:      id,
        name:    jQuery('#epu_name').val(),
        phone:   jQuery('#epu_phone').val(),
        email:   jQuery('#epu_email').val(),
        address: jQuery('#epu_address').val(),
        pan:     jQuery('#epu_pan').val(),
        gst:     jQuery('#epu_gst').val(),
        type:    jQuery('#epu_type').val(),
        pcent:   jQuery('#epu_pcent').val(),
        remark:  jQuery('#epu_remark').val(),
        status:  jQuery('#epu_status').val(),
        agents:  jQuery('#epu_agents').val()
    }, function(r) {
        try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch(e) {}
        if (r && r.success) {
            jQuery('#editPublicUserModal').modal('hide');
            location.reload();
        } else {
            alert('Save failed. Please try again.');
        }
    });
}
</script>
<!-- Approve Modal — rendered FIRST so it's always in the DOM -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Approve User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="approve_uid"/>
                <input type="hidden" id="approve_role"/>
                <div class="form-group">
                    <label>Registered Role</label>
                    <p class="form-control-static"><strong id="approve_role_label">—</strong></p>
                </div>
                <div class="row">
                    <div class="col-md-6" id="approve_pcent_wrap">
                        <div class="form-group">
                            <label id="approve_pcent_label">Percent (%)</label>
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
                <div class="form-group" id="approve_agent_wrap" style="display:none;">
                    <label>Parent User ID <small class="text-muted">(Distributor / Wholesaler / Agent)</small></label>
                    <input type="text" class="form-control" id="approve_agent" placeholder="Enter parent user ID"/>
                    <p class="help-block">For retailers managed by a distributor or agent, enter their parent's ID here.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="
                    var uid=document.getElementById('approve_uid').value,
                        role=document.getElementById('approve_role').value,
                        pcent=document.getElementById('approve_pcent').value,
                        rmark=document.getElementById('approve_remark').value,
                        agent=document.getElementById('approve_agent').value;
                    if(role!='4' && !pcent){alert(role=='1'?'Commission % is required.':'Margin % is required.');return;}
                    jQuery.post('<?= base_url('admin/approve'); ?>',{id:uid,role:role,pcent:pcent,rmark:rmark,agent:agent},function(){jQuery('#approveModal').modal('hide');location.reload();});
                ">Save changes</button>
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
                        <th>Parent</th>
                        <th>GST</th>
                        <th>PAN</th>
                        <th>Status</th>
                        <th>Approve/Reject</th>
                        <th>Registration Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; foreach ($Allusers->result() as $user) { $i++; if ($i > 100) break; ?>
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
                        <td><?php
                            $type_labels = [1 => 'Agent', 2 => 'Distributor', 3 => 'Wholesaler'];
                            if (!empty($user->agents)) {
                                $parent_ids = array_filter(array_map('intval', explode(',', $user->agents)));
                                $parent_parts = [];
                                foreach ($parent_ids as $pid) {
                                    if (isset($user_map[$pid])) {
                                        $p = $user_map[$pid];
                                        $display = $p['company'] ?: $p['name'];
                                        $role_label = $type_labels[$p['type']] ?? 'User';
                                        $parent_parts[] = htmlspecialchars($display) . ' <span class="label label-default">' . $role_label . '</span>';
                                    }
                                }
                                echo $parent_parts ? implode('<br>', $parent_parts) : '<span class="text-muted">—</span>';
                            } else {
                                echo '<span class="text-muted">—</span>';
                            }
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
                        ?></td>
                        <td>
                            <?php if ($user->status == '2'): ?>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-success" onclick="openApproveModal(<?= (int)$user->id ?>, <?= (int)$user->type ?: 4 ?>)">Approve</button>
                                <button type="button" class="btn btn-danger" onclick="if(confirm('Reject this user?')){jQuery.post('<?= base_url('admin/reject'); ?>',{id:<?= (int)$user->id; ?>},function(){location.reload();});}">Reject</button>
                            </div>
                            <?php else: ?>
                            &mdash;
                            <?php endif; ?>
                        </td>
                        <td><?= !empty($user->last_login) ? date('d.m.Y - H:i:s', $user->last_login) : '-'; ?></td>
                        <td class="text-center">
                            <a href="?delete=<?= $user->id ?>" class="confirm-delete">Delete</a>
                            &nbsp;
                            <button type="button" class="btn btn-xs btn-default js-edit-pub-user" onclick="openEditPublicUser(this)"
                                data-id="<?= (int)$user->id ?>"
                                data-name="<?= htmlspecialchars($user->name ?? '', ENT_QUOTES) ?>"
                                data-phone="<?= htmlspecialchars($user->phone ?? '', ENT_QUOTES) ?>"
                                data-email="<?= htmlspecialchars($user->email ?? '', ENT_QUOTES) ?>"
                                data-address="<?= htmlspecialchars($user->address ?? '', ENT_QUOTES) ?>"
                                data-pan="<?= htmlspecialchars($user->pan ?? '', ENT_QUOTES) ?>"
                                data-gst="<?= htmlspecialchars($user->gst ?? '', ENT_QUOTES) ?>"
                                data-type="<?= (int)$user->type ?>"
                                data-pcent="<?= htmlspecialchars($user->percent ?? '', ENT_QUOTES) ?>"
                                data-remark="<?= htmlspecialchars($user->remark ?? '', ENT_QUOTES) ?>"
                                data-status="<?= (int)$user->status ?>"
                                data-agents="<?= htmlspecialchars($user->agents ?? '', ENT_QUOTES) ?>"
                            >Edit</button>
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

<!-- Edit Public User Modal -->
<div class="modal fade" id="editPublicUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Edit User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="epu_id"/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="epu_name"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" id="epu_phone"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="epu_email"/>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" id="epu_address"/>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>PAN</label>
                            <input type="text" class="form-control" id="epu_pan"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>GST</label>
                            <input type="text" class="form-control" id="epu_gst"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" id="epu_type">
                                <option value="1">Agent</option>
                                <option value="2">Distributor</option>
                                <option value="3">Wholesaler</option>
                                <option value="4">Retailer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Margin / Commission (%)</label>
                            <input type="text" class="form-control" id="epu_pcent" placeholder="0"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="epu_status">
                                <option value="1">Active</option>
                                <option value="2">Pending</option>
                                <option value="3">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Remark</label>
                    <input type="text" class="form-control" id="epu_remark"/>
                </div>
                <input type="hidden" id="epu_agents"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveEditPublicUser()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).on('click', '.js-edit-pub-user', function() {
    openEditPublicUser(this);
});
</script>

