<?php
  include "./includes/db.php";
  include "./includes/header.php";
  include "./admin/functions.php";
?>
  
  <!-- Navigation -->
  <?php
    include "./includes/navigation.php";
  ?>
           
  <!-- Page Content -->
  <div class="container">
    <h1 class="page-header">Page Heading <small>Secondary Text</small> </h1>
    <div class="row">
      
      <!-- Blog Entries Column -->
      <div class="col-md-8">
        <?php
          if(isset($_GET['category_id']))
            {
              $the_category_id = escape($_GET['category_id']); 
              $statement_one = mysqli_prepare($connection, "SELECT id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");
              $published = "published";
              if(isset($statement_one))
               {
                 mysqli_stmt_bind_param($statement_one, "is", $the_category_id, $published);
                 mysqli_stmt_execute($statement_one);
                 mysqli_stmt_store_result($statement_one);
                 mysqli_stmt_bind_result($statement_one, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
               }
               


              if(mysqli_stmt_num_rows($statement_one) === 0)
                {
                   echo "<h1 class='text-center'>No posts to display</h1>"; 
                }
               else
                {
                   while(mysqli_stmt_fetch($statement_one))
               {
                 $post_content = "" . substr($post_content, 0, 100) . "...";
        ?>
                 <h2><a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
                 <p class="lead">by <a href="/cms/authorpost/<?php echo $post_author; ?>/<?php echo $post_id; ?>"><?php echo $post_author; ?></a></p>
                 <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                 <hr>
                  <a href="/cms/post/<?php echo $post_id; ?>"><img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt=""></img></a>
                 <hr>
                 <p><?php echo $post_content; ?></p>
                 <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                 <hr>
        <?php          
               }
               }
              mysqli_stmt_close($statement_one);
            }
          else
            {
              header("Location: index.php");   
            }
        ?>
             
        <!-- Pager -->
        <ul class="pager">
          <li class="previous"><a href="#">&larr; Older</a></li>
          <li class="next"><a href="#">Newer &rarr;</a></li>
        </ul>

      </div>

      <!-- Blog Sidebar Widgets Column -->
      <?php
        include "./includes/sidebar.php";
      ?>

    </div><!-- /.row -->
    <hr>

<?php
   include "./includes/footer.php";
?>