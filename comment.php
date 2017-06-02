

  <div id="addComment">
    <?php
         if(isset($_SESSION["userId"]))
         { ?>
            <form action="process_post.php" method="post" enctype="multipart/form-data">
              <fieldset>
                <legend>Add new comment</legend>
                <p>
                  <label for="comment">Comment</label>
                  <input name="comment" id="comment" required/>
                </p>
               
                  <input type="hidden" name="dateCreated" value="<?= date("Y/m/d H:i:s")?>" />
                  <input type="hidden" name="userId" value="<?=$_SESSION["userId"] ?>" />
                  <input type="hidden" name="postId" value="<?=$row["postId"] ?>" />
                  <input type="submit" value="Post the comment" />  </p>
              </fieldset>
           </form>
         <?php
         }
         else
         {
             echo "please log in first";
         }
       ?>
</div>