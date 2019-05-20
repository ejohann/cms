<?php
  
 
function escape($string)
 {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
 }


function users_online()
 {
    if(isset($_GET['online_users']))
    {
         global $connection;
        
        if(!$connection)
         {
            session_start();
            include("../includes/db.php");
             $minute = 60;
  $hour = 60;
  $day = 24;
  $session_id = session_id();
  $session_time = time();
  $time_out_in_seconds = $minute;
  $time_out = $session_time - $time_out_in_seconds;
 
  $query = "SELECT * FROM users_online WHERE session = '{$session_id}' ";
  $online_users_query = mysqli_query($connection, $query);
  confirm_query($online_users_query);
  $session_count = mysqli_num_rows($online_users_query);

  if($session_count == NULL)
    {
      $query = "INSERT INTO users_online(session, time) VALUES ('{$session_id}', '{$session_time}')";
      $add_session_query = mysqli_query($connection, $query);
      confirm_query($add_session_query);
   }
 else
  {
      $query = "UPDATE users_online SET time = '{$session_time}' WHERE session = '{$session_id}' ";
      $update_session_query = mysqli_query($connection, $query);
      confirm_query($update_session_query);
  }
  
 $query = "SELECT * FROM users_online WHERE time > '{$time_out}'";
 $users_online_query = mysqli_query($connection, $query);
 confirm_query($users_online_query);
 
  $users_online_count = mysqli_num_rows($users_online_query);
  echo $users_online_count;
        }
    }
}

users_online();

  function confirm_query($query_result)
   {
     global $connection;
     if(!$query_result)
       {
         die("Post Query Failed " . mysqli_error($connection));   
       }  
   }



function insert_categories()
  {
     global $connection;
     if(isset($_POST['submit']))
       {
         $category_title = escape($_POST['category_title']);
         if($category_title == "" || empty($category_title))
           {
             echo "Category field cannot be empty";   
           }
         else
           {
             $query = "INSERT INTO categories(category_title) ";
             $query .= "VALUE('{$category_title}')";                         
             $create_category_query = mysqli_query($connection, $query);
             if(!$create_category_query)
               {
                 die("Category Query Failed " . mysqli_error($connection));   
               }
             else
               {
                 echo "<p class='bg-success'>Category added successfully</p>";
               }
           }
       }                      
   }


function add_categories_form()
  {
     echo "  
      <form action='' method='post'>
        <div class='form-group'>
          <label for='category_title'>Add Category</label>
          <input class='form-control' type='text' name='category_title'></input>        
        </div>
        <div class='form-group'>
          <input class='btn btn-primary' type='submit' name='submit' value='Add Category'>
        </div>
      </form> 
        ";
   }
  
function delete_categories()
  {
    global $connection; 
    if(isset($_GET['delete']))
      {
        if(isset($_SESSION['user_role']))
          {
            if($_SESSION['user_role'] == "Admin")
              {
                $delete_category_id = $_GET['delete'];
                $query = "DELETE FROM categories WHERE id = {$delete_category_id}";
                $delete_query = mysqli_query($connection, $query);
                header("Location: categories.php");      
              }
             else
              {    
                header("Location: index.php");
              }
           }
          else
           {
             header("Location: ../index.php");
           }
      }
  }
  
 
?>