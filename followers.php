<?php require './templates/header.php' ?>
<body>
<?php require './templates/navbar.php' ?>
<!-- FOLLOWING SECTION START -->
<section class="container" style="margin-top: 7rem;"> 
  <div>
  <div class="followingAccounts">
    <?php
    require './includes/connection.inc.php';
    $userid = mysqli_real_escape_string($conn, $_GET['user']);
    $userid = intval($userid);

    $sql = "SELECT followers.followedUserid, followers.followerUserid, users.firstname, users.lastname, users.username, users.profilePic FROM followers INNER JOIN users ON followers.followerUserid=users.userid WHERE followedUserid=$userid;";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)<=0){
      echo '<p style="margin-top:8rem; text-align:center;font-size:2rem;">you have no followers<p>';
    } else {
      $output = "";
      while($row = mysqli_fetch_assoc($result)){
        $sql="SELECT * FROM followers WHERE followedUserid=$row[followerUserid];";
        if($results = mysqli_query($conn, $sql)){
          $accountFollowers = mysqli_num_rows($results);
        }
        $sql = "SELECT * FROM followers WHERE followerUserid=$row[followerUserid];";
        if($results = mysqli_query($conn, $sql)){
          $accountFollowing = mysqli_num_rows($results);
        }
        $output .= '<div class="card mb-3 m-auto" style="width:50%; height:200px; margin-bottom:1rem;">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="'.$row['profilePic'].'" class="img-fluid rounded-start" alt="'.$row['username'].'" style="width:100%;height:200px;">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title" id="followerTitle">'.$row['firstname'].' '.$row['lastname'] .'</h5>
              <p class="card-text"><a href="./profilepage.php?user='.$row['followerUserid'].'"class="link-brand underline" >@' .$row['username'] .'</a></p>
              <p class="card-text"><small class="text-muted">followers - '.$accountFollowers .' &nbsp&nbsp following - ' .$accountFollowing. '</small></p>
            </div>
          </div>
          </div>
      </div>';
      }
      echo $output;
    }
    ?>
  </div>
  </div>
</section>

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
<!-- PROFILE MODAL START -->
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
<!-- FOLLOWING SECTION END -->
<?php require './templates/footer.php' ?>
</body>
</html>