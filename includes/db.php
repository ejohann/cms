<?php

    $db['db_host'] = "localhost";
    $db['db_user'] = "root"; 
    $db['db_password'] = ""; 
    $db['db_name'] = "cms"; 

   // converts keys to constants
   foreach($db as $key => $value)
    {
      define(strtoupper($key), $value); 
         
    }


    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "SET NAMES utf8";
    msqli_query($connection, $query);

     if($connection)
      {
         // echo "we are connected";
      }
     else
      {
         echo "Connection failed: ".  mysqli_error($connection); 
      }
 

?>