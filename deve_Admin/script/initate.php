<?php
require_once '../../core/init.php';
$general = new General();
$admin = new Admin();


if(isset($_POST['action']) && $_POST['action']== "fetch_data"){
    $output = '';

    $row = $general->loggedUsers();

   if ($row) {
     foreach ($row as $active) {

       ?>
       <div class="col-lg-4">

          <img src='../chapel_Members/profile/<?=$active->passport;?>' width='70px' height='70px' style='border-radius:50px;' alt='Passport'>
         <br>
         <?
         echo strtok($active->full_name, ' ') . '- ID-' . $active->id ;
         ?>

       </div>
       <?
     }
   }else{

       echo '<span class="text-center">No active Member</span>';

   }


}


if(isset($_POST['action']) && $_POST['action'] == "fetch_super"){
    $output = '';

    $supers = $admin->loggedAdmin();

   if ($supers) {
     foreach ($supers as $active) {

       ?>
         <div class="align-middle m-b-30">
             <img src="profile/<?=$active->passport?>" alt="<?=$active->sudo_full_name?>" class="img-radius img-40 align-top m-r-15">
             <div class="d-inline-block">
                 <h6><?=strtok($active->sudo_full_name,' ')?></h6>
                 <p class="text-muted m-b-0"><?=$active->sudo_permission?></p>
             </div>
         </div>
       <?php
     }
   }


}


if (isset($_POST['action']) && $_POST['action'] == 'update_admin') {
  $admin->updateAdminLog($admin->data()->id);

}


if(isset($_POST['action']) && $_POST['action'] == "totMembers"){
  $tot =  $general->totalCountApproved('members',1);
   echo $tot;
}

if(isset($_POST['action']) && $_POST['action'] == "totfeed"){
  $tot =  $general->totalCount('feedback');
   echo $tot;
}
if(isset($_POST['action']) && $_POST['action'] == "totsermon"){
  $tot =  $general->totalCount('sermon');
   echo $tot;
}
if(isset($_POST['action']) && $_POST['action'] == "totNewReg"){
  $tot =  $general->totalCountApproved('members', 0);
   echo $tot;
}
if(isset($_POST['action']) && $_POST['action'] == "totVemail"){
  $tot =  $student->verified_users(0);
   echo $tot;
}
if(isset($_POST['action']) && $_POST['action'] == "totVdemail"){
  $tot =  $student->verified_users(1);
   echo $tot;
}
if(isset($_POST['action']) && $_POST['action'] == "totPwdReset"){
  $tot =  $general->totalCount('pwdReset');
   echo $tot;
}
if(isset($_POST['action']) && $_POST['action'] == "totAUemail"){
  $tot =  $general->verified_admin(0);
   echo $tot;
}

if(isset($_POST['action']) && $_POST['action'] == "totAemail"){
  $tot =  $general->verified_admin(1);
   echo $tot;
}
