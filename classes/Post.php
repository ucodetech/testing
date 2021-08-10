<?php
/**
 * post class
 */
class Post
{
  private  $_db,
           $_userpost;


  function __construct()
  {
    $this->_db = Database::getInstance();
   $this->_userpost = new User() ;

  }

  public function userpost()
  {
   return $this->_userpost;
  }

  public function sendPost($message, $user_to_timeline)
    {

      $posted_by_id = $this->_userpost->getUserId();
      $posted_by_username = $this->_userpost->getUsername();


      if ($user_to_timeline == $posted_by_username) {
        $user_to_timeline = 'none';
      }

      $post = $this->_db->insert('code_posts', array(
        'message' => $message,
        'posted_by_id' => $posted_by_id ,
        'user_to_timeline' => $user_to_timeline
      ));

      if ($post) {
  //update count
         $num_posts = $this->_userpost->userNumPost();
         $num_posts = $num_posts + 1;
       
         $this->_db->update('codeChat_users', 'id', $posted_by_id, array(
          'num_posts' => $num_posts 
        ));
        }

      
    }


//get number of posts of a user
    public function GetUserNumPost($currentChatUser)
    {
      $getUser = $this->_db->get('codeChat_users', array('id', '=', $currentChatUser));
    
     if ($getUser->count()) {
         $this->_userpost = $getUser->first();
         return $this->_userpost;
       
      }else{
        return false;
      }
    }

public function CountComment($postid)
{
   $counted = $this->_db->get('post_comments', array('post_id', '=', $postid));
      if ($counted->count()) {
       
       return $counted->count();
      }else{
         
        return false;
      }
}
public function CountLikes($postid)
{
   $counted = $this->_db->get('likes', array('post_id', '=', $postid));
      if ($counted->count()) {
       
       return $counted->count();
      }else{
         
        return false;
      }
}
public function CountShares($postid)
{
   $counted = $this->_db->get('shares', array('post_id', '=', $postid));
      if ($counted->count()) {
       
       return $counted->count();
      }else{
         
        return false;
      }
}
//LOAD POST 
  public function loadPosts($data, $limit)
    {
      $output = '';
      $user_to = '';
      $val = 0;
     $userLoggedIn = $this->userpost()->data()->user_username;
      $page = $data['page'];

   if ($page == 1)
      $start = 0;
   else
      $start = ($page - 1) * $limit;
      //grabs all posts where deleted is 0
      $posts = $this->_db->getAll('code_posts', 'deleted', $val);
      // loop through all posts
      if ($posts) {

       $num_iterations = 0; //number of loops checked
      $count = 1;

      foreach ($posts as $allpost) {
      $posted_by = $allpost->posted_by_id;
      // grabs user who made the post
      $userPosted = $this->_db->get('codeChat_users', array('id', '=', $posted_by));
      $userPosted = $userPosted->first(); //returns the user details

      

        //grabs and check if someone was mentioed on the post
      if ($allpost->user_to_timeline == 'none') {
        $user_to = '';
      }else{

        $mentioned = new User($allpost->user_to_timeline);
        $user_to_name = $mentioned->getAnyUsername();
        $user_to_username = $mentioned->getUsername();
        $user_to .= 'to <a href="'.URLROOT.'conversation/ur_profile/'.$user_to_username.'">'.$user_to_name.'</a>';
           //check if user is closed
        if ($mentioned->isUserClosed($allpost->posted_by_id)) {
          continue;
        }


      }
        
        $user_logged_in = new User($userLoggedIn);
        if ($user_logged_in->isFriend($userPosted->user_username)) {
      
       if ($num_iterations++ < $start)
            continue;
         //once 10 posts loaded break
         if($count > $limit){
            break;
         }else{
            $count++;
         }

         ?>
      <script>
  function toggle<?=$allpost->id;?>(){

    var target = $(event.target);
    if(!target.is("a")){
      var element = document.getElementById('toggleComment<?=$allpost->id;?>');
        if (element.style.display == 'block')
          element.style.display = 'none';
        else
          element.style.display ='block';
    }

    

  }
  
          </script>
         <?
         //count comments of each post
      $comments = new Post();
      $count = $comments->CountComment($allpost->id);
      if ($count) {
        $count = $count;
      }else{
        $count = 0;
      }
      //get likes
      
      $likes = $comments->CountLikes($allpost->id);
      if ($likes) {
        $likes = $likes;
      }else{
        $likes = 0;
      }
       $shares = $comments->CountShares($allpost->id);
      if ($shares) {
        $shares = $shares;
      }else{
        $shares = 0;
      }
        $user_logged = new User();
          if ($allpost->posted_by_id == $user_logged->getUserId()) {
          $button ='
            
              <button class="text-light btn btn-sm btn-danger  delete" title="Delete Post" id="'.$allpost->id.'">
              <i class="fa fa-trash"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;
              <button class="text-light  btn btn-sm btn-warning edit" data-toggle="modal" data-target="#editPost" title="Edit Post" id="'.$allpost->id.'">
              <i class="fa fa-edit"></i></button>
             
          ';
          }else{
            $button = '';
          }


         $output .='
        <div class="status_post">
           <div class="post_profile_pic">
                <img src="'.URLROOT.'conversation/profile/'.$userPosted->profile_pic.'" alt="'.$userPosted->full_name.'" width="50">
            </div>
            <div class="posted_by" style="color:#ACACAC">
                <a href="'.URLROOT.'conversation/ur_profile/'.$userPosted->user_username.'">'.$userPosted->full_name.'</a> &nbsp; '.$user_to.'<span class="text-sm"><i> &nbsp; '.timeAgo($allpost->date_posted).'</i></span> &nbsp; '.$button.'
            </div>
            <div id="post_content">
                '.$allpost->message.'
           </div>
           </div>

        <hr>
            <div class="row lcs">
          

            <div class="col-md-3">';
          
            $userLiked = new User();
            $user_liked = $userLiked->getUsername();
            $sql = "SELECT * FROM likes WHERE username = '$user_liked ' AND post_id = '$allpost->id'";
            $check = $this->_db->query($sql);
           
            if ($check->count()) {
              $output .= '<button class="btn btn-danger btn-lg showCase unlike" id="'.$allpost->id.'"> <i class="fa fa-thumbs-down"></i>&nbsp;('.$likes.')</button>&nbsp;&nbsp';

            }else{
              $output .= '<button class="btn btn-primary btn-lg showCase like" id="'.$allpost->id.'"> <i class="fa fa-thumbs-up"></i>&nbsp;('.$likes.')</button>&nbsp;&nbsp';

            }
             
            $output .='</div>
             <div class="col-md-3">
              <button class="btn btn-info btn-lg showCase comment_now" onClick="javascript:toggle'.$allpost->id.'()"><i class="fa fa-comment"></i>&nbsp; ('.$count.')</button>&nbsp;&nbsp;
            </div>
             <div class="col-md-3">
              <button class="btn btn-success btn-lg showCase share" id="'.$allpost->id.'"> <i class="fas fa-share-alt"></i>&nbsp;('.$shares.')</button>&nbsp;&nbsp;
            </div>
          </div>
        
        
         <hr>
        
        <div class="post_comment" id="toggleComment'.$allpost->id.'" style="display:none; width:100%;height:auto !important;">
        <iframe src="comment_frame/'.$allpost->id.'" id="comment_iframe" frameborder="0" style="width:100%;border-radius:5px; min-height:300px !important; overflow:hidden;"></iframe>
        </div>
        <hr/>
        ';

            }


      }//end of loop
      if($count > $limit){
         $output .='<input type="hidden" class="nextPage"
          value="'.($page + 1).'" >
          <input type="hidden" class="noMorePosts" value="false" >';
      }else
          $output .='<input type="hidden" class="noMorePosts" value="true" >
          <p class="text-center lead text-light" style="font-size:15px;">No more Post to load</p>';
    }
 echo $output;

    }
     




public function loadPostId($postId){
  $post = $this->_db->get('code_posts', array('id', '=', $postId));
  if ($post->count()) {
    return  $this->_db->first();
  }else{
    return false;
  }
}

public function LikePost($post_id_like)
  {
    
    $userLiked = new User();
    $user_liked = $userLiked->getUsername();
    $sql = "INSERT INTO likes (username,  post_id) VALUES ('$user_liked ', '$post_id_like')";
     $this->_db->query($sql);
     //update num likes
      $update = "UPDATE codeChat_users SET num_likes =  num_likes  + 1 WHERE user_username = '$user_liked' ";
      $this->_db->query($update);
     
     
     return true;
    
       
  }

public function DisLikePost($post_id_dislike){
  $userLiked = new User();
    $user_liked = $userLiked->getUsername();
  
  $sql = "DELETE FROM likes  WHERE username = '$user_liked ' AND post_id = '$post_id_dislike'";
      $this->_db->query($sql);
    // update num likes
  $update = "UPDATE codeChat_users SET num_likes =  num_likes - 1 WHERE user_username = '$user_liked' ";
    $this->_db->query($update);
  return true;

}

// public function LikePost($post_id_like){
   
//     $userLiked = new User();
//     $user_liked = $userLiked->getUsername();
//     $sql = "SELECT * FROM likes WHERE username = '$user_liked ' AND post_id = '$post_id_like' ";
//     $check = $this->_db->query($sql);
   
//     if ($check->count()) {
//       $sql = "DELETE FROM likes  WHERE username = '$user_liked ' AND post_id = '$post_id_like'";
//       $this->_db->query($sql);
//     // update num likes
//       $update = "UPDATE codeChat_users SET num_likes =  num_likes - 1 WHERE user_username = '$user_liked' ";
//         $this->_db->query($update);
//       return true;
//     }else{
//       $sql = "INSERT INTO likes (username,  post_id) VALUES ('$user_liked ', '$post_id_like')";
//      $this->_db->query($sql);
//      //update num likes
//       $update = "UPDATE codeChat_users SET num_likes =  num_likes  + 1 WHERE user_username = '$user_liked' ";
//       $this->_db->query($update);
     

//      return true;
//     }
       
// }
public function deletePost($post_id_delete){
   $creator = new User();
    $creatorDeleted = $creator->getUsername();

  $delete = $this->_db->delete('code_posts', array('id', '=', $post_id_delete));
  if ($delete) {
    $this->_db->delete('post_comments', array('post_id', '=', $post_id_delete));
    $update = "UPDATE codeChat_users SET num_posts =  num_posts  - 1 WHERE user_username = '$creatorDeleted' ";
      $this->_db->query($update);
    return  true;
  }else{
    return false;
  }
}

public function updatePost($message,$postid)
{
   
  $update = $this->_db->update('code_posts','id', $postid, array(
    'message' => $message
  ));
  return true;

}



//LOAD POST for user timeline
public function loadProfilePosts($data, $limit)
    {
      $output = '';
      $profileUser = $data['profileUsername'];
      $proUser = $this->userpost()->userName($profileUser);
      $userProfileUsername = $proUser->user_username;
     $userLoggedIn = $this->userpost()->data()->user_username;
      $page = $data['page'];

   if ($page == 1)
      $start = 0;
   else
      $start = ($page - 1) * $limit;
      //grabs all posts where deleted is 0
      $sql = "SELECT * FROM code_posts WHERE deleted = 0 AND ((posted_by_id = '$profileUser' AND user_to_timeline = 'none') OR user_to_timeline ='$userProfileUsername') ORDER BY id DESC";
      $this->_db->query($sql);
      $posts = $this->_db->results();
     
      
      // loop through all posts
      if ($posts) {

       $num_iterations = 0; //number of loops checked
      $count = 1;

      foreach ($posts as $allpost) {
      $posted_by = $allpost->posted_by_id;
      // grabs user who made the post
      $userPosted = $this->_db->get('codeChat_users', array('id', '=', $posted_by));
      $userPosted = $userPosted->first(); //returns the user details


        $user_logged_in = new User($userLoggedIn);
       
      
       if ($num_iterations++ < $start)
            continue;
         //once 10 posts loaded break
         if($count > $limit){
            break;
         }else{
            $count++;
         }

         ?>
      <script>
  function toggle<?=$allpost->id;?>(){

    var target = $(event.target);
    if(!target.is("a")){
      var element = document.getElementById('toggleComment<?=$allpost->id;?>');
        if (element.style.display == 'block')
          element.style.display = 'none';
        else
          element.style.display ='block';
    }

    

  }
  
          </script>
         <?
         //count comments of each post
      $comments = new Post();
      $count = $comments->CountComment($allpost->id);
      if ($count) {
        $count = $count;
      }else{
        $count = 0;
      }
      //get likes
      
      $likes = $comments->CountLikes($allpost->id);
      if ($likes) {
        $likes = $likes;
      }else{
        $likes = 0;
      }
       $shares = $comments->CountShares($allpost->id);
      if ($shares) {
        $shares = $shares;
      }else{
        $shares = 0;
      }
        $user_logged = new User();
          if ($allpost->posted_by_id == $user_logged->getUserId()) {
          $button ='
            
              <button class="text-light btn btn-sm btn-danger  delete" title="Delete Post" id="'.$allpost->id.'">
              <i class="fa fa-trash"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;
              <button class="text-light  btn btn-sm btn-warning edit" data-toggle="modal" data-target="#editPost" title="Edit Post" id="'.$allpost->id.'">
              <i class="fa fa-edit"></i></button>
             
          ';
          }else{
            $button = '';
          }


         $output .='
        <div class="status_post">
           <div class="post_profile_pic">
                <img src="'.URLROOT.'conversation/profile/'.$userPosted->profile_pic.'" alt="'.$userPosted->full_name.'" width="50">
            </div>
            <div class="posted_by" style="color:#ACACAC">
                <a href="'.URLROOT.'conversation/ur_profile/'.$userPosted->user_username.'">'.$userPosted->full_name.'</a> &nbsp;<span class="text-sm"><i> &nbsp; '.timeAgo($allpost->date_posted).'</i></span> &nbsp; '.$button.'
            </div>
            <div id="post_content">
                '.$allpost->message.'
           </div>
           </div>

        <hr>
            <div class="row lcs">
          

            <div class="col-md-3">';
          
            $userLiked = new User();
            $user_liked = $userLiked->getUsername();
            $sql = "SELECT * FROM likes WHERE username = '$user_liked ' AND post_id = '$allpost->id'";
            $check = $this->_db->query($sql);
           
            if ($check->count()) {
              $output .= '<button class="btn btn-danger btn-lg showCase unlike" id="'.$allpost->id.'"> <i class="fa fa-thumbs-down"></i>&nbsp;('.$likes.')</button>&nbsp;&nbsp';

            }else{
              $output .= '<button class="btn btn-primary btn-lg showCase like" id="'.$allpost->id.'"> <i class="fa fa-thumbs-up"></i>&nbsp;('.$likes.')</button>&nbsp;&nbsp';

            }
             
            $output .='</div>
             <div class="col-md-3">
              <button class="btn btn-info btn-lg showCase comment_now" onClick="javascript:toggle'.$allpost->id.'()"><i class="fa fa-comment"></i>&nbsp; ('.$count.')</button>&nbsp;&nbsp;
            </div>
             <div class="col-md-3">
              <button class="btn btn-success btn-lg showCase share" id="'.$allpost->id.'"> <i class="fas fa-share-alt"></i>&nbsp;('.$shares.')</button>&nbsp;&nbsp;
            </div>
          </div>
        
        
         <hr>
        
        <div class="post_comment" id="toggleComment'.$allpost->id.'" style="display:none; width:100%;height:auto !important;">
        <iframe src="../comment_frame/'.$allpost->id.'" id="comment_iframe" frameborder="0" style="width:100%;border-radius:5px; min-height:300px !important; overflow:hidden;"></iframe>
        </div>
        <hr/>
        ';

            


      }//end of loop
      if($count > $limit){
         $output .='<input type="hidden" class="nextPage"
          value="'.($page + 1).'" >
          <input type="hidden" class="noMorePosts" value="false" >';
      }else
          $output .='<input type="hidden" class="noMorePosts" value="true" >
          <p class="text-center lead text-light" style="font-size:15px;">No more Post to load</p>';
    }
 return $output;

    }
     




}