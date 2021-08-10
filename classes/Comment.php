<?php 

/**
 * 
 */
class Comment
{
	
	private  $_db,
             $_commentby,
             $_postID;


  function __construct()
  {
    $this->_db = Database::getInstance();
   $this->_commentby = new User();
   $this->_postID = new Post();


  }

  public function sendComment($commentParent,$commentBody,$postid)
  {
  	$commented_by = $this->_commentby->getUsername();
  	
  	$this->_db->insert('post_comments', array(
  		'comment_parent' => $commentParent,
  		'commented_by' => $commented_by,
  		'comment_body' =>  $commentBody,
  		'post_id' => $postid
  	));

  	return true;

  }


 public function loadComments($postid)
 {
 	$output = '';
 	 $parent = 0;
	 $sql = "SELECT * FROM post_comments WHERE comment_parent = '$parent' AND post_id = '$postid' ORDER BY id DESC ";
  	$com = $this->_db->query($sql);
 	 // $com = $this->_db->get('post_comments', array('post_id', '=', $postid));
  	if ($com->count()) {
  		 $result = $this->_db->results();
  foreach ($result as $postcomment) {
  	 
  	 $commented_by = $postcomment->commented_by;
      // grabs user who made the post
      $userCommented = $this->_db->get('codeChat_users', array('user_username', '=', $commented_by));
      $userCommented = $userCommented->first(); //returns the user details

      

        //grabs and check if someone was mentioed on the post
      // if ($postcomment->user_to_timeline == 'none') {
      //   $user_to_timeline = '';
      // }else{

      //   $mentioned = new User($postcomment->user_to_timeline);
      //   $user_to_name = $mentioned->getAnyUsername();
      //   $user_to_username = $mentioned->getUsername();
      //   $user_to .= 'to <a href="'.URLROOT.'conversation/ur_profile/'.$user_to_username.'">'.$user_to_name.'</a>';
      //      //check if user is closed
      //   if ($mentioned->isUserClosed($postcomment->posted_by_id) == 0) {
      //     continue;
      //   }


      // }
  	 $output .='
        <div class="status_post text-light">

            <div class="post_profile_pic">
                <img src="'.URLROOT.'conversation/profile/'.$userCommented->profile_pic.'" alt="'.$userCommented->full_name.'" width="50">
            </div>
            <div class="posted_by" style="color:#ACACAC">
                <a href="'.URLROOT.'conversation/ur_profile/'.$userCommented->user_username.'" class="text-warning">'.$userCommented->full_name.'</a> &nbsp;<span class="text-sm"><i> &nbsp; '.timeAgo($postcomment->comment_date).'</i></span>
            </div>
            <div id="post_content">
                '.$postcomment->comment_body.'
            </div><hr>
            <div class="row lcd">';
            $output .= '<div class="col-sm-4">';
            $likeCount = $this->_db->get('comment_likes',array('comment_id', '=', $postcomment->id));
            if ($likeCount->count()) {
            	$likeCounted = $likeCount->count();
            }else{
            	$likeCounted = 0;
            }
            $userLiked = new User();
		    $user_liked = $userLiked->getUsername();

		    $sql = "SELECT * FROM comment_likes WHERE username = '$user_liked ' AND comment_id = '$postcomment->id' ";
		    $check = $this->_db->query($sql);
		   
		    if ($check->count()) {
		    	$output .= '<button class="btn btn-danger btn-xs showCase DislikeComment" style="font-size:12px !important;" id="'.$postcomment->id.'"> Unlike&nbsp;('.$likeCounted.')</button>';
		    }else{
		    	$output .= '<button class="btn btn-primary btn-xs showCase likeComment" style="font-size:12px !important;" id="'.$postcomment->id.'"> Like&nbsp;('.$likeCounted.')</button>';
		    }
             
          
            $output .= ' </div>
            
             <div class="col-sm-4">
              <button class="btn btn-success btn-xs showCase reply" style="font-size:12px !important;" id="'.$postcomment->id.'"> Reply</button>
            </div>
            </div>
        </div>


        <hr>
  	';
   $output .= $this->get_reply_comment($postcomment->id);
  }//end of foreach loop
  	echo $output;


  	}else{
  		echo '<h3 class="text-cneter text-light">No Comments Yet</h3>';
  	}//end of count


 }//end of function

public function get_reply_comment($parent_id = 0, $marginleft = 0){
    $output = '';
     $comReply = $this->_db->get('post_comments', array('comment_parent', '=', $parent_id));


    if ($parent_id == 0) {
      $marginleft = 0;
    }else{
      $marginleft = $marginleft + 48;
    }
    if ($comReply->count()) {
    	$result = $this->_db->results();
      foreach ($result as $row) {
      	$replied_by = $row->commented_by;
      // grabs user who made the post
      $userReplied = $this->_db->get('codeChat_users', array('user_username', '=', $replied_by));
      $userReplied = $userReplied->first();
      	$output .='
        <div class="status_post text-light" style="margin-left:'.$marginleft.'px">

            <div class="post_profile_pic">
                <img src="'.URLROOT.'conversation/profile/'.$userReplied->profile_pic.'" alt="'.$userReplied->full_name.'" width="50">
            </div>
            <div class="posted_by" style="color:#ACACAC">
                <a href="'.URLROOT.'conversation/ur_profile/'.$userReplied->user_username.'" class="text-warning">'.$userReplied->full_name.'</a> &nbsp;<span class="text-sm"><i> &nbsp; '.timeAgo($row->comment_date).'</i></span>
            </div>
            <div id="post_content">
                '.$row->comment_body.'
            </div><hr>
            <div class="row lcd">
            <div class="col-sm-4">';

             $likeCount = $this->_db->get('comment_likes',array('comment_id', '=', $row->id));
            if ($likeCount->count()) {
            	$likeCounted = $likeCount->count();
            }else{
            	$likeCounted = 0;
            }
            $userLiked = new User();
		    $user_liked = $userLiked->getUsername();

		    $sql = "SELECT * FROM comment_likes WHERE username = '$user_liked ' AND comment_id = '$row->id' ";
		    $check = $this->_db->query($sql);
		   
		    if ($check->count()) {
		    	$output .= '<button class="btn btn-danger btn-xs showCase DislikeCommentReply" style="font-size:12px !important;" id="'.$row->id.'"> Unlike&nbsp;('.$likeCounted.')</button>';
		    }else{
		    	$output .= '<button class="btn btn-primary btn-xs showCase likeCommentReply" style="font-size:12px !important;" id="'.$row->id.'"> Like&nbsp;('.$likeCounted.')</button>';
		    }
             

            $output .='</div>
            
             <div class="col-sm-4">
              <button class="btn btn-success btn-xs showCase reply" style="font-size:12px !important;" id="'.$row->id.'"> Reply</button>
            </div>
            </div>
        </div>


        <hr>
  	';
        
        $output .= $this->get_reply_comment($row->id, $marginleft);
      }
    }
    return $output;

  }

public function LikeComment($comment_id_like)
  {
  	
    $userLiked = new User();
    $user_liked = $userLiked->getUsername();
    $sql = "INSERT INTO comment_likes (username,  comment_id) VALUES ('$user_liked ', '$comment_id_like')";
     $this->_db->query($sql);
     //update num likes
      $update = "UPDATE codeChat_users SET num_likes =  num_likes  + 1 WHERE user_username = '$user_liked' ";
      $this->_db->query($update);
     
     return true;
    
       
  }

public function DisLikeComment($comment_id_dislike){
	$userLiked = new User();
    $user_liked = $userLiked->getUsername();
  
  $sql = "DELETE FROM comment_likes  WHERE username = '$user_liked ' AND comment_id = '$comment_id_dislike'";
  $this->_db->query($sql);
// update num likes
  $update = "UPDATE codeChat_users SET num_likes =  num_likes - 1 WHERE user_username = '$user_liked' ";
    $this->_db->query($update);
  return true;
   
}


}//end of class
