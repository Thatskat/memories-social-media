<?php require './templates/header.php' ?>
<body>
<?php require './templates/navbar.php' ?>

<!-- UPDATE PROFILE START -->
<section class="container" id="updateProfile">
  <?php
  if(isset($_GET['user']) && isset($_SESSION['userid'])){
    require './includes/connection.inc.php';

    $userid = mysqli_real_escape_string($conn, $_GET['user']);
    $userid = intval($userid);

    $sql = "SELECT * FROM users WHERE userid=?;";
    $statement = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location ./updateProfile.php?error=sqlError");
      exit();
    } else {
      mysqli_stmt_bind_param($statement, "i", $userid);
      mysqli_stmt_execute($statement);
      $results = mysqli_stmt_get_result($statement);
      $row = mysqli_fetch_assoc($results);
    }
  } else {
    header("Location: ./home.php?error=forbidden");
    exit();
  }
  ?>
  <div class="row">
    <div class="col-4 mt-5">
      <div class="previousProfile">
      <h1>update your profile</h1>
    <img src="<?php if(!empty($_GET['user'])){echo $row['profilePic'];}?>" alt="">
    <p>username - <?php if(!empty($_GET['user'])){echo $row['username'];} ?></p>
    <p>name - <?php if(!empty($_GET['user'])){echo $row['firstname']; echo " "; echo $row['lastname'];} ?></p>
    <p>account email - <?php if(!empty($_GET['user'])){echo $row['email'];} ?></p>
    <p>bio - <?php if(!empty($_GET['user'])){echo $row['bio'];} ?></p>
      </div>
    </div>
    <div class="col-8 mt-5 ps-5">
    <?php 
  if(isset($_GET['error'])){
    if($_GET['error'] == 'emptyFields'){
      $errorMsg = 'Empty Fields - Please fill in all form fields';
    } else if($_GET['error'] == 'imageSize'){
          $errorMsg = 'Oops - Your profile image is too big. Please choose a smaller profile image file';}
            else if($_GET['error'] == 'fileType'){
              $errorMsg = 'Wrong File Type - Please upload a jpg, png, gif, jpeg or svg image file';}
              else if($_GET['error'] == 'sqlError'){
                $errorMsg = 'Sql Error - Something went wrong that isnt your fault';} else if ($_GET['error'] == 'imageType'){
                  $errorMsg = 'Wrong image type - Please choose an image/jpeg, image/png, image/gif, image/jpg or image/svg file';
                } else if ($_GET['error'] == 'invalidFields'){
                  $errorMsg = 'Oops - Some of your inputs are invalid. Please change them to be valid';
                }
                else if ($_GET['error'] == 'usernameTaken'){
                  $errorMsg = 'Oh no - That username has already been taken. Please choose a different and possibly more creative username';
                }else if ($_GET['error'] == 'emailTaken'){
                  $errorMsg = 'Oh no - That email is associated with another account. Try a different email';
                }

    echo '<div class="alert" style="width:50%;">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$errorMsg.'
  </div>';
  } else if (isset($_GET['success'])){
      if($_GET['success'] == 'updateProfile'){
        $successMsg = 'Success - Your profile has been updated';
      } 
       echo '<div class="alert success" style="width:50%;">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$successMsg.'
  </div>';
  }
  ?>
<form action="./updateProfile.inc.php?user=<?php echo $_GET['user'] ?>" method="POST" enctype="multipart/form-data" id="signUpForm">
<div class="step step-1 active">
    <div class="mb-3">
  <label for="updateFirstName" class="form-label">update your first name</label>
  <input type="text" class="form-control" id="updateFirstName" placeholder="your first name?" name="updateFirstName" value="<?php echo $row['firstname']; ?>">
      </div>
  <div class="mb-3">
  <label for="updateLastName" class="form-label">update your last name</label>
  <input type="text" class="form-control" id="updateLastName" placeholder="your last name?" name="updateLastName" value="<?php echo $row['lastname']; ?>">
  </div>
  <div class="mb-3">
  <label for="updateEmail" class="form-label">update your email</label>
  <input type="email" class="form-control" id="updateEmail" placeholder="your email?" name="updateEmail" value="<?php echo $row['email']; ?>">
</div>
  <a class="btn btn-secondary mt-4" id="nextBTN" >next</a>
  <div><p class="mt-5">Want to update your account details?</p><div>
</div>
    </div>
  </div>
  <div class="step step-2">
<div class="mb-3">
  <label for="updateUsername" class="form-label">update your username</label>
  <input type="text" class="form-control" id="updateUsername" placeholder="create a fun username here" name="updateUsername"value="<?php echo $row['username']?>">
  </div>
  <label for="updatePassword" class="form-label">update your password</label>
  <input type="password" class="form-control" id="updatePassword" placeholder="enter your password*" name="updatePassword">
  <p id="passwordNote">*your password must be at least 8 characters long, with at least 1 capital letter, 1 special character and 1 number</p>
<div class="input-group" style="width: 75%;border-radius:15px;">
  <input type="file" class="form-control" id="profileImg" aria-describedby="updateProfileImg" aria-label="Upload" name="updateProfileImg" >
  <p>Your previous profile picture was <?php echo $row['profilePic']?></p>
</div>
<div class="mb-3">
  <label for="updateBio" class="form-label">update your profile's bio</label>
  <textarea class="form-control" id="updateBio" name="updateBio" rows="2"><?php echo $row['bio'] ?></textarea>
</div>
<input type="submit" value="update" name="submitUpdateProfile" class="btn btn-secondary">
<div><p>Want to update your account details?</p><div>
</form>
</section>
<!-- UPDATE PROFILE END -->

<!-- PROFILE MODAL START -->
<?php
  require './includes/connection.inc.php';
  $sql="SELECT * FROM followers WHERE followedUserid=$_SESSION[userid];";
  if($results = mysqli_query($conn, $sql)){
    $accountFollowers = mysqli_num_rows($results);
  }
  $sqlFollowing = "SELECT * FROM followers WHERE followerUserid=$_SESSION[userid];";
  if($results = mysqli_query($conn, $sqlFollowing)){
    $accountFollowing = mysqli_num_rows($results);
  }
  ?>
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">profile</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="<?php echo $_SESSION['profilePic'] ?>" alt="<?php echo $_SESSION['username'] ?>" style="width: 10rem;">
        <h1><?php echo $_SESSION['username'] ?></h1>
        <p>followers - <?php echo '<a href="./followers.php?user='.$_SESSION['userid'].'">'. $accountFollowers .'</a>'?>&nbsp;&nbsp;&nbsp;&nbsp; following - <?php echo '<a href="./following.php?user='.$_SESSION['userid'].'">'. $accountFollowing .'</a>' ?></p>
        <p class="modalLeft">name - <?php echo $_SESSION['firstname']; echo " "; echo $_SESSION['lastname']; ?></p>
        <p class="modalLeft">memories bio - <?php echo $_SESSION['bio'] ?></p>
      <div class="modal-footer">
      <a href="./updateProfile.php?user=<?php echo $_SESSION['userid'] ?>" class="btn btn-brand">update profile</a>
      </div>
    </div>
  </div>
</div>
<!-- PROFILE MODAL END -->


<script src="./js/multiPage.js"></script>
<script src="./js/likeBTN.js"></script> 
<script src="./js/alertBTN.js"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> 
<?php require './templates/footer.php' ?>
</body>
</html>