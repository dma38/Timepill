<?php

	require("connect.php");

	if($_POST && isset($_POST["password"]) && isset($_POST["userName"]))
	{
		$password = filter_input(INPUT_POST, "password",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$username = filter_input(INPUT_POST, "userName",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$userId = filter_input(INPUT_POST, "userId",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$gender = filter_input(INPUT_POST, "gender",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description = filter_input(INPUT_POST, "description",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
				echo $password . $username . $userId.$gender.$description;
				$query = "UPDATE User SET userName = :userName, password = :password, gender=:gender, description=:description WHERE userId=:userId";
				$statement = $db -> prepare($query);
				$statement -> bindValue(":userName", $username);
				$statement -> bindValue(":password", $password);
				$statement -> bindValue(":gender", $gender);
				$statement -> bindValue(":description", $description);
				$statement -> bindValue(":userId", $userId);
				$statement -> execute();
		
	
		
		header("Location: manage.php");
	}
	?>
