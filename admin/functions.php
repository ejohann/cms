<?php


/**************************************************/
          /* GENERAL FUNCTIONS */
/**************************************************/

// displays a default image if no image attached to post
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

// trims a value from post or get request
function escape($string)
 {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
 }

// confirms a db query has been successful
function confirm_query($query_result)
  {
    global $connection;
    if(!$query_result)
      {
        die("Post Query Failed " . mysqli_error($connection));   
      }  
  }

// redirects a user to a page
function redirect($location)
  {
     header("Location: " . $location . ""); 
     exit;
  }

 // this method has to be troubleshooted
 function if_it_is_method($method = mull)
  { 
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method))
     {
       return true;    
     }
    return false;  
  }

 // this method has to be troubleshooted
 function check_if_user_logged_in_and_redirect($redirectLocation)
    {
      if(is_logged_in())
       {
         redirect($redirectLocation);   
       }
       
      return false;
    }
  

/************************************************/
          /* END GENERAL FUNCTIONS */
/**************************************************/


/************************************************/
          /* ADMIN FUNCTIONS */
/**************************************************/

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


// add a category
function insert_categories()
  {
     global $connection;
     if(isset($_POST['add_category']))
       {
         $category_title = escape($_POST['category_title']);
         $user_id = logged_in_user_id();
         if($category_title == "" || empty($category_title))
           {
             echo "Category field cannot be empty";   
           }
         else
           {
             $statement = mysqli_prepare($connection, "INSERT INTO categories (user_id, category_title) VALUES (?, ?) ");
             mysqli_stmt_bind_param($statement, 'is', $user_id, $category_title);
             mysqli_stmt_execute($statement); 
             confirm_query($statement);
             mysqli_stmt_close($statement);
           }
       }                      
   }

function delete_categories()
 {
   global $connection; 
   if(isset($_GET['delete']))
     {
       if(is_admin(get_username()))
         {
           $delete_category_id = escape($_GET['delete']);
           $delete_category = mysqli_prepare($connection, "DELETE FROM categories WHERE id = ?");
           mysqli_stmt_bind_param($delete_category, 'i', $delete_category_id);
           mysqli_stmt_execute($delete_category);
           confirm_query($delete_category);
           mysqli_stmt_close($delete_category);
           redirect("categories.php");      
         }
       else
         {
           redirect("../index.php");
         }
     }
 }

/************************************************/
          /* END ADMIN FUNCTIONS */
/**************************************************/


/************************************************/
  /* DISPLAY ONLINE USERS IN ADMIN FUNCTIONS */
/**************************************************/

// Display users online - uses javascript
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

/************************************************/
/* END DISPLAY ONLINE USERS IN ADMIN FUNCTIONS */
/**************************************************/
  

/**************************************************/
          /* GET DATA FOR DISPLAYING CHARTS */
/**************************************************/

// return number of records assigned to a user
function record_count_by_user($table, $column) 
 {
   global $connection;
   $select_record_by_user = mysqli_prepare($connection, "SELECT id FROM ".$table." WHERE ".$column." = ? ");
   $post_author = get_username();    
   mysqli_stmt_bind_param($select_record_by_user, 's', $post_author);
   mysqli_stmt_execute($select_record_by_user);
   confirm_query($select_record_by_user);
   mysqli_stmt_store_result($select_record_by_user);
   $record_count = mysqli_stmt_num_rows($select_record_by_user); 
   mysqli_stmt_close($select_record_by_user);
   return $record_count; 
 }

// return number of records assigned to a user_id
function record_count_by_user_id($table, $column) 
 {
   global $connection;
   $select_record_by_user_id = mysqli_prepare($connection, "SELECT id FROM ".$table." WHERE ".$column." = ? ");
   $author_id = logged_in_user_id();    
   mysqli_stmt_bind_param($select_record_by_user_id, 'i', $author_id);
   mysqli_stmt_execute($select_record_by_user_id);
   confirm_query($select_record_by_user_id);
   mysqli_stmt_store_result($select_record_by_user_id);
   $record_count = mysqli_stmt_num_rows($select_record_by_user_id); 
   mysqli_stmt_close($select_record_by_user_id);
   return $record_count; 
 }

// return number of records in a tabls
function record_count($table) 
 {
   global $connection;
   $select_record = mysqli_prepare($connection, "SELECT id FROM ".$table."");
   mysqli_stmt_execute($select_record);
   confirm_query($select_record);
   mysqli_stmt_store_result($select_record);
   $record_count = mysqli_stmt_num_rows($select_record); 
   mysqli_stmt_close($select_record);
   return $record_count; 
 }
  

// returns number of records by status 
function check_status($table, $column, $status)
 {
    global $connection;
    $select_status = mysqli_prepare($connection, "SELECT id FROM " .$table. " WHERE " .$column. " = ? ");
    mysqli_stmt_bind_param($select_status, 's', $status);
    mysqli_stmt_execute($select_status);
    confirm_query($select_status);
    mysqli_stmt_store_result($select_status);
    $records_by_status_count = mysqli_stmt_num_rows($select_status);
    return $records_by_status_count;
 }

// returns number of records by status assigned to a user
function check_status_by_user($table, $column, $status)
 {
    global $connection;
    $select_status = mysqli_prepare($connection, "SELECT id FROM " .$table. " WHERE " .$column. " = ? ");
    mysqli_stmt_bind_param($select_status, 's', $status);
    mysqli_stmt_execute($select_status);
    confirm_query($select_status);
    mysqli_stmt_store_result($select_status);
    $records_by_status_count = mysqli_stmt_num_rows($select_status);
    return $records_by_status_count;
 }

/**************************************************/
          /* END GET DATA FOR DISPLAYING CHARTS */
/**************************************************/


/**************************************************/
          /* USER LOGIN FUNCTIONS */
/**************************************************/

//returns the user id of a username
function get_user_id($username = '')
 {
     global $connection;
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

 // returns the username of the logged in user
function get_username()
 {
   if(isset($_SESSION['username']))
    {
      return $_SESSION['username'];  
    }
   else
    {
      return null;   
    }
 }

// check if user is admin and logged in
function is_admin($username = '')
 {
    global $connection;
    if(is_logged_in())
     {
        $select_role = mysqli_prepare($connection, "SELECT user_role FROM users WHERE username = ? ");
        mysqli_stmt_bind_param($select_role, 's', $username);
        mysqli_stmt_execute($select_role);
        confirm_query($select_role);
        mysqli_stmt_bind_result($select_role, $user_role);
        mysqli_stmt_fetch($select_role);
        mysqli_stmt_close($select_role);
       if($user_role == "Admin")
         {
           return true;  
         }
        else
         {
            return false;
         } 
     }
    else
     {
         redirect("/cms/");
     }
   return false;
 }

 //return id of logged in user
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
 
 // check if a user is logged in
 function is_logged_in()
  {
     if(isset($_SESSION['user_role'])  && $_SESSION['user_role'] != null)
      {
        return true;   
      }
     
     return false;
  }

//login a user
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
           // user login successful / create sessions
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

/**************************************************/
          /* END USER LOGIN FUNCTIONS */
/**************************************************/


/**************************************************/
          /* USER REGISTRATION FUNCTIONS */
/**************************************************/

// check if a username exists
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

 // check if an email address exists
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

 // registers a user
 function register_user($username, $user_password, $user_email, $user_role)
   {
     global $connection;
     $user_hash_password = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => 10));
     $query = "INSERT INTO users (username, user_password, user_email, user_role) ";
     $query .= "VALUES ('{$username}', '{$user_hash_password}', '{$user_email}', '{$user_role}' )";    
     $register_user_query = mysqli_query($connection, $query);  
     confirm_query($register_user_query);   
   }

/**************************************************/
          /* END USER REGISTRATION FUNCTIONS */
/**************************************************/


/**************************************************/
          /* POST LIKE FUNCTIONS */
/**************************************************/

// check if a user liked a post
function user_liked_post($post_id = null)
  {
    global $connection;
    $user_like = mysqli_prepare($connection, "SELECT likes FROM likes WHERE user_id = ? AND post_id = ?");
    $user_id = logged_in_user_id();
    mysqli_stmt_bind_param($user_like, 'ii', $user_id, $post_id);
    mysqli_stmt_execute($user_like);
    mysqli_stmt_bind_result($user_like, $likes);
    mysqli_stmt_fetch($user_like);
    mysqli_stmt_close($user_like);
    if($likes != null)
     {
        return true;
    }
    else
    {
        return false;
    }
   return false;  
  } 
 
 // get number of post likes
 function get_post_likes($post_id = null)
  {
     global $connection;
     $post_likes = mysqli_prepare($connection, "SELECT id FROM likes WHERE post_id = ?");
     mysqli_stmt_bind_param($post_likes, 'i', $post_id);
     mysqli_stmt_execute($post_likes);
     mysqli_stmt_store_result($post_likes);
     $total_post_likes = mysqli_stmt_num_rows($post_likes);
     mysqli_stmt_close($post_likes);
     return $total_post_likes;
  }

/**************************************************/
          /* END POST LIKE FUNCTIONS */
/**************************************************/
 

  
?>