<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./index.php">Home</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php          
          $query = "SELECT * FROM categories";
          $select_all_categories = mysqli_query($connection, $query);
          while($row = mysqli_fetch_assoc($select_all_categories))
            {
              $category_title = $row['category_title'];
              $category_id = $row['id']; 
              echo "<li><a href='category.php?category_id={$category_id}'>{$category_title}</a></li>";
            }
        ?>
       
        <?php  
          session_start();   
          if(isset($_SESSION['user_role']))
           {
              if($_SESSION['user_role'] == 'Admin')
               {
                 echo " <li><a href='admin'>Admin</a></li>";
                 if(isset($_GET['post_id']))
                   {
                     $post_id = $_GET['post_id'];
                     echo "<li><a href='admin/posts.php?source=edit_post&post_id={$post_id}'>Edit Post</a></li>";  
                   }
              }
           }
          else
          {
             echo " <li><a href='registration.php'>User Registration</a></li>";   
          }
        ?>
               
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>
