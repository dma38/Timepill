<?php



  require("connect.php");
   session_start();


  $errorMessage;

  if(isset($_SESSION["isAdmin"]))
  {
      $query = "SELECT * FROM User ORDER BY userId";
      $statement = $db -> prepare($query);
      $statement -> execute();

      $rows = $statement -> fetchAll();

  }
  else
  {
      $errorMessage = "Please log in as an Administrator first.";
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

              ?>
                 <div class = "post">

              <table>
              <tr>
                <th>Email</th>
                <th>Username</th>
                <th>Gender</th>
                <th>Description</th>
                <th>Identity</th>
                <th>Permission</th>
                <th>Management</th>
              </tr>

              <?php
               foreach($rows as $user): ?>

                    <tr>
                     <td><?= $user["email"]?></td>
                     <td><?= $user["userName"]?></td>
                     <td><?= $user["gender"]?></td>
                     <td><?= $user["description"]?></td>
                     <td>
                 <?php
                    if($user["isAdmin"] == "1")
                    {
                      echo "Admin";
                    }
                    else
                    {
                      echo "User";
                    }
                 ?>
                 </td>

                  <td>
                    <?php
                    if($user["isAdmin"] == "0")
                    {?>
                      <a href="set_admin.php?userId=<?=$user["userId"] ?>">Set as Admin</a>
                    <?php
                    }
                    else
                    {?>
                       <a href="set_user.php?userId=<?=$user["userId"] ?>">Set back to User</a>
                    <?php
                    }
                 ?></td>
                 <td>
                  <a href="edit_user.php?userId=<?=$user["userId"] ?>">Edit</a>
                  <a href="process_delete_user.php?userId=<?=$user["userId"] ?>" onclick="return confirm('Are you sure you want delete this user?');">Delete</a>
                  </td>
                  </tr>
              <?php endforeach ?>

              </table>
              <?php
          }
          else
          {
              echo $errorMessage;
          }


       ?>

     </div>
   </div>

</div>

</body>

</html>
