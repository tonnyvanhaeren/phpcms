<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

  <!-- Navigation -->
  <?php include "includes/admin_navigation.php"; ?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
                Welcome to comments
                <small>Author</small>
          </h1>

          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In response to</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['p_id']) . " ";
                $select_comments = mysqli_query($connection, $query);
              
                confirmQuery($select_comments);

                while($row = mysqli_fetch_assoc($select_comments)) {
                  $comment_id= $row['comment_id'];
                  $comment_post_id = $row['comment_post_id'];
                  $comment_author = $row['comment_author'];
                  $comment_email = $row['comment_email'];
                  $comment_content = $row['comment_content'];
                  $comment_status = $row['comment_status'];
                  $comment_date = $row['comment_date'];

                  echo "<tr>";
                    echo "<td>{$comment_id}</td>";
                    echo "<td>{$comment_author}</td>";
                    echo "<td>{$comment_content}</td>";
                    echo "<td>{$comment_email}</td>";
                    echo "<td>{$comment_status}</td>";

                    $query = "SELECT * FROM posts WHERE post_id= $comment_post_id " ;
                    $select_post_by_id = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_assoc($select_post_by_id)) {
                      $post_id = $row['post_id'];
                      $post_title = $row['post_title'];
                      
                      echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
                    }
              
                    echo "<td>{$comment_date}</td>";

                    echo "<td><a href='post_comments.php?approve=$comment_id&p_id=" . $_GET['p_id'] . "'>Approve</a></td>";
                    echo "<td><a href='post_comments.php?unapprove=$comment_id&p_id=" . $_GET['p_id'] . "'>Up Approve</a></td>";
                    echo "<td><a href='post_comments.php?delete=$comment_id&p_id=" . $_GET['p_id'] . "'>Delete</a></td>";
                  echo "</tr>";
              
                }
              ?>

              <?php
                if(isset($_GET['approve'])){
                  $comment_id = escape($_GET['approve']); 
                  $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_id} ";

                  $approve = mysqli_query($connection, $query);
                  header("Location: post_comments.php?p_id=" . $_GET['p_id'] . "");  
                }

                if(isset($_GET['unapprove'])){
                  $comment_id = escape($_GET['unapprove']); 
                  $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id} ";

                  $unapprove = mysqli_query($connection, $query);
                  header("Location: post_comments.php?p_id=" . $_GET['p_id'] . "");  
                }

                if(isset($_GET['delete'])){
                  $comment_id = escape($_GET['delete']); 
                  $query = "DELETE FROM comments WHERE comment_id = {$comment_id} ";

                  $delete = mysqli_query($connection, $query);
                  header("Location: post_comments.php?p_id=" . $_GET['p_id'] . "");  
                }
              
              ?>
            </tbody>
          </table>
        </div>        
      </div>
    </div>
  </div>    
</div>

<?php include "includes/admin_footer.php"; ?>