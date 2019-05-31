<?php 
  $page_name = $_SERVER['PHP_SELF']; 
  switch ($page_name)
    {
       case '/cms/admin/index.php';
       $title= 'CMS Admin';
       $description = 'Welcome to Admin';
       break;

       case '/cms/admin/dashboard.php';
       $title= 'CMS Admin';
       $description = 'All site data';
       break;
       
       case '/cms/admin/categories.php';
       $title= 'CMS Categories Admin';
       $description = 'Welcome to categories';
       break;
       
       case '/cms/admin/profile.php';
       $title= 'CMS Profile';
       $description = 'Welcome to profile';
       break;
          
       case '/cms/admin/comments.php';
       $title= 'CMS Comments';
       $description = 'Welcome to comments';
       break;
        
       case '/cms/admin/post_comments.php';
       $title= 'CMS Post Comments';
       $description = 'Welcome to Post Comments';
       break;
          
       case '/cms/admin/posts.php';
       $title= 'CMS Posts';
       $description = 'Welcome to posts';
       break;
       
       case '/cms/admin/users.php';
       $title= 'CMS Users';
       $description = 'Welcome to users';
       break;
          
       default:
       $title= 'CMS Admin';
       $description = 'Welcome to CMS Admin';
       break;       
}
?>
