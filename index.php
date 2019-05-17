<?php
  include "./includes/db.php";
  include "./includes/header.php";
?>
        
<!-- Navigation -->
<?php
  include "./includes/navigation.php";
?>
    
<!-- Page Content -->
<div class="container">
  <div class="row">
    <h1 class="page-header">Page Heading <small>Secondary Text</small></h1>

    <!-- Blog Entries Column -->
    <div class="col-md-8">
      <?php
        
        $post_count_query = "SELECT * FROM posts";
        $find_count_query = mysqli_query($connection, $post_count_query);
        if(!$find_count_query)
         {
           die("QUERY FAILED: " . mysqli_error($connection));
         }
    echo $post_count = mysqli_num_rows($find_count_query);
        
        
        $query = "SELECT * FROM posts";
        $select_all_posts = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_all_posts))
          {
            $post_id = $row['id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = "" . substr($row['post_content'], 0, 100) . "...";
            $post_status = $row['post_status'];
            if($post_status == 'published')
              {
      ?>
                <h2><a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
                <p class="lead">by <a href="author_post.php?author=<?php echo $post_author; ?>&post_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a></p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?post_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></img></a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
            <?php          
              }
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