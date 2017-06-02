<?php

	require("connect.php");
	 session_start();

	 include 'ImageResize.php';
	 $postTitle = filter_input(INPUT_POST, "postTitle",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	 $postContent = filter_input(INPUT_POST, "postContent",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(strtolower($_SESSION['captcha']['code']) != strtolower($_POST["captcha"]))
    {
    	$errorMessage = "Wrong verification code.";
    }
    else
    {
    	if($_POST && isset($_POST["postTitle"]) && isset($_POST["postContent"]))
		{
			
			

			function file_is_an_image($temporary_path, $new_path) {
	        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
	        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
	        
	        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
	        $actual_mime_type        = getimagesize($temporary_path)['mime'];
	        
	        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
	        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
	        
	        return $file_extension_is_valid && $mime_type_is_valid;
	    }

		    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
		       $current_folder = dirname(__FILE__);
		       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
		       return join(DIRECTORY_SEPARATOR, $path_segments);
		    }

		     $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

		    if ($image_upload_detected) { 
		        $image_filename       = $_FILES['image']['name'];
		        $temporary_image_path = $_FILES['image']['tmp_name'];
		        $new_image_path       = file_upload_path($image_filename);

		        if (file_is_an_image($temporary_image_path, $new_image_path)) { 
		            move_uploaded_file($temporary_image_path, $new_image_path);
		            $image = new \Eventviva\ImageResize('uploads/'.$image_filename);
					$image->crop(500, 300);

					$image->save('uploads/Resize_'.$image_filename.'.jpg');

					
		            $query = "INSERT INTO Post (postTitle, postContent, dateCreated, userId, image) VALUES (:postTitle, :postContent, :dateCreated, :userId,:image)";
					$statement = $db -> prepare($query);
					$statement -> bindValue(":postTitle", $postTitle);
					$statement -> bindValue(":postContent", $postContent);
					$statement -> bindValue(":dateCreated", $_POST["dateCreated"]);
					$statement -> bindValue(":userId", $_POST["userId"]);
					$statement -> bindValue(":image", 'uploads/Resize_'.$image_filename.'.jpg');
					$statement -> execute();
		        }
		        else
		        {
		        	$new_image_path = "";
		        	$errorMessage = "Please upload valid images. (Only files end with 'gif', 'jpg', 'jpeg', 'png' Allowed.)";

		        }
		    }
		    else
		    {
		    	$query = "INSERT INTO Post (postTitle, postContent, dateCreated, userId, updatedAt) VALUES (:postTitle, :postContent, :dateCreated, :userId,:updatedAt)";
				$statement = $db -> prepare($query);
				$statement -> bindValue(":postTitle", $postTitle);
				$statement -> bindValue(":postContent", $postContent);
				$statement -> bindValue(":dateCreated", $_POST["dateCreated"]);
				$statement -> bindValue(":updatedAt", $_POST["updatedAt"]);
				$statement -> bindValue(":userId", $_POST["userId"]);
				$statement -> execute();

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
  </head>
  <body>
    <div id="content">
        <div class = "all_posts">
      	<?php 
          require "nav.php";
          if(!isset($errorMessage))
          {
                header("Location: myDiaries.php");
          }
          else
          {?>
    		 
             <h3><?=$errorMessage ?></h3>
             <!-- <button onclick="history.go(-1);return true;">Go Back</button> -->
             <form method = "post" action="newDiary.php">
             	<input type="hidden" name="unsavedTitle" value="<?=$postTitle?>">
             	<input type="hidden" name="unsavedContent" value="<?=$postContent?>">
             	<input type="submit" value="Go back">
             </form>
         <?php
          }

       ?>
      </div>
 
</div>

</body>

</html>