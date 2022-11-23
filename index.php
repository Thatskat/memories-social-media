<?php require './templates/header.php' ?>
<body style="background-color: #0c4a6e;">
  
<!-- INDEX SECTION START -->
<section id="indexSection" class="box">
  <?php 
  if(isset($_GET['error'])){
    if($_GET['error'] == 'forbidden'){
      $errorMsg = 'Error 403 - Forbidden.<br>You do not have permission to access this page';
    }
    echo '<div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$errorMsg.'
  </div>';
  } else if (isset($_GET['success'])){
    if($_GET['success'] == 'logout'){
      $successMsg = 'You have been logged out successfully';
    }
    echo '<div class="alert success" style="width:100%;">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$successMsg.'
  </div>';
  }

  ?>
      <h1 class="mt-3">memories</h1>
      <p class="sub-heading mb-3">the new way to social media</p>
      <a class="btn btn-brand d-block" id="loginBTN" href="./login.php">login</a>
      <a class="btn btn-secondary" href="./signup.php">sign up</a>
      <div class="copyrightTermConditions mt-5">
        <p class="pt-4">for any concerns <br>please see our <a href="#" class="link-brand underline">terms & conditions</a></p>
      </div>
</section>
<!-- INDEX SECTION END -->
<canvas id="canvas-basic"></canvas>

<!-- COLOR CHANGE JS -->
<script src = "https://cdnjs.cloudflare.com/ajax/libs/granim/2.0.0/granim.js"></script>
<script type="text/javascript" src="./js/colorBackground.js"></script>
<script src="./js/alertBTN.js"></script>
</body>
</html>
