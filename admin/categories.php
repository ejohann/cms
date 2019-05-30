<?php include "includes/admin_header.php"; ?>
 <!-- GO TO HOMEPAGE IF USER NOT LOGGED IN --> 
<?php if(is_logged_in()){}else{redirect("/cms/");}?>
  <div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>           
    
    <div id="page-wrapper">
      <div class="container-fluid">
         <!-- Page Heading -->
         <div class="row">
           <div class="col-lg-12">
             <h1 class="page-header">Categories <small><?php echo get_username(); ?></small></h1>       <div class="col-xs-6">
    
               <?php
                  
                  // set a user is admin variable
                  $is_admin = null;
                  if(is_admin(get_username()))
                   {
                     $is_admin = true;
                   }
               
                  if(isset($_GET['edit']))
                    { 
                      if(is_admin(get_username()))
                        { //only allow admin to edit categories
                          $edit_category_id = escape($_GET['edit']); 
                          include "includes/edit_categories.php";
                        }
                       else
                        {
                           redirect("/cms/admin/");
                        }
                    }
                   else
                   {
                     // ADD CATEGORY FORM/QUERY
                      insert_categories();
                      add_categories_form();
                   }
               ?>
             </div> <!-- Category forms -->
                        
             <div class="col-xs-6">
               <h5>All Categories </h5>
               <table class="table table-bordered table-hover">
                 <thead>
                   <tr>
                     <th>ID</th>
                     <th>Category Title</th>
                     <?php if($is_admin) : ?>
                     
                     <th>Delete</th>
                     <th>Edit</th>
                     <?php endif;?>
                   </tr>           
                 </thead>
                 <tbody>
                   <?php 
                     // get all categories and show them
                     $select_category = mysqli_prepare($connection, "SELECT id, category_title FROM categories");
                     mysqli_stmt_execute($select_category);
                     confirm_query($select_category);
                     mysqli_stmt_bind_result($select_category, $category_id, $category_title);
                     while(mysqli_stmt_fetch($select_category))
                       {
                   ?>
                          <tr>
                              <td><?php echo $category_id; ?></td>
                              <td><?php echo $category_title; ?></td>
                               <?php if($is_admin) : ?>
                                 <!-- ONLY SHOW DELETE AND EDIT BUTTONS TO ADMIN-->
                                 <?php echo "<td><a onClick= \"javascript: return confirm('Are you sure you want to delete this category?'); \" href='categories.php?delete={$category_id}'>Delete</a></td>"; ?>
                                 <td><a href='categories.php?edit=<?php echo $category_id; ?>'>Edit</a></td>
                                <?php endif;?>
                          </tr>  
                   <?php      
                       }
                     // close db connection  
                     mysqli_stmt_close($select_category);
                   ?>
                   <?php
                      delete_categories();
                   ?>
                 </tbody>
               </table>
             </div>                   
 
           </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /#page-wrapper -->
    
</div><!-- /#wrapper -->

<?php include "includes/admin_footer.php"; ?>