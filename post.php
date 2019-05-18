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
  <h1 class="page-header">Page Heading <small>Secondary Text</small></h1>
  <div class="row">
  
    <!-- Blog Entries Column -->
    <div class="col-md-8">
      <?php
        if(isset($_GET['post_id']))
          {
            $the_post_id = $_GET['post_id'];
         //   $query_views = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE id = $the_post_id ";
           // $update_post_views_query = mysqli_query($connection, $query_views);
        //    if(!$update_post_views_query)
        //      {
          //      die("QUERY FAILED: " . mysqli_error($connection));  
        //      }
            
        
        $query = "SELECT * FROM posts WHERE id = '{$the_post_id}' ";
        $select_post_by_id = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_post_by_id))
          {
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
      ?>
      <h2><a href="#"><?php echo $post_title; ?></a></h2>
      <p class="lead">by <a href="author_post.php?author=<?php echo $post_author; ?>&post_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a></p>
      <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
      <hr>
      <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
      <hr>
      <p><?php echo $post_content; ?></p>
      <hr>
      <?php          
          }
      ?>

    <!-- Blog Comments -->
    <?php
      if(isset($_POST['create_comment']))
        {      
          $comment_author = $_POST['comment_author'];
          $comment_email = $_POST['comment_email'];
          $comment_content = $_POST['comment_content'];
          $comment_date = date('y-m-d');
          $the_post_id = $_GET['post_id'];
          $comment_status = "unapproved";
          
          if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content))
           {
              $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
              $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', '{$comment_status}', now())";
              $create_comment_query = mysqli_query($connection, $query);
              if(!$create_comment_query)
               {
                 die('QUERY FAILED' . mysqli_error($connection));
               }
              $query_comment_count = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
              $query_comment_count .=  "WHERE id = $the_post_id ";
              $update_comment_count_query = mysqli_query($connection, $query_comment_count);
           }
          else
           {
             echo "<script>alert('Fields Cannot be Empty!')</script>";   
           }
        }
    ?>                  
                
    <!-- Comments Form -->
    <div class="well">
      <h4>Leave a Comment:</h4>
      <form action="" method="post" role="form">
        <div class="form-group">
          <label for="comment_author">Name</label>
          <input class="form-control" type="text" name="comment_author"></input>
        </div>
        <div class="form-group">
          <label for="comment_email">Email</label>
          <input class="form-control" type="email" name="comment_email"></input>
        </div>
        <div class="form-group">
          <label for="comment_content">Your Comment</label>
          <textarea class="form-control" rows="3" name="comment_content"></textarea>
        </div>
        <button type="submit" name="create_comment" class="btn btn-primary">Add Comment</button>
      </form>
    </div>
    <hr>

    <!-- Posted Comments -->
    <!-- Comment -->
    <?php    
      $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id ";
      $query .= "AND comment_status = 'approved' ";
      $query .=  "ORDER BY id DESC";
      $select_comments_by_post_id = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($select_comments_by_post_id))
        {
          $comment_id = $row['id'];
          $comment_author = $row['comment_author'];
          $comment_email = $row['comment_email'];
          $comment_post_id = $row['comment_post_id'];
          $comment_status = $row['comment_status'];
          $comment_content = $row['comment_content'];
          $comment_date = $row['comment_date'];   
    ?>
      <div class="media">
        <a class="pull-left" href="#"><img class="media-object" src="http://placehold.it/64x64" alt=""></a>
        <div class="media-body">
          <h4 class="media-heading">
            <?php echo $comment_author; ?>
            <small><?php echo $comment_date; ?></small>
          </h4>
          <?php echo $comment_content; ?>
        </div>
      </div>     
    <?php
        }
    
       }
      else
      {
          header("Location: index.php");
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