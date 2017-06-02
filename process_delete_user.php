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

	$userId = filter_input(INPUT_GET, "userId",FILTER_SANITIZE_NUMBER_INT);

			if(is_numeric($userId))
			{
				$query = "DELETE FROM User WHERE userId=:userId";
			    $statement = $db->prepare($query);
			    $statement -> bindvalue(":userId",$_GET["userId"]);
			    $statement->execute();

			    header("Location: manage.php");
			    exit();
		    }
		    else
		    {?>
				<h2>Sorry, invalid input.</h2>
				<h3><a href="manage.php">Click here to go back to my diary.</a></h3>
			<?php	
			}
?>
</body>   
</html>