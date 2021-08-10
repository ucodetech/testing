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
$counsel = new Counsel();
$show = new Show();

if (isset($_GET['detail']) && !empty($_GET['detail'])){
    $detail = $_GET['detail'];
    $getDetail = $counsel->getDetail('counsellingForm',$detail);
    if ($getDetail){
        ?>

        <style>
            input[type='text'],input[type='tel'],input[type='email'],input[type='date']{
                border: none;
                border-bottom: 2px dotted #000;
                background:none;
            }
            input[type='text']:hover,input[type='tel']:hover,input[type='email']:hover,input[type='date']:hover{
                border: none;
                border-bottom: 2px dotted #000;
                background:none;
            }
            input[type='text']:active,input[type='tel']:active,input[type='email']:active,input[type='date']:active{
                border: none;
                border-bottom: 2px dotted #2bd225;
                background:none;
            }
            input[type='text']:focus ,input[type='tel']:focus,input[type='email']:focus,input[type='date']:focus{
                border: none;
                border-bottom: 2px dotted #000;
                background:none;
            }
            textarea{
                border: none;
                border-bottom: 2px dotted #000;
                background:none;
            }
            .signature{
                width:120px;
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
            }
            .form-control[text],.form-control{
                border: none;
                border-bottom: 2px dotted #000;
                background:none;
            }
        </style>
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <div class="card">
                            <div class="card-header">
                                <h5>Counselling Form A1</h5>
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
                                <div class="col-lg-12 text-center">
                                    <h2>ALL SAINTS CHAPEL</h2>
                                    <h3>THE FEDERAL POLYTECHNIC, IDAH</h3>
                                    <h6>Tel: 08050351078, 081351331</h6>
                                    <hr class="invisible">
                                    <h3 class="text-underline">COUNSELLING FORM A1</h3>
                                    (<span class="text-underline">To be completed by the decision maker</span>)
                                </div>
                                <hr class="invisible">
                                <div class="col-lg-12">
                                    <form action="#" id="counsellingFormUpdate" method="post" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-6">
                                                <label for="surname">Surname: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="surname" id="surname" class="form-control" value="<?=$getDetail->surname?>">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="othernames">Other names: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="othernames" id="othernames" class="form-control" value="<?=$getDetail->othernames?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-6 mb-4 mt-4">
                                                <label for="sex">Sex: <sup class="text-danger">*</sup></label>
                                                <select name="sex" id="sex" class="form-control">
                                                    <option value="">Select gender</option>
                                                    <?php
                                                    $sex = array('male','female');
                                                    foreach ($sex as $gender){
                                                        ?>
                                                        <option value="<?=$gender?>" <?=(($gender == $getDetail->sex))?' selected' : ''?>><?=$gender?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6 mb-4 mt-4">
                                                <label for="age">Age Range: <sup class="text-danger">*</sup></label>
                                                <select name="age" id="age" class="form-control">
                                                    <option value="">Select Age range</option>
                                                    <?php
                                                    $range = array('13-19','20-26','27-33','34-40','above 40');
                                                    foreach ($range as $agerange){
                                                        ?>
                                                        <option value="<?=$agerange?>" <?=(($agerange == $getDetail->age))?' selected':''?>><?=strtoupper($agerange)?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-12">
                                                <label for="address">Address: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="address" id="address" class="form-control" value="<?=$getDetail->address?>">
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-4">
                                                <label for="department">Department:</label>
                                                <input type="text" name="department" id="department" class="form-control" value="<?=$getDetail->department?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="level">Level:</label>
                                                <input type="text" name="level" id="level" class="form-control" value="<?=$getDetail->level?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="phoneNo">Phone No <sup class="text-danger">*</sup>:</label>
                                                <input type="text" name="phoneNo" id="phoneNo" class="form-control"  value="<?=$getDetail->phoneNo?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-12 mb-4 mt-4">
                                                <label for="age">Your Decision: <sup class="text-danger">*</sup></label>
                                                <select name="yourDecision" id="yourDecision" class="form-control">
                                                    <option value="">Select your decision</option>
                                                    <?php
                                                    $decision = array('first decision for Christ','rededication to Christ','other');
                                                    foreach ($decision as $decisioned){
                                                        ?>
                                                        <option value="<?=$decisioned?>"<?=(($decisioned == $getDetail->yourDecison))?' selected':''?>><?=strtoupper($decisioned)?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-12">
                                                <label for="altarCall">Why did you answer Altar Call today? (Briefly describe your problem): <sup class="text-danger">*</sup></label>
                                                <textarea name="altarCall" id="altarCall" cols="50" rows="5" class="form-control"><?=$getDetail->altarCallAnswer?></textarea>

                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-12">
                                                <label for="duration">How long have you lived with this problem?: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="duration" id="duration"  class="form-control" value="<?=$getDetail->problemDuration;?>">

                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-12">
                                                <label for="solution">What have you done before now to help solve the problem: <sup class="text-danger">*</sup></label>
                                                <textarea name="solution" id="solution" cols="50" rows="5" class="form-control"><?=$getDetail->yourSolution?></textarea>

                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-6">
                                                <label for="followUp">Will you be available for follow up with our Counsellors on this matter?: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="followUp" id="followUp"  class="form-control" value="<?=$getDetail->counsellorsfollowUp?>">

                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="yourTime">If yes, what is the best time to see you?: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="yourTime" id="yourTime"  class="form-control" value="<?=$getDetail->yourTime;?>">

                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">

                                                <label for="signatureFile">
                                                    Signature: <br>
                                                    <div class="imgDivs float-right" id="showFileSignature">
                                                        <img src="../../../chapel_Members/profile/<?=$getDetail->signature;?>" class="img-fluid signature" alt="signature">
                                                    </div>
                                                    <input type="hidden" name="signature" id="signature" value="<?=$getDetail->signature;?>">
                                                </label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <input type="hidden" name="counselId" id="counselId" value="<?=$detail;?>">
                                            <div class="form-group col-md-6">
                                                <button type="button" class="btn btn-outline-success" id="updateCounselFormBtn"><i class="fa fa-edit fa-lg"></i> Update Form</button>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <button type="button" class="btn btn-outline-secondary" id="printForm"><i class="fa fa-print fa-lg"></i> Print Form</button>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div id="showError"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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


        $('#updateCounselFormBtn').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: '../../script/counselling-process.php',
                method: 'post',
                data: $('#counsellingFormUpdate').serialize()+'&action=updateCounsel',
                success: function (response) {
                    if ($.trim(response) === 'success') {
                        Swal.fire({
                            title: 'Counselling Records Updated Successfully!',
                            type: 'success'
                        });
                        setTimeout(function (){
                            location.reload();
                        },4000);
                    } else {
                        $('#showError').html(response);
                    }
                }
            })
        })


    });
</script>