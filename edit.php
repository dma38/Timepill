<?php

  require("connect.php");
  session_start();
 include("simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();
  $errorMessage;

  if(isset($_SESSION["userId"]))
  {  

    if(isset($_GET["postId"]))
    {
        $query = "SELECT * FROM Post WHERE postId=:postId LIMIT 1";
        $statement = $db -> prepare($query);
        $statement -> bindValue(":postId", $_GET["postId"]);
        $statement -> execute();

        $rows = $statement -> fetchAll();
    }
    else if(isset($_POST["postId"]))
    {
        $query = "SELECT * FROM Post WHERE postId=:postId LIMIT 1";
        $statement = $db -> prepare($query);
        $statement -> bindValue(":postId", $_POST["postId"]);
        $statement -> execute();

        $rows = $statement -> fetchAll();
    }
    else
    {
       $errorMessage = "No post got.";
    }

  }
  else
  {
      $errorMessage = "Please log in first.";
  }
  
?>
<!DOCTYPE html>
<html>
<head>
   
    <title>Home</title>
     <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'.editor' });</script>
    <link rel="stylesheet" type="text/css" href="nav.css" />
  <div id="content">
    <?php 
          require "nav.php";
          if(!isset($errorMessage))
          {
            ?>


    <form action="process_edit_post.php" method="post">
    <fieldset>
      <legend>Edit post</legend>
      <p>
        <label for="postTitle">Post Title</label>
          <?php
          if(isset($_POST["unsavedTitle"]))
          {?>
             <input name="postTitle" id="postTitle" value="<?=$_POST["unsavedTitle"]?>" required/>
          <?php
          }
          else
          {?>
             <input name="postTitle" id="postTitle" value="<?= $rows[0]["postTitle"] ?>"  required/>
          <?php
          }
        ?>
       
      </p>
      <p>
        <label for="postContent">Post Content</label>
         <?php
          if(isset($_POST["unsavedContent"]))
          {?>
             <textarea name="postContent" id="postContent" class="editor" required/><?=$_POST["unsavedContent"]?></textarea> 
          <?php
          }
          else
          {?>
             <textarea class="editor" name="postContent" id="postContent" required><?= $rows[0]["postContent"] ?></textarea> 
          <?php
          }
        ?>
       
      </p>
      <p>
        <input type="hidden" name="dateCreated" value="<?= $rows[0]["dateCreated"]?>" />
        <input type="hidden" name="updatedAt" value="<?= date("Y/m/d H:i:s")?>" />
        <input type="hidden" name="postId" value="<?=$rows[0]["postId"] ?>" />
         <?php
                 
                  if(isset($rows[0]["image"]) && $rows[0]["image"] !=null)
                  {  
                    $image_name = substr($rows[0]["image"], strpos($rows[0]["image"],"uploads")+8);
                    ?>

                   <img src="uploads/<?=$image_name?>" alt="image" >
                   <input type="checkbox" name="image">Remove the image</input>
                  <?php
                  }
                  ?>
            
        <img src="<?=$_SESSION['captcha']['image_src']?>" alt="captcha">
         
        <label for="captcha">Enter verification code:</label>
        <input name="captcha" id="captcha" required/>
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