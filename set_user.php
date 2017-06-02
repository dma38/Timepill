<?php
	 require("connect.php");
   session_start();
print_r($_GET);
  
  $errorMessage;

  $userId = filter_input(INPUT_GET, "userId",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if(isset($_SESSION["isAdmin"]) && is_numeric($userId))
  {
  	  
      $query = "UPDATE User SET isAdmin = 0 WHERE userId = :userId";
      $statement = $db -> prepare($query);
      $statement -> bindValue(":userId", $userId);
      $statement -> execute();
  
  	  header("Location: manage.php");

  }
  else
  {

      $errorMessage = "invalid.";
      echo $errorMessage;
  }
  

?>