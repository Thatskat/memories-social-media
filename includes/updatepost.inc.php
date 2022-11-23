<?php
session_start(); 
if(isset($_SESSION['userid']) && isset($_POST['submitEditPost']) && isset($_GET['post'])){
  require './connection.inc.php';

  $caption = mysqli_real_escape_string($conn, $_POST['editCaption']);
  $location = mysqli_real_escape_string($conn, $_POST['editLocation']);
  $date = mysqli_real_escape_string($conn, $_POST['editDate']);
  $postid = mysqli_real_escape_string($conn, $_GET['post']);
  $postid = intval($postid);

  if(empty($caption) || empty($location) || empty($date)){
    header("Location: ../editpost.php?error=emptyFields&post=" . $postid);
    exit();
  } else {
    $sql = "UPDATE posts SET caption=?, postDate=?, location=? WHERE postid=? AND userid=?;";
    $statement = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ../editpost.php?error=sqlError&post=".$postid);
      exit();
    } else {
      mysqli_stmt_bind_param($statement, "sssii", $caption, $date, $location, $postid, $_SESSION['userid']);
      mysqli_stmt_execute($statement);

      header("Location: ../home.php?success=postUpdated");
      exit();
    }
  }
  mysqli_stmt_close($statement);
mysqli_close($conn);
} else {
  header("Location: ../home.php?error=forbidden");
  exit();
}



?>