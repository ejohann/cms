<?php if(!isset($_SESSION['user_role'])){header("Location: ../../index.php"); exit;}?>

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
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $query = "SELECT * FROM comments";
      $select_all_comments = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($select_all_comments))
        {
          $comment_id = $row['id'];
          $comment_author = $row['comment_author'];
          $comment_email = $row['comment_email'];
          $comment_post_id = escape($row['comment_post_id']);
          $comment_status = $row['comment_status'];
          $comment_content = $row['comment_content'];
          $comment_date = $row['comment_date'];
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
          echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
          echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
          echo "<td><a onClick= \"javascript: return confirm('Are you sure you want to delete this comment?'); \" href='comments.php?delete={$comment_id}'>Delete</a></td>";
          echo "</tr>";
        }
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
        