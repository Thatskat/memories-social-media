<?php
session_start();
if(isset($_GET['post']) && isset($_SESSION['userid'])){
  require './connection.inc.php';

  $postid = mysqli_real_escape_string($conn, $_GET['post']);
  $postid = intval($postid);

  $sql = "DELETE FROM likes WHERE postid=?;";

  $statement = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($statement, $sql)){
    header("Location: ../home.php?error=sqlError&post=" . $postid);
    exit();
  } else {
    mysqli_stmt_bind_param($statement, "i", $postid);
    mysqli_stmt_execute($statement);

    if(mysqli_stmt_execute($statement) == false){
      header("Location: ../home.php?error=sqlError");
      exit();
    } else {

      $sql = "DELETE FROM posts WHERE postid=?;";
      $statement = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($statement, $sql)){
        header("Location: ../home.php?error=sqlError&post=" . $postid);
        exit();
      } else {
        mysqli_stmt_bind_param($statement, "i", $postid);
        mysqli_stmt_execute($statement);
        if(mysqli_stmt_execute($statement) == false){
          header("Location: ../home.php?error=sqlError&post=" . $postid);
          exit();
        } else {
         header("Location : ../home.php?success=postDeleted&post=" . $postid);
        exit();
      }
        }
      }

    }  mysqli_stmt_close($statement);
    mysqli_close($conn);
  }

else {
  header("Location: ../home.php?error=forbidden");
  exit();
}


?>