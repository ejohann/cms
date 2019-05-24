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
            $the_post_author = $_GET['author'];
          }
        
        $query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}' ";
        $select_post_by_author = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_post_by_author))
          {
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_id = $row['id'];
      ?>
      <h2><a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
      <p class="lead">All Post by: <?php echo $post_author; ?></p>
      <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
      <hr>
        <a href="/cms/post/<?php echo $post_id; ?>"><img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt=""> </a>
      <hr>
      <p><?php echo $post_content; ?></p>
      <hr>
      <?php          
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