<?php
  define("BR", "<br/>\n");
   
  
	require("connect.php");
	 session_start();

  
  $errorMessage;

  if(isset($_SESSION["userId"]))
  {
     

      if(isset($_GET["postId"]))
      {
          $query = "SELECT * FROM Post WHERE postId=:postId LIMIT 1";
          $statement = $db -> prepare($query);
          $statement -> bindValue(":postId", $_GET["postId"]);
          $statement -> execute();

          $row = $statement -> fetchAll()[0];


          $query = "SELECT * FROM comment WHERE postId=:postId ORDER BY commentId ";
          $statement = $db -> prepare($query);
          $statement -> bindValue(":postId", $_GET["postId"]);
          $statement -> execute();

          $comments = $statement -> fetchAll();

      }
      else
      {
         $errorMessage = "No post got.";
      }

  }
  else
  {
      $errorMessage = "Please log in first.";
  }
	
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <script type="text/javascript" src="comment.js">
    </script>
    <link rel="stylesheet" type="text/css" href="nav.css" />
  </head>
  <body>
    <div id="content">
        <div class = "all_posts">
      	<?php 
          require "nav.php";
          if(!isset($errorMessage))
          {?>
             
               <div class = "post">
                  <div class = "postContent">
                  <h2><?= $row["postTitle"] ?></h2>
                  <p>Date created:<?=date('F j, Y, g:i a',strtotime($row["dateCreated"])) ?></p>
                  
                  <?=htmlspecialchars_decode($row["postContent"]) ?>
                  <?php
                  $image_name = substr($row["image"], strpos($row["image"],"uploads")+8);
                  if(isset($row["image"]) && $row["image"] !=null)
                  {?>

                   <img src="uploads/<?=$image_name?>" alt="image" >
                  <?php
                  }
                  ?>
                  <input type="button" name="postComment" id="postComment" value="Add a Comment" />
                 
               </div>

           

               <div class="comment">

                <?php foreach($comments as $comment): ?>
               
                  <div class = "commentContent">
                     <?php 
                     $query2 = "SELECT * FROM User WHERE userId = :userId LIMIT 1";
                     $statement2 = $db -> prepare($query2);
                     $statement2 -> bindValue(":userId", $comment["userId"]);
                     $statement2 -> execute();

                     $users =  $statement2 -> fetchAll();
                     if( $users != null)
                     {
                       $user =  $users[0];
                       $userName = $user["userName"];
                     }
                     else
                     {
                       $userName = "account cancelled";
                     }
                   

                     ?>
                     <p class="bold"><?= $userName?></p>
                      <p><?="Posted at ".date('F j, Y, g:i a',strtotime($comment["dateCreated"])) ?></p>
                     <p class="bold"><?= $comment["commentContent"]?></p>
                
                  </div>
             

              <?php endforeach ?>
               </div>
               <div id="addComment">
                    <?php
                       if(isset($_SESSION["userId"]))
                       { ?>
                          <form action="process_post_comment.php" method="post" enctype="multipart/form-data">
                            <fieldset>
                              <legend>Add new comment</legend>
                              <p>
                                <label for="commentContent">Comment</label>
                                <input name="commentContent" id="commentContent" required/>
                              </p>
                             
                                <input type="hidden" name="dateCreated" value="<?= date("Y/m/d H:i:s")?>" />
                                <input type="hidden" name="userId" value="<?=$_SESSION["userId"] ?>" />
                                <input type="hidden" name="postId" value="<?=$row["postId"] ?>" />
                                <input type="submit" value="Post the comment" /> 
                            </fieldset>
                         </form>
                       <?php
                       }
                       else
                       {
                           echo "please log in first";
                       }
                     ?>
              </div>
              <?php
          }
          else
          {
              echo $errorMessage;
          }

       ?>
      </div>
 </div>
</div>

</body>

</html>