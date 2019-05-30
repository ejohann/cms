<?php if(!isset($_SESSION['user_role'])){header("Location: ../../index.php"); exit;}?>

<?php
 // set a user is admin variable
  $is_admin = null;
  if(is_admin(get_username()))
   {
     $is_admin = true;
   }
?>  

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Author</th>
      <th>Comments</th>
      <th>Email</th>
      <th>Status</th>
      <th>In Response to</th> 
      <th>Date</th>   
      <?php if($is_admin) : ?>                         
        <th>Approve</th>
        <th>Unapprove</th>
        <th>Delete</th>
      <?php endif; ?>  
    </tr>
  </thead>
  <tbody>
    <?php 
      $select_comment = mysqli_prepare($connection, "SELECT id, comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date FROM comments ");
      mysqli_stmt_execute($select_comment);
      confirm_query($select_comment);
      mysqli_stmt_store_result($select_comment);
      mysqli_stmt_bind_result($select_comment, $comment_id, $comment_post_id, $comment_author, $comment_email, $comment_content, $comment_status, $comment_date);
      while(mysqli_stmt_fetch($select_comment))
        {
          echo "<tr>";
          echo "<td>{$comment_id}</td>";
          echo "<td>{$comment_author}</td>";
          echo "<td>{$comment_content}</td>";
          echo "<td>{$comment_email}</td>";
          echo "<td>{$comment_status}</td>";
          
          //get post title
          $select_title = mysqli_prepare($connection, "SELECT post_title FROM posts WHERE id = ? ");
          mysqli_stmt_bind_param($select_title, 'i', $comment_post_id);
          mysqli_stmt_execute($select_title);
          confirm_query($select_title);
          mysqli_stmt_store_result($select_title);
          mysqli_stmt_bind_result($select_title, $post_title);
          mysqli_stmt_fetch($select_title);
          mysqli_stmt_close($select_title);  
          
          // display post title
          echo "<td><a href='../post.php?post_id={$comment_post_id}'>{$post_title}</a></td>"; 
          echo "<td>{$comment_date}</td>";
          if($is_admin)
            {      
              if($comment_status == 'unapproved')
                {
                  echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
                }
               else
                {
                    echo "<td>Approve</td>";
                }
              if($comment_status == 'approved')
                {
                  echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
                }
               else
                {
                   echo "<td>Unapprove</td>";
                }
              
              echo "<td><a onClick= \"javascript: return confirm('Are you sure you want to delete this comment?'); \" href='comments.php?delete={$comment_id}'>Delete</a></td>";
            }
           else
            {
              // do not show link to non admin users  
            }
          echo "</tr>";
        }
      mysqli_stmt_close($select_comment);
    ?>                  
  </tbody>
</table>

<?php
  if(isset($_GET['delete']))
   {
     if(is_admin(get_username()))
       {
         $the_comment_id = escape($_GET['delete']);
         $delete_comment = mysqli_prepare($connection, "DELETE FROM comments WHERE id = ? ");
         mysqli_stmt_bind_param($delete_comment, 'i', $the_comment_id);
         mysqli_stmt_execute($delete_comment);
         confirm_query($delete_comment);
         mysqli_stmt_close($delete_comment);
         redirect("comments.php");
       }
      else
        {
          redirect("../index.php");
        }
   }

  if(isset($_GET['unapprove']))
    {
      if(is_admin(get_username()))
        {
          $the_comment_id = escape($_GET['unapprove']);
          $unapprove_comment = mysqli_prepare($connection, "UPDATE comments SET comment_status = ? WHERE id = ?");
          $unapproved = 'unapproved';
          mysqli_stmt_bind_param($unapprove_comment, 'si', $unapproved, $the_comment_id);
          mysqli_stmt_execute($unapprove_comment);
          confirm_query($unapprove_comment);
          mysqli_stmt_close($unapprove_comment);
          redirect("comments.php");
        }
      else
        {
          redirect("../index.php");
        }
    }

  if(isset($_GET['approve']))
    {
      if(is_admin(get_username()))
        {
          $the_comment_id = escape($_GET['approve']);
          $approve_comment = mysqli_prepare($connection, "UPDATE comments SET comment_status = ? WHERE id = ?");
          $approved = 'approved';
          mysqli_stmt_bind_param($approve_comment, 'si', $approved, $the_comment_id);
          mysqli_stmt_execute($approve_comment);
          confirm_query($approve_comment);
          mysqli_stmt_close($approve_comment);
          redirect("comments.php");
        }
      else
        {
          redirect("../index.php");
        }
    }
?>
        