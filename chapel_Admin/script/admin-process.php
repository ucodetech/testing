<?php
require_once '../../core/init.php';

$general = new General();
$show = new Show();
$admin = new Admin();

if (isset($_POST['action']) && $_POST['action'] == 'fetchAdmins') {

	$fetchAdmin = $general->fetchAdmins(0);
	if ($fetchAdmin) {
		echo $fetchAdmin;
	}

}

if (isset($_POST['admin_id'])) {
	$admin_id = (int)$_POST['admin_id'];

	$get = $general->getAdminDetail($admin_id);
	if ($get) {
		echo $get;
	}
}

if (isset($_POST['fullName'])) {

	if (!empty($_POST['fullName'])) {
		$fullName =  $show->test_input($_POST['fullName']);
		$admin_id = (int)$_POST['adminId'];

		$update = $general->updateAdminRecored($admin_id, 'sudo_full_name', $fullName);
		if ($update) {
			echo 'success';
		}
	}else{
		echo  'This field should not be empty!';
		return false;
	}


}
if (isset($_POST['email'])) {

	if (!empty($_POST['email'])) {
		$email =  $show->test_input($_POST['email']);
		$admin_id = (int)$_POST['adminId'];

		$update = $general->updateAdminRecored($admin_id, 'sudo_email', $email);
		if ($update) {
			echo 'success';
		}
	}else{
		echo  'This field should not be empty!';
		return false;
	}


}
if (isset($_POST['fileNo'])) {

	if (!empty($_POST['fileNo'])) {
		$fileNo =  $show->test_input($_POST['fileNo']);
		$admin_id = (int)$_POST['adminId'];

		$update = $general->updateAdminRecored($admin_id, 'sudo_fileNo', $fileNo);
		if ($update) {
			echo 'success';
		}
	}else{
		echo  'This field should not be empty!';
		return false;
	}


}
if (isset($_POST['phoneNo'])) {

	if (!empty($_POST['phoneNo'])) {
		$phoneNo =  $show->test_input($_POST['phoneNo']);
		$admin_id = (int)$_POST['adminId'];

		$update = $general->updateAdminRecored($admin_id, 'sudo_phoneNo', $phoneNo);
		if ($update) {
			echo 'success';
		}
	}else{
		echo  'This field should not be empty!';
		return false;
	}


}

if (isset($_POST['department'])) {

	if (!empty($_POST['department'])) {
		$department =  $show->test_input($_POST['department']);
		$admin_id = (int)$_POST['adminId'];

		$update = $general->updateAdminRecored($admin_id, 'sudo_department', $department);
		if ($update) {
			echo 'success';
		}
	}else{
		echo  'This field should not be empty!';
		return false;
	}


}
