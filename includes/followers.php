<?php
session_start();
$followerId = $_SESSION['userid'];
$followerId = intval($followerId);
if(isset($_POST['followBTN']) && isset($_SESSION['userid']) && isset($_GET['user'])){
  require './connection.inc.php';

  $followedId = mysqli_real_escape_string($conn, $_GET['user']);
  $followedId = intval($followedId);

  $sql = "SELECT followedUserid, followerUserid FROM followers WHERE followedUserid=? AND followerUserid=?;";
  $statement = mysqli_stmt_init($conn);

  if($followedId === $followerId) {
    header("Location: ../home.php?error=followedSelf");
    exit();
  } else {
    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Header: ../home.php?error=sqlError");
      exit();
    } else {
      mysqli_stmt_bind_param($statement, "ii", $followedId, $followerId);
      mysqli_stmt_execute($statement);
      mysqli_stmt_store_result($statement);

      $results = mysqli_stmt_num_rows($statement);
      if($results >= 1){
        $sql = "DELETE FROM followers WHERE followedUserid=? and followerUserid=?;";
        $statement = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($statement, $sql)){
          header("Location: ../home.php?error=sqlError");
          exit();
        } else {
          mysqli_stmt_bind_param($statement, "ii", $followedId, $followerId);
          mysqli_stmt_execute($statement);
          header("Location: ../home.php?success=userUnfollowed");
          exit();
        }

      } else {

        $sql = "INSERT INTO followers(followedUserid, followerUserid) VALUES (?,?);";
        $statement = mysqli_stmt_init($conn);
  
        if(!mysqli_stmt_prepare($statement, $sql)){
          header("Location: ../home.php?error=sqlError");
          exit();
        } else {
          mysqli_stmt_bind_param($statement, "ii", $followedId, $followerId);
          mysqli_stmt_execute($statement);
  
          header("Location: ../home.php?success=userFollowed");
          exit();
        }
      }
    }
  }  
mysqli_stmt_close($statement); 
mysqli_close($conn); 
} else {
  header("Location: ../home.php?error=forbidden");
  exit();
}
?>