 <?php if(!isset($_SESSION['user_role'])){header("Location: ../../index.php"); exit;}?>
   
                                                      
<table class="table table-bordered table-hover">
  <thead>
   <tr>
     <th>ID</th>
     <th>Username</th>
     <th>Firstname</th>
     <th>Lastname</th>
     <th>Email</th>
     <th>Role</th> 
   </tr>
  </thead>
  <tbody>
  <?php 
    $select_users = mysqli_prepare($connection, "SELECT id, username, user_firstname, user_lastname, user_email, user_role FROM users ");
      
    mysqli_stmt_execute($select_users);
    confirm_query($select_users);
    mysqli_stmt_store_result($select_users);
    mysqli_stmt_bind_result($select_users, $user_id, $username, $user_firstname, $user_lastname, $user_email, $user_role);
    while(mysqli_stmt_fetch($select_users))
      {
        echo "<tr>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$username}</td>";
        echo "<td> {$user_firstname}</td>";
        echo "<td>{$user_lastname}</td>";
        echo "<td>{$user_email}</td>";
        echo "<td>{$user_role}</td>";
        if($user_role == 'Admin')
         {
             echo "<td>Upgrade</td>";
         }
        else
         {
             echo "<td><a href='users.php?upgrade={$user_id}'>Upgrade</a></td>";
         }
        if($user_role == 'Subscriber')
         {
               echo "<td>Downgrade</td>";
         }
        else
         {
            echo "<td><a href='users.php?downgrade={$user_id}'>Downgrade</a></td>";
         }
     
        echo "<td><a href='users.php?source=edit_user&edit={$user_id}'>Edit</a></td>";
        echo "<td><a onClick= \"javascript: return confirm('Are you sure you want to delete this user?'); \" href='users.php?delete={$user_id}'>Delete</a></td>";
        echo "</tr>";
      }
      mysqli_stmt_close($select_users);
  ?>                  
  </tbody>
</table>

<?php
  if(isset($_GET['delete']))
    {
      if(is_admin(get_username()))
        {
          $the_user_id = escape($_GET['delete']);
          $delete_query = mysqli_prepare($connection, "DELETE FROM users WHERE id = ? ");
          mysqli_stmt_bind_param($delete_query, 'i', $the_user_id);
          mysqli_stmt_execute($delete_query);
          confirm_query($delete_query);
          mysqli_stmt_close($delete_query);
          redirect("users.php");
        }
      else
        {
          redirect("../index.php");
        }
    }

  if(isset($_GET['downgrade']))
    { 
      if(is_admin(get_username()))
        {
          $the_user_id = escape($_GET['downgrade']);
          $downgrade_query = mysqli_prepare($connection, "UPDATE users SET user_role = ? WHERE id = ? ");
          $subscriber = "Subscriber";
          mysqli_stmt_bind_param($downgrade_query, 'si', $subscriber, $the_user_id);
          mysqli_stmt_execute($downgrade_query);
          confirm_query($downgrade_query);
          mysqli_stmt_close($downgrade_query);
          redirect("users.php");
        }
       else
        {
          redirect("../index.php");
        }
    }

  if(isset($_GET['upgrade']))
    {
     if(is_admin(get_username()))
        {
          $the_user_id = escape($_GET['upgrade']);
          $upgrade_query = mysqli_prepare($connection, "UPDATE users SET user_role = ? WHERE id = ? ");
          $admin = "Admin";
          mysqli_stmt_bind_param($upgrade_query, 'si', $admin, $the_user_id);
          mysqli_stmt_execute($upgrade_query);
          confirm_query($upgrade_query);
          mysqli_stmt_close($upgrade_query);
          redirect("users.php"); 
        }
      else
       {
         redirect("../index.php");
       }
    }
?>        