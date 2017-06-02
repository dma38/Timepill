
	    <div id="logo"><h1>Timepill Diary - Record every precious moment</h1></div>
		<div id = "Navigation">
			<nav>
				<ul>
					<li><a href = "index.php">Home</a></li>
					<li><a href = "myDiaries.php">My Diaries</a></li>	
					<li><a href = "newDiary.php">New Diary</a></li>
					<li><a href="search.php">Search Keywords</a></li> 
					<?php
					if(isset($_SESSION["isAdmin"]))
					{
						if($_SESSION["isAdmin"] == "1")
						{?>
							<li><a href="manage.php">Manage Users</a></li> 
						<?php
						}
					}
					?>
				</ul>

			</nav>
			
		</div>	
		<div id="welcome">
		<?php
			if(!isset($_SESSION["userId"]))
			{
				require "login.php";
			}
			else
			{?> 
		    Welcome <?=$_SESSION["userName"]?>
		    <span class="right"><a href="signout.php">Sign out</a></span>
		     <?php
			}
		    ?>
		</div>
		
