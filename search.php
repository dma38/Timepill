<?php

   
  
  require("connect.php");
   session_start();

  
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
 <?php
    require "nav.php";
    ?>
      <?php
         if(isset($_SESSION["userId"]))
         { ?>
        <div class="search">
      <form method="post" action="process_search_post.php">
        <fieldset>
          <legend>Search overall</legend>
          <p><label for="keyword">Keyword: </label>
          <input id="keyword" type="text" name="keyword"></p>

           <p><input type="checkbox" name="scope" id="scope">
          <label for="scope">Search only my posts</label></p>
         <p><input type="submit" value="Search!"></p>
        </fieldset>

      </form>
      </div>
       <div class="search">
       <form method="post" action="process_search_post.php">
        <fieldset>
          <legend>Search by Category</legend>
          <p><select name="category">
            <option value="1">Keyword in post title</option>
            <option value="2">Keyword in post content</option>
        
          </select> 
        </p>
             <p><label for="keyword2">Keyword: </label>
              <input id="keyword2" type="text" name="keyword"></p>
              <p><input type="submit" value="Search!">
              </p>
          </fieldset>

      </form>
    </div>
  <?php
         }
         else
         {?>
              <span class="error">Please log in first.</span>
              <?php
          }

    ?>
</div>

</body>

</html>