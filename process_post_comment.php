<?php

	require("connect.php");
	 session_start();


	if($_POST && isset($_POST["commentContent"]))
	{
		$commentContent = filter_input(INPUT_POST, "commentContent",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	            $query = "INSERT INTO comment (commentContent, dateCreated, userId, postId) VALUES (:commentContent, :dateCreated, :userId, :postId)";
				$statement = $db -> prepare($query);
				$statement -> bindValue(":commentContent", $commentContent);
				$statement -> bindValue(":dateCreated", $_POST["dateCreated"]);
				$statement -> bindValue(":userId", $_POST["userId"]);
			    $statement -> bindValue(":postId", $_POST["postId"]);
				$statement -> execute();
	      
	    }
	    else
	    {
	    	

	    }



		
	?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    
    <link rel="stylesheet" type="text/css" href="nav.css" />
  </head>
  <body>
    <div id="content">
        <div class = "all_posts">
      	<?php 
          require "nav.php";
          if(!isset($errorMessage))
          {?>
      		<h2>Commented successfully.</h2>
      		<a href="readAll.php?postId=<?=$_POST["postId"]?>">Click to go back</a>
          <?php     
          }
          else
          {?>
    		  <script>
				function goBack() {
				    window.history.back();
				}
			</script>
             <h3><?=$errorMessage ?></h3>
             <button onclick="goBack()">Go Back</button>
             
         <?php
          }

       ?>
      </div>
 
</div>

</body>

</html>