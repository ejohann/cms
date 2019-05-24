<?php
session_start(); 
 $registration_class = '';
 $contact_class = '';
 $home_class = '';
 $home = 'index.php';
 $contact = 'contact.php';
 $registration = 'registration.php';
 $page_name = basename($_SERVER['PHP_SELF']);
 
 if($page_name == $registration)
    {
      $registration_class = 'active';  
    }
  else if($page_name == $contact)
    {
        $contact_class = 'active';  
    }   
  else if($page_name == $home)
    {
        $home_class = 'active';  
    }              
?>
 
 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header ">
   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
           <li class='<?php echo $home_class; ?>'>  <a href="/cms">Home</a></li>
        <?php          
          $query = "SELECT * FROM categories";
          $select_all_categories = mysqli_query($connection, $query);
          while($row = mysqli_fetch_assoc($select_all_categories))
            {
              $category_title = $row['category_title'];
              $category_id = $row['id']; 
              
               $category_class = '';
             
              if(isset($_GET['category_id']) && $_GET['category_id'] == $category_id)
               {
                 $category_class = 'active';   
               }
              echo "<li class='{$category_class}'><a href='/cms/category/{$category_id}'>{$category_title}</a></li>";
            }
        ?>
        <li  class='<?php echo $contact_class; ?>'><a href='/cms/contact'>Contact</a></li>  
        <?php  
            
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
             echo " <li class='{$registration_class}'><a href='/cms/registration'>User Registration</a></li>";   
          }
        ?>
             
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>
