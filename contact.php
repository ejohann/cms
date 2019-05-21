<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>












<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact Us</h1>
                    <form role="form" action="contact.php" method="post" id="contact-form" autocomplete="off">
                        <h6 class="text-center"><?php // echo $message; ?></h6>
                        <div class="form-group">
                            <label for="contact_name" class="">Your Name: </label>
                            <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="Enter Name">
                        </div>
                         <div class="form-group">
                            <label for="email" class="">Your Email: </label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter  Your Email">
                        </div>
                        <div class="form-group">
                            <label for="message_subject" class="">Subject: </label>
                            <input type="text" name="message_subject" id="message_subject" class="form-control" placeholder="Enter Message Subject">
                        </div>
                        
                        <div class="form-group">
                          <label for="message_content">Message: </label>
                          <textarea class="form-control" id="message_content" name="message_content" placeholder="Enter Message"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Contact Us">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>




































<?php include "includes/footer.php";?>