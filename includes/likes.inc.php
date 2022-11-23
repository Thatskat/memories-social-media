<?php
session_start();
$userid = $_SESSION['userid'];
$userid = intval($userid);
if(isset($_POST['likeBTN']) && isset($_SESSION['userid']) && isset($_GET['post'])){
  require './connection.inc.php';

  $postid = mysqli_real_escape_string($conn, $_GET['post']);
  $postid = intval($postid);

  $sql = "SELECT postid, userid FROM likes WHERE userid=? AND postid=?";
  $statement = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($statement, $sql)){
    header('Location: ../home.php?error=sqlError');
    exit();
  }else {
    mysqli_stmt_bind_param($statement, "ii", $userid, $postid);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);

    $results = mysqli_stmt_num_rows($statement);
    if($results >= 1){
     $sql = "DELETE FROM likes WHERE userid=? and postid=?";
     $statement = mysqli_stmt_init($conn);

     if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ../home.php?error=sqlError");
      exit();
     } else {
      mysqli_stmt_bind_param($statement, "ii", $userid, $postid);
      mysqli_stmt_execute($statement);
      
      header("Location: ../home.php?success=postUnliked");
      exit();
     }
    } else {
      $sql = "INSERT INTO likes(userid, postid) VALUES (?,?);";
      $statement = mysqli_stmt_init($conn);
  
    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ../home.php?error=sqlError");
      exit();
    } else {
      mysqli_stmt_bind_param($statement, "ii", $userid, $postid);
      mysqli_stmt_execute($statement);
  
      header("Location: ../home.php?success=postLiked");
      exit();
    }
    }
   }
   mysqli_stmt_close($statement); 
   mysqli_close($conn); 
  }
  else {
  header("Location: ../home.php?error=forbidden");
  exit();
}
?>

