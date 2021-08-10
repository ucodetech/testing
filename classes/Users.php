<?php

  class Users extends DB {
  

    // public function create($user_full_name, $user_email, $user_username, $user_phoneNo, $hashed_password, $user_gender)
    // {
    //    $sql = "INSERT INTO codeChat_users (full_name,user_email,user_username,user_phoneNo,user_password,user_gender) VALUES (?,?,?,?,?,?)";
    //    $stmt = $this->_pdo->prepare($sql);
    //    $stmt->execute([$user_full_name, $user_email, $user_username, $user_phoneNo, $hashed_password, $user_gender]);
    //    return true;
    // }

    // public function findUser($user_access)
    // {
    //    $sql = "SELECT * FROM codeChat_users WHERE  user_username = '$user_access' OR  user_phoneNo = '$user_access' OR  user_email = '$user_access' AND deleted = 0";
    //    $stmt = $this->_pdo->prepare($sql);
    //    $stmt->execute();
    //    $result = $stmt->fetch(PDO::FETCH_OBJ);
    //    return $result;
    // }

    // public function updateProfile($profile, $userid)
    // {
    //   $sql = "UPDATE codeChat_users SET profile_pic = ? WHERE id = ?";
    //    $stmt = $this->_pdo->prepare($sql);
    //    $stmt->execute([$profile, $userid]);
    //    return true;
    // }

    // public function findEmail($table, $field, $email)
    // {
    //    $sql = "SELECT * FROM $table WHERE $field = ? AND deleted = 0";
    //    $stmt = $this->_pdo->prepare($sql);
    //    $stmt->execute([$email]);
    //    $result = $stmt->fetch(PDO::FETCH_OBJ);
    //    return $result;
    // }

    //  public function findPhone($table,$field, $phone)
    // {
    //    $sql = "SELECT * FROM $table WHERE $field = ? AND deleted = 0";
    //    $stmt = $this->_pdo->prepare($sql);
    //    $stmt->execute([$phone]);
    //    $result = $stmt->fetch(PDO::FETCH_OBJ);
    //    return $result;
    // }

    //  public function findUsername($table,$field, $username)
    // {
    //    $sql = "SELECT * FROM $table WHERE $field = ? AND deleted = 0";
    //    $stmt = $this->_pdo->prepare($sql);
    //    $stmt->execute([$username]);
    //    $result = $stmt->fetch(PDO::FETCH_OBJ);
    //    return $result;
    // }


     public function selectTable($table)
    {
       $sql = "SELECT * FROM $table WHERE deleted = 0";
       $stmt = $this->_pdo->prepare($sql);
       $stmt->execute();
       $result = $stmt->fetchAll(PDO::FETCH_OBJ);
       return $result;
    }

     public function getById($table, $field, $id)
    {
       $sql = "SELECT * FROM $table WHERE $field = ? AND deleted = 0";
       $stmt = $this->_pdo->prepare($sql);
       $stmt->execute([$id]);
       $result = $stmt->fetch(PDO::FETCH_OBJ);
       return $result;
    }
public function findCurrentUser($id){
    $sql = "SELECT * FROM codeChat_users WHERE id = ? AND deleted = 0";
    $stmt = $this->_pdo->prepare($sql);
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result;
    }
    public function keyInUser($currentuser, $user_email, $verify_key)
    {
        
       $sql = "INSERT INTO verifyEmail (user_id,verifiy_email,verify_key) VALUES (?,?,?)";
       $stmt = $this->_pdo->prepare($sql);
       $stmt->execute([$currentuser, $user_email, $verify_key]);
       return true;
    }


public function deleteToken($email){
    $sql = "DELETE FROM pwdReset WHERE email = ? ";
    $stmt = $this->_pdo->prepare($sql);
    $stmt->execute([$email]);
    return true;
}

public function selectSelector($selector){

  $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector = ? AND pwdResetExpires > NOW()";
  $stmt = $this->_pdo->prepare($sql);
  $stmt->execute([$selector]);
  $result = $stmt->fetch(PDO::FETCH_OBJ);
  return $result;
}

public function updateUser($password,$email){
  $sql = "UPDATE users SET password = ? WHERE email = ? AND deleted = 0";
  $stmt = $this->_pdo->prepare($sql);
  $stmt->execute([$password, $email]);
  return true;
}

public function isFriend($username_to_check)
{
  $username = "," . $username_to_check . ",";
  if (strstr($currentData->user_friends, $username) || $username_to_check == $currentData->user_username) {
     return true;
  }else{
   return false;
  }
}


}
