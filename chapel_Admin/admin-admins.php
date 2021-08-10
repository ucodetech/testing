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
                <div class="card">
                    <div class="card-header">
                        <h5>Chapel Admins and Editors</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                <li><i class="fa fa-window-maximize full-card"></i></li>
                                <li><i class="fa fa-minus minimize-card"></i></li>
                                <li><i class="fa fa-refresh reload-card"></i></li>
                                <li><i class="fa fa-trash close-card"></i></li>
                            </ul>
                        </div>
                        <a href="admin-register" class="btn btn-outline-primary">Add Editor</a>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive" id="showAdmins"></div>

                    </div>
                </div>
            </div>
            <!-- Page-body end -->
        </div>
        <div id="styleSelector"> </div>
    </div>
</div>




<?php
require APPROOT . '/includes/footerpanel.php';
?>
<script>
    $(document).ready(function (){

        //fetch admins
        fetch_admins();
        function fetch_admins(){
            action = 'fetchAdmins';
            $.ajax({
               url:'script/admin-process.php',
               method:'post',
               data:{action:action},
               success:function (response){
                   $('#showAdmins').html(response);
                   $('#showAdmin').DataTable({
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