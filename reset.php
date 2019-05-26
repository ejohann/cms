<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>


<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>


<?php
    if(!isset($_GET['email']) && !isset($_GET['token']))
     {
       redirect('index');
     }

    $token = escape($_GET['token']);
    $email = escape($_GET['email']);

    $confirm_email_token = mysqli_prepare($connection, "SELECT username, user_email FROM users WHERE token = ? AND user_email = ?");
  
   if($confirm_email_token)
    {
      mysqli_stmt_bind_param($confirm_email_token, "ss", $token, $email);
      mysqli_stmt_execute($confirm_email_token);
      mysqli_stmt_bind_result($confirm_email_token, $username, $user_email);
      mysqli_stmt_fetch($confirm_email_token);
      mysqli_stmt_close($confirm_email_token);
    }
  else
    {  
     redirect('index');
    }

  
  if(isset($_POST['password']) && isset($_POST['confirmPassword']))
    {
      if($_POST['password'] === $_POST['confirmPassword'])
        {
          $password = escape($_POST['password']);
          $hashed_password = password_hash($password, PASSWORD_DEFAULT, array('cost' => 10));
          $token = '';
            
          $update_password = mysqli_prepare($connection, "UPDATE users SET token = ?, user_password = ? WHERE user_email = ? ");
          if($update_password)
            {
              mysqli_stmt_bind_param($update_password, "sss", $token, $hashed_password, $email);
              mysqli_stmt_execute($update_password);
              if(mysqli_stmt_affected_rows($update_password) >= 1)
                {
                  mysqli_stmt_close($update_password);
                  redirect('/cms/login.php');
                }
              mysqli_stmt_close($update_password);
            }
        }
    }

?>





<div class="container">



    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">


                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<hr>

<?php include "includes/footer.php";?>

</div> <!-- /.container -->



