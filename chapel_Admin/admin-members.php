<?php
require_once '../core/init.php';
if (!isIsLoggedIn()){
    Session::flash('warning', 'You need to login to access that page!');
    Redirect::to('admin-login');
}
$admin = new Admin();
$adminEmail = $admin->getAdminEmail();


// if (isOTPset($adminEmail)) {
//   Redirect::to('otp-verify');
// }

require APPROOT . '/includes/headpanel.php';
require APPROOT . '/includes/navpanel.php';

?>
<div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-body start -->
            <div class="page-body">
                <div id="updateError"></div>
                <hr class="invisible">
                <div class="card">
                    <div class="card-header">
                        <h5>Members</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                <li><i class="fa fa-window-maximize full-card"></i></li>
                                <li><i class="fa fa-minus minimize-card"></i></li>
                                <li><i class="fa fa-refresh reload-card"></i></li>
                                <li><i class="fa fa-trash close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive" id="members"></div>
                    </div>

                    </div>
                </div>
            </div>
            <!-- Page-body end -->
        </div>
        <div id="styleSelector"> </div>
    </div>
</div>

<!--modal-->
<div class="modal fade" id="memberDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="memberDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Member Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-5" id="showMemberDetail">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--end of modal-->

<?php
require APPROOT . '/includes/footerpanel.php';
?>
<script>
    $(document).ready(function (){

        //fetch admins
        fetch_newMembers();
        function fetch_newMembers(){
            action = 'fetchNewMembersApproved';
            $.ajax({
                url:'script/request-process.php',
                method:'post',
                data:{action:action},
                success:function (response){
                    $('#members').html(response);
                    $('#ShowMembersApproved').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "order": [0,'desc'],
                        "info": true,
                        "autoWidth": true,
                        "responsive": false,
                        "lengthMenu": [[10,10, 25, 50, -1], [10, 25, 50, "All"]]
                    });
                }
            });
        }
    })
</script>