<?php
  ob_start();
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
  <h1 class="page-header">Page Heading <small>Secondary Text</small></h1>
  <div class="row">
  
    <!-- Blog Entries Column -->
    <div class="col-md-8">
      <?php
        if(isset($_GET['author']))
          {
            $the_post_author = escape($_GET['author']);
       
        $author_post = mysqli_prepare($connection, "SELECT id, post_title, post_author, post_date, post_image, post_content, post_status FROM posts WHERE post_author = ? AND post_status = ? ORDER BY id DESC ");
             $published = 'published';
             mysqli_stmt_bind_param($author_post, 'ss', $the_post_author, $published);
             mysqli_stmt_execute($author_post);
             confirm_query($author_post);
             mysqli_stmt_store_result($author_post);
             mysqli_stmt_bind_result($author_post, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_status);  

        while(mysqli_stmt_fetch($author_post))
          {
            $post_content = "" . substr(strip_tags($post_content), 0, 300) . "...";
      ?>
      <h2><a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
      <p class="lead">All Post by: <?php echo $post_author; ?></p>
      <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
      <hr>
        <a href="/cms/post/<?php echo $post_id; ?>"><img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt=""> </a>
      <hr>
      <p><?php echo $post_content; ?>  <a class="btn btn-secondary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a></p>
      <hr>
      <?php          
          } // end while there is post
         mysqli_stmt_close($author_post);
         } // close if there is author  get request
        else
         {
            redirect("index.php");
        }
      ?>

                         

    <!-- Pager -->
    <ul class="pager">
      <li class="previous">
        <a href="#">&larr; Older</a>
      </li>
      <li class="next">
        <a href="#">Newer &rarr;</a>
      </li>
    </ul>
  
  </div> <!-- /Blog Entries  -->

<!-- Blog Sidebar Widgets Column -->
<?php
  include "./includes/sidebar.php";
?>

</div><!-- /.row -->
<hr>

<?php
  include "./includes/footer.php";
?>