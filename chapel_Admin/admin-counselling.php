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
                <!--open or close form-->
                <hr class="invisible">
                <div class="card">
                    <div class="card-header">
                        <h5>Counselling A1</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                <li><i class="fa fa-window-maximize full-card"></i></li>
                                <li><i class="fa fa-minus minimize-card"></i></li>
                                <li><i class="fa fa-refresh reload-card"></i></li>
                                <li><i class="fa fa-trash close-card"></i></li>
                            </ul>
                        </div>
                        <hr>
                        <div id="showHide" class="text-dark">

                        </div>

                    <div class="card-block">
                        <div class="table-responsive shadow-lg" id="counselling"></div>

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
        fetch_Counselling();
        function fetch_Counselling(){
            action = 'fetchCounselling';
            $.ajax({
                url:'script/counselling-process.php',
                method:'post',
                data:{action:action},
                success:function (response){
                    $('#counselling').html(response);
                    $('#showCounselling').DataTable({
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

        showHideForm();

        function showHideForm(){
            action = 'CheckTrigger';
            $.ajax({
                url:'script/counselling-process.php',
                method:'post',
                data:{action:action},
                success:function(response){
                    $('#showHide').html(response);
                }
            });
        }


        $('body').on('click','.activateCounselFrom',function(e){
            e.preventDefault();
            action = 'activateBtn';
           $.ajax({
               url:'script/counselling-process.php',
               method:'post',
               data:{action:action},
               success:function(response){
                   showHideForm();
               }
           })


        });

        $('body').on('click','.deactivateCounselFrom',function(e){
            e.preventDefault();
            action = 'deactivateBtn';
            $.ajax({
                url:'script/counselling-process.php',
                method:'post',
                data:{action:action},
                success:function(response){
                    showHideForm();
                }
            })



        });


    })
</script>