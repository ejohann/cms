<?php
  include "./includes/db.php";
  include "./includes/header.php";
  include "./admin/functions.php";
?>

<!-- Navigation -->
<?php include "./includes/navigation.php"; ?>
   
<?php 

  // like button clicked db  
  if(isset($_POST['liked']))
   {
     $post_id = escape($_POST['post_id']);
     $user_id = escape($_POST['user_id']);
     $liked = escape($_POST['liked']);
    
     //insert like into db
     $insert_like = mysqli_prepare($connection, "INSERT INTO likes (user_id, post_id, likes) VALUES (?, ?, ?)");
     mysqli_stmt_bind_param($insert_like, 'iii', $user_id, $post_id, $liked);
     mysqli_stmt_execute($insert_like);
     confirm_query($insert_like);
     mysqli_stmt_close($insert_like);
    
     //update post likes column in posts
     $update_likes = mysqli_prepare($connection, "UPDATE posts SET post_likes = post_likes + ? WHERE id = ? ");
     mysqli_stmt_bind_param($update_likes, 'ii', $liked, $post_id);
     mysqli_stmt_execute($update_likes);
     confirm_query($update_likes);
     mysqli_stmt_close($update_likes);    
   }

  //unlike button clicked
  if(isset($_POST['unliked']))
   {
     $post_id = escape($_POST['post_id']);
     $user_id = escape($_POST['user_id']);
     $unliked = escape($_POST['unliked']);
    
     //remove like from db
     $delete_like = mysqli_prepare($connection, "DELETE FROM likes WHERE user_id = ? AND post_id = ? ");
     mysqli_stmt_bind_param($delete_like, 'ii', $user_id, $post_id);
     mysqli_stmt_execute($delete_like);
     confirm_query($delete_like);
     mysqli_stmt_close($delete_like);
    
     //update post likes column in posts
     $update_likes = mysqli_prepare($connection, "UPDATE posts SET post_likes = post_likes - ? WHERE id = ? ");
     mysqli_stmt_bind_param($update_likes, 'ii', $unliked, $post_id);
     mysqli_stmt_execute($update_likes);
     confirm_query($update_likes);
     mysqli_stmt_close($update_likes);    
   }

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
            $the_post_id = escape($_GET['post_id']);
            $confirmation = '';
            
            // If logged in user is admin show post even it is draft
            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin')
              {
                $select_post = mysqli_prepare($connection, "SELECT post_title, post_author, post_date, post_image, post_content FROM posts WHERE id = ? ");
                mysqli_stmt_bind_param($select_post, 'i', $the_post_id);
              }
             else
              { // if user is not logged in only show post if published
                $select_post = mysqli_prepare($connection, "SELECT post_title, post_author, post_date, post_image, post_content FROM posts WHERE id = ? AND post_status = ? ");
                $published = 'published'; 
                mysqli_stmt_bind_param($select_post, 'is', $the_post_id, $published);
              }
            
             if(isset($select_post))
               {
                 mysqli_stmt_execute($select_post);
                 mysqli_stmt_bind_result($select_post, $post_title, $post_author, $post_date, $post_image, $post_content);   
              }    
             confirm_query($select_post); 
            
             // Display post
             while(mysqli_stmt_fetch($select_post))
               {
      ?>
                 <h2><?php echo $post_title; ?></h2>
                 <p class="lead">by <a href="/cms/authorpost/<?php echo $post_author; ?>/<?php echo $post_id; ?>"><?php echo $post_author; ?></a></p>
                 <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                 <hr>
                 <img class="img-responsive" src="/cms/images/<?php echo image_placeholder($post_image); ?>" alt="">
                 <hr>
                 <p><?php echo $post_content; ?></p>
                 <hr>
                 
                 <!-- LIKE BUTTON -->
                 <div class="row">
                     <p class="pull-right"><a class="like" href="#"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a></p>
                 </div>
                  <div class="row">
                     <p class="pull-right"><a class="unlike" href="#"><span class="glyphicon glyphicon-thumbs-down"></span> Unlike</a></p>
                 </div>
                  <div class="row">
                     <p class="pull-right">Likes : 6</p>
                 </div>
                 <div class="clearfix"></div>
      <?php          
               }
            
             // close select post db connection 
             mysqli_stmt_close($select_post);
            
             //update post views
             $update_views = mysqli_prepare($connection, "UPDATE posts SET post_views_count = post_views_count + ? WHERE id = ?");
             $views = 1;
             mysqli_stmt_bind_param($update_views, 'ii', $views, $the_post_id);
             mysqli_stmt_execute($update_views);
             confirm_query($update_views);
             // close update views db connection
             mysqli_stmt_close($update_views);  
      ?>

    <!-- Process comments from form and enter into database -->
    <?php
      if(isset($_POST['create_comment']))
        {      
          $comment_author = escape($_POST['comment_author']);
          $comment_email = escape($_POST['comment_email']);
          $comment_content = escape($_POST['comment_content']);
          $comment_date = date('y-m-d');
          $comment_status = "unapproved";
          
          if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content))
           {
              $add_comment = mysqli_prepare($connection, "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES (?, ?, ?, ?, ?, ?) ");
              mysqli_stmt_bind_param($add_comment, 'isssss', $the_post_id, $comment_author, $comment_email, $comment_content, $comment_status, $comment_date);
              mysqli_stmt_execute($add_comment);
              confirm_query($add_comment);
              mysqli_stmt_close($add_comment);
              $confirmation = "Comment has been submitted and will appear on website shortly"; 
           }
          else
           {
             echo "<script>alert('Fields Cannot be Empty!')</script>";   
           }
        }
    ?>                  
                
    <!-- Comments Form -->
    <div class="well">
        <p><?php echo $confirmation; ?></p>
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
    <?php    
       $select_comments = mysqli_prepare($connection, "SELECT comment_author, comment_date, comment_content FROM comments WHERE comment_post_id = ? AND comment_status = ? ORDER BY id DESC");
       $approved = 'approved';
       mysqli_stmt_bind_param($select_comments, 'is', $the_post_id, $approved);
       mysqli_stmt_execute($select_comments);
       mysqli_stmt_bind_result($select_comments, $comment_author, $comment_date, $comment_content);
       confirm_query($select_comments);
            
       while(mysqli_stmt_fetch($select_comments))
         {
    ?>
            <div class="media">
              <a class="pull-left" href="#"><img class="media-object" src="http://placehold.it/64x64" alt=""></a>
              <div class="media-body">
                <h4 class="media-heading"> <?php echo $comment_author; ?> <small> <?php echo $comment_date; ?></small></h4>
                <?php echo $comment_content; ?>
              </div>
            </div>     
    <?php
        }
       mysqli_stmt_close($select_comments);        
    }  // if post get request
   else
     {
       header("Location: index.php");
     }
  ?>                
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


<script>
   $(document).ready(function(){
    var post_id = <?php echo $the_post_id; ?>;
    var user_id = 22;
    $('.like').click(function(){
        
      //  console.log("Like button clicked");
      $.ajax({
          
         url: "/cms/post.php?post_id=<?php echo $the_post_id; ?>/",
         type: 'post',
         data: {
             'liked': 1,
             'post_id': post_id,
             'user_id': user_id
         }
      }); // ajax
    });   //like click function
       
    
    //unlike function   
    $('.unlike').click(function(){ 
      $.ajax({
          
         url: "/cms/post.php?post_id=<?php echo $the_post_id; ?>/",
         type: 'post',
         data: {
             'unliked': 1,
             'post_id': post_id,
             'user_id': user_id
         }
      }); // ajax
    });   //unlike click function
       
   }); // jquery on load
    
</script>