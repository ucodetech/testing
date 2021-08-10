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
                        <h5>Election Screening</h5>
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
                            <div class="table-responsive shadow-lg" id="screening"></div>

                        </div>
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
            <div id="styleSelector"> </div>
        </div>
    </div>
<!--    exco selection modal-->

    <!-- Modal -->
    <div class="modal fade" id="makeExcoModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update as Student Exco</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" enctype="multipart/form-data" id="makeExcoForm">
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="form-group">
                            <label for="fullName">Full Name: <sup class="text-danger">*</sup></label>
                            <input type="disabled" name="fullName" id="fullName" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="office">Office: <sup class="text-danger">*</sup></label>
                            <input type="text" name="office" id="office" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="schoolSession">Session: <sup class="text-danger">*</sup></label>
                            <select type="text" name="schoolSession" id="schoolSession" class="form-control">
                                <option value="">Select Academic Session</option>
                                <?
                                    $sessions = array(
                                       '2018/2019',
                                        '2019/2020',
                                        '2020/2021',
                                        '2021/2022',
                                        '2022/2023',
                                        '2023/2024',
                                        '2024/2025'

                                    );
                                    foreach ($sessions as $academic){
                                          ?>
                                        <option value="<?=$academic?>"><?=$academic?></option>
                                <?
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-outline-primary" id="makeExcoBtn">Make Exco</button>
                            <br>
                            <span id="showError2"></span>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!--end of exco selection modal-->
    <?php
    require APPROOT . '/includes/footerpanel.php';
    ?>
    <script>
        $(document).ready(function (){

            //fetch admins
            fetch_screening();
            function fetch_screening(){
                action = 'fetchScreening';
                $.ajax({
                    url:'script/screening-process.php',
                    method:'post',
                    data:{action:action},
                    success:function (response){
                        $('#screening').html(response);
                        $('#showscreening').DataTable({
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
                    url:'script/screening-process.php',
                    method:'post',
                    data:{action:action},
                    success:function(response){
                        $('#showHide').html(response);
                    }
                });
            }


            $('body').on('click','.activateScreenForm',function(e){
                e.preventDefault();
                action = 'activateBtn';
                $.ajax({
                    url:'script/screening-process.php',
                    method:'post',
                    data:{action:action},
                    success:function(response){
                        showHideForm();
                    }
                })


            });

            $('body').on('click','.deactivateScreenForm',function(e){
                e.preventDefault();
                action = 'deactivateBtn';
                $.ajax({
                    url:'script/screening-process.php',
                    method:'post',
                    data:{action:action},
                    success:function(response){
                        showHideForm();
                    }
                })



            });


            $('body').on('click','.showMakeExco',function(e){
                e.preventDefault();
                exco_id = $(this).attr('id');
                $.ajax({
                    url:'script/screening-process.php',
                    method:'post',
                    data:{exco_id:exco_id},
                    success:function(response){
                        data = JSON.parse(response);
                        $('#user_id').val(data.user_id);
                        $('#fullName').val(data.surname+' '+data.othernames);
                    }
                });

            });

            $('#makeExcoBtn').click(function(e){
                e.preventDefault();
                $.ajax({
                    url:'script/screening-process.php',
                    method:'post',
                    data:$('#makeExcoForm').serialize()+'&action=makeExcoNow',
                    success:function(response){
                        if (response === 'success'){
                            swal.fire({
                                icon:'success',
                                title:'Done',
                                text:'Member Approved as an Exco!'

                            });
                            $('#makeExcoForm')[0].reset();
                            $('#makeExcoModal').modal('hide');
                        }else{
                            $('#showError2').html(response);
                        }
                    }
                })
            })

        })
    </script>