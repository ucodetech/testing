<?php
require_once  '../../core/init.php';
$grapNote = new UserNote();
$feed = new Feedback();
$notify = new Notification();


//Fetch Notes Ajax request
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllFeed') {
    $output = '';
    $feeds =  $feed->getFeedback();
    echo $feeds;
}

if (isset($_POST['feeddetails_id'])) {
    $id = $_POST['feeddetails_id'];
    $feeds = $feed->feedDetails($id);
    $user = $grapNote->selectUserNote($feeds->user_id);
    $output = '';
    if ($feeds->replied == 0) {
        $msg = "<span class='text-danger align-self-center lead'>No</span>";
        $answer  = '<a href="#" fid="'.$feeds->id.'" id="'.$feeds->user_id.'" class="btn btn-primary btn-block btn-lg replyFeedbackIcon" title="Reply" data-toggle="modal" data-target="#replyModal"><i class="fas fa-reply fa-lg"></i> </a>';
    }else{
        $msg = "<span class='text-success align-self-center lead'>Yes</span>";
        $answer = "<span class='btn btn-info btn-lg btn-block align-self-center lead'>Feedback Replied</span>";
    }
    $output .= '
    <div class="modal-header">
      <h3 class="modal-title" id="getName">
        '.$user->full_name.' - ID: '.$user->id.'
      </h3>
      <button type="button" class="close" data-dismiss="modal" name="button">&times;</button>
    </div>
    <div class="modal-body">
      <div class="card-deck">
        <div class="card border-primary" style="border:2px solid blue;">
          <div class="card-body">
            <p> Email: '.$user->email.' </p>
            <p>Subject: '.$feeds->subject.'</p>
            <p>Feedback: '.$feeds->feedback.' </p>
            <p>Replied: '.$msg.'</p>
            <p>Sent On: '.pretty_date($feeds->dateCreated).'</p>
          </div>
        </div>
        <div class="card align-self-center">
              '.$answer.'
        </div>
      </div>
    </div>
    <div class="modal-footer">
    <span class="align-left">Feedback Detail</span>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
    </div>
    ';


    echo $output;
}

//Reply feedback to user Ajax
if (isset($_POST['message'])) {
    $userid = $_POST['userid'];
    $message = Show::test_input($_POST['message']);
    $feedid = (int)$_POST['feedid'];

    $warhead->replyFeedback($userid, $message);
    $warhead->updateFeedbackReplied($feedid);

}


// FEtch notification ajax
if (isset($_POST['action']) && $_POST['action'] == 'fetchNotifaction') {

    $notifaction = $notify->fetchNotifactionAdmin();
    $output = '';
    if ($notifaction){
        foreach ($notifaction as $noti) {
            $user = $grapNote->selectUserNote($noti->user_id);
            $output .= '
      <div class="col-lg-5 align-self-center">
      <div class="alert alert-info" role="alert">
        <button type="button" id="'.$noti->id.'" name="button" class="close" data-dismiss="alert" aria-label="Close">
        <span arid-hidden="true">&times;</span>
      </button>
      <h4 class="alert-heading">New Notification</h4>
      <p class="mb-0 lead">
        '.$user->full_name.'->  '.$noti->message.'
      </p>
      <hr class="my-2">
      <p class="mb-0 float-left">User -> '.$user->full_name.'</p>
      <p class="mb-0 float-right"><i class="lead">'.timeAgo($noti->dateCreated).'</i></p>
      <div class="clearfix"> </div>
    </div>
    </div>
      ';
        }
        echo $output;
    }else{
        echo '<h4 class="text-center text-white mt-5">No New Notifications</h4>';
    }



}

if (isset($_POST['action']) && $_POST['action'] == 'getNotify') {
    if ($notify->fetchNotifactionAdmin()) {
        $count =  $notify->fetchNotifactionCountAdmin();
        echo '<span class="badge badge-pill badge-danger">'.$count.'</span>';
    }else{
        $count =  $notify->fetchNotifactionCountAdmin();
        echo '<span class="badge badge-pill badge-danger">'.$count.'</span>';
    }
}


if(isset($_POST['action']) && $_POST['action'] == 'fetchFpiUsers'){
    $output = '';

    $dat = $warhead->selectFpiUsers();

    if ($dat) {

        $output .= '
      <table class="table table-striped table-hover" id="show">
        <thead>
          <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Full Name</th>
            <th>E-Mail</th>
            <th>Phone Number</th>
            <th>Email Verified</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody>
      ';
        foreach ($dat as $row) {
            $profi = $warhead->getImg($row->id);
            if ($profi->status == 0) {
                $yes = '<img src="'.$imgPath.$profi->user_id.'.jpg"  alt="User Image" width="70px" height="70px" style="border-radius:50px;">';
            }else{
                $yes = "<img src='".$imgPathD."/default.png' width='70px' height='70px' style='border-radius:50px;' alt='Default Image'>";
            }
            if($row->verified == 0){
                $msg ='<span class="text-danger align-self-center lead">No</span>';
            }else{

                $msg ='<span class="text-success align-self-center lead">Yes</span>';

            }
            $output .= '
            <tr>
              <td>'.$row->id.'</td>
                <td>'.$yes.'</td>
                     <td>'.$row->full_name.'</td>
                       <td>'.$row->email.'</td>
                         <td>'.$row->phone_number.'</td>
                           <td>'.$msg.'</td>
                           <td>
                           <a href="#" id="'.$row->id.'" title="View Details" class="text-primary fpiuserDetailsIcon" data-toggle="modal" data-target="#showUserDetailsModal"><i class="fas fa-info-circle fa-lg"></i> </a>&nbsp;
                           <a href="#" id="'.$row->id.'" title="Trash User" class="text-danger fpideleteUserIcon"><i class="fa fa-recycle fa-lg"></i> </a>&nbsp;

                           </td>
            </tr>
            ';
        }



        $output .= '
        </tbody>
      </table>';
        echo $output;
    }else{
        echo '<h3 class="text-center text-secondary align-self-center lead">No user In database</h3>';
    }

}



// USer in detail by id
if (isset($_POST['fpidetails_id'])) {
    $output = '';
    $id = $_POST['fpidetails_id'];
    $data = $warhead->fetchUserDetail($id, 0);
    $profi = $warhead->getImg($data->id);
    if ($profi->status == 0) {
        $yes = '<img src="'.$imgPath.$profi->user_id.'.jpg"
    alt="User Image" class="img-thumbnail img-fluid align-self-center" width="280px" >';
    }else{
        $yes = "<img src='".$imgPathD."/default.png' class='img-thumbnail img-fluid align-self-center' width='280px' alt='Default Image'>";
    }
    if($data->verified == 0){
        $msg ='<span class="text-danger align-self-center lead">No</span>';
    }else{

        $msg ='<span class="text-success align-self-center lead">Yes</span>';

    }
    $output .= '
  <div class="modal-header">
    <h3 class="modal-title" id="getName">
      '.$data->full_name.' - ID: '.$data->id.'
    </h3>
    <button type="button" class="close" data-dismiss="modal" name="button">&times;</button>
  </div>
  <div class="modal-body">
    <div class="card-deck">
      <div class="card border-primary" style="border:2px solid blue;">
        <div class="card-body">
          <p> Email: '.$data->email.' </p>
          <p>Phone Number: '.$data->phone_number.'</p>
          <p>Gender: '.ucfirst($data->gender).'</p>
          <p>DOB: '.$data->dob.' </p>
          <p>Email-Verified: '.$msg.'</p>
          <p>Registered On: '.pretty_date($data->dateJoined).'</p>
          <p>Last Login: '.timeAgo($data->lastLogin).'</p>
        </div>
      </div>
      <div class="card align-self-center">
          '.$yes.'
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
  </div>
  ';
    echo ($output);
}
//delete user
if (isset($_POST['fpidel_id'])) {
    $id = $_POST['fpidel_id'];
    $warhead->userAction($id, 1);
}
