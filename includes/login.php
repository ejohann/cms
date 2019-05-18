<?php include "db.php"; ?>
<?php session_start(); ?>

<?php 

  if(isset($_POST['login']))
   {
      $username = $_POST['username'];
      $password = $_POST['password'];
      
     $username = mysqli_real_escape_string($connection, $username);
     $password = mysqli_real_escape_string($connection, $password);
      
      $query = "SELECT * FROM users WHERE username = '{$username}' ";
      
      $select_user_by_name = mysqli_query($connection, $query);
      
      if(!$select_user_by_name)
       {   
          die("QUERY FAILED" . mysqli_error($connection));
       }
      else
       {
        while($row = mysqli_fetch_array($select_user_by_name))
         {
            $the_username = $row['username'];
            $the_user_id = $row['id'];
            $the_user_password = $row['user_password'];
            $the_user_firstname = $row['user_firstname'];
            $the_user_lastname = $row['user_lastname'];
            $the_user_email = $row['user_email'];
            $the_user_role = $row['user_role'];
         }
                  
        if(password_verify($password, $the_user_password))
           {
             // user login successful
             $_SESSION['username'] = $the_username;
             $_SESSION['user_firstname'] = $the_user_firstname;
             $_SESSION['user_lastname'] = $the_user_lastname;
             $_SESSION['user_email'] = $the_user_email;
             $_SESSION['user_role'] = $the_user_role;

             header("Location: ../admin/index.php");
          }
         else
         {      
           header("Location: ../index.php");
         }
          
          
       }
      
   }
  

?>