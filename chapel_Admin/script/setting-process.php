<?php
    require_once '../../core/init.php';
    $admin = new Admin();
    $fileupload = new FileUpload();
    $show = new Show();
    $error = array();
    $admin_id = $admin->data()->id;
    $general = new General();

    // $file = Input::get('profile_file');
if (isset($_FILES['profile_file']) && !empty($_FILES['profile_file'])) {

   $file = $_FILES['profile_file'];
    $filename = $file['name'];
    //  var_dump($_FILES);
    // die();

    if (empty($file['name'])) {
        echo $show->showMessage('danger', 'File cant be empty!', 'warning');
        return false;
    }
    if (!$fileupload->isImage($filename)) {
        echo $show->showMessage('danger', 'File is not a valid image!', 'warning');
        return false;

    }
    if ($fileupload->fileSize($filename)) {
        echo $show->showMessage('danger', 'File size is too large!', 'warning');
        return false;
    }

    $ds = DIRECTORY_SEPARATOR;
    $temp_file = $file['tmp_name'];
    $file_path = $fileupload->moveFile($temp_file, "profile", $filename)->path();
    $fileSize = $file['size'];


    $fileupload->moveToDatabaseUpdate('superusers',$admin_id, array(
        'profile_pic' => $file_path
    ));
      

    echo 'success';

}

if (isset($_FILES['signature_file']) && !empty($_FILES['signature_file'])) {

   $file = $_FILES['signature_file'];
    $filename = $file['name'];
    //  var_dump($_FILES);
    // die();

    if (empty($file['name'])) {
        echo $show->showMessage('danger', 'File cant be empty!', 'warning');
        return false;
    }
    if (!$fileupload->isImage($filename)) {
        echo $show->showMessage('danger', 'File is not a valid image!', 'warning');
        return false;

    }
    if ($fileupload->fileSize($filename)) {
        echo $show->showMessage('danger', 'File size is too large!', 'warning');
        return false;
    }

    $ds = DIRECTORY_SEPARATOR;
    $temp_file = $file['tmp_name'];
    $file_path = $fileupload->moveFile($temp_file, "signatures", $filename)->path();
    $fileSize = $file['size'];


    $fileupload->moveToDatabaseUpdate('adminSignatures',$admin_id, array(
        'signature' => $file_path
    ));
      

    echo 'success';

}

