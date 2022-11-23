<?php require './templates/header.php' ?>

<body style="background-color: #0c4a6e;">
<!-- SIGN UP SECTION START -->
<section id="signUpSection" class="box">
<?php 
  if(isset($_GET['error'])){
    if($_GET['error'] == 'emptyFields'){
      $errorMsg = 'Empty Fields - Please fill in all form fields';
    } else if($_GET['error'] == 'imageSize'){
      $errorMsg = 'Image Size Too Big - Please choose a smaller image';}
      else if($_GET['error'] == 'fileType'){
        $errorMsg = 'Wrong File Type - Please choose a .jpeg, .png, .gif, .jpeg or .svg image file';}
        else if($_GET['error'] == 'imageType'){
          $errorMsg = 'Wrong Image Type - Please choose a image/jpeg, image/png, image/gif, image/jng or image/svg file';}
          else if($_GET['error'] == 'invalidFields'){
            $errorMsg = 'Invalid Fields - Please make sure all form fields are valid';}
            else if($_GET['error'] == 'passwordCheck'){
              $errorMsg = 'Check Password - Your passwords do not match';}
              else if($_GET['error'] == 'sqlError'){
                $errorMsg = 'Sql Error - Something went wrong that isnt your fault';}
                else if($_GET['error'] == 'usernameTaken'){
                  $errorMsg = 'Username Taken - That username is taken, try a different one';}
                  else if($_GET['error'] == 'emailTaken'){
                    $errorMsg = 'Email Taken - That email is already in use, try a different one';}
    echo '<div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$errorMsg.'
  </div>';
  }
  ?>
      <h1>sign up</h1>
      <p>sign up to see your friends memories</p>
    <form action="./signup.inc.php" method="POST" id="signUpForm" enctype="multipart/form-data">
    <div class="step step-1 active">
    <div class="mb-3">
  <label for="signUpFirstName" class="visually-hidden">enter first name here</label>
  <input type="text" class="form-control" id="signUpFirstName" placeholder="your first name?" name="signUpFirstName" value="<?php if(!empty($_GET['firstName'])){echo $_GET['firstName'];} ?>">
      </div>
  <div class="mb-3">
  <label for="signUpLastName" class="visually-hidden">enter last name here</label>
  <input type="text" class="form-control" id="signUpLastName" placeholder="your last name?" name="signUpLastName" value="<?php if(!empty($_GET['lastName'])){echo $_GET['lastName'];} ?>">
  </div>
  <div class="mb-3">
  <label for="signUpEmail" class="visually-hidden">enter your email here</label>
  <input type="email" class="form-control" id="signUpEmail" placeholder="your email?" name="signUpEmail" value="<?php if(!empty($_GET['email'])){echo $_GET['email'];} ?>">
</div>
  <a class="btn btn-secondary mt-1" id="nextBTN">next</a>
    </div>
<div class="step step-2">
<div class="mb-3">
  <label for="signUpUsername" class="visually-hidden">enter your username here</label>
  <input type="text" class="form-control" id="signUpUsername" placeholder="create a fun username here" name="signUpUsername"value="<?php if(!empty($_GET['username'])){echo $_GET['username'];} ?>">
  </div>
  <div>
  <label for="signUpPassword" class="visually-hidden">enter your password here</label>
  <input type="password" class="form-control" id="signUpPassword" placeholder="enter your password*" name="signUpPassword">
  <p id="passwordNote">*your password must be at least 8 characters long, with at least 1 capital letter, 1 special character and 1 number</p>
  </div>
  <div class="mb-2">
  <label for="passwordConfirm" class="visually-hidden">confirm your password here</label>
  <input type="password" class="form-control" id="passwordConfirm" placeholder="confirm your password" name="passwordConfirm">
  </div>
  <a class="btn btn-secondary mt-1" id="nextBTNTwo">next</a>
</div>
<div class="step step-3">
  <div class="mb-3">
  <div class="input-group" style="width: 60%; margin:auto;">
  <input type="file" class="form-control" id="profileImg" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="profileImg">
</div>
  </div>
<div class="mb-3">
  <label for="profileBio" class="form-label">enter your profile's bio</label>
  <textarea class="form-control" id="profileBio" name="profileBio" rows="2" style="width: 60%;margin:auto;"><?php if(!empty($_GET['bio'])){echo $_GET['bio'];} ?></textarea>
</div>
<input type="submit" value="signup" name="submitSignup" class="btn btn-secondary mb-2">
</div>
    </form>
      <div class="copyrightTermConditions mt-2">
        <p class="pt-4">already got an account? <br>log in <a href="./login.php" class="link-brand underline">here</a></p>
      </div>
</section>
<!-- SIGN UP SECTION END -->


<canvas id="canvas-basic"></canvas>

<!-- COLOR CHANGE JS -->
<script src = "https://cdnjs.cloudflare.com/ajax/libs/granim/2.0.0/granim.js"></script>
<script type="text/javascript" src="./js/colorBackground.js"></script>

<!-- MULTI PAGE FORM JS -->
<script src="./js/multiPage.js"></script>
<!-- ALERT BTN SCRIPT -->
<script src="./js/alertBTN.js"></script>
</body>
</html>