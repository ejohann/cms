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
          <h1 class="page-header">My Dashboard <small><?php echo get_username(); ?></small></h1>
        </div>
      </div> <!-- /.row -->
                       
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-file-text fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                  <?php
                     $post_count = record_count_by_user('posts', 'post_author');
                     echo "<div class='huge'>{$post_count}</div>";
                  ?>
                  <div>Posts</div>
                </div>
              </div>
            </div>
            <a href="posts.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
      
      <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-comments fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <?php
                  $comment_count = record_count_by_user('comments', 'comment_author');
                  echo "<div class='huge'>{$comment_count}</div>";
                ?>
                <div>Comments</div>
              </div>
            </div>
          </div>
          <a href="comments.php">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="panel panel-red">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-list fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <?php
                  $category_count = record_count('categories');
                   echo "<div class='huge'>{$category_count}</div>";
                ?>
                <div>Categories</div>
              </div>
            </div>
          </div>
          <a href="categories.php">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
    </div><!-- /.row -->
    
    <?php       
      $published_post_count = check_status('posts', 'post_status', 'published');   
      $draft_post_count = check_status('posts', 'post_status', 'draft');  
      $unapprove_comment_count = check_status('comments', 'comment_status', 'unapproved');
    //  $approve_comment_count = check_status('comments', 'comment_status', 'approved');
      $subscriber_count = check_status('users', 'user_role', 'subscriber');
    ?>
    <div class="row">
      <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() 
          {
            var data = google.visualization.arrayToDataTable
              ([
                ['Data', 'Count'],
                <?php
                  $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Comments Pending', 'Categories'];
                  $element_count = [$post_count, $published_post_count, $draft_post_count, $comment_count, $unapprove_comment_count, $category_count];
                  for($i=0; $i < 6; $i++)
                    {
                      echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                    }
                ?>
              ]);

            var options = 
              {
                chart: 
                  {
                    title: '',
                    subtitle: '',
                  }
              };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
      </script>
      <div id="columnchart_material" style="width:'auto'; height: 500px;"></div>
    </div> <!-- /.row -->
                
  </div><!-- /.container-fluid -->
        
 </div><!-- /#page-wrapper -->
        
</div><!-- /#wrapper -->

<?php include "includes/admin_footer.php"; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script>
  $(document).ready(function(){
    var pusher = new Pusher('e7959654d2a9e49cd403', {cluster: 'eu', forceTLS: true});
    var notification_channel = pusher.subscribe('notifications');
    notification_channel.bind('new_user', function(notification){
    var notification_message = notification.message;
    toastr.success('Great news: ' + notification_message);
    });
  });
</script>

