<?php
require_once '../core/init.php';

if (isset($_GET['token'])) {
  $token = $_GET['token'];


      if (empty($token)) {
        Redirect::to('ur-profile');
      }else{
        $userid = $user->getUserId();
          $verify =  $user->selectToken($token, $userid );
          if ($verify===false) {
            Redirect::to('ur-profile');
          }else{
              $id = $verify->user_id;
              $user->verify_email($id);
              $user->deleteVkey($userid);
              Redirect::to('ur-profile');
            }

      }
}
