<?php
require_once '../../core/init.php';

$fileupload = new FileUpload();
$show = new Show();
$error = array();


$file = Input::get('profileFile');

$filename = $file['name'];


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
$file_path = $fileupload->moveFile($temp_file, "chapel_Admin","profile", $filename)->path();
$db_path = $file_path;

    if (Input::exists()){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'fullname' => array(
                'required' => true,
            ) ,
            'email' => array(
                'required' => true,
                'unique' => 'councilMembers'
            ) ,
            'phoneNo' => array(
                'required' => true,
                'unique' => 'councilMembers'
            ) ,
            'portfolio' => array(
                'required' => true,
            )
    ));
    }

$fileupload->moveToDatabase('councilMembers', array(
    'fullname' => Input::get('fullname'),
    'email' => Input::get('email'),
     'phoneNo' => Input::get('phoneNo'),
     'portfolio' => Input::get('portfolio'),
    'photo' => $db_path
));
echo  'success';