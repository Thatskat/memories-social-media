<?php require './templates/header.php' ?>
<body style="background-color: #0c4a6e;">
  
<!-- INDEX SECTION START -->
<section id="loginSection" class="box">
<?php 
  if(isset($_GET['error'])){
    if($_GET['error'] == 'emptyFields'){
      $errorMsg = 'Empty Fields - Please fill in all form fields';
    } else if($_GET['error'] == 'imageType'){
          $errorMsg = 'Wrong Image Type - Please choose a image/jpeg, image/png, image/gif, image/jng or image/svg file';}
            else if($_GET['error'] == 'wrongPassword'){
              $errorMsg = 'Wrong Password - That isnt the password for this account';}
              else if($_GET['error'] == 'sqlError'){
                $errorMsg = 'Sql Error - Something went wrong that isnt your fault';}
    echo '<div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$errorMsg.'
  </div>';
  } else if (isset($_GET['success'])){
    if($_GET['success'] == 'signup'){
      $successMsg = 'Success - You are all signed up';
    }    echo '<div class="alert success">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$successMsg.'
  </div>';
  }
  ?>
      <h1>login</h1>
      <p>login to connect with your friends</p>
    <form action="./includes/login.inc.php" method="POST" id="loginForm">
    <div class="mb-3 mt-5">
  <label for="loginEmailUsername" class="visually-hidden">enter your account's email or username</label>
  <input type="text" class="form-control" id="loginEmailUsername" placeholder="email or username" name="loginEmailUsername">
      </div>
  <div class="mb-3">
  <label for="loginPassword" class="visually-hidden">enter your account's password</label>
  <input type="password" class="form-control" id="loginPassword" placeholder="password" name="loginPassword">
  </div>
  <input type="submit" name="loginSubmit" value="login" class="btn btn-secondary mt-3 mb-2">
    </form>
      <div class="copyrightTermConditions mt-1">
        <p class="pt-4">don't have an account? <br>sign up <a href="./signup.php" class="link-brand underline">here</a></p>
      </div>
</section>
<!-- INDEX SECTION END -->

<canvas id="canvas-basic"></canvas>

<!-- COLOR CHANGE JS -->
<script src = "https://cdnjs.cloudflare.com/ajax/libs/granim/2.0.0/granim.js"></script>
<script type="text/javascript" src="./js/colorBackground.js"></script>
<!-- ALERT BTN SCRIPT -->
<script src="./js/alertBTN.js"></script>
</body>
</html>