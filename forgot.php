<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>
<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
?>
 
<?php require "./vendor/autoload.php"; ?>
<?php // require "./classes/config.php"; ?>
<?php

  
  // Check if request came from get request else redirect user
 if(!isset($_GET['forgot']))
   {
      redirect('index');
   }


  if(if_it_is_method('post'))
   {
     if(isset($_POST['email']))
      {
        $email = escape($_POST['email']);   
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
         
        if(!email_exists($email))
         {
            // echo "Email exists";
            $update_token = mysqli_prepare($connection, "UPDATE users SET token= ? WHERE user_email = ? ");
            if($update_token)
             {
               mysqli_stmt_bind_param($update_token, 'ss', $token, $email);
               mysqli_stmt_execute($update_token);
               mysqli_stmt_close($update_token);
                
                /*********CONFIGURE PHPMAILER *************/
        
               $mail = new PHPMailer();
               $mail->isSMTP();                                            
               $mail->Host = Config::SMTP_HOST;  
               $mail->Username = Config::SMTP_USER;                    
               $mail->Password = Config::SMTP_password; 
               $mail->Port = Config::SMTP_PORT; 
               $mail->SMTPSecure = 'tls';   
               $mail->SMTPAuth   = true;  
               $mail->isHTML(true);  
               $mail->Charset = 'UTF-8';
               $mail->setFrom('info@sunsetcity.gd', 'Johanne Lewis');
               $mail->addAddress($email);
               $mail->Subject = 'This is a test email';
               $mail->Body = "<p>Please click on link to reset password
                                <a href='http://localhost/cms/reset.php?email={$email}&token={$token}'>http://localhost/cms/reset.php?email={$email}&token={$token}</a>
                              </p>";
               if($mail->send()) 
                 { 
                   $email_sent = true;
                 } 
                else  
                 { 
                   echo "EMAIL NOT SENT"; 
                 }               
             }
            else
             {
              echo mysqli_error($connection);    
             }
        }
      }
   }

?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                             
                                <?php if(!isset($email_sent)) : ?>
                                
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>
                                    
                                     <?php else : ?>
                                     
                                    <p>An email has been sent to the address you provided, please check your email and follow the directions.  Please check your junk email, if you don't see the email in your inbox! Thanks</p>
                                    
                                    <?php endif; ?>
                                    
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
