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

.active {
    background-color: #28a745; /* Green for Active */
}

.pending {
    background-color: #ffc107; /* Yellow/Orange for Pending */
    color: #000;
}

.deactive {
    background-color: #dc3545; /* Red for Deactive */
}
</style>
<div id="users">
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-3px;"> Admin Users</h1> 
    <hr>
    <?php if (validation_errors()) { ?>
        <hr>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_add')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    ?>
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_users" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add new user</a>
    <div class="clearfix"></div>
    <?php
    if ($users->result()) {
        ?>
        <div class="row">
            <div class="col-md-12">
                 <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/import'); ?>">
                        <label>Select Excel File</label>
                        <input type="file" name="file" accept=".xls, .xlsx, .csv" required>
                        <input type="submit" name="import" class="btn btn-info" style="margin-left: 20%;
    margin-top: -4%;"  value="Import">
                    </form>                
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped custab" id="admin-user1">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Username</th>
                        <th>Password</th>
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
                <?php $i='0'; foreach ($Allusers->result() as $user) { $i++; ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= isset($user->username) ? $user->username : $user->name; ?></td>
                        <td><b>hidden ;)</b></td>
                        <td><?= $user->email; ?></td>
                        <td><?php
                            if($user->type=='1'){ echo 'Agent'; }elseif($user->type=='2'){ echo 'Distributor'; }elseif($user->type=='3'){ echo 'Wholeseller'; }else{
                                echo 'Retailer';
                            }
                        ?></td>
                        <td><?= $user->gst; ?></td>
                        <td><?= $user->pan; ?></td>
                        <td><?php   
                            if($user->status=='1')
                            { 
                                echo '<span class="status active" id="active" data-attr="'.$user->id.'">Active</span>'; 
                            }elseif ($user->status=='2') {
                                echo '<span class="status pending" id="deactive" data-attr="'.$user->id.'">Pending</span>';
                            }
                            else{ 
                                echo '<span class="status deactive" id="pending" data-attr="'.$user->id.'">Reject</span>'; 
                            } 
                            if($i==100){ return false; }
                         ?></td>
                        <td>
                              <div class="btn-group btn-group-sm" role="group">
<!--                                <button class="btn btn-success open-modal-btn" onclick="openApproveModal(<?= $user->id ?>)">Approve</button>
-->                                <button class="btn btn-success open-modal-btn" id="<?= $user->id; ?>">Approve</button>
                                <button class="btn btn-danger" onclick="reject(<?= $user->id ?>)">Reject</button>
                              </div>
                        </td>
                        <!-- APPROVE BUTTON -->

<!-- BOOTSTRAP MODAL -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Define User Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">   
                <input type="hidden" id="uid" name="User_id"/>
                    <div class="col-md-12">
                                        <label>Select</label>
                <select class="form-control user_type" id="role">
                    <option value="1">Agent</option>
                    <option value="2">Distributor</option>
                    <option value="3">Wholeseller</option>
                    <option value="4">Retailer</option>
                </select>

                    </div>
                </div><br>
                <div class="row" >   
                    <div class="col-md-12">
                <select class="form-control hide" id="userlist">
                </select>

                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label>Set Percent</label>
                            <input type="text" class="form-control" placeholder="%" id="pcent"/>
                        </div>
                        <div class="col-md-6">
                            <label>Remark</label>
                            <input type="text" class="form-control" id="remark" placeholder=""/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
<button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                <button type="button" class="btn btn-primary" onclick="approve()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>
function closeModal() { 
    $('#myModal').modal('hide');
}
function approve() {
  var role =  $('#role').val();
  var pcent =  $('#pcent').val();
  var rmark =  $('#remark').val();
  var User_id = $('#uid').val();
  var agent = $('#userlist').val();
  if(pcent == ''){ 
      alert('All fields are required.'); 
     return false;
      
  }
  $.post('/admin/approve', {id: User_id,role: role, pcent: pcent, rmark: rmark, agent:agent}, function() {
    location.reload(); // or update row via DataTables API
  });
}
function reject(id) {
  if(confirm('Reject user?')) {
   // $.post('/admin/reject', {id: id});
  }
}
$(document).ready(function(){
$('.user_type').on('change', function() {
            var val = $(this).val(); //alert(val)
            // show / hide div
            if (val !== '0') {
                $.ajax({
                    url: '<?= base_url('admin/adminusers/get_data'); ?>', // controller/method
                    type: 'POST',
                    data: {
                        option_id: val
                    },
                    dataType: 'text',
                    success: function(res) {
                        // update DOM with response
                        $('#userlist').removeClass('hide');
                        $('#userlist').html(res);
                        $('.agent-select').select2({ // re-init Select2
                            width: '100%',
                            placeholder: 'Search...',
                            allowClear: true
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            } else {
                $('#extraDiv').hide();
            }
        });

    $('.open-modal-btn').click(function(){
        var id = $(this).attr('id');
        $('#uid').val(id);
        $('#myModal').modal('show');
    });
});
</script>

                        <td><?= date('d.m.Y - H:i:s', $user->last_login); ?></td>
                        <td class="text-center">
                            <div>
                                <a href="?delete=<?= $user->id ?>" class="confirm-delete">Delete</a>
                                <a href="?edit=<?= $user->id ?>">Edit</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No users found!</div>
    <?php } ?>

    <!-- add edit users -->
    <div class="modal fade" id="add_edit_users" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Administrator</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit" value="<?= isset($_GET['edit']) ? (int)$_GET['edit'] : '0' ?>">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" class="form-control" id="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" value="" id="password">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" id="email">
                        </div>
                        <div class="form-group">
                            <label for="notify">Notifications</label>
                            <input type="text" name="notify" class="form-control" value="<?= isset($_POST['notify']) ? htmlspecialchars($_POST['notify']) : '' ?>" placeholder="Get notifications by email: 1 / 0 (yes or no)" id="notify">
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
</div>
<link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script>$(document).ready(function() { $('#admin-user').DataTable(); });</script>

<script>



<?php if (isset($_GET['edit'])) { ?>
        $(document).ready(function () {
            $("#add_edit_users").modal('show');
        });
<?php } ?>
</script>