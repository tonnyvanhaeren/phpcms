<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>


<?php 

  if(isset($_POST['submit'])){
    $to       = $_POST['email'];    
    $subject  = $_POST['subject']; 
    $email    = $_POST['email']; 
    $body     = wordwrap($_POST['body'], 70);

    $header = "From: " . "";
    //mail("to", "subject", "body");

    mail($to, $subject, $body, $header);
  }

?>


  <!-- Navigation -->
  
  <?php  include "includes/navigation.php"; ?>
  

  <!-- Page Content -->
  <div class="container">
    
<section id="login">
  <div class="container">
    <div class="row">
      <div class="col-xs-6 col-xs-offset-3">
        <div class="form-wrap">
          <h1>Contact</h1>
          <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
            <div class="form-group">
              <label for="email" class="">Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
            </div>
            <div class="form-group">
              <label for="subject" class="">Subject</label>
              <input type="text" name="subject" id="subject" class="form-control">
            </div>            
            <div class="form-group">
              <label for="body" class="">Body</label>
              <textarea id="body" name="body" class="form-control" rows="10"></textarea>
            </div>
            <input type="submit" name="submit" id="btn-login" class="btn btn-success btn-lg btn-block" value="Send">
          </form>
            
        </div>
      </div> <!-- /.col-xs-12 -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</section>


<?php include "includes/footer.php";?>
