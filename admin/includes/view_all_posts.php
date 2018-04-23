<?php 
  if(isset($_POST['checkBoxArray'])){

    foreach($_POST['checkBoxArray'] as $postValueId ){

      $bulk_options = $_POST['bulk_options'] ;

      switch($bulk_options) {
        case 'published':
          $query = "UPDATE posts SET post_status = '{$bulk_options}'
            WHERE post_id = {$postValueId} ";
          $update_to_published_status = mysqli_query($connection, $query);

          confirmQuery($update_to_published_status);

          break;
        case 'draft':
          $query = "UPDATE posts SET post_status = '{$bulk_options}'
            WHERE post_id = {$postValueId} ";
          $update_to_draft_status = mysqli_query($connection, $query);

          confirmQuery($update_to_draft_status);

          break;
        case 'delete':
          $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
          $update_to_delete_status = mysqli_query($connection, $query);

          confirmQuery($update_to_delete_status);

          break;
        case 'clone':
          $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
          $select_post_query = mysqli_query($connection, $query);
        
          while ($row = mysqli_fetch_array($select_post_query)) {
            $post_title         = $row['post_title'];
            $post_category_id   = $row['post_category_id'];
            $post_date          = $row['post_date']; 
            $post_author        = $row['post_author'];
            $post_status        = $row['post_status'];
            $post_image         = $row['post_image'] ; 
            $post_tags          = $row['post_tags']; 
            $post_content       = $row['post_content'];
          }
               
          $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,post_content,post_tags,post_status) ";
          $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') "; 

          $copy_query = mysqli_query($connection, $query);   

          confirmQuery($copy_query);
              
            break;
          case 'reset_wiews_count':
            $query = "UPDATE posts SET post_views_count = 0
              WHERE post_id = {$postValueId} ";
            $update_views_post = mysqli_query($connection, $query);
  
            confirmQuery($update_views_post);
  
            break;            
            
      }
    }
  }
?>

<form action="" method="post">
  <div id="bulkOptionsContainer" class="col-xs-4">
    <select class="form-control" name="bulk_options" id="">
      <option value="">Select Options</option>
      <option value="published">Publish</option>
      <option value="draft">Draft</option>
      <option value="delete">Delete</option>
      <option value="clone">Clone</option>
      <option value="reset_wiews_count">Reset views count</option>
    </select>
  </div>
  <div class="col-xs-4">
    <input type="submit" name="submit" class="btn btn-success" value="Apply">
    <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
  </div>


  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>Id</th>
        <th>Author</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Content</th>
        <th>Comment Count</th>
        <th>Date</th>
        <th>Visited</th>
        <th>Show</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $query = "SELECT * FROM posts ORDER BY post_id DESC ";
        $select_posts = mysqli_query($connection, $query);
      
        while($row = mysqli_fetch_assoc($select_posts)) {
          $post_id = $row['post_id'];
          $post_author = $row['post_author'];
          $post_title = $row['post_title'];
          $post_category_id = $row['post_category_id'];
          $post_status = $row['post_status'];
          $post_image = $row['post_image'];
          $post_tags = $row['post_tags'];
          $post_content = $row['post_content'];
          $post_comment_count = $row['post_comment_count'];
          $post_date = $row['post_date'];
          $post_views_count = $row['post_views_count'];

          echo "<tr>";
            ?>

              <td>
                <input type='checkbox' class='checkBoxes' name='checkBoxArray[]'  value='<?php echo $post_id ;?>'>
              </td>

            <?php  

            echo "<td>{$post_id}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$post_title}</td>";

            $query = "SELECT cat_title FROM categories WHERE cat_id= {$post_category_id} "; 
            $select_categories_id = mysqli_query($connection, $query);
    
            confirmQuery($select_categories_id);

            while($row = mysqli_fetch_assoc($select_categories_id)) {

              $cat_title = $row['cat_title'];

              echo "<td>{$cat_title}</td>";
            }  

            echo "<td>{$post_status}</td>";
            echo "<td><img width='100' src='../images/$post_image' alt='post image' /></td>";
            echo "<td>{$post_tags}</td>";
            echo "<td>{$post_content}</td>";

            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
            $count_comments_query = mysqli_query($connection, $query);
            $count_comments = mysqli_num_rows($count_comments_query);



            echo "<td><a href='post_comments.php?p_id=$post_id'>{$count_comments}</a></td>";

            echo "<td>{$post_date}</td>";

            echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";

            echo "<td><a href='../post.php?p_id={$post_id}'>Details</a></td>";
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            //javascript confirm function
            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";

          echo "</tr>";
      
        }
      ?>

      <?php
        if(isset($_GET['delete'])){
          $id = $_GET['delete']; 
          $query = "DELETE FROM posts WHERE post_id = {$id} ";

          $delete = mysqli_query($connection, $query);
          header("Location: posts.php");  
        }

        if(isset($_GET['reset'])){
          $id = $_GET['reset'];
          
          $clean_id = mysqli_real_escape_string($connection, $id);


          $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$clean_id} ";

          $update_views_count = mysqli_query($connection, $query);
          header("Location: posts.php");  
        }
     
      ?>
    </tbody>
  </table>

</form>  