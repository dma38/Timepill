 <?php
  
  require("connect.php");

  
  $message;
  $email = $_POST["email"];


  
  $email = filter_input(INPUT_POST, "email",FILTER_SANITIZE_EMAIL);
  $user_password = filter_input(INPUT_POST, "password",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $query = "SELECT * FROM User WHERE email = :email LIMIT 1";
  $statement = $db -> prepare($query);
  $statement -> bindValue(":email", $email);
  $statement -> execute();
  $rows =  $statement -> fetchAll();

if(isset($rows) && $rows!= null)
{
  $row = $rows[0];
  $hashAndSalt = $row["password"];
  $id = $row["userId"];
  $userName = $row["userName"];
  
  if (!isset($_POST['email']) || !isset($_POST['password'])

      ||  (password_verify($user_password,$hashAndSalt))) {

    $message = "Invalid credentials.";
  }
  else
  {
  session_start();
  $_SESSION["userId"] = $id;
  $_SESSION["userName"] = $userName;
  $_SESSION["isAdmin"] = $row["isAdmin"];

  header("Location:index.php");
}
}
else
{
  $message = "Please Sign up first.";
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
   <h1><?=$message ?></h1>
</div>
</body>

</html>