<?php
require_once '../../core/init.php';

$student = new Admin();
$show = new Show();
$counsel = new Counsel();
$validate = new Validate();
$db = Database::getInstance();

if (isset($_POST['action']) && $_POST['action'] == 'fetchScreening') {
    $screening = $counsel->fetchScreening();
    if ($screening){
        echo $screening;
    }

}

if (isset($_POST['action']) && $_POST['action'] == 'CheckTrigger'){
    $check = $counsel->triggerForm('formName', 'electionScreeningFrom');
    $output = '';
    if ($check->switch == 0){
        $output .= '<div class="row">
            <div class="col-sm-6">
                <button type="button" class="btn btn-outline-info activateScreenForm">Activate Screening Form</button>
            </div>
            <div class="col-sm-6">
                <h4 class="text-danger">Screening Form is not Active</h4>
            </div>
        </div>';

    }else{

        $output .= '<div class="row">
            <div class="col-sm-6">
                <button type="button" class="btn btn-outline-danger deactivateScreenForm">Deactivate Screening Form</button>
            </div>
            <div class="col-sm-6">
                <h4 class="text-success">Screening Form is Active</h4>
            </div>
        </div>';



    }
    echo $output;
}

if(isset($_POST['action']) && $_POST['action'] == 'activateBtn'){
//    $sql = "UPDATE triggerTable SET switch = 1 WHERE formName = 'counsellingForm'";
//    $db->query($sql);
    $counsel->updateTrigger(1,'electionScreeningFrom');
}
if(isset($_POST['action']) && $_POST['action'] == 'deactivateBtn'){
    $counsel->updateTrigger(0,'electionScreeningFrom');
}

//update screening form
if (isset($_POST['action']) && $_POST['action'] == 'updateScreen') {

    if (Input::exists()) {
        $validation = $validate->check($_POST, array(
            'surname' => array(
                'required' => true,
            ),
            'othernames' => array(
                'required' => true,
            ),
            'phoneNo' => array(
                'required' => true,
            ),
            'dob' => array(
                'required' => true,
            ),
            'maritalStatus' => array(
                'required' => true,
            ),
            'department' => array(
                'required' => true,
            ),
            'level' => array(
                'required' => true,
            ),
            'cgpa' => array(
                'required' => true,
            ),
            'bornAgain' => array(
                'required' => true,
            ),
            'bornAgainDate' => array(
                'required' => false,
            ),
            'howItHappened' => array(
                'required' => false,
            ),
            'homeChurch' => array(
                'required' => true,
            ),
            'christianLeadership' => array(
                'required' => true,
            ),
            'whereDid' => array(
                'required' => false,
            ),
            'positionHeld' => array(
                'required' => false,
            ),
            'spiritualGift' => array(
                'required' => true,
            ),
            'brieflyDesribe' => array(
                'required' => false,
            ),
            'signature' => array(
                'required' => true,
            ),
            'electoralCommitteComment' => array(
                'required' => true,
                'min' => 10,
                'max' => 255

            ),
            'chaplainComment' => array(
                'required' => true,
                'min' => 10,
                'max' => 255

            )

        ));

        if ($validation->passed()) {
            $screenid = Input::get('screenid');
            try {
                $counsel->update('screeningForm', $screenid, array(
                    'surname' => Input::get('surname'),
                    'othernames' => Input::get('othernames'),
                    'dateOfBirth' => Input::get('dob'),
                    'maritalStatus' => Input::get('maritalStatus'),
                    'cgpa' => Input::get('cgpa'),
                    'department' => Input::get('department'),
                    'level' => Input::get('level'),
                    'phoneNo' => Input::get('phoneNo'),
                    'bornAgain' => Input::get('bornAgain'),
                    'dateBornAgain' => Input::get('bornAgainDate'),
                    'howItHappened' => Input::get('howItHappened'),
                    'yourHomeChurch' => Input::get('homeChurch'),
                    'christianLeadership' => Input::get('christianLeadership'),
                    'whereDidYou' => Input::get('whereDid'),
                    'positonHeld' => Input::get('positionHeld'),
                    'discoveredGift' => Input::get('spiritualGift'),
                    'describeBriefly' => Input::get('brieflyDesribe'),
                    'signature' => Input::get('signature'),
                    'electoralCommitteComment' => Input::get('electoralCommitteComment'),
                    'chaplainComment' => Input::get('chaplainComment')
                ));
                echo 'success';
            } catch (Exception $e) {
                echo $show->showMessage('danger', $e->getMessage(), 'warning');
                echo $show->showMessage('danger', 'Code Line ' . $e->getLine(), 'warning');
                echo $show->showMessage('danger', 'Code ' . $e->getCode(), 'warning');
                return false;
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $show->showMessage('danger', $error, 'warning');
                return false;
            }
        }
    }
}


if (isset($_POST['exco_id']) && !empty($_POST['exco_id'])){
    $exco_id = $_POST['exco_id'];
    $get = $counsel->getScreenDetail($exco_id);
    if ($get){
        echo json_encode($get);
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'makeExcoNow'){
   if (Input::exists()){
       $validation = $validate->check($_POST, array(
           'user_id' => array(
           'required' => true,
               'unique' => 'studentExcos'
               ),
            'fullName' => array(
                   'required' => true,
               ),
            'office' => array(
                   'required' => true,
                    'unique' => 'studentExcos'
               ),
            'schoolSession' => array(
                   'required' => true,
               )
               ));
       if ($validation->passed()){
           $counsel->create('studentExcos', array(
               'user_id' => Input::get('user_id'),
               'office' => Input::get('office'),
               'SchoolSession' => Input::get('schoolSession')
           ));
           echo 'success';
       }else{
           foreach ($validation->errors() as $error){
               echo $show->showMessage('danger', $error, 'warning');
               return false;
           }
       }
   }

}