<?php require './templates/header.php'?>
<body>
<?php require './templates/navbar.php' ?>

<!-- POST SECTION START -->
<section id="postSection" class="container">
<div class="row">
  <div class="col-4">
    <div class="postSectionNote">
    <h2>create a new post</h2>
    <p>upload a photo, write a caption and share it with your friends</p>
    <img src="./img/background-img/memories-posts-photo.jpg" alt="" class="w-100 h-50">
    </div>
  </div>
  <div class="col-8 mt-5 ps-5">
  <?php 
  if(isset($_GET['error'])){
    if($_GET['error'] == 'emptyFields'){
      $errorMsg = 'Empty Fields - Please fill in all form fields';
    } else if($_GET['error'] == 'imageSize'){
          $errorMsg = 'Wrong Image Size - Your image is too big. Please choose a smaller image';}
            else if($_GET['error'] == 'fileType'){
              $errorMsg = 'Wrong File Type - Please choose an image that is either a jpeg, png, gif, jpg or svg';}
              else if($_GET['error'] == 'sqlError'){
                $errorMsg = 'Sql Error - Something went wrong that isnt your fault';} else if ($_GET['error'] == 'followedSelf'){
                  $errorMsg = 'Error - You cannot follow yourself';
                } else if ($_GET['error'] == 'imageType'){
                  $errorMsg = 'Wrong Image Type - Please choose an image/jpeg, image/png, image/gif, image/jpg or image/svg types';
                }

    echo '<div class="alert" style="width:50%;">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$errorMsg.'
  </div>';
  } 
  ?>
    <form action="./post.inc.php" method="POST" id="postForm" enctype="multipart/form-data">
  <div class="mb-3">
  <label for="postUpload" class="form-label" style="margin-top: 1.5rem;">upload your photo</label>
  <input type="file" class="form-control w-75" id="postUpload" aria-describedby="postUpload" aria-label="Upload" name="postUpload">
  </div>
<div class="mb-3">
  <label for="postCaption" class="form-label">add a caption</label>
  <textarea class="form-control w-75" id="postCaption" name="postCaption" rows="2"></textarea>
</div>
<div class="mb-3">
  <label for="postLocation" class="form-label">add a location</label>
  <input type="text" class="form-control w-75" id="postLocation" placeholder="i.e melbourne, vic" name="postLocation">
</div>
<div class="mb-1">
  <label for="postDate" class="form-label">post date</label>
  <input type="text" class="form-control w-75" id="postDate" name="postDate" value=<?php date_default_timezone_set("Australia/Melbourne"); $date = date('Y-m-d'); echo $date; ?>>
</div>
<input type="submit" class="btn btn-secondary" value="post" name="submitPostUpload" style="width: 20%; margin-left:16rem;" id="phoneBTNCSS">
    </form>
  </div>
</div>
</section>
<!-- POST SECTION END -->

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
</div>
<!-- PROFILE MODAL END -->


<script src="./js/likeBTN.js"></script> 
<script src="./js/alertBTN.js"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> 
</body>
</html>