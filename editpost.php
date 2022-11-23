<?php require './templates/header.php' ?>
<body>
<?php require './templates/navbar.php' ?>

<!-- EDIT POST START -->
<section class="container" id="updatePostSection" style="margin-top: 4rem;">
  <?php 
  if(isset($_GET['post']) && isset($_SESSION['userid'])){
    require './includes/connection.inc.php';

    $postid = mysqli_real_escape_string($conn, $_GET['post']);
    $postid = intval($postid);

    $sql = "SELECT * FROM posts WHERE postid=?;";
    $statement = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ../editpost.php?error=sqlError&post=" . $postid);
      exit();
    } else {
      mysqli_stmt_bind_param($statement, "i", $postid);
      mysqli_stmt_execute($statement);

      $results = mysqli_stmt_get_result($statement);
      $row = mysqli_fetch_assoc($results);
    }
  } else {
    header("Location: ../home.php?error=forbidden");
    exit();
  }

  if(isset($_GET['error'])){
    if($_GET['error'] == 'emptyFields'){
      $errorMsg = 'Empty Fields - Please fill in all form fields';
    } else if($_GET['error'] == 'sqlError'){
      $errorMsg = 'Sql Error - Something went wrong that isnt your fault';}
    echo '<div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$errorMsg.'
  </div>';
  } 

  ?>
  <div class="row">
    <div class="col-4" id="editPostNote">
      <h1>edit your post</h2>
      <p>want to edit your post?</p>
      <img src="<?php if(!empty($_GET['post'])){echo $row['postImage'];}?>" alt="<?php if(!empty($_GET['post'])){echo $row['location'];}?>" style="width: 22rem; height:20rem">
    </div>
    <div class="col-8 mt-5 ps-5">
      <form action="./includes/updatepost.inc.php?post=<?php echo $_GET['post']
      ?>" method="POST">
      <div class="mb-3">
  <label for="editCaption" class="form-label">edit post caption</label>
  <textarea class="form-control w-75" id="editCaption" name="editCaption" rows="2" placeholder="edit your post caption"><?php if(!empty($_GET['post'])){echo $row['caption'];}?></textarea>
</div>
<div class="mb-3">
  <label for="editLocation" class="form-label">edit post location</label>
  <input type="text" class="form-control w-75" id="editLocation" placeholder="i.e melbourne, vic" name="editLocation" value="<?php if(!empty($_GET['post'])){echo $row['location'];} ?>">
</div>
<div class="mb-3">
  <label for="editDate" class="form-label">edit post date</label>
  <input type="text" class="form-control w-75" id="editDate" name="editDate" value=<?php if(!empty($_GET['post'])){echo $row['postDate'];}?> placeholder="<?php date_default_timezone_set("Australia/Melbourne"); $date = date('Y-m-d'); echo $date; ?>">
</div>
<input type="submit" value="edit" class="btn btn-secondary" name="submitEditPost" id="submitEditPost" style="left: 32rem;position:absolute;">
      </form>
    </div>
  </div>
</section>


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


<script src="./js/likeBTN.js"></script> 
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> 
<!-- ALERT BTN SCRIPT -->
<script src="./js/alertBTN.js"></script>
<?php require './templates/footer.php' ?>
</body>
</html>