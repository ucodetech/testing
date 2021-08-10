<?php
require_once '../../core/init.php';

$student = new User();
$show = new Show();
$general = new General();
$db = Database::getInstance();
if (isset($_POST['action']) && $_POST['action'] == 'fetchNewMembers') {
		$member = 	$general->fetchMembers(0);
		if ($member){
		    echo $member;
        }

}

if (isset($_POST['action']) && $_POST['action'] == 'fetchNewMembersApproved') {
    $member = 	$general->fetchMembersApproved();
    if ($member){
        echo $member;
    }

}

if (isset($_POST['approvedid']) && !empty($_POST['approvedid'])){
    $approveid = $_POST['approvedid'];
    $general->approveMember($approveid);


}

if (isset($_POST['detail_id']) && !empty($_POST['detail_id'])){
    $detail_id = $_POST['detail_id'];
    $getDetail = $general->getMemberDetail($detail_id);
    if ($getDetail){
        $output = '';

        $output.='
            <div class="text-center">
               <img src="profile/'.$getDetail->passport.'"  alt="'.$getDetail->full_name.'" width="250px" height="250px" style="border-radius:50%;border:3px double limegreen"> 
            </div><br><hr class="invisible">
          <form class="form-material" action="#" id="memberDetailForm" method="post">
          <input type="hidden" name="memberId" id="memberId" value="'.$getDetail->id.'">
           <div class="row">
            <div class="form-group col-sm-6 form-primary">
                <input type="text" name="fullname" id="fullname" class="form-control" value="'.$getDetail->full_name.'" required="">
                <span class="form-bar"></span>
                <label class="float-label">Fullname</label>
            </div>
            <div class="form-group col-sm-6  form-primary">
                <input type="email" name="email" id="email" class="form-control" value="'.$getDetail->email.'" required="">
                <span class="form-bar"></span>
                <label class="float-label">Email</label>
            </div>
             <div class="form-group col-sm-6  form-primary">
                <input type="text" name="gender" id="gender" class="form-control" value="'.$getDetail->Gender.'" required="">
                <span class="form-bar"></span>
                <label class="float-label">Gender</label>
            </div>
            <div class="form-group col-sm-6  form-primary">
                <input type="text" name="pob" id="pob" class="form-control" value="'.$getDetail->pob.'" required="">
                <span class="form-bar"></span>
                <label class="float-label">Place of Birth</label>
            </div>
            <div class="form-group col-sm-6  form-primary">
                <input type="text" name="birthday" id="birthday" class="form-control" value="'.pretty_dates($getDetail->Birthday).'" required="">
                <span class="form-bar"></span>
                <label class="float-label">Birthday</label>
            </div>
            <div class="form-group col-sm-6  form-primary">
                <input type="text" name="homeChurch" id="homeChurch" class="form-control" value="'.$getDetail->home_church.'" required="">
                <span class="form-bar"></span>
                <label class="float-label">Home church</label>
            </div>
            <div class="form-group col-sm-6  form-primary">
                <input type="tel" name="mobile" id="mobile" class="form-control" value="'.$getDetail->mobile.'" required="">
                <span class="form-bar"></span>
                <label class="float-label">Phone No</label>
            </div>
            <div class="form-group col-sm-6  form-primary">
                <input type="text" name="department" id="department" class="form-control" value="'.$getDetail->department.'" required="">
                <span class="form-bar"></span>
                <label class="float-label">Department</label>
            </div>
            <div class="form-group col-sm-6  form-primary">
                <input type="text" name="level" id="level" class="form-control" value="'.$getDetail->level.'" required="">
                <span class="form-bar"></span>
                <label class="float-label">Level</label>
            </div>
             <div class="form-group col-sm-6  form-primary">
                <input type="text" name="school" id="school" class="form-control" value="'.$getDetail->school.'" required="">
                <span class="form-bar"></span>
                <label class="float-label">School</label>
            </div>
            <div class="form-group col-sm-12 form-default form-static-label">
                <textarea class="form-control" id="residence" name="residence" required="">'.$getDetail->Residence.'</textarea>
                <span class="form-bar"></span>
                <label class="float-label">Address</label>
            </div>
            
            </div>
            <div class="row">
                <button class="btn btn-outline-info updateMemberBtn" id="updateMemberBtn" type="button">Update</button>             
            </div>
            <hr class="invisible">
            <div id="updateError"></div>
        </form>
        ';
    echo $output;
    }
}


if (isset($_POST['action']) && $_POST['action'] == 'updateMember'){

    $memberId = ((isset($_POST['memberId']) && !empty($_POST['memberId']))?$show->test_input($_POST['memberId']): '');
    $fullname = ((isset($_POST['fullname']) && !empty($_POST['fullname']))?$show->test_input($_POST['fullname']): '');
    $email  = ((isset($_POST['email']) && !empty($_POST['email']))?$show->test_input($_POST['email']): '');
    $gender = ((isset($_POST['gender']) && !empty($_POST['gender']))?$show->test_input($_POST['gender']): '');
    $pob = ((isset($_POST['pob']) && !empty($_POST['pob']))?$show->test_input($_POST['pob']): '');
    $birthday = ((isset($_POST['birthday']) && !empty($_POST['birthday']))?$show->test_input($_POST['birthday']): '');
    $homeChurch = ((isset($_POST['homeChurch']) && !empty($_POST['homeChurch']))?$show->test_input($_POST['homeChurch']): '');
    $mobile = ((isset($_POST['mobile']) && !empty($_POST['mobile']))?$show->test_input($_POST['mobile']): '');
    $department = ((isset($_POST['department']) && !empty($_POST['department']))?$show->test_input($_POST['department']): '');
    $level = ((isset($_POST['level']) && !empty($_POST['level']))?$show->test_input($_POST['level']): '');
    $school  = ((isset($_POST['school']) && !empty($_POST['school']))?$show->test_input($_POST['school']): '');
    $residence  = ((isset($_POST['residence']) && !empty($_POST['residence']))?$show->test_input($_POST['residence']): '');

        $required = array(
                            'memberId',
                            'fullname',
                            'email',
                            'gender',
                            'pob',
                            'birthday',
                            'homeChurch',
                            'mobile',
                            'department',
                            'level',
                            'school',
                            'residence'
);
        foreach ($required as $fields){
            if (empty($_POST[$fields])){
                echo $show->showMessage('danger', 'All Fields are required!', 'warning');
                return false;
            }
        }

         $db->update('members','id',$memberId, array(
                    'full_name' =>  $fullname,
                    'Gender' => $gender,
                    'Birthday' => $birthday,
                    'Residence' => $residence,
                    'pob' => $pob,
                    'home_church' => $homeChurch,
                    'mobile' => $mobile,
                    'email' => $email,
                    'department' => $department,
                    'level' => $level,
                    'school' => $school
        ));
        echo 'success';

}

if (isset($_POST['action']) && $_POST['action'] == 'fetchVisitors') {
    $visitor = 	$general->fetchVisitors();
    if ($visitor){
        echo $visitor;
    }

}

if (isset($_POST['action']) && $_POST['action'] == 'fetchStudentExco') {
    $studentExco = 	$general->fetchStudentExco();
    if ($studentExco){
         echo  $studentExco;
    }

}

if (isset($_POST['action']) && $_POST['action'] == 'fetchCouncilExco') {
    $councileExco = 	$general-> getCouncilExco();
    if ($councileExco){
       foreach ($councileExco as $executives){
           ?>
           <div class="align-middle m-b-30">
               <img src="profile/<?=$executives->photo?>" alt="<?=$executives->fullname?>" class="img-radius img-40 align-top m-r-15">
               <div class="d-inline-block">
                   <h6><?=$executives->fullname?></h6>
                   <p class="text-muted m-b-0"><?=$executives->portfolio?></p>
                   <p class="text-muted m-b-0"><?=$executives->email?></p>
                   <p class="text-muted m-b-0"><?=$executives->phoneNo?></p>

               </div>
           </div>
        <?php
       }
    }else{
        echo '<span class="text-danger text-bold text-uppercase">No Data yet!</span>';
    }

}