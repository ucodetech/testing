<?php
require_once '../../core/init.php';
if (!isIsLoggedIn()){
    Session::flash('warning', 'You need to login to access that page!');
    Redirect::to('../../admin-login');
}
$admin = new Admin();
$adminEmail = $admin->getAdminEmail();


// if (isOTPset($adminEmail)) {
//   Redirect::to('otp-verify');
// }

require APPROOT . '/includes/headpanel.php';
require APPROOT . '/includes/navpanel.php';
$general = new General();
$show = new Show();

if (isset($_GET['detail']) && !empty($_GET['detail'])){
    $detail = $_GET['detail'];
    $getDetail = $general->getVisitorDetail($detail);
    if ($getDetail){
        ?>


<style>
    input[type='text'],input[type='email'],input[type='tel'],input[type='date']{
        border: 0;
        background:none;
        border-radius:0;
        border-bottom: 2px solid rgba(97,26,26,0.7);
    }
    input[type='text']:hover,input[type='email']:hover,input[type='tel']:hover,input[type='date']:hover{
        border: 0;
        background:none;
        border-radius:0;
        border-bottom: 2px solid rgba(97,26,26,0.7);
    }
    input[type='text']:focus,input[type='email']:focus,input[type='tel']:focus,input[type='date']:focus{
        border: 0;
        background:none;
        border-radius:0;
        border-bottom: 2px solid rgba(97,26,26,0.7);
    }
    input[type='text']:active,input[type='email']:active,input[type='tel']:active,input[type='date']:active{
        border: 0;
        background:none;
        border-radius:0;
        border-bottom: 2px solid rgba(97,26,26,0.7);
    }
    label{
        font-size: 1.2rem;
        color:#00ACED;

    }

    .signature{
        width:80px;
        height:50px;
    }
    .fa-cloud-upload{
        font-size:2.5rem;
        cursor: pointer;
    }
    .imgDivs{
        cursor:pointer;
    }
    .btn {
        border-radius: 20px;
    }
        </style>
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body p-5">
                        <div class="card">
                            <div class="card-header">
                                <h5><?=$getDetail->full_name;?> Detail</h5>
                                <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                            </div>
                            <div class="card-block">

                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <a href="<?=URLROOT?>">
                                                <img class="img-fluid img-120" src="<?=URLROOT?>img/chap.png" alt="All Saints Chapel" style="border-radius: 50%; border: 2px solid #00E466; "/>
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="showError" class="text-primary text-center" style="font-size: 1.2rem;">
                                                <h2>All Saints Chapel Federal Polytechnic Idah</h2>
                                                <h6 class="text-center">(Interdenominational)</h6>
                                                <h4 class="text-center">Visitor's Slip</h4>
                                            </div>
                                        </div>

                                    </div>
                                    <hr>

                                <form action="" method="post" id="visitorForm" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <div class="form-group col-sm-8">
                                            <label for="fullname">
                                                Full Name: <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="text" name="fullname" id="fullname" class="form-control" value="<?=$getDetail->full_name;?>">

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="gender">
                                                Gender: <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="text" name="gender" id="gender" class="form-control" value="<?=$getDetail->gender;?>">

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-sm-4">
                                            <label for="department">
                                                Department:
                                            </label>
                                            <input type="text" name="department" id="department" class="form-control" value="<?=$getDetail->department;?>">

                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="level">
                                                Level:
                                            </label>
                                            <input type="text" name="level" id="level" class="form-control" value="<?=$getDetail->level;?>">

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="gender">
                                                E-mail:
                                            </label>
                                            <input type="text" name="email" id="email" class="form-control" value="<?=$getDetail->email;?>">

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-sm-12">
                                            <label for="fullname">
                                                Residential Address: <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="text" name="address" id="address" class="form-control" value="<?=$getDetail->address;?>">

                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="comment">
                                                General Comments about the Service: <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="text" name="comment" id="comment" class="form-control" value="<?=$getDetail->general_comments;?>">

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-md-12">
                                            <label for="phoneNo">
                                                Phone No: <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="tel" name="phoneNo" id="phoneNo" class="form-control" value="<?=$getDetail->phoneNo;?>">

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-md-4">
                                            <label for="invited_by">
                                                Who invited you to the service:
                                            </label>
                                            <input type="text" name="invited_by" id="invited_by" class="form-control" value="<?=$getDetail->invited_by;?>">

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="prayerRequest">
                                                Prayer Request:
                                            </label>
                                            <input type="text" name="prayerRequest" id="prayerRequest" class="form-control" value="<?=$getDetail->prayer_request;?>">

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="become_member">
                                                Would you like to be a member:
                                            </label>
                                            <input type="text" name="become_member" id="become_member" class="form-control" value="<?=$getDetail->become_member;?>">

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-md-6">

                                            <img src="../../../uploads/signatures/<?=$getDetail->signature?>" alt="signature" class="img-fluid" width="105 ">
                                        </div>
                                        <div class="form-group col-smd-6">
                                            Date: <span><u><?=pretty_dates($getDetail->signatureDate);?></u></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div id="showError"></div>
                                    </div>
                                </form>

                                <hr class="invisible">
                                <!--    update signature-->
                               
                            </div>
                        </div>
                    </div>
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
            </div>
        </div>

        <?php
    }
}
?>

<?php
require APPROOT . '/includes/footerpanel.php';
?>
<script>
    $(document).ready(function () {


        $('#updateMemberBtn').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: '../../script/request-process.php',
                method: 'post',
                data: $('#memberDetailForm').serialize()+'&action=updateMember',
                success: function (response) {
                    console.log(response);
                    if ($.trim(response) === 'success') {
                        Swal.fire({
                            title: 'Member Records Updated Successfully!',
                            type: 'success'
                        });
                        setTimeout(function (){
                            location.reload();
                        },2000);
                    } else {
                        $('#updateError').html(response);
                    }
                }
            })
        })


    });
</script>