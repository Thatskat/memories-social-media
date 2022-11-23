<?php 
if(isset($_POST['submitSignup'])){
  require './includes/connection.inc.php';

  $firstName = mysqli_real_escape_string($conn, $_POST['signUpFirstName']);
  $lastName = mysqli_real_escape_string($conn, $_POST['signUpLastName']);
  $email = mysqli_real_escape_string($conn, $_POST['signUpEmail']);
  $username = mysqli_real_escape_string($conn, $_POST['signUpUsername']);
  $password = mysqli_real_escape_string($conn, $_POST['signUpPassword']);
  $passwordConfirm = mysqli_real_escape_string($conn, $_POST['passwordConfirm']);
  $bio = mysqli_real_escape_string($conn, $_POST['profileBio']);
  $profileImg = './profileImages/' . $_FILES['profileImg']['name'];
  $profileImg = mysqli_real_escape_string($conn, $profileImg);
  $imageFileType = strtolower(pathinfo($profileImg, PATHINFO_EXTENSION));
  $imageFileSize = $_FILES['profileImg']['size'];
  $imageType = $_FILES['profileImg']['type'];
  $maxSize = 1024 * 1024 * 2;

  // VALIDATION
  if(empty($firstName) || empty($lastName) || empty($email) || empty($username) || empty($passwordConfirm) || empty($bio) || empty($profileImg)){
    header("Location: ./signup.php?error=emptyFields");
    exit();
  } else if($imageFileSize > $maxSize){
    header("Location: ./signup.php?error=imageSize");
    exit();
  } else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg" &&$imageFileType != "svg") {
    header("Location: ./signup.php?error=fileType");
    exit();
  } else if($imageType != "image/jpeg" && $imageType != "image/png" && $imageType != "image/gif" && $imageType != "image/jpg" && $imageType != "image/svg") {
    header("Location: ./signup.php?error=imageType");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields");
    exit();
  } else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&bio=" . $bio);
    exit();
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) ) {
    header("Location: ./signup.php?error=invalidFields&lastName=" .$lastName);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) &&  !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)  && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&username=" .$username);
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&email=" . $email);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&bio=" . $bio . "&lastName=" . $lastName);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&bio=" . $bio . "&firstName=" . $firstName);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)  && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&bio=" . $bio . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&bio=" . $bio . "&username=" . $username);
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&bio=" . $bio . "&email=" . $email);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&lastName=" . $lastName . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&LastName=" . $lastName . "&username=" . $username);
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&lastName=" . $lastName . "&email=" . $email);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)  && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)  && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&username=" . $username);
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)  && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName ."&email=" . $email);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)  && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&username=" . $username . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields");
    exit();
  }  else if ( !preg_match("/^[a-zA-Z0-9]*$/", $username)&& !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&email=" .$email . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&bio=" . $bio);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&lastName=" . $lastName . "&bio=" . $bio . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)  && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&lastName=" . $lastName . "&username=" . $username . "&bio=" . $bio);
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&lastName=" . $lastName . "&email=" . $email . "&bio=" . $bio);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&bio=" . $bio) . "&passwordValid";
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)  && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)  && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&username=" . $username . "&bio=" . $bio);
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&email=" . $email . "&bio=" . $bio);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&username=" . $username . "&bio=" . $bio . "&passwordValid");
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)  && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&email=" . $email . "&bio=" . $bio . "&passwordValid");
    exit();
  }  else if (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password) && !preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&email=" . $email . "&username=". $username . "&bio=" . $bio);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)  && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&username=" . $username);
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&email=" . $email);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&username=" . $username . "&passwordValid");
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&email=" . $email . "&passwordValid");
    exit();
  }  else if (!preg_match("/^[a-zA-Z]*$/", $firstName) && !preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&email=" . $email . "&username=" . $username . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&bio=" . $bio . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&username=" . $username . "&bio=" . $bio);
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&email=" . $email . "&bio=" . $bio);
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&lastName=" . $lastName . "&username=" . $username . "&bio=" . $bio . "&passwordValid");
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&lastName=" . $lastName . "&email=" . $email . "&bio" . $bio . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&username=" . $username . "&passwordValid");
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName" . $lastName . "&email=" . $email . "&passwordValid");
    exit();
  }  else if (!preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&email=" . $email . "&username=" . $username . "&passwordValid");
    exit();
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&username=" . $username . "&bio=" . $bio . "&passwordValid");
    exit();
  }  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&email=" . $email . "&bio=" . $bio . "&passwordValid");
    exit();
  }  else if (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&lastName=" . $lastName . "&email=" . $email . "&username=" . $username . "&bio=" . $bio );
    exit();
  }else if (!preg_match("/^[a-zA-Z]*$/", $firstName)) {
    header("Location: ./signup.php?error=invalidFields&lastName=" . $lastName . "&email=" . $email . "&username=" . $username . "&bio=" . $bio . "&passwordValid");
    exit();
  }  else if (!preg_match("/^[a-zA-Z]*$/", $lastName)) {
    header("Location: ./signup.php?error=invalidFields&firstName=" . $firstName . "&email=" . $email . "&username=" . $username . "&bio=" . $bio . "&passwordValid");
    exit();
  }  else if($password !== $passwordConfirm){
    header("Location: ./signup.php?error=passwordCheck&firstname=" . $firstName . "&lastname=" . $lastName . "&email=" . $email . "&username=" . $username ."&bio=" . $bio);
    exit();
  } else {
    $sql = "SELECT username FROM users WHERE username=?";
    $statement = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ./signup.php?error=sqlError");
      exit();
    } else {
      mysqli_stmt_bind_param($statement, "s", $username);
      mysqli_stmt_execute($statement);
      mysqli_stmt_store_result($statement);

      $resultsCheck = mysqli_stmt_num_rows($statement);

      if($resultsCheck == 1 || $resultsCheck > 0){
        header("Location: ./signup.php?error=usernameTaken&firstName=" . $firstName . "&lastName=" . $lastName . "&email=" . $email . "&bio=" . $bio . "&passwordValid");
        exit();
      } else {
        $sql = "SELECT email FROM users WHERE email=?;";
        $statement = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($statement, $sql)){
          header("Location: ./signup.php?error=sqlError");
          exit();
        } else {
          mysqli_stmt_bind_param($statement, "s", $email);
          mysqli_stmt_execute($statement);
          mysqli_stmt_store_result($statement);

          $resultsCheck - mysqli_stmt_num_rows($statement);

          if($resultsCheck == 1 || $resultsCheck > 0){
            header("Location: ./signup.php?error=emailTaken&firstName=" . $firstName . "&lastName=" . $lastName . "&username=" . $username . "&bio=" . $bio . "&passwordValid");
            exit();
          } else {
            $sql = "INSERT INTO users(firstname, lastname, email, username, password, profilePic, bio) VALUES (?,?,?,?,?,?,?);";

            $statement = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($statement, $sql)){
              header("Location: ./signup.php?error=sqlError");
              exit();
            } else {
              $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

              mysqli_stmt_bind_param($statement, "sssssss", $firstName, $lastName, $email, $username, $passwordHashed, $profileImg, $bio);
              mysqli_stmt_execute($statement);
              if(move_uploaded_file($_FILES['profileImg']['tmp_name'], $profileImg)) {
                header("Location: ./login.php?success=signup");
                exit();
              } else {
                header("Location: ./signup.php?error=sqlError");
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
  header("Location: ./index.php?error=forbidden");
  exit();
}



?>