<?php

   
  
	require("connect.php");
	 session_start();

  
  $errorMessage;

  if(isset($_SESSION["userId"]))
  {
      $query = "SELECT * FROM Post WHERE userId=:userId ORDER BY postId";
      $statement = $db -> prepare($query);
      $statement -> bindValue(":userId", $_SESSION["userId"]);
      $statement -> execute();

      $rows = $statement -> fetchAll();

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
    <link rel="stylesheet" type="text/css" href="nav.css" />
  </head>
  <body>
    <div id="content">
      <?php
        require "nav.php";
      ?>
        <div class = "all_posts">
      	<?php 
        
          if(!isset($errorMessage))
          {
               foreach($rows as $post): ?>
               <div class = "post">
                  <div class = "postContent">
                  <h2><?= $post["postTitle"] ?></h2>
                  <p>Date created:<?=date('F j, Y, g:i a',strtotime($post["dateCreated"])) ?></p>
                  <?=htmlspecialchars_decode($post["postContent"]) ?>
                  <?php
                  $image_name = substr($post["image"], strpos($post["image"],"uploads")+8);
                  if(isset($post["image"]) && $post["image"] !=null)
                  {?>
                <p>
                   <img src="uploads/<?=$image_name?>" alt="image" >
                 </p>
                  <?php
                  }
                  ?>
                  <a href="readAll.php?postId=<?=$post["postId"]?>">Read All</a>
           
                  <a href="edit.php?postId=<?=$post["postId"] ?>">Edit</a>
                  <a href="process_delete.php?postId=<?=$post["postId"] ?>" onclick="return confirm('Are you sure you want delete this post?');">Delete</a>

                  </div>
               </div>
              <?php endforeach ?>
              <?php
          }
          else
          {?>
              <span class="error"><?=$errorMessage?></span>
              <?php
          }


       ?>
      </div>
 
</div>

</body>

</html>