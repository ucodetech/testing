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
                        <h5>Feedbacks</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                <li><i class="fa fa-window-maximize full-card"></i></li>
                                <li><i class="fa fa-minus minimize-card"></i></li>
                                <li><i class="fa fa-refresh reload-card"></i></li>
                                <li><i class="fa fa-trash close-card"></i></li>
                            </ul>
                        </div>


                        <div class="card-block">
                            <div class="table-responsive shadow-lg" id="showAlFeed"></div>

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


            fetchFeedback();
            function fetchFeedback(){
                $.ajax({
                    url: 'script/inits.php',
                    method: 'post',
                    data: {action: 'fetchAllFeed'},
                    success:function(response){
                        console.log(response);
                        $('#showAlFeed').html(response);
                        $('#showFeed').DataTable({
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": true,
                            "responsive": false,
                            "lengthMenu": [[5,10, 25, 50, -1], [10, 25, 50, "All"]]
                        });

                    }

                });
            }

//Display user in details ajax request
            $("body").on("click", ".userDetailsIcon", function(e){
                e.preventDefault();

                details_id = $(this).attr('id');
                $.ajax({
                    url: 'script/inits.php',
                    method: 'post',
                    data: {details_id: details_id},
                    success:function(response){
                        $('#others').html(response);
                    }
                });
            });

//Delete users

            $("body").on("click", ".feedBackdeleteBtn", function(e){
                e.preventDefault();
                delfed_id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You can revert this action",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: 'script/inits.php',
                            method: 'POST',
                            data: {delfed_id: delfed_id},
                            success:function(response){
                                Swal.fire(
                                    'Feedback  Deleted!',
                                    'Feedback Deleted Successfully!',
                                    'success'
                                )
                                fetchFeedback();
                            }
                        });

                    }
                });

            });




//Display user in details ajax request
            $("body").on("click", ".feedBackinfoBtn", function(e){
                e.preventDefault();

                feeddetails_id = $(this).attr('id');
                $.ajax({
                    url: 'script/inits.php',
                    method: 'post',
                    data: {feeddetails_id: feeddetails_id},
                    success:function(response){
                        $('#feedBack').html(response);
                    }
                });
            });

//GEt current selected user id and feedback id
            var userid;
            var feedid;
            $('body').on('click', '.replyFeedbackIcon', function(e){
                $('#showFeedDetailsModal').modal('hide');
                userid = $(this).attr('id');
                feedid = $(this).attr('fid');
            });
            //SEnd feedback reply to the user ajax request
            $('#replyBtn').click(function(e){
                if($('#reply-feedback-form')[0].checkValidity()){
                    let message = $("#message").val();
                    e.preventDefault();
                    $("#replyBtn").val('Please wait...');
                    $.ajax({
                        url: 'script/inits.php',
                        method: 'post',
                        data: {userid: userid, message : message, feedid : feedid},
                        success:function(response){
                            $("#replyBtn").val('Send Reply');
                            $('#replyModal').modal('hide');
                            $('#reply-feedback-form')[0].reset();
                            Swal.fire(
                                'Sent!',
                                'Reply Sent Successfully to the user!',
                                'success'
                            )
                            fetchFeedback();
                        }
                    })
                }
            })



        })
    </script>