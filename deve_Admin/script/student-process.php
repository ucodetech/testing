<?php
require_once '../../core/init.php';

$general = new General();
$show = new Show();
$student = new Student();

if (isset($_POST['hod_approve'])) {
		$user_id  = $_POST['hod_approve'];
		$check = $student->approveAction('hod_approval',0,$user_id);
		if ($check===true)
				echo 'success';

}

if (isset($_POST['circulationApprove'])) {
		$user_id  = $_POST['circulationApprove'];
	$check = $student->approveAction('circulation_approval',1,$user_id);
		if ($check===true) {
				$student->giveCard($user_id);
				echo 'success';
		}else{
			echo $show->showMessage('danger','The student or staff have not updatd his/her details completely!', 'warning');
			return false;


		}
}

if (isset($_POST['action']) && $_POST['action'] == 'fetch_students') {

	$fetchStudent = $student->fetchStudentsApproved();
	if ($fetchStudent) {
		echo $fetchStudent;
	}

}

if (isset($_POST['action']) && $_POST['action'] == 'fetch_staffs') {

	$fetchStaff = $student->fetchStaffApproved();
	if ($fetchStaff) {
		echo $fetchStaff;
	}

}
if (isset($_POST['action']) =='fetch_notApproved') {
	$fetchNot = $student->notApprovedUser();
		if ($fetchNot) {
		echo $fetchNot;
	}

}
if (isset($_POST['student_id'])) {
	$student_id = (int)$_POST['student_id'];

	$get = $student->getStudentDetail($student_id);
	if ($get) {
		echo $get;
	}
}

if (isset($_POST['fullName'])) {
	if (hasPermissionSuper())
			if (!empty($_POST['fullName'])) {
				$fullName =  $show->test_input($_POST['fullName']);
				$student_id = (int)$_POST['studentId'];

				$update = $student->updateStudentRecored($student_id, 'full_name', $fullName);
				if ($update) {
					echo 'success';
				}
			}else{
				echo  'This field should not be empty!';
				return false;
			}
		else
			echo 'Sorry you do not have permission to edit Student or Staff Recored! Please redirect them to the Administrator';
			return false;

}
if (isset($_POST['email'])) {
	if (hasPermissionSuper())
			if (!empty($_POST['email'])) {
				$email =  $show->test_input($_POST['email']);
				$student_id = (int)$_POST['studentId'];

				$update = $student->updateStudentRecored($student_id, 'email', $email);
				if ($update) {
					echo 'success';
				}
			}else{
				echo  'This field should not be empty!';
				return false;
			}
	else
		echo 'Sorry you do not have permission to edit Student or Staff Recored! Please redirect them to the Administrator';
		return false;

}
if (isset($_POST['matricNo'])) {
 if (hasPermissionSuper())
		if (!empty($_POST['matricNo'])) {
			$matricNo =  $show->test_input($_POST['matricNo']);
			$student_id = (int)$_POST['studentId'];

			$update = $student->updateStudentRecored($student_id, 'matric_no', $matricNo);
			if ($update) {
				echo 'success';
			}
		}else{
			echo  'This field should not be empty!';
			return false;
		}

	else
		echo 'Sorry you do not have permission to edit Student or Staff Recored! Please redirect them to the Administrator';
		return false;
}
if (isset($_POST['phoneNo'])) {
	if (hasPermissionSuper())
		if (!empty($_POST['phoneNo'])) {
			$phoneNo =  $show->test_input($_POST['phoneNo']);
			$student_id = (int)$_POST['studentId'];

			$update = $student->updateStudentRecored($student_id, 'phone_number', $phoneNo);
			if ($update) {
				echo 'success';
			}
		}else{
			echo  'This field should not be empty!';
			return false;
		}
	else
		echo 'Sorry you do not have permission to edit Student or Staff Recored! Please redirect them to the Administrator';
		return false;
}

if (isset($_POST['department'])) {
		if (hasPermissionSuper())
			if (!empty($_POST['department'])) {
				$department =  $show->test_input($_POST['department']);
				$student_id = (int)$_POST['studentId'];

				$update = $student->updateStudentRecored($student_id, 'department', $department);
				if ($update) {
					echo 'success';
				}
			}else{
				echo  'This field should not be empty!';
				return false;
			}
	else
		echo 'Sorry you do not have permission to edit Student or Staff Recored! Please redirect them to the Administrator';
		return false;

}

if (isset($_POST['level'])) {
		if (hasPermissionSuper())
			if (!empty($_POST['level'])) {
				$level =  $show->test_input($_POST['level']);
				$student_id = (int)$_POST['studentId'];

				$update = $student->updateStudentRecored($student_id, 'level', $level);
				if ($update) {
					echo 'success';
				}
			}else{
				echo  'This field should not be empty!';
				return false;
			}

	else
		echo 'Sorry you do not have permission to edit Student or Staff Recored! Please redirect them to the Administrator';
		return false;
}
if (isset($_POST['gender'])) {
		if (hasPermissionSuper())
			if (!empty($_POST['gender'])) {
				$gender =  $show->test_input($_POST['gender']);
				$student_id = (int)$_POST['studentId'];

				$update = $student->updateStudentRecored($student_id, 'gender', $gender);
				if ($update) {
					echo 'success';
				}
			}else{
				echo  'This field should not be empty!';
				return false;
			}

	else
		echo 'Sorry you do not have permission to edit Student or Staff Recored! Please redirect them to the Administrator';
		return false;
}

if (isset($_POST['dob'])) {
	if (hasPermissionSuper())
			if (!empty($_POST['dob'])) {
				$dob =  $show->test_input($_POST['dob']);
				$student_id = (int)$_POST['studentId'];

				$update = $student->updateStudentRecored($student_id, 'dob', $dob);
				if ($update) {
					echo 'success';
				}
			}else{
				echo  'This field should not be empty!';
				return false;
			}

	else
		echo 'Sorry you do not have permission to edit Student or Staff Recored! Please redirect them to the Administrator';
		return false;
}

if (isset($_POST['school'])) {
	if (hasPermissionSuper())
		if (!empty($_POST['school'])) {
			$school =  $show->test_input($_POST['school']);
			$student_id = (int)$_POST['studentId'];

			$update = $student->updateStudentRecored($student_id, 'school', $school);
			if ($update) {
				echo 'success';
			}
		}else{
			echo  'This field should not be empty!';
			return false;
		}
	else
		echo 'Sorry you do not have permission to edit Student or Staff Recored! Please redirect them to the Administrator';
		return false;

}
