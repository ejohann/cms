<?php include "includes/admin_header.php"; ?>
  <div id="wrapper">
  
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>           
    
    <div id="page-wrapper">
      <div class="container-fluid">
         <!-- Page Heading -->
         <div class="row">
           <div class="col-lg-12">
             <h1 class="page-header">Categories <small><?php echo $_SESSION['username']; ?></small></h1>       <div class="col-xs-6">
    
               <?php
                  // UPDATE CATEGORY FORM/QUERY
                  if(isset($_GET['edit']))
                    { 
                      if(isset($_SESSION['user_role']))
                        {
                          if($_SESSION['user_role'] == "Admin")
                            {
                              $edit_category_id = escape($_GET['edit']); 
                              include "includes/edit_categories.php";
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
                   else
                   {
                     // ADD CATEGORY FORM/QUERY
                      insert_categories();
                      add_categories_form();
                   }
               ?>
             </div> <!-- Category forms -->
                        
             <div class="col-xs-6">
               <table class="table table-bordered table-hover">
                 <thead>
                   <tr>
                     <th>ID</th>
                     <th>Category Title</th>
                   </tr>           
                 </thead>
                 <tbody>
                   <?php          
                     $query = "SELECT * FROM categories";
                     $select_all_categories = mysqli_query($connection, $query);
                     while($row = mysqli_fetch_assoc($select_all_categories))
                       {
                         $category_title = $row['category_title'];
                         $category_id = $row['id'];
                   ?>
                   <tr>
                     <td><?php echo $category_id; ?></td>
                     <td><?php echo $category_title; ?></td>
                  <?php echo "<td><a onClick= \"javascript: return confirm('Are you sure you want to delete this category?'); \" href='categories.php?delete={$category_id}'>Delete</a></td>"; ?>
                     <td><a href='categories.php?edit=<?php echo $category_id; ?>'>Edit</a></td>
                   </tr>  
                   <?php      
                       }
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