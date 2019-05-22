<div class="col-md-4">
    
   <!-- Blog Search Well -->
   <div class="well">
     <h4>Blog Search</h4>
     <form action="search.php" method="post">   
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
     <?php else:?>
       <h4>Login</h4>
       <form action="includes/login.php" method="post">   
       <div class="form-group">
        <input type="text" class="form-control" name="username" placeholder="Enter Username"></input>
       </div>
       <div class="input-group">
         <input type="password" class="form-control" name="password" placeholder="Enter Password"></input>
         <span class="input-group-btn">
           <button class="btn btn-primary" type="submit" name="login">Login</button>
         </span>
       </div>
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
               $query = "SELECT * FROM categories";
               $select_all_categories = mysqli_query($connection, $query);
               while($row = mysqli_fetch_assoc($select_all_categories))
                 {
                   $category_title = $row['category_title']; 
                   $category_id = $row['id']; 
            ?>
            <li><a href="category.php?category_id=<?php echo $category_id ?>"><?php echo $category_title; ?></a></li>
            <?php      
                 }
            ?>
          </ul>
        </div>
     </div><!-- /.row -->
   </div><!-- Side Widget Well -->
   <?php
     include "widgets.php";
   ?>
</div>