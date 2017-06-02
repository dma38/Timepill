<?php

	require("connect.php");
	session_start();
	$postTitle = filter_input(INPUT_POST, "postTitle",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$postContent = filter_input(INPUT_POST, "postContent",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$removeImage = filter_input(INPUT_POST, "image",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

 	if(strtolower($_SESSION['captcha']['code']) != strtolower($_POST["captcha"]))
    {
    	$errorMessage = "Wrong verification code.";
    }
    else
    {
    	if($_POST && isset($_POST["postTitle"]) && isset($_POST["postContent"]))
		{
			



			$query = "UPDATE Post SET postTitle = :postTitle, postContent = :postContent, updatedAt= :updatedAt WHERE postId=:postId";
					$statement = $db -> prepare($query);
					$statement -> bindValue(":postTitle", $postTitle);
					$statement -> bindValue(":postContent", $postContent);
					$statement -> bindValue(":postId", $_POST["postId"]);
					$statement -> bindValue(":updatedAt", $_POST["updatedAt"]);
					$statement -> execute();
			

			if($removeImage != null || isset($removeImage))
			{
				
				$image = "";
				$query = "UPDATE Post SET image = :image WHERE postId=:postId";
					$statement = $db -> prepare($query);
					$statement -> bindValue(":image", $image);
					$statement -> bindValue(":postId", $_POST["postId"]);
					$statement -> execute();
			}
			
		}
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
        <div class = "all_posts">
      	<?php 
          require "nav.php";
          if(!isset($errorMessage))
          {
                header("Location: myDiaries.php");
          }
          else
          {?>
    		 
             <h3><?=$errorMessage ?></h3>
           <form method = "post" action="edit.php">
             	
             	<input type="hidden" name="postId" value="<?=$post["postId"] ?>">
             	<input type="hidden" name="unsavedTitle" value="<?=$postTitle?>">
             	<input type="hidden" name="unsavedContent" value="<?=$postContent?>">
             	<input type="submit" value="Go back">
             </form>
         <?php
          }

       ?>
      </div>
 
</div>

</body>
</html>