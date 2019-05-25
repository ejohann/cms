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
  <div class="row">
    <h1 class="page-header">Page Heading <small>Secondary Text</small></h1>

    <!-- Blog Entries Column -->
    <div class="col-md-8">
      <?php    
        $post_count_query = "SELECT * FROM posts WHERE post_status = 'published' ";
        $find_count_query = mysqli_query($connection, $post_count_query);
        if(!$find_count_query)
         {
           die("QUERY FAILED: " . mysqli_error($connection));
         }
        
        $post_count = mysqli_num_rows($find_count_query);
        
        if($post_count == 0 )
         {
           echo "<h1 class='text-center'>No posts to display</h1>";   
         }
        else
         { 
            if($post_count < 5)
             {
                $post_per_page = $post_count;
             }
            else
             {
               $post_per_page = 5;
             }
            
            $post_pages = ceil($post_count / $post_per_page);
        
            if(isset($_GET['page']))
             {
               $page = $_GET['page'];   
             }
            else
             {
                $page = "";   
             }
        
            if($page == "" || $page == 1)
              {
                 $page_1 = 0;   
              }
             else
              {
                 $page_1 = ($page * $post_per_page) - $post_per_page;     
              }
            
             $query = "SELECT * FROM posts LIMIT $page_1, $post_per_page";
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
            ?>

      <!-- Pager -->
      <ul class="pager">
        <?php
          for($i=1; $i<=$post_pages; $i++)
           {
              if($i == $page)
               {
                  echo "<li class='active_link'><a href='/cms/page/{$i}'>{$i}</a></li>"; 
              }
              else
              {
                 echo "<li><a href='/cms/page/{$i}'>{$i}</a></li>";  
              }             
           }
        } // end show if have post
        ?>
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