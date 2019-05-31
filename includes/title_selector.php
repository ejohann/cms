<?php 
  $page_name = $_SERVER['PHP_SELF']; 
  switch ($page_name)
    {
       case '/cms/index.php';
       $title= 'CMS Home';
       $description = 'Welcome to Home Page';
       break;

       case '/cms/author_post.php';
       $title= 'CMS Author Posts';
       $description = 'Author Posts Page';
       break;
       
       case '/cms/category.php';
       $title= 'CMS Blog Category';
       $description = 'CMS Category Page';
       break;
       
       case '/cms/contact.php';
       $title= 'CMS Contact Us';
       $description = 'Welcome to contact page';
       break;
          
       case '/cms/forgot.php';
       $title= 'CMS Forgot Password';
       $description = 'Forgot Password Page';
       break;
        
       case '/cms/login.php';
       $title= 'CMS Login';
       $description = 'Welcome to Login Page';
       break;
          
       case '/cms/post.php';
       $title= 'CMS Blog Post';
       $description = 'Welcome to Blog Post';
       break;
       
       case '/cms/registration.php';
       $title= 'CMS Registration';
       $description = 'Welcome to registration page';
       break;
          
       case '/cms/search.php';
       $title= 'CMS Search Results';
       $description = 'Welcome to search results page';
       break;
          
       case '/cms/reset.php';
       $title= 'CMS Reset Password';
       $description = 'Welcome to reset password page';
       break;
          
       default:
       $title= 'CMS';
       $description = 'Welcome to CMS';
       break;       
}
?>
