<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="nav.css" />
    
</head>
  <?php
     require "nav.php";
  ?>
  <body>    
    <div id="content">
    <?php
	require "connect.php";

	$postId = filter_input(INPUT_GET, "postId",FILTER_SANITIZE_NUMBER_INT);

			if(is_numeric($postId))
			{
				$query = "DELETE FROM Post WHERE postId=:postId";
			    $statement = $db->prepare($query);
			    $statement -> bindvalue(":postId",$_GET["postId"]);
			    $statement->execute();

			    header("Location: myDiaries.php");
			    exit();
		    }
		    else
		    {?>
				<h2>Sorry, invalid input.</h2>
				<h3><a href="myDiaries.php">Click here to go back to my diary.</a></h3>
			<?php	
			}
?>
</body>   
</html>