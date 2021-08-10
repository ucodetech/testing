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
    $getDetail = $counsel->getDetail('screeningForm',$detail);
    if ($getDetail){
        ?>
<!--  main page here-->
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
                                <h5>Screening Form </h5>
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
                                    (<span class="text-uppercase text-center">Interdenominational</span>)
                                    <h3>THE FEDERAL POLYTECHNIC, IDAH</h3>
                                    <h6>_______NEW STUDENTS' EXCO ELECTION_______</h6>
                                    <hr class="invisible">
                                    <h3 class="text-primary">_____SCREENING  FORM. <span class="float-right text-uppercase">Date: <u><?=pretty_dates($getDetail->dateApplied);?></u></span></h3>
                                </div>
                                <hr class="invisible">
                                <div class="col-lg-12">
                                    <form action="#" id="screeningFormUpdate" method="post" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-4">
                                                <label for="surname">Surname: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="surname" id="surname" class="form-control" value="<?=$getDetail->surname?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="othernames">Other names: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="othernames" id="othernames" class="form-control" value="<?=$getDetail->othernames?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="phoneNo">Phone No <sup class="text-danger">*</sup>:</label>
                                                <input type="text" name="phoneNo" id="phoneNo" class="form-control"  value="<?=$getDetail->phoneNo?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-6">
                                                <label for="dob">Date of Birth: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="dob" id="dob" class="form-control" value="<?=$getDetail->dateOfBirth?>">
                                            </div>
                                            <div class="form-group col-lg-6 mb-4">
                                                <label for="maritalStatus">Marital Status: <sup class="text-danger">*</sup></label>
                                                <select name="maritalStatus" id="maritalStatus" class="form-control">
                                                    <option value="">Select status</option>
                                                    <?php
                                                    $marital = array('single','married');
                                                    foreach ($marital as $status){
                                                        ?>
                                                        <option value="<?=$status?>" <?=(($status == $getDetail->maritalStatus))?' selected' : ''?>><?=$status?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
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
                                                <label for="cgpa">CGPA <sup class="text-danger">*</sup>:</label>
                                                <input type="text" name="cgpa" id="cgpa" class="form-control" value="<?=$getDetail->cgpa;?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-4 mb-4">
                                                <label for="bornAgain">Born Again: <sup class="text-danger">*</sup></label>
                                                <select name="bornAgain" id="bornAgain" class="form-control">
                                                    <option value="">Select your decision</option>
                                                    <?php
                                                    $decision = array('yes','no');
                                                    foreach ($decision as $decisioned){
                                                        ?>
                                                        <option value="<?=$decisioned?>"<?=(($decisioned == $getDetail->bornAgain))?' selected':''?>><?=strtoupper($decisioned)?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4 mb-4">
                                                <label for="bornAgainDate">If yes Date:</label>
                                                <input type="date" name="bornAgainDate" id="bornAgainDate" class="form-control" value="<?=$getDetail->dateBornAgain;?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="howItHappened">How did it happen: </label>
                                                <textarea name="howItHappened" id="howItHappened" cols="50" rows="5" class="form-control"><?=$getDetail->howItHappened;?></textarea>

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-4">
                                                <label for="homeChurch">Your Home Church: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="homeChurch" id="homeChurch" class="form-control" value="<?=$getDetail->yourHomeChurch;?>">
                                            </div>
                                            <div class="form-group col-lg-4 mb-4">
                                                <label for="christianLeadership">Do you have any Christian Leadership Experience: <sup class="text-danger">*</sup></label>
                                                <select name="christianLeadership" id="christianLeadership" class="form-control">
                                                    <option value="">Select your decision</option>
                                                    <?php
                                                    $leadership = array('yes','no');
                                                    foreach ($leadership as $leader){
                                                        ?>
                                                        <option value="<?=$leader?>"<?=(($leader == $getDetail->christianLeadership))?' selected': ''?>><?=strtoupper($leader)?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="whereDid">If yes Where?:</label>
                                                <input type="text" name="whereDid" id="whereDid" class="form-control" value="<?=$getDetail->whereDidYou?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group col-lg-4">
                                                <label for="positionHeld">Position(S) held with date: <sup class="text-danger">*</sup></label>
                                                <input type="text" name="positionHeld" id="positionHeld"  class="form-control" value="<?=$getDetail->positonHeld?>">

                                            </div>
                                            <div class="form-group col-lg-4 mb-4">
                                                <label for="spiritualGift">Have you discovered your spiritual gift(s): <sup class="text-danger">*</sup></label>
                                                <select name="spiritualGift" id="spiritualGift" class="form-control">
                                                    <option value="">Select your decision</option>
                                                    <?php
                                                    $gift = array('yes','no');
                                                    foreach ($gift as $gifts){
                                                        ?>
                                                        <option value="<?=$gifts?>"<?=(($gifts == $getDetail->discoveredGift))?' selected':''?>><?=strtoupper($gifts)?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="brieflyDesribe">If yes briefly describe:</label>
                                                <input type="text" name="brieflyDesribe" id="brieflyDesribe" class="form-control" value="<?=$getDetail->describeBriefly;?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">

                                                <label for="signatureFile">
                                                    Signature: <br>
                                                    <div class="imgDivs" id="showFileSignature">
                                                        <img src="../../../chapel_Members/profile/<?=$getDetail->signature;?>" class="img-fluid signature" alt="signature">
                                                    </div>
                                                    <input type="hidden" name="signature" id="signature" value="<?=$getDetail->signature;?>">
                                                </label>
                                            </div>
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4 float-right">
                                                Date: <br>
                                                <span class="text-underline">
                                                    <?=pretty_dates($getDetail->signatureDate);?>
                                                </span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="spacer"></div>
                                        <h4 class="text-center text-underline">FOR OFFICE USE ONLY</h4>
                                       <div class="row mb-3">
                                           <div class="form-group col-lg-12">
                                               <label for="howItHappened">Electoral Committee Chairman's Comment: </label>
                                               <textarea name="electoralCommitteComment" id="electoralCommitteComment" cols="50" rows="5" class="form-control"><?=$getDetail->electoralCommitteComment;?></textarea>

                                           </div>
                                           <div class="form-group col-lg-12">
                                               <label for="chaplainComment">Chaplain's Comment: </label>
                                               <textarea name="chaplainComment" id="chaplainComment" cols="50" rows="5" class="form-control"><?=$getDetail->chaplainComment;?></textarea>

                                           </div>
                                       </div>
                                        <hr class="invisible">
                                        <div class="row mb-3">
                                            <input type="hidden" name="screenid" id="screenid" value="<?=$detail;?>">
                                            <div class="form-group col-md-6">
                                                <button type="button" class="btn btn-outline-primary" id="updateScreenFormBtn"><i class="fa fa-edit fa-lg"></i>Update Form</button>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <button type="submit" class="btn btn-outline-dark" id="printBtn"><i class="fa fa-print fa-lg"></i>Print Form</button>
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


        $('#updateScreenFormBtn').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: '../../script/screening-process.php',
                method: 'post',
                data: $('#screeningFormUpdate').serialize()+'&action=updateScreen',
                success: function (response) {
                    if ($.trim(response) === 'success') {
                        Swal.fire({
                            title: 'Screening Records Updated Successfully!',
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