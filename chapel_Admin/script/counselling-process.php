<?php
require_once '../../core/init.php';

$student = new Admin();
$show = new Show();
$counsel = new Counsel();
$db = Database::getInstance();
$validate = new Validate();

if (isset($_POST['action']) && $_POST['action'] == 'fetchCounselling') {
    $counselled = 	$counsel->fetchCounselling();
    if ($counselled){
        echo $counselled;
    }

}

if (isset($_POST['action']) && $_POST['action'] == 'CheckTrigger'){
    $check = $counsel->triggerForm('formName', 'counsellingForm');
    $output = '';
    if ($check->switch == 0){
       $output .= '<div class="row">
            <div class="col-sm-6">
                <button type="button" class="btn btn-outline-info activateCounselFrom">Activate Counselling Form</button>
            </div>
            <div class="col-sm-6">
                <h4 class="text-danger">Counselling Form is not Active</h4>
            </div>
        </div>';

    }else{

      $output .= '<div class="row">
            <div class="col-sm-6">
                <button type="button" class="btn btn-outline-danger deactivateCounselFrom">Deactivate Counselling Form</button>
            </div>
            <div class="col-sm-6">
                <h4 class="text-success">Counselling Form is Active</h4>
            </div>
        </div>';



    }
    echo $output;
}

if(isset($_POST['action']) && $_POST['action'] == 'activateBtn'){
//    $sql = "UPDATE triggerTable SET switch = 1 WHERE formName = 'counsellingForm'";
//    $db->query($sql);
    $counsel->updateTrigger(1,'counsellingForm');
}
if(isset($_POST['action']) && $_POST['action'] == 'deactivateBtn'){
    $counsel->updateTrigger(0,'counsellingForm');
}

if (isset($_POST['action']) && $_POST['action'] == 'updateCounsel'){
    if (Input::exists()){
        $validation = $validate->check($_POST, array(

            'surname' => array(
                'required' => true
            ),
            'othernames'  => array(
                'required' => true
            ),
            'sex' => array(
                'required' => true
            ),
            'age'  => array(
                'required' => true
            ),
            'address' => array(
                'required' => true
            ),
            'department'  => array(
                'required' => true
            ),
            'level' => array(
                'required' => true
            ),
            'phoneNo' => array(
                'required' => true
            ),
            'yourDecision' => array(
                'required' => true
            ),
            'altarCall' => array(
                'required' => true
            ),
            'duration'  => array(
                'required' => true
            ),
            'solution'  => array(
                'required' => true
            ),
            'followUp'  => array(
                'required' => true
            ),
            'yourTime'  => array(
                'required' => true
            ),
            'signature'  => array(
                'required' => true
            )


        ));
        if ($validation->passed()){
            $counselid = Input::get('counselId');
            try {
                $counsel->update('counsellingForm',$counselid, array(
                    'surname' => Input::get('surname'),
                    'othernames' => Input::get('othernames'),
                    'sex' => Input::get('sex'),
                    'age' => Input::get('age'),
                    'address' => Input::get('address'),
                    'department' => Input::get('department'),
                    'level' => Input::get('level'),
                    'phoneNo' => Input::get('phoneNo'),
                    'yourDecison' => Input::get('yourDecision'),
                    'altarCallAnswer' => Input::get('altarCall'),
                    'problemDuration' => Input::get('duration'),
                    'yourSolution' => Input::get('solution'),
                    'counsellorsfollowUp' => Input::get('followUp'),
                    'yourTime' => Input::get('yourTime'),
                    'signature' => Input::get('signature')
                ));
                echo  'success';
            }catch (Exception $e){
                echo $show->showMessage('danger', $e->getMessage(), 'warning');
                echo $show->showMessage('danger', 'Code Line '.$e->getLine(), 'warning');
                echo $show->showMessage('danger', 'Code ' .$e->getCode(), 'warning');
                return false;
            }

        }else{
            foreach ($validation->errors() as $error){
                echo $show->showMessage('danger', $error, 'warning');
                return false;
            }
        }
    }
}
