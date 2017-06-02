<?php

  require("connect.php");
  session_start();
 
  $errorMessage;

  if(isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1)
  {  

    if(isset($_GET["userId"]))
    {
        $query = "SELECT * FROM User WHERE userId=:userId LIMIT 1";
        $statement = $db -> prepare($query);
        $statement -> bindValue(":userId", $_GET["userId"]);
        $statement -> execute();

        $rows = $statement -> fetchAll();
    }
    else
    {
       $errorMessage = "No users got.";
    }

  }
  else
  {
      $errorMessage = "Please log in first.";
  }
  
?>
<!DOCTYPE html>
<html>
<!-- <pre><?php print_r($_SESSION)?></pre> -->
<head>
    <meta charset="utf-8">
    <title>Home</title>
    
    <link rel="stylesheet" type="text/css" href="nav.css" />
  <div id="content">
    <?php 
          require "nav.php";
          if(!isset($errorMessage))
          {
            ?>


    <form action="process_edit_user.php" method="post">
    <fieldset>
      <legend>Edit User infomation</legend>
      <p>
        <label for="userName">Username</label>
        <input name="userName" id="userName" value="<?= $rows[0]["userName"] ?>"  required/>
      </p>
       <p>
        <label for="password">Password</label>
        <input name="password" id="password" type="password" value="<?= $rows[0]["password"] ?>"  required/>
      </p>
     <p>
        <label for="gender">Gender</label>
        <input name="gender" id="gender" value="<?= $rows[0]["gender"] ?>"  />
      </p>
      <p>
        <label for="description">Description</label>
        <input name="description" id="description" value="<?= $rows[0]["description"] ?>"  />
      </p>
       <p>
       
        <input type="hidden" name="userId" id="userId" value="<?= $_GET["userId"] ?>"  />
      </p>
      <p>
        <input type="submit" value="Update" />  </p>
    </fieldset>
  </form>

 <?php  
      }
      else
      {?>
        <p><?=$errorMessage ?></p>
      <?php
      }
 ?>

      
</div>

</body>

</html>