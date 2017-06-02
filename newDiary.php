<?php
  
	require("connect.php");
	 session_start();
include("simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();
 


?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'.editor' });</script>
    <link rel="stylesheet" type="text/css" href="nav.css" />
</head>
<body>
  <div id="content">
  <?php
  require "nav.php";
  ?>
  
    <?php
         if(isset($_SESSION["userId"]))
         { ?>
            <div id="addpostarea">
            <form action="process_post.php" method="post" enctype="multipart/form-data">
    <fieldset>
      <legend>Add new post</legend>
      <p>
        <label for="postTitle">Post Title</label>
        <?php
          if(isset($_POST["unsavedTitle"]))
          {?>
             <p><input name="postTitle" id="postTitle" value="<?=$_POST["unsavedTitle"]?>" required/></p>
          <?php
          }
          else
          {?>
             <input name="postTitle" id="postTitle" required/>
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
            <textarea name="postContent" id="postContent" class="editor"></textarea> 
          <?php
          }
        ?>
      </p>
      <p>
        <input type="hidden" name="dateCreated" value="<?= date("Y/m/d H:i:s")?>" />
        <input type="hidden" name="updatedAt" value="<?= date("Y/m/d H:i:s")?>" />
        <input type="hidden" name="userId" value="<?=$_SESSION["userId"] ?>" />
        <label for="image">Image Filename:</label>
        <input type="file" name="image" id="image">
        <p class="right">
       <img src="<?=$_SESSION['captcha']['image_src']?>" alt="captcha">
        </p>
        <p class="right">
        <label for="captcha">Enter verification code:</label>
        <input name="captcha" id="captcha" required/>
        </p>
        <input class="center" type="submit" value="Add it on" /> 
    </fieldset>
  </form>

         <?php
         }
         else
         {?>
              <span class="error">Please log in first.</span>
              <?php
          }

    ?>
      
    </div>
      
</div>

</body>

</html>