<?php
   require_once "./../vendor/autoload.php";
   $dotenv = Dotenv\Dotenv::create(__DIR__.'/../../');
   $dotenv->load();

   $connection = mysqli_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'));
   $query = "SET NAMES utf8";
   mysqli_query($connection, $query);

   if($connection)
     {
         // echo "we are connected";
     }
    else
     {
        echo "Connection failed: ".  mysqli_error($connection); 
     }
 

?>