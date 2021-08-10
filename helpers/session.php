 <?php
$user = new User();
if ((Session::exists(Config::get('session/session_nameChat')))) {
  $userLoggedIn = $user->data()->user_username;
  $userLoggedInId = $user->data()->id;


}

  function isLoggedInChat(){
      $user = new User();
    if ($user->isLoggedIn()) {
        return true;
     }else{
        return false;
     }


      }
function hasPermission(){
$user = new User();

if ($user->data()->user_closed == 0) {
      return true;
    }else{
      return false;
    }
}


  // $warhead = new Warauth();
  // if (Session::exists(Config::get('session/session_nameAd'))) {
  //   $activeHead = $_SESSION[Config::get('session/session_nameAd')];
  //   $incharge = $warhead->virusHead($activeHead);
  //   $activeProfile = $warhead->getWarStatus($incharge->id);

  // }

  //     function isWarHeadGranted(){
  //            if (isset($_SESSION[Config::get('session/session_nameAd')])) {
  //                return true;
  //                }else{
  //                    return false;
  //                }

  //         }





function userLiked($postid){
    global $db;
    global  $currentUser;

  $sql = "SELECT * FROM likeSystem WHERE user_id = '$currentUser' AND post_id = ? AND like_dislike_count  = 'like' ";
  $stmt = $db->_pdo->prepare($sql);
  $stmt->execute([$postid]);
  $result = $stmt->rowCount();
  
  if ($result) {
      return true;
  }else{
    return false;
  }
}
function userDisliked($postid){
    global $db;
    global $userid;

  $sql = "SELECT * FROM likeSystem WHERE user_id = '$currentUser' AND post_id = ? AND like_dislike_count  = 'dislike' ";
  $stmt = $db->_pdo->prepare($sql);
  $stmt->execute([$postid]);
  $result = $stmt->rowCount();
  
  if ($result) {
      return true;
  }else{
    return false;
  }
}