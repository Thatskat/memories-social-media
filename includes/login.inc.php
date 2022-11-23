<?php
if(isset($_POST['loginSubmit'])){
  require './connection.inc.php';

  $loginEmailUsername = mysqli_real_escape_string($conn, $_POST['loginEmailUsername']);
  $loginPassword = mysqli_real_escape_string($conn, $_POST['loginPassword']);

  if(empty($loginEmailUsername) || empty($loginPassword)){
    header("Location: ../login.php?error=emptyFields");
    exit();
  } else {
    $sql = "SELECT * FROM users WHERE username=? OR email=? OR password=?;";

    $statement = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ../login.php?error=sqlError");
      exit();
    } else {
     mysqli_stmt_bind_param($statement, "sss", $loginEmailUsername, $loginEmailUsername, $loginPassword);
     mysqli_stmt_execute($statement);
     $results = mysqli_stmt_get_result($statement);

     if($row = mysqli_fetch_assoc($results)){
      $passwordCheck = password_verify($loginPassword, $row['password']);

      if($passwordCheck == false){
        header('Location: ../login.php?error=wrongPassword');
        exit();
      } else if ($passwordCheck == true){
        session_start();

        $_SESSION['username'] = $row['username'];
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['bio'] = $row['bio'];
        $_SESSION['profilePic'] = $row['profilePic'];

        header("Location: ../home.php?success=login");
        exit();
      } else {
        header("Location: ../login.php?error=sqlError");
        exit();
      }
     }
    }
  }
  mysqli_stmt_close($statement);
  mysqli_close($conn);

} else {
  header("Location: ../index.php?error=forbidden");
  exit();
}



?>