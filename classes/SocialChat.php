<?php

  class SocialChat extends DB {

      public function selectTable($table)
    {
       $sql = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC";
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

   public function sendPost($message, $posted_by_id, $user_to_timeline)
    {
       $sql = "INSERT INTO `code_posts` (message, posted_by_id, user_to_timeline) VALUES (?, ?, ?)";
       $stmt = $this->_pdo->prepare($sql);
       $stmt->execute([$message, $posted_by_id, $user_to_timeline]);
       return true;
    }


public function loadPosts($data, $limit)
{
  $output = '';
   $page = $data['page'];

   if ($page == 1)
      $start = 0;
   else
      $start = ($page - 1) * $limit;

   $post = $this->selectTable('code_posts');
   if ($post > 0) {

      $num_iterations = 0; //number of loops checked
      $count = 1;
       foreach ($post as $posts) {

        $userowner = $posts->posted_by_id;
        $userPosted = $this->getById('codeChat_users', 'id', $userowner);

        if ($posts->user_to_timeline == 'none') {
            $user_to = '';
        }else{
           $user_to_now =  $this->getById('codeChat_users', 'user_username', $posts->user_to_timeline);
            $user_to = 'to '.$user_to_now->full_name;
        }



        if ($num_iterations++ < $start)
            continue;
         //once 10 posts loaded break
         if($count > $limit){
            break;
         }else{
            $count++;
         }

        //output
           $output .='
        <div class="status_post">
            <div class="post_profile_pic">
                <img src="'.URLROOT.'conversation/profile/'.$userPosted->profile_pic.'" alt="'.$userPosted->full_name.'" width="50">
            </div>
            <div class="posted_by" style="color:#ACACAC">
                <a href="'.URLROOT.'conversation/ur_profile/'.$userPosted->user_username.'">'.$userPosted->full_name.'</a> &nbsp; '.$user_to.'<span class="text-sm"><i> &nbsp; '.timeAgo($posts->date_posted).'</i></span>
            </div>
            <div id="post_content">
                '.$posts->message.'
            </div>
        </div><hr>
                 ';
       }//end foreach
       if($count > $limit){
         $output .='<input type="hidden" class="nextPage"
          value="'.($page + 1).'" >
          <input type="hidden" class="noMorePosts" value="false" >';
      }else
          $output .='<input type="hidden" class="noMorePosts" value="true" >
          <p class="text-center lead text-light" style="font-size:15px;">No more Post to load</p>';
    }
     return  $output;
   }


// end of class
}
