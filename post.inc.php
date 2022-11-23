<?php
session_start();
$userid = $_SESSION['userid'];
if(isset($_POST['submitPostUpload']) && isset($userid)){
  require './includes/connection.inc.php';
  
  $postImage = './uploads/' . $_FILES['postUpload']['name'];
  $postImage = mysqli_real_escape_string($conn, $postImage);
  $imageFileType = strtolower(pathinfo($postImage, PATHINFO_EXTENSION));
  $imageFileSize = $_FILES['postUpload']['size'];
  $imageType = $_FILES['postUpload']['type'];
  $maxSize = 1024 * 1024 * 5;
  $postCaption = mysqli_real_escape_string($conn, $_POST['postCaption']);
  $postLocation = mysqli_real_escape_string($conn, $_POST['postLocation']);
  $postDate = mysqli_real_escape_string($conn, $_POST['postDate']);


  if(empty($postImage) || empty($postCaption) || empty($postLocation) || empty($postDate)) {
    header("Location: ./post.php?error=emptyFields");
    exit();
  } else if($imageFileSize > $maxSize){
    header("Location: ./post.php?error=imageSize");
    exit();
  } else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg" &&$imageFileType != "svg") {
    header("Location: ./post.php?error=fileType");
    exit();
  } else if($imageType != "image/jpeg" && $imageType != "image/png" && $imageType != "image/gif" && $imageType != "image/jpg" && $imageType != "image/svg") {
    header("Location: ./post.php?error=imageType");
    exit();
  } else {
    $userid = intval($userid);
    $sql = "INSERT INTO posts(userid, postImage, caption, postDate, location) VALUES (?,?,?,?,?);";
    $statement = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ./post.php?error=sqlError");
      exit();
    } else {

      mysqli_stmt_bind_param($statement, "issss", $userid, $postImage, $postCaption, $postDate, $postLocation);
      mysqli_stmt_execute($statement);
    
      if(move_uploaded_file($_FILES['postUpload']['tmp_name'], $postImage)){
        header("Location: ./home.php?success=postUploaded");
        exit();
      } else {
        header("Location: ./post.php?error=sqlError");
        exit();
      }
    }
    } 

  mysqli_stmt_close($statement); 
  mysqli_close($conn); 

} else {
  header("Location: ./home.php?error=forbidden");
  exit();
}

?>