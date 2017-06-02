


<?php
 require("connect.php");
	session_unset(); 
$message="";

	if($_POST && isset($_POST["email"]) && isset($_POST["password"]))
	{


		$password = filter_input(INPUT_POST, "password",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password2 = filter_input(INPUT_POST, "password2",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		$userName = filter_input(INPUT_POST, "userName",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		if($password != $password2)
		{
			$message = "The passwords are inconsistent.";	
		}
		else
		{

			if(!filter_input(INPUT_POST,"email",FILTER_VALIDATE_EMAIL) || strlen(trim($password)) == 0 ||strlen(trim($userName))==0 )
			{
				$message = "Please enter valid input and try again.";

			}
			else
			{
				  $queryU = "SELECT * FROM User WHERE email = :email LIMIT 1";
				  $statement = $db -> prepare($queryU);
				  $statement -> bindValue(":email",$_POST["email"]);
				  $statement -> execute();
				  $users =  $statement -> fetchAll();

				if(isset($users) && $users!= null)
				{
					$message = "Sorry, the same email exists. Please log in.";
				
				}
				else
				{
					 $hashAndSalt = password_hash($_POST["password"],PASSWORD_BCRYPT);

		    	    $query = "INSERT INTO User (email, password, userName,isAdmin) VALUES (:email, :password, :userName, 0)";
					$statement = $db -> prepare($query);
					$statement -> bindValue(":email", $_POST["email"]);
					$statement -> bindValue(":password", $hashAndSalt);
					$statement -> bindValue(":userName", $userName);
					$statement -> execute();
				}
				
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
     
    <div id="content">
    	  <?php
     require "nav.php";
      ?>
        <div class = "all_posts">
        	<?php
        	if($message != "")
        	{?>
        		<h3><?=$message ?></h3>
        		<p><a href="signUp.php">Go Back to register again.</a></p>
        <?php

            }

            else
            {
            ?>
              <h3>Welcome to Timepill, <?=$userName ?>. </h3>
              <p>You have successfully signed up with this email <?=$_POST["email"] ?> . </p>
              <p>You can sign in to Timepill now.</p>
     		<?php 
     		}
     		?>
      </div>
 
</div>

</body>

</html>