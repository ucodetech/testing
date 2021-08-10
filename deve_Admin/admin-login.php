<?php
require_once '../core/init.php';
    if(isIsLoggedIn()){
        Redirect::to('admin-dashboard');
    }
require APPROOT . '/includes/headpanel.php';

?>

<section class="login-block">
    <!-- Container-fluid starts -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Authentication card start -->

                <form class="md-float-material form-material" id="loginForm" action="#" method="post">
                    <div class="text-center">
                        <img src="../img/chaps.jpeg" alt="chapel logo" class="img-fluid img-80 chapelLogo">
                    </div>
                    <div class="auth-box card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-center">Admin Login</h3>
                                </div>
                            </div>
                            <div class="form-group form-primary">
                                <input type="text" name="username" id="username" class="form-control" required="">
                                <span class="form-bar"></span>
                                <label class="float-label">Your Username</label>
                            </div>
                            <div class="form-group form-primary">
                                <input type="password" name="password" id="password" class="form-control" required="">
                                <span class="form-bar"></span>
                                <label class="float-label">Password</label>
                            </div>
                            <div class="row m-t-25 text-left">
                                <div class="col-12">
                                    <div class="checkbox-fade fade-in-primary d-">
                                        <label>
                                            <input type="checkbox" value="">
                                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                            <span class="text-inverse">Remember me</span>
                                        </label>
                                    </div>
                                    <div class="forgot-phone text-right f-right">
                                        <a href="#" class="text-right f-w-600"> Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="button" id="loginBtn" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
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
                <!-- end of form -->
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
        $('#loginBtn').click(function (e){
            e.preventDefault();
            $.ajax({
                url:'script/login-process.php',
                method:'post',
                data:$('#loginForm').serialize()+'&action=login',
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
