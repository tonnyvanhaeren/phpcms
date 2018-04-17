<?php include "db.php"; ?>
<?php session_start() ; ?>

<?php 
  if(isset($_POST['login'])){
    $username      = $_POST['username']; 
    $password = $_POST['user_password'];

    $username =  mysqli_real_escape_string($connection, $username);
    $password =  mysqli_real_escape_string($connection, $password);

    $query = "SELECT * from users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    
    if (!$select_user_query){
      die('QUERY FAILED' . mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user_query)){
      
      $user_id = $row['user_id'];
      $user_firstname = $row['user_firstname'];
      $user_lastname = $row['user_lastname'];
      $user_role = $row['user_role'];
      $user_email = $row['user_email'];
      $user_username = $row['username'];
      $user_password = $row['user_password'];
 
    }

    if($username === $user_username && $password === $user_password) {

      $_SESSION['username'] = $user_username ; 
      $_SESSION['firstname'] = $user_firstname ; 
      $_SESSION['lastname'] = $user_lastname ; 
      $_SESSION['user_role'] = $user_role ; 
      $_SESSION['email'] = $user_email ; 

      header("Location: ../admin");
    } else {
      header("Location: ../index.php");
    }
  }
?>
