<?php 
  if(if_it_is_method('post'))
   {
     if(isset($_POST['username']) && isset($_POST['password'])) 
      {
         if(($_POST['username'] != '' || $_POST['username'] != null) && ($_POST['password'] != '' || $_POST['password'] != null))
          {
            $username = escape($_POST['username']);
            $password = escape($_POST['password']);
            login_user($username, $password);
          }
         else
          {
             echo "Please enter a username and password";
          }
      }  
   }

?>


<div class="col-md-4">
    
   <!-- Blog Search Well -->
   <div class="well">
     <h4>Blog Search</h4>
     <form action="http://localhost/cms/search.php" method="post">   
       <div class="input-group">
         <input type="text" class="form-control" name="search">
         <span class="input-group-btn">
           <button class="btn btn-default" type="submit" name="submit">
             <span class="glyphicon glyphicon-search"></span>
           </button>
         </span>
       </div>
     </form><!-- search form -->
   </div>
                
   <!-- Login -->
   <div class="well">
    <?php if(isset($_SESSION['user_role'])):?>
       <h4>Logged in as: <?php echo $_SESSION['username']; ?> </h4>
       <a href='http://localhost/cms/includes/logout.php' class='btn btn-primary'>Logout</a>
     <?php else:?>
      
       <h4>Login</h4>
       <form method="post">   
       <div class="form-group">
        <input type="text" class="form-control" name="username" placeholder="Enter Username"></input>
       </div>
       <div class="input-group">
         <input type="password" class="form-control" name="password" placeholder="Enter Password"></input>
         <span class="input-group-btn">
           <button class="btn btn-primary" type="submit" name="login">Login</button>
         </span>
       </div>
       <div class="form-group"><a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password</div>
     </form><!-- LOGIN form -->
     
    <?php endif; ?>
   </div>
                
   <!-- Blog Categories Well -->
   <div class="well">
     <h4>Blog Categories</h4>
     <div class="row">
        <div class="col-lg-12">
          <ul class="list-unstyled">
            <?php          
               $select_categories = mysqli_prepare($connection, "SELECT id, category_title FROM categories");
               mysqli_stmt_execute($select_categories);
               confirm_query($select_categories);
               mysqli_stmt_bind_result($select_categories, $category_id, $category_title);
               while(mysqli_stmt_fetch($select_categories))
                 {
            ?>
                    <li><a href="/cms/category/<?php echo $category_id ?>"><?php echo $category_title; ?></a></li>
            <?php      
                 }
              mysqli_stmt_close($select_categories);
            ?>
          </ul>
        </div>
     </div><!-- /.row -->
   </div><!-- Side Widget Well -->
   <?php
     include "widgets.php";
   ?>
</div>