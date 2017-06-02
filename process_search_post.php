<?php

    
 //print_r($_POST);


	require("connect.php");
	 session_start();
   // print_r($_SESSION);
   $errorMessage="";

  $keyword = filter_input(INPUT_POST, "keyword",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if(isset($_POST["category"]))
  {
      $category = filter_input(INPUT_POST, "category",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $rows;
      if($category =="1")
      {
            $query = "SELECT * FROM Post WHERE postTitle LIKE :keyword";
            $statement = $db -> prepare($query);
            $statement -> bindValue(":keyword", "%".$keyword."%");
            $statement -> execute();
            $rows = $statement -> fetchAll();
      }
      elseif($category =="2")
      {
            $query = "SELECT * FROM Post WHERE postContent LIKE :keyword";
            $statement = $db -> prepare($query);
            $statement -> bindValue(":keyword", "%".$keyword."%");
            $statement -> execute();
            $rows = $statement -> fetchAll();
      }

  
  }
  else
  {
      if(!isset($_POST["scope"]) || $_POST["scope"]==null)
      {
        
          $query = "SELECT * FROM Post WHERE postTitle LIKE :keyword OR postContent LIKE :keyword";
          $statement = $db -> prepare($query);
          $statement -> bindValue(":keyword", "%".$keyword."%");
          $statement -> execute();

          $rows = $statement -> fetchAll();
      }
      else if($_POST["scope"] == "on")
      {
        
          $query = "SELECT * FROM Post WHERE userId = :userId AND (postTitle LIKE :keyword OR postContent LIKE :keyword)";
          $statement = $db -> prepare($query);
          $statement -> bindValue(":keyword", "%".$keyword."%");
          $statement -> bindValue(":userId", $_SESSION["userId"]);
          $statement -> execute();

          $rows = $statement -> fetchAll();
      }
    
  }
  if($rows == null)
  {
     $errorMessage = "No result found.";
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
    <?php
     require "nav.php";
  ?> 
    <div id="content">
        <div class = "all_posts">
      	<?php foreach($rows as $post): ?>
      		<div class = "post">
            <?php 


               $query2 = "SELECT * FROM User WHERE userId = :userId LIMIT 1";
               $statement2 = $db -> prepare($query2);
               $statement2 -> bindValue(":userId", $post["userId"]);
               $statement2 -> execute();

               $user =  $statement2 -> fetchAll()[0];
               $userName = $user["userName"];

            ?>
            <div class="author">By: <?= $userName ?></div>
            <div class = "postContent">
            <h2><?= $post["postTitle"] ?></h2>
      
      			<p>Date created: <?=date('F j, Y, g:i a',strtotime($post["dateCreated"])) ?> </p>
	      		<?=htmlspecialchars_decode($post["postContent"]) ?>
            <?php
                  $image_name = substr($post["image"], strpos($post["image"],"uploads")+8);
                  if(isset($post["image"]) && $post["image"] !=null)
                  {?>
                   <img src="uploads/<?=$image_name?>" alt="image" >
                  <?php
                  }
                  ?>
            <a href="readAll.php?postId=<?=$post["postId"]?>">Read All</a>
            </div>

	      		

	      		
	      	</div>
      	<?php endforeach ?>
        <?php
        if($errorMessage !=null && $errorMessage!="")
        {?>
          <h2><?=$errorMessage?></h2>
        <?php
        }
        ?>
      </div>
 
</div>

</body>

</html>