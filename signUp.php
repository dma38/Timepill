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
    <div id="content">
      
      <div id="logo"><h1>Timepill Diary - Record every precious moment</h1></div>
    <div id = "Navigation">
      <nav>
        <ul>
          <li><a href = "index.php">Home</a></li>
          <li><a href = "myDiaries.php">My Diaries</a></li> 
          <li><a href = "newDiary.php">New Diary</a></li>
         <li><a href="search.php">Search Keywords</a></li> 
        </ul>

      </nav>
      
    </div>  
<form action="signup_post.php" method="post">
    <fieldset>
      <legend>Sign up to be our customers!</legend>
      <p>
        <label for="email">Email:</label>
        <input name="email" id="email" required/>
      </p>
      <p>
        <label for="password">Password</label>
    <input name="password" id="password" type = "password" required/>
      </p>
      <p>
        <label for="password2">Re-Input Password</label>
    <input name="password2" id="password2" type = "password" required/>
      </p>
      <p>
        <label for="userName">Nickname:</label>
        <input name="userName" id="userName" type = "text" required/>
      </p>
      <p>
        
        <input type="submit" value="SIGN UP" />  </p>
    </fieldset>
  </form>
      
</div>

</body>

</html>