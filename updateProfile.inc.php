<?php
session_start();
if(isset($_POST['submitUpdateProfile']) && $_GET['user']){
require './includes/connection.inc.php';

$userid = $_GET['user'];
$userid = intval($userid);

$firstName = mysqli_real_escape_string($conn, $_POST['updateFirstName']);
$lastName = mysqli_real_escape_string($conn, $_POST['updateLastName']);
$email = mysqli_real_escape_string($conn, $_POST['updateEmail']);
$username = mysqli_real_escape_string($conn, $_POST['updateUsername']);
$password = mysqli_real_escape_string($conn, $_POST['updatePassword']);
$bio = mysqli_real_escape_string($conn, $_POST['updateBio']);

$profileImg = './profileImages/' . $_FILES['updateProfileImg']['name'];
$profileImg = mysqli_real_escape_string($conn, $profileImg);
$imageFileType = strtolower(pathinfo($profileImg, PATHINFO_EXTENSION));
$imageFileSize = $_FILES['updateProfileImg']['size'];
$imageType = $_FILES['updateProfileImg']['type'];
$maxSize = 1024 * 1024 * 2;

if(empty($firstName) || empty($lastName) || empty($email) || empty($username) || empty($password) || empty($bio) || empty($profileImg)){
  header("Location: ./updateProfile.php?error=emptyFields&user=" . $userid);
  exit();
} else if($imageFileSize > $maxSize){
  header("Location: ./updateProfile.php?error=imageSize&user=" . $userid);
  exit();
} else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg" &&$imageFileType != "svg"){
  header("Location: ./updateProfile.php?error=fileType&user=" . $userid);
  exit();
}else if($imageType != "image/jpeg" && $imageType != "image/png" && $imageType != "image/gif" && $imageType != "image/jpg" && $imageType != "image/svg") {
  header("Location: ./updateProfilep.php?error=imageType&user=" . $userid);
  exit();
}  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
  header("Location: ./updateProfile.php?error=invalidFields&user=" . $userid);
  exit();
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z0-9]*$/", $username) || !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) || !preg_match("/^[a-zA-Z]*$/", $firstName) || !preg_match("/^[a-zA-Z]*$/", $lastName)) {
  header("Location: ./updateProfile?error=invalidFields&user=" . $userid);
  exit();
} else {
  $sql = "SELECT username FROM users WHERE username=?;";
  $statement = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($statement, $sql)){
    header("Location: ./updateProfile.php?error=sqlError&user=" . $userid);
    exit();
  } else {
    mysqli_stmt_bind_param($statement, "s", $username);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);

    $results = mysqli_stmt_num_rows($statement);

    if($results > 1){
      header("Location: ./updateProfile.php?error=usernameTaken&user=" . $userid);
      exit();
    } else {
      $sql = "SELECT email FROM users WHERE email=?;";
      $statement = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($statement, $sql)){
        header("Location: ./updateProfile.php?error=emailTaken&user=" . $userid);
        exit();
      } else {
        mysqli_stmt_bind_param($statement, "s", $email);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);

        $results = mysqli_stmt_num_rows($statement);

        if($results > 1){
          header("Location: ./updateProfile.php?error=emailTaken&user=" . $userid);
          exit();
        } else {
          $sql = "UPDATE users SET firstname=?, lastname=?, email=?, username =?, password=?, profilePic=?,bio=? WHERE userid=?;";
          $statement = mysqli_stmt_init($conn);

          if(!mysqli_stmt_prepare($statement, $sql)){
            header("Location: ./updateProfile.php?error=sqlError&user=" . $userid);
            exit();
          } else {
            $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

            mysqli_stmt_bind_param($statement, "sssssssi", $firstName, $lastName, $email, $username, $passwordHashed, $profileImg, $bio, $userid);
            mysqli_stmt_execute($statement);

            if(move_uploaded_file($_FILES['updateProfileImg']['tmp_name'], $profileImg)){
              header("Location: ./updateProfile.php?success=updateProfile&user=" . $userid);
              exit();
            } else {
              header("Location: ./updateProfile.php?error=sqlError&user=" . $userid);
              exit();
            }
          }
        }
      }
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