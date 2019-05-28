<?php





function image_placeholder($image=null)
 {
   if(!$image)
    {
       return 'Tulips.jpg';
   }
  else
   {
      return $image;
  }
 }




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


function add_categories_form()
  {
     echo "  
      <form action='' method='post'>
        <div class='form-group'>
          <label for='category_title'>Add Category</label>
          <input class='form-control' type='text' name='category_title'></input>        
        </div>
        <div class='form-group'>
          <input class='btn btn-primary' type='submit' name='add_category' value='Add Category'>
        </div>
      </form> 
        ";
   }
  

function insert_categories()
  {
     global $connection;
     if(isset($_POST['add_category']))
       {
         $category_title = escape($_POST['category_title']);
         if($category_title == "" || empty($category_title))
           {
             echo "Category field cannot be empty";   
           }
         else
           {
             $statement = mysqli_prepare($connection, "INSERT INTO categories (category_title) VALUES (?) ");
             mysqli_stmt_bind_param($statement, 's', $category_title);
             mysqli_stmt_execute($statement); 
             if(!$statement)
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


function delete_categories()
  {
    global $connection; 
    if(isset($_GET['delete']))
      {
        if(isset($_SESSION['user_role']))
          {
            if($_SESSION['user_role'] == "Admin")
              {
                $delete_category_id = escape($_GET['delete']);
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


function record_count($table) 
 {
   global $connection;
   $query = "SELECT * FROM " . $table ;
   $select_all_records = mysqli_query($connection, $query);
   confirm_query($select_all_records);
   $record_count = mysqli_num_rows($select_all_records);
   return $record_count; 
 }
  
function check_status($table, $column, $status)
 {
    global $connection;
    $query = "SELECT * FROM " .$table. " WHERE " .$column. " = '" .$status. "' ";
    $select_records_by_status = mysqli_query($connection, $query);     
    confirm_query($select_records_by_status);
    $records_by_status_count = mysqli_num_rows($select_records_by_status);
    return $records_by_status_count;
 }


function is_admin($username = '')
 {
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $results = mysqli_query($connection, $query);
    confirm_query($results);
    $row = mysqli_fetch_array($results);
    if($row['user_role'] == "Admin")
     {
       return true;  
     }
    else
     {
       return false;
     } 
 }
 
 function username_exists($username)
  {
     global $connection;
     $query = "SELECT username FROM users WHERE username = '$username'";
     $results = mysqli_query($connection, $query);
     confirm_query($results);
     if(mysqli_num_rows($results) == 0)
      {
         return true;
      }
     else
      {
        return false;
      }
  }

 function email_exists($email)
  {
     global $connection;
     $query = "SELECT user_email FROM users WHERE user_email = '$email'";
     $results = mysqli_query($connection, $query);
     confirm_query($results);
     if(mysqli_num_rows($results) == 0)
      {
         return true;
      }
     else
      {
        return false;
      }
  }

 function redirect($location)
  {
     header("Location: " . $location . ""); 
     exit;
  }

 function if_it_is_method($method = mull)
  { 
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method))
     {
       return true;    
     }
    return false;  
  }



 function logged_in_user_id()
  {
    global $connection;  
    if(is_logged_in())
     {
       $username = $_SESSION['username'];
       $select_user = mysqli_prepare($connection, "SELECT id FROM users WHERE username = ?");
       mysqli_stmt_bind_param($select_user, 's', $username);
       mysqli_stmt_execute($select_user);
       mysqli_stmt_bind_result($select_user, $user_id);
       mysqli_stmt_fetch($select_user);
       mysqli_stmt_close($select_user);
       if($user_id != null)
        {
          return $user_id;  
        }
     }
     return false;
  }


function user_liked_post($post_id = '')
  {
    global $connection;
    $user_like = mysqli_prepare($connection, "SELECT likes FROM likes WHERE user_id = ? AND post_id = ?");
    $user_id = logged_in_user_id();
    mysqli_stmt_bind_param($user_like, 'ii', $user_id, $post_id);
    mysqli_stmt_execute($user_like);
    mysqli_stmt_bind_result($user_like, $likes);
    mysqli_stmt_fetch($user_like);
    mysqli_stmt_close($user_like);
    $likes >= 1 ? true : false;
    
  } 

 function is_logged_in()
  {
     if(isset($_SESSION['user_role'])  && $_SESSION['user_role'] != null)
      {
        return true;   
      }
     
     return false;
  }

   function check_if_user_logged_in_and_redirect($redirectLocation)
    {
      if(is_logged_in())
       {
         redirect($redirectLocation);   
       }
       
      return false;
    }
  


  function register_user($username, $user_password, $user_email, $user_role)
   {
     global $connection;
     $user_hash_password = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => 10));
     $query = "INSERT INTO users (username, user_password, user_email, user_role) ";
     $query .= "VALUES ('{$username}', '{$user_hash_password}', '{$user_email}', '{$user_role}' )";    
     $register_user_query = mysqli_query($connection, $query);  
     confirm_query($register_user_query);   
   }

  function login_user($username, $user_password)
   {
     global $connection;  

     $query = "SELECT * FROM users WHERE username = '{$username}' ";
     $select_user_by_name = mysqli_query($connection, $query);
     confirm_query($select_user_by_name);
     while($row = mysqli_fetch_array($select_user_by_name))
      {
        $the_username = $row['username'];
        $the_user_id = $row['id'];
        $the_user_password = $row['user_password'];
        $the_user_firstname = $row['user_firstname'];
        $the_user_lastname = $row['user_lastname'];
        $the_user_email = $row['user_email'];
        $the_user_role = $row['user_role'];
        if(password_verify($user_password, $the_user_password))
         {
           // user login successful
           $_SESSION['username'] = $the_username;
           $_SESSION['user_firstname'] = $the_user_firstname;
           $_SESSION['user_lastname'] = $the_user_lastname;
           $_SESSION['user_email'] = $the_user_email;
           $_SESSION['user_role'] = $the_user_role;
           $_SESSION['user_id'] = $the_user_id;
            redirect("/cms/admin");
           
          }   
        else
         {
            redirect("/cms/login");
            return false;
        }
      }
    
     
   }

?>