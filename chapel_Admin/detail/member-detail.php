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
    $getDetail = $general->getMemberDetail($detail);
        if ($getDetail){
            ?>


<style>
input[type="text"],input[type="email"],input[type="tel"],input[type="date"]{
    border:none;
    background: none;
    border-bottom:3px dotted #000;
    font-size: 1.2rem;
}
input[type="text"]:hover,input[type="email"]:hover,input[type="tel"]:hover,input[type="date"]:hover{
    border:none;
    background: none;
    border-bottom:3px dotted #000;

}
input[type="text"]:active,input[type="email"]:active,input[type="tel"]:active,input[type="date"]:active{
    border:none;
    background: none;
    border-bottom:3px dotted #000;

}
input[type="text"]:focus,input[type="email"]:focus,input[type="tel"]:focus,input[type="date"]:focus{
    border:none;
    background: none;
    border-bottom:3px dotted #000;

}
.form-control[readonly]{
    background: none;
}

textarea{
    border:none;
    background: none;
    border:3px dotted #000;
}
select{
    border:none;
    background: none;
    border-bottom:3px dotted #000;
}
label{
    font-size: 1.2rem;
    color:#00ACED;

}
.passport{
    width:150px;
    height:160px;
    border:2px solid #000;
}
.signature{
    width:80px;
    height:50px;
}
.fa-cloud-upload{
    font-size:2.5rem;
    cursor: pointer;
}
.imgDiv,  .imgDivs{
    cursor:pointer;
}
.btn{
    border-radius:20px;
</style>
    <div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-body start -->
            <div class="page-body p-5">
                <div class="card">
                    <div class="card-header">
                        <h5><?=$getDetail->full_name;?> Membership Registration Form</h5>
                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                    </div>
                    <div class="card-block">
                        <form action="#" id="profileUpdateForm" method="post"  enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <a href="<?=URLROOT?>">
                                        <img class="img-fluid img-120" src="<?=URLROOT?>img/chap.png" alt="All Saints Chapel" style="border-radius: 50%; border: 2px solid #00E466; "/>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <div id="showError" class="text-primary text-center" style="font-size: 1.2rem;">
                                        <h2>All Saints Chapel Federal Polytechnic Idah</h2>
                                        <h4 class="text-center">Membership Form</h4>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <label for="profileFile">
                                        <div class="imgDiv" id="showFile">
                                            <img src="<?=URLROOT?>chapel_Members/profile/<?=$getDetail->passport;?>" class="img-fluid passport" alt="passport">
                                        </div>
                                    </label><br>
                                    <?php if($getDetail->passport == 'default.png'):?>
                                        <input type="file" name="profileFile" id="profileFile" style="display: none;">
                                        <!--                                                    <hr class="invisible">-->
                                        <label for="profileFile"><i class="fa fa-cloud-upload fa-lg text-info"></i> &nbsp;Select File</label>
                                        &nbsp;<br><button type="submit" class="btn btn-sm btn-info" id="updateProfile">Update</button>
                                    <?php endif;?>
                                </div>
                            </div>
                            <hr>
                        </form>
                        <form class="form" id="formUpdate" action="#" method="post">

                            <div class="form-group row">
                                <div class="col-sm-9">
                                    <label class="float-label">Full Name</label>
                                    <input type="text" class="form-control" name="fullName" id="fullName" value="<?=$getDetail->full_name;?>" readonly>
                                </div>
                                <div class="col-sm-3">
                                    <label class="float-label">Gender</label>
                                    <input type="text" class="form-control"  name="gender" id="gender" value="<?=$getDetail->Gender;?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label class="float-label">Marital Status</label><br>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Marital Status</option>
                                        <?php
                                        $required = array('single','in_courtship','married','divorced' );
                                        ?>
                                        <?php foreach($required as $status): ?>
                                            <option value="<?=$status?>"<?=(($status == $getDetail->marital_status))?' selected':''?>><?=strtoupper($status)?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label class="float-label">Phone No</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile" value="<?=$getDetail->mobile;?>" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <label class="float-label">E-Mail</label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?=$getDetail->email;?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label class="float-label">Department(if FPI Staff/Student)</label>
                                    <input type="text" class="form-control" name="department" id="department" value="<?=$getDetail->department;?>" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <label class="float-label">Level</label>
                                    <input type="text" class="form-control"  name="level" id="level" value="<?=$getDetail->level;?>" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <label class="float-label">School</label>
                                    <input type="text" class="form-control"  name="school" id="school" value="<?=$getDetail->school;?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="float-label">Residential Address(Hostel/Lodge for student)</label>
                                    <input type="text" name="address" id="address"  class="form-control" value="<?=$getDetail->Residence;?>"/>
                                </div>
                                <div class="col-sm-6">
                                    <label class="float-label">Permanent Home Address</label>
                                    <input type="text" name="p_address" id="p_address"  class="form-control" value="<?=$getDetail->Residence;?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="float-label">State of Origin</label>
                                    <select name="state" id="state" class="form-control">
                                        <?php
                                        $getState = $general->getState();
                                        ?>
                                        <option value="">Select State of Origin</option>

                                        <?php foreach($getState as $state): ?>
                                            <option value="<?=$state->state?>" <?=(($state->state == $getDetail->state))?' selected':''?>><?=strtoupper($state->state)?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="float-label">LGA</label>
                                    <select name="lga" id="lga" class="form-control">
                                        <?php
                                        $getLga = $general->getLGA();
                                        ?>
                                        <option value="">Select State of Origin</option>

                                        <?php foreach($getLga as $lga): ?>
                                            <option value="<?=$lga->lga?>" <?=(($lga->lga == $getDetail->lga))?' selected':''?>><?=strtoupper($lga->lga)?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label class="float-label">Date of Birth</label>
                                    <input type="text" class="form-control" name="birthday" id="birthday" value="<?=$getDetail->Birthday;?>" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <label class="float-label">Date of New Birth</label>
                                    <input type="date" class="form-control" name="dateOfNewBirth" id="dateOfNewBirth" value="<?=$getDetail->date_new_birth;?>">
                                </div>
                                <div class="col-sm-4">
                                    <label class="float-label">Date of Water Baptism</label>
                                    <input type="date" class="form-control" name="dateOfBaptism" id="dateOfBaptism" value="<?=$getDetail->dateOfBaptism;?>">
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label class="float-label">Have you experience the Baptism of Holy Spirit</label><br>
                                    <select name="baptism_holy" id="baptism_holy" class="form-control">
                                        <option value="">Select one of the option</option>
                                        <?php
                                        $hp = array('yes','no');
                                        ?>
                                        <?php foreach($hp as $answer): ?>
                                            <option value="<?=$answer?>" <?=(($answer == $getDetail->baptism_holy))?' selected':''?>><?=strtoupper($answer)?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                                <div class="col-sm-4">
                                    <label class="float-label">Spiritual Gift</label>
                                    <select name="spiritual_gift" id="spiritual_gift" class="form-control">
                                        <option value="">Select</option>
                                        <?php
                                        $gift = array(
                                            'prophecy',
                                            'service',
                                            'teaching',
                                            'exhorting',
                                            'giving',
                                            'leadership',
                                            'mercy/helps',
                                            'word of wisdom',
                                            'word of knowledge',
                                            'discerning of spirits',
                                            'gift of faith',
                                            'gifts of healing',
                                            'working of miracles',
                                            'kinds of tongues',
                                            'interpretation of tongues'
                                        );
                                        ?>
                                        <?php foreach($gift as $thick): ?>
                                            <option value="<?=$thick?>" <?=(($thick == $getDetail->spiritual_gift))?' selected':''?>><?=strtoupper($thick)?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label class="float-label">Home Church Denomination</label>
                                    <input type="text" class="form-control" name="homeChurch" id="homeChurch" value="<?=$getDetail->home_church;?>" readonly>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label class="float-label">Position Held in your Church</label>
                                    <input type="text" class="form-control" name="position" id="position" value="<?=$getDetail->position;?>">
                                </div>
                                <div class="col-sm-12">
                                    <div class="row m-t-25 text-left">
                                        <label class="float-label text-lg ml-5">Unit</label>

                                        <?php
                                    $units = explode(',', $getDetail->ChapelUnit);
                                        foreach ($units as $memberUnit){
                                            ?>
                                                <div class="col-12">
                                                    <div class="checkbox-fade fade-in-primary d-">
                                                        <label>
                                                            <input type="checkbox">
                                                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                            <span class="text-inverse"><?=strtoupper($memberUnit)?></span>
                                                        </label>
                                                    </div>

                                                </div>
                                            <?
                                        }
                                    ?>
                                </div>
                                </div>

                            </div>

                        </form>
                        <hr class="invisible">
                        <!--    update signature-->
                        <form action="" id="signatureUpdateForm" method="post"  enctype="multipart/form-data">
                            <div class="form-group row">

                                <div class="col-sm-3 text-center">
                                    <label for="signatureFile">
                                        <div class="imgDivs" id="showFileSignature">
                                            <img src="<?=URLROOT?>chapel_Members/profile/<?=$getDetail->memberSignature;?>" class="img-fluid signature" alt="signature">
                                        </div>
                                    </label>
                                    <?php if($getDetail->memberSignature == 'defaultSign.png'):?>
                                        <input type="file" name="signatureFile" id="signatureFile" style="display: none;">
                                        <!--<hr class="invisible">-->
                                        <label for="updateSignature"><i class="fa fa-cloud-upload fa-lg text-info"></i> &nbsp;Select Signature</label>
                                        &nbsp;<br><button type="submit" class="btn btn-sm btn-info rounded-10" id="updateSignature">Update</button>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <span class="text-dark">Date:&nbsp;<?=pretty_dates($getDetail->signatureDate);?></span>
                                </div>

                            </div>
                            <hr>
                        </form>
                        <hr class="invisible">
                        <div id="showError2"></div>
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