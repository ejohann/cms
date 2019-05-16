    <table class="table table-bordered table-hover">
                            <thead>
                             <tr>
                                 <th>ID</th>
                                <th>Author</th>
                                <th>Comments</th>
                               
                                <th>Email</th>
                                <th>Status</th>
                                <th>In Response to</th> 
                                 <th>Date</th>                            
                                 <th>Approve</th>
                                 <th>Unapprove</th>
                                 <th>Delete</th>
                              </tr>
                           </thead>
                            <tbody>
                            
                             <?php 
                                $query = "SELECT * FROM comments";
                                $select_all_comments = mysqli_query($connection, $query);
                                    while($row = mysqli_fetch_assoc($select_all_comments))
                                      {
                                        $comment_id = $row['id'];
                                        $comment_author = $row['comment_author'];
                                        $comment_email = $row['comment_email'];
                                        $comment_post_id = $row['comment_post_id'];
                                        $comment_status = $row['comment_status'];

                                        $comment_content = $row['comment_content'];
                                        
                                         $comment_date = $row['comment_date'];
                                        
                                        echo "<tr>";
                                        
                                        echo "<td>{$comment_id}</td>";
                                        echo "<td>{$comment_author}</td>";
                                        echo "<td>{$comment_content}</td>";
                                        
                                           echo "<td>{$comment_email}</td>";
                                        
                                            echo "<td>{$comment_status}</td>";
                                        
                                           
                                    $query = "SELECT * FROM posts WHERE id = $comment_post_id";
                                    $select_post_by_id = mysqli_query($connection, $query);
                                     confirm_query($select_post_by_id);
                                    while($row = mysqli_fetch_assoc($select_post_by_id))
                                      {
                                        $post_title = $row['post_title'];   
                                         echo "<td><a href='../post.php?post_id={$comment_post_id}'>{$post_title}</a></td>";
                                       }       
                                            echo "<td>{$comment_date}</td>";
                                            echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
                                            echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
                                            echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
                                        echo "</tr>";
                                    }
                           ?>                  
                           </tbody>
                        </table>


            <?php
                if(isset($_GET['delete']))
                 {
                   $the_comment_id = $_GET['delete'];
                   $query = "DELETE FROM comments WHERE id = {$the_comment_id} ";
                   $delete_comment_query = mysqli_query($connection, $query);
                    
                   confirm_query($delete_comment_query);
                   
                header("Location: comments.php");
                    
                 }

                if(isset($_GET['unapprove']))
                 {
                   $the_comment_id = $_GET['unapprove'];
                   $query = "UPDATE comments SET comment_status = 'unapproved' WHERE id = $the_comment_id ";
                   $unapprove_comment_query = mysqli_query($connection, $query);
                    
                   confirm_query($unapprove_comment_query);
                   
                header("Location: comments.php");
                    
                 }

                if(isset($_GET['approve']))
                 {
                   $the_comment_id = $_GET['approve'];
                   $query = "UPDATE comments SET comment_status = 'approved' WHERE id = $the_comment_id ";
                   $approve_comment_query = mysqli_query($connection, $query);
                    
                   confirm_query($approve_comment_query);
                   
                header("Location: comments.php");
                    
                 }
                   
                   
             ?>
        