<?php
   include "./includes/db.php";
   include "./includes/header.php";
   include "./admin/functions.php";
?>

<!-- Navigation -->
<?php include "./includes/navigation.php"; ?>

<!-- PAGE BANNER HERE -->
<h1 class="page-header">Page Heading <small> Secondary Text</small></h1>

<!-- Page Content -->
<div class="container">
  <div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">
      <?php
        if(isset($_POST['submit']))
          {
            $search = escape($_POST['search']); 
            $search_query = mysqli_prepare($connection, "SELECT id, post_title, post_author, post_date, post_image, post_content, post_status FROM posts WHERE post_tags LIKE ? AND post_status = ? ORDER BY id DESC ");
            $published = 'published';
            $search_param = "%{$search}%";
            mysqli_stmt_bind_param($search_query, 'ss', $search_param, $published);
            mysqli_stmt_execute($search_query);
            confirm_query($search_query);
            mysqli_stmt_store_result($search_query);
            mysqli_stmt_bind_result($search_query, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_status);

            $count = mysqli_stmt_num_rows($search_query);
            if($count === 0)
              {
                echo "<h1>No Results found for " . $search . "</h1>";    
              }
            else
              {
                while(mysqli_stmt_fetch($search_query))
                  {
                    $post_content = "" . substr(strip_tags($post_content), 0, 300) . "...";
        ?>
                    <h2><a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        <span class="lead">by <a href="/cms/authorpost/<?php echo $post_author; ?>/<?php echo $post_id; ?>"><?php echo $post_author; ?></a></span>
                        <small><span class="glyphicon glyphicon-time"></span><?php echo " " .$post_date; ?></small>
                    </h2>
                    <a href="/cms/post/<?php echo $post_id; ?>"><img class="img-responsive" src="/cms/images/<?php echo image_placeholder($post_image); ?>" alt=""></img></a>
                    <p><?php echo $post_content; ?><a class="btn btn-secondary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </p>
                    <hr>
        <?php
                  } // close while there is posts
               mysqli_stmt_close($search_query);
            }
         } 
        else
          { // if no search post request
              redirect("/cms");
          }
        ?>

  </div> <!-- END BLOG ENTRIES -->

  <!-- Blog Sidebar Widgets Column -->
  <?php include "./includes/sidebar.php"; ?>

</div><!-- /.row -->


<?php
   include "./includes/footer.php";
?>