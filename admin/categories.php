<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
        
          <?php include "includes/admin_navigation.php"; ?>           
                                            

        <div id="page-wrapper">
           
           <?php 
             
             // if($connection) {echo "Hello";}
             
            ?>
           
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin Dashboard
                            <small>Author</small>
                        </h1>                    
                        
                        <div class="col-xs-6">
                           <?php
                                insert_categories();
                                add_categories_form();
                            ?>
                         
                          <?php
                            // UPDATE CATEGORY FORM/QUERY
                            if(isset($_GET['edit']))
                              {
                                 $edit_category_id = $_GET['edit']; 
                                 include "includes/edit_categories.php";
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
                                    <td><a href='categories.php?delete=<?php echo $category_id; ?>'>Delete</a></td>
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
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        
        

    </div>
    <!-- /#wrapper -->

  <?php include "includes/admin_footer.php"; ?>