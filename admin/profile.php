<?php include "includes/admin_header.php"; ?>

<?php

  if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    $query = "SELECT * from users WHERE username = '{$username}' ";
    $select_user = mysqli_query($connection, $query);

    confirmQuery($select_user);

    while($row = mysqli_fetch_array($select_user)) {
      $user_id= $row['user_id'];
      $username = $row['username'];
      $user_password = $row['user_password'];
      $user_firstname = $row['user_firstname'];
      $user_lastname = $row['user_lastname'];
      $user_email = $row['user_email'];
      $user_image = $row['user_image'];
      $user_role = $row['user_role'];
    }
  }

  if(isset($_POST['edit_profile'])){

    $user_firstname   = escape($_POST['user_firstname']);
    $user_lastname    = escape($_POST['user_lastname']);
    $user_role        = escape($_POST['user_role']);
  
   // $post_image = $_FILES['image']['name'];
   // $post_image_temp = $_FILES['image']['tmp_name'];
  
    //$username      = $_POST['username'];
    $user_email    = escape($_POST['user_email']);
    $user_password = escape($_POST['user_password']);
    //$post_date     = ('d-m-y');
     
    $query = "UPDATE users SET ";
    $query .="user_firstname  = '{$user_firstname}', ";
    $query .="user_lastname = '{$user_lastname}', ";
    $query .="user_role   =  '{$user_role}', ";
    //$query .="username = '{$username}', ";
    $query .="user_email = '{$user_email}', ";
    $query .="user_password   = '{$user_password}' ";
    $query .= "WHERE username = '{$username}' ";
  
    $edit_profile_query = mysqli_query($connection,$query);
    confirmQuery($edit_profile_query);
  }

?>

<div id="wrapper">

  <!-- Navigation -->
  <?php include "includes/admin_navigation.php"; ?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
        <h1 class="page-header">
          Welcome to the Admin
          <small><?php echo $username ; ?></small>
        </h1>

          <form action="" method="post" enctype="multipart/form-data">    
            <div class="form-group">
              <label for="user_firstname">Firstname</label>
              <input type="text" value="<?php echo $user_firstname ; ?>" class="form-control" name="user_firstname">
            </div>
            <div class="form-group">
              <label for="user_lastname">Lastname</label>
              <input type="text" value="<?php echo $user_lastname ; ?>" class="form-control" name="user_lastname">
            </div>

          <!--   <div class="form-group">
              <label for="user_image">Image</label>
              <input type="file" class="form-control" name="user_image">
            </div> -->


            <div class="form-group">
              <select class="form-control" name="user_role" id="">
                <option value="<?php echo $user_role; ?>" > <?php echo $user_role ; ?></option>

                <?php 

                  if($user_role == 'admin') {
                    echo "<option value='subscriber'>subscriber</option>" ;
                  } else {
                    echo "<option value='admin'>admin</option>" ;
                  }
                ?>
              
              </select>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" value="<?php echo $username ; ?>" class="form-control" name="username">
            </div>
            <div class="form-group">
              <label for="user_email">Email</label>
              <input type="email" value="<?php echo $user_email ; ?>" class="form-control" name="user_email">
            </div>
            <div class="form-group">
              <label for="user_password">Password</label>
              <input type="password" value="<?php echo $user_password ; ?>" class="form-control" name="user_password">
            </div>
              <div class="form-group">
                <input class="btn btn-primary" type="submit" name="edit_profile" value="Update Profile">
              </div>
          </form>

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