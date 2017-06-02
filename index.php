<?php

    
  
	require("connect.php");
	 session_start();

 // print_r($_SESSION);
  if(isset($_GET['sort']) && $_GET['sort']=='title')
  {
     $query = "SELECT * FROM Post ORDER BY TRIM(postTitle)";
  }
  elseif(isset($_GET['sort']) && $_GET['sort']=='create')
  {
     $query = "SELECT * FROM Post ORDER BY dateCreated DESC";
  }
  elseif(isset($_GET['sort']) && $_GET['sort']=='update')
  {
     $query = "SELECT * FROM Post ORDER BY updatedAt DESC"; 
  }
  else
  {
     $query = "SELECT * FROM Post ORDER BY postId DESC";
  }
	//$query = "SELECT * FROM Post ORDER BY postId DESC";
  $statement = $db -> prepare($query);
  $statement -> execute();

	$rows = $statement -> fetchAll();

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
           <h3>Sorted By: </h3>
        <a class="iso" href="index.php?sort=<?="title"?>">Title</a>
        <a class="iso" href="index.php?sort=<?="create"?>">Created At</a>
        <a href="index.php?sort=<?="update"?>">Updated At</a>
         <div class = "all_posts">
      	<?php foreach($rows as $post): ?>
      		<div class = "post">
            <?php 
            
               $query2 = "SELECT * FROM User WHERE userId = :userId LIMIT 1";
               $statement2 = $db -> prepare($query2);
               $statement2 -> bindValue(":userId", $post["userId"]);
               $statement2 -> execute();
               $users = $statement2 -> fetchAll();
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
            <div class="author">By: <?= $userName ?></div>
            <div class = "postContent">
            <h2><?= $post["postTitle"] ?></h2>
      
      			<p>Date created: <?=date('F j, Y, g:i a',strtotime($post["dateCreated"])) ?> </p>
            <p>Last Updated At: <?=date('F j, Y, g:i a',strtotime($post["updatedAt"])) ?> </p>
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
            </div>

	      		

	      		
	      	</div>
      	<?php endforeach ?>
       
      </div>
 
</div>

</body>

</html>