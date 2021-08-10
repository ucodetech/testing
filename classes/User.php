<?php
/**
 * post class
 */
class User
{
  private  $_db,
           $_data,
           $_sessionName,
           $_cookieName,
           $_isLoggedIn;

public function __construct($user = null)
  {
    $this->_db = Database::getInstance();
    $this->_sessionName = Config::get('session/session_nameChat');
    $this->_cookieName = Config::get('cookie/cookie_name');

    if (!$user) {
      if (Session::exists($this->_sessionName)) {
        $user = Session::get($this->_sessionName);

        if ($this->findUser($user)) {
          $this->_isLoggedIn = true;
        }else{
          //process logout
        }
      }
    }else{
     $getUser =  $this->findUser($user);
    }

  }

public function create($fields =  array())
{
    if (!$this->_db->insert('codeChat_users', $fields)) {
      throw new Exception("Error Processing Request create account", 1);
      
    }
}
//find user details for login
public function findUser($user = null)
    {
      if ($user) {
       $field = (is_numeric($user)) ? 'id' : 'user_username';
       $data = $this->_db->get('codeChat_users', array($field, '=', $user));
       if ($data->count()) {
         $this->_data = $data->first();
         return true;
       }
      }
      return false;
    }

//login
public function login($user_access = null, $user_password = null)
{
  $user = $this->findUser($user_access);
  if ($user) {
    if (password_verify($user_password, $this->data()->user_password)) {
      Session::put($this->_sessionName, $this->data()->id);
      return true;
    }else{
      echo Show::showMessage('warning', 'Password Incorrect', 'warning');
      return false;
    }
  }else{
    echo Show::showMessage('danger', 'User not found!', 'warning');
   return false; 
  }
  
}
public function userName($profileUser)
{
  $this->_db->get('codeChat_users', array('id', '=', $profileUser));
  if ($this->_db->count()) {
    return $this->_db->first();
  }else{
    return false;
  }
}

public function data()
{
  return $this->_data;
}

public function isLoggedIn(){
  return $this->_isLoggedIn;
}

public function logout()
{
  Session::delete($this->_sessionName);
}

public function createVerification($fields =  array())
{
    if (!$this->_db->insert('verifyEmail', $fields)) {
      throw new Exception("Error Processing Request email verify", 1);
      
    }
}
//find email
public function findEmail($email)
{
  $data = $this->_db->get('codeChat_users', array('user_email', '=', $email));
  if ($data->count()) {
    $this->_data = $data->first();
    return true;
  }else{
    return false;
  }

}

//find phone number
public function findPhone($phoneNo)
{
  $data = $this->_db->get('codeChat_users', array('user_phoneNo', '=', $phoneNo));
  if ($data->count()) {
     $this->_data = $data->first();
    return true;
  }else{
    return false;
  }

}

// find username
public function findUsername($username)
{
  $data = $this->_db->get('codeChat_users', array('user_username', '=', $username));
  if ($data->count()) {
   $this->_data = $data->first();
    return true;
  }else{
    return false;
  }

}

  public function updateProfile($profile, $userid)
    {
      $up = $this->_db->update('codeChat_users','id', $userid, array(
        'profile_pic' => $profile
    ));
      if ($up) {
        return true;
      }else{
        return false;
      }
    }


//password reset
   // delete token
    public function deleteToken($email, $field = array())
    {
      $this->_db->delete('pwdReset', array('email', '=', $email));
    }

  //get username 
    public function getUsername()
    {
      return $this->data()->user_username;
    }
    //get friend array
    public function getFriendArray()
    {
      return $this->data()->user_friends;
    }
    //get profile pic
    public function getProfilePic()
    {
      return $this->data()->profile_pic;
    }
     //get id
    public function getUserId()
    {
      return $this->data()->id;
    }
    //check me
    public function checkMe($userprofile)
    {
      $usernow = $this->_db->get('codeChat_users', array('user_username', '=', $userprofile));
      if ($usernow->count()) {
        return $usernow->first();
      }else{
        return false;
      }

    }
    public function getMutualFriends($user_to_check)
    {
      $mutual = 0;
      $user_friends = $this->getFriendArray();
      $user_friends_explode = explode(',', $user_friends);

       $sql = "SELECT user_friends FROM codeChat_users WHERE user_username = '$user_to_check'";
       $row = $this->_db->query($sql);
       if ($row->count()) {
         $user_to_check_friends = $this->_db->first();
         $user_to_check_array = explode(',', $user_to_check_friends->user_friends);
       }
       foreach ($user_friends_explode as $me) {
         foreach ($user_to_check_array as $other) {
           if ($me == $other && $me != "") {
             $mutual++;
           }
         }
       }
       return $mutual;
   
    }

    // is user closed
    public function isUserClosed($user)
    {
     $sql = "SELECT * FROM codeChat_users WHERE user_username = '$user' AND user_closed = 0 ";
    $closed = $this->_db->query($sql);
   
      if ($closed->count()) {
        return true;
      }else{
        return false;
      }
    }

    //usr number of post
    public function userNumPost()
    {
      return  $this->data()->num_posts;
    }
     public function userNumLikes()
    {
      return  $this->data()->num_likes;
    }

    //get user name
    public function getAnyUsername()
    {
      // get this general
     return  $this->data()->full_name;
    }

    //check your friends
  public function isFriend($username_to_check)
    {
      $usernameComma = $username_to_check . ",";
      
      if (strstr($this->data()->user_friends, $usernameComma) || $username_to_check == $this->data()->user_username) {
         return true;
      }else{
       return false;
      }
    }
 public function LoadFriends($userFriend){

   $output = '';
 $userLoggedIn = $this->data()->user_username;
  $sql = "SELECT * FROM codeChat_users WHERE user_username = '$userFriend' ORDER BY full_name";
  $getFriends = $this->_db->query($sql);

  if ($getFriends->count()) {
    $friends = $getFriends->first();
    $listThem = explode(',', $friends->user_friends);
    foreach ($listThem as $friends) {

      $getFriendDetail = $this->_db->get('codeChat_users', array('user_username', '=', $friends));
      if ($getFriendDetail->count()) {
        $friendDetail = $getFriendDetail->first();
        $shorted = explode(' ', $friendDetail->full_name);
        $short = $shorted[0] .' '. $shorted[1];
       

        //fetch details now

        if (!$this->isUserClosed($friendDetail->user_username)) {
        $output .= '<div class="profile_profile_pic">
          <img src="'.URLROOT.'conversation/profile/'.$friendDetail->profile_pic.'" alt="'.$friendDetail->full_name.'" width="80">
          <a class="text-light">'.$friendDetail->full_name.'</a> &nbsp
          <span class="text-center text-danger">Closed</span></div>';
        }else{
          if ($userLoggedIn  == $userFriend) {
            $output .= '<div class="profile_profile_pic mt-2">
        <img src="'.URLROOT.'conversation/profile/'.$friendDetail->profile_pic.'" alt="'.$friendDetail->full_name.'" width="80">
        <a href="'.URLROOT.'conversation/ur_profile/'.$friendDetail->user_username.'" class="text-light">'.$friendDetail->full_name.'</a> &nbsp </div>';
          }else {
             $friends = $getFriends->first();
          if ($userLoggedIn == $friends->user_username) {

          }else{
      $output .= '<div class="profile_profile_pic mt-2">
        <img src="'.URLROOT.'conversation/profile/'.$friendDetail->profile_pic.'" alt="'.$friendDetail->full_name.'" width="80">
        <a href="'.URLROOT.'conversation/ur_profile/'.$friendDetail->user_username.'" class="text-light">'.$friendDetail->full_name.'</a> &nbsp';
          $friends = $getFriends->first();
        }
        if ($this->isLoggedIn() == $this->checkMe($friends->user_username)) {
          if ($this->isLoggedIn() == $this->isFriend($friends->user_username)) {
            if ($userLoggedIn == $friends->user_username) {
              
            }else{
              $output .='<a class="text-light">Mutal Friend</a> &nbsp';
            }
          

        }else{
         if($userLoggedIn == $this->didSendRequest($friendDetail->user_username)){
               
           $output .='  <a class="btn btn-lg btn-secondary cancelRequestRequest" href="#" data-username="'.$friendDetail->user_username.'" ><i class="fas fa-times"></i>&nbsp;Cancel Request</a>';
              
             }else{
           $output .='<button type="submit" data-username="'.$friendDetail->user_username.'" class="btn  codeBtn2 addFriendFriends" style="font-size:1.5em;">Add Friend</button>';
            $output .='</div> ';
         }

        
       
        }

        }
        
        }
        
        }
      
        
      }
      
    }
    return  $output;
    
  }

}

public function didReceiveRequest($user_from)
{
  $user_to = $this->getUsername();
  $sql = "SELECT * FROM codeChat_friendRequest WHERE user_to = '$user_to' AND user_from = '$user_from'";
  $check_request = $this->_db->query($sql);
  if ($check_request->count()) {
    return true;
  }else{
    return false;
  }
}
public function didSendRequest($user_to)
{
  $user_from = $this->getUsername();
  $sql = "SELECT * FROM codeChat_friendRequest WHERE user_to = '$user_to' AND user_from = '$user_from'";
  $check_request = $this->_db->query($sql);
  if ($check_request->count()) {
    return true;
  }else{
    return false;
  }
}

public function removeFriend($user_to_remove)
{
  $logged_in_user = $this->getUsername();
   $sql = "SELECT user_friends FROM codeChat_users WHERE user_username = '$user_to_remove' ";
  $check = $this->_db->query($sql);
  if ($check->count()) {
    $row = $this->_db->first();

    $friend_user_array = $row->user_friends;

    $new_friends_array = str_replace($user_to_remove.',','', $this->data()->user_friends);
    $sqlup = "UPDATE codeChat_users SET user_friends = '$new_friends_array' WHERE user_username = '$logged_in_user' ";
    $remove_friend = $this->_db->query($sqlup);
  

    $new_friends_array = str_replace($this->data()->user_username.',','', $friend_user_array);
     $sqlupd = "UPDATE codeChat_users SET user_friends = '$new_friends_array' WHERE user_username = '$user_to_remove' ";
    $remove_friend = $this->_db->query($sqlupd);
  
    

  }

}

public function sendFriendRequest($user_to)
{
  $user_from = $this->getUsername();
  $put = $this->_db->insert('codeChat_friendRequest', array(
    'user_to' => $user_to,
    'user_from' => $user_from
  ));
  return true;
}

public function getRequests($userloggedIn)
{
  $requests = $this->_db->get('codeChat_friendRequest', array('user_to', '=', $userloggedIn));
  if ($requests->count()) {
    return $this->_db->results();
  }else{
  
    return false;
  }
}


public function acceptFriend($user_to_add)
{
  $logged_in_user = $this->getUsername();
  $sql = "UPDATE codeChat_users SET user_friends = CONCAT(user_friends, '$user_to_add,') WHERE user_username = '$logged_in_user' ";
 $this->_db->query($sql);

  $sql2 = "UPDATE codeChat_users SET user_friends = CONCAT(user_friends, '$logged_in_user,') WHERE user_username = '$user_to_add' ";
  $this->_db->query($sql2);

  $sql3 = "DELETE FROM codeChat_friendRequest WHERE user_to = '$logged_in_user' AND user_from = '$user_to_add' ";

  $this->_db->query($sql3);
  return true;
}

public function declineFriend($user_to_decline)
{
  $user_to = $this->getUsername();
  $sql = "DELETE FROM codeChat_friendRequest WHERE user_to = '$user_to' AND user_from = '$user_to_decline' ";
  $this->_db->query($sql);
  return true;
}

public function cancelFriendRequest($cancelRequest)
{
  $user_from = $this->getUsername();
  $sql = "DELETE FROM codeChat_friendRequest WHERE user_from = '$user_from' AND user_to = '$cancelRequest'";
  $this->_db->query($sql);
  return true;
}


public function getNotifedCount()
{
  $userloggedIn = $this->getUsername();
  $requests = $this->_db->get('codeChat_friendRequest', array('user_to', '=', $userloggedIn));
  if ($requests->count()) {
    return $requests->count();
  }else{
  
    return false;
  }
}

public function getAllChatUser()
{
  $logged_in_user = $this->getUsername();
  $sql = "SELECT * FROM codeChat_users WHERE deleted = 0 AND user_closed = 0 AND user_username != '$logged_in_user'";
  $get = $this->_db->query($sql);
  if ($get->count()) {
    return $get->results();
  }else{
    return false;
  }
}

public function UpdateProfileReal($result_path)
{
  $loggedIn = $this->getUsername();
  $this->_db->update('codeChat_users','user_username', $loggedIn, array(
    'profile_pic' => $result_path
  ));
  return true;
}

public function query($sql)
{
  return $this->_db->query($sql);
}
//end of class
}
