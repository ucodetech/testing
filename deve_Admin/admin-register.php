<?php
require_once '../core/init.php';
require APPROOT . '/includes/headpanel.php';

?>

    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <form class="md-float-material form-material" id="addAdminForm" action="#" method="post">
                        <div class="text-center">
                            <img src="../img/chaps.jpeg" alt="chapel logo" class="img-fluid img-80 chapelLogo">

                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Add Admin</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="fullname" id="fullname" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Full Name</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="tel" name="sudo_phoneNo" id="sudo_phoneNo" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Phone No</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="sudo_email" id="sudo_email" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Email Address</label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-primary">
                                            <input type="password" name="password" id="password" class="form-control" required="">
                                            <span class="form-bar"></span>
                                            <label class="float-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-primary">
                                            <input type="password" name="confirm-password" id="confirm-password" class="form-control" required="">
                                            <span class="form-bar"></span>
                                            <label class="float-label">Confirm Password</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <?php
                                            $permission = '';
                                            $chaplain = 'chaplain';
                                            $superuser = 'chaplain,editor,superuser';
                                            $editor = 'editor';

                                        ?>
                                        <div class="form-group form-primary">
                                            <select name="permission" id="permission" class="form-control">
                                                <option value=""<?=(($permission == ''))?' selected':'';?>>Select Permission</option>
                                                <option value="<?=$chaplain?>"<?=(($permission == $chaplain))?' selected':'';?>>Chaplain</option>
                                                <option value="<?=$editor?>"<?=(($permission == $editor))?' selected':'';?>>Editor</option>
                                                <option value="<?=$superuser?>"<?=(($permission == $superuser))?' selected':'';?>>Superuser</option>
                                            </select>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" id="addAdminBtn">Add Admin</button>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="text-inverse text-left m-b-0" id="showError"></p>

                                    </div>
                                    <div class="col-md-2">
                                        <img src="../img/chap.png" alt="small-logo.png" class="img-50">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>


<?php
require APPROOT . '/includes/footerpanel.php';
?>

<script>
    $(document).ready(function(){

        // process register
        $('#addAdminBtn').click(function (e){
            e.preventDefault();
           $.ajax({
               url:'script/register-process.php',
               method:'post',
               data:$('#addAdminForm').serialize()+'&action=addAdmin',
               success:function (response){
                   if ($.trim(response)==='success'){
                       $('#showError').html('<span class="text-success"><img src="../gif/tra.gif" alt="loader">&nbsp;Success:&nbsp;Redirecting...</span>');
                    setTimeout(function(){
                        window.location = 'admin-dashboard';
                    },5000);
                   }else{
                       $('#showError').html(response);
                   }
               }
           })
        });
    })
</script>