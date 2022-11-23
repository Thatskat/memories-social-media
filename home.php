<?php require './templates/header.php' ?>
<body style="background-color: var(--primary-light);">
<?php require './templates/navbar.php' ?>

<!-- POST SECTION START -->
<section class="container">
<?php 
  if(isset($_GET['error'])){
    if($_GET['error'] == 'emptyFields'){
      $errorMsg = 'Empty Fields - Please fill in all form fields';
    } else if($_GET['error'] == 'imageType'){
          $errorMsg = 'Wrong Image Type - Please choose a image/jpeg, image/png, image/gif, image/jng or image/svg file';}
            else if($_GET['error'] == 'wrongPassword'){
              $errorMsg = 'Wrong Password - That isnt the password for this account';}
              else if($_GET['error'] == 'sqlError'){
                $errorMsg = 'Sql Error - Something went wrong that isnt your fault';} else if ($_GET['error'] == 'followedSelf'){
                  $errorMsg = 'Error - You cannot follow yourself';
                } else if ($_GET['error'] == 'forbidden'){
                  $errorMsg = 'Error 403 - Forbidden.<br>You do not have permission to access this page';
                }

    echo '<div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$errorMsg.'
  </div>';
  } else if (isset($_GET['success'])){
      if($_GET['success'] == 'postUploader'){
        $successMsg = 'Success - Your post have been uploaded';
      } else if($_GET['success'] == 'userUnfollowed'){
        $successMsg = 'Success - User Unfollowed';
      } else if($_GET['success'] == 'userFollowed'){
        $successMsg = 'Success - User followed';
      } else if($_GET['success'] == 'postUnliked'){
        $successMsg = 'Post Unliked';
      } else if($_GET['success'] == 'postLiked'){
        $successMsg = 'Posted liked';
      } else if($_GET['success'] == 'login'){
        $successMsg = 'Welcome back ' . $_SESSION['username'];
      } else if ($_GET['success'] == 'postDeleted'){
        $successMsg = 'You post has been deleted';
      }else if($_GET['success'] == 'postUploaded'){
        $successMsg = 'Success - Your post has been uploaded';
      }else if($_GET['success'] == 'postUpdated'){
        $successMsg = 'Success - Your post has been updated';
      }
       echo '<div class="alert success">
    <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
    '.$successMsg.'
  </div>';
  }
  ?>
  <div class="grid">
  <?php
      require './includes/connection.inc.php';

      $sql = "SELECT posts.postid, users.username, users.userid, posts.postImage, posts.caption, posts.postDate, posts.location FROM posts INNER JOIN users ON posts.userid=users.userid ORDER BY postDate DESC;";

      $result = mysqli_query($conn, $sql);

      
      if(mysqli_num_rows($result) <= 0){
        echo "there are no current memories - post something";
      } else {
        $output = "";
        while($row = mysqli_fetch_assoc($result)){
          $sql="SELECT * FROM likes WHERE postid=$row[postid];";
          if($results = mysqli_query($conn, $sql)){
            $likeAmount = mysqli_num_rows($results);
            }
              $output .= '<div class="item">
              <div class="overlayPar">
            <img style="height:100%;"src="'. $row['postImage'].'" alt="'.$row['username'].'"class="equilibrium" id="postImage">
            <div class="imgOverlay">
              <a id="postUsername"><a class="card-title link-brand mb-4 fs-5 infoPost" style="font-family:Knewave,cursive;" href="./profilepage.php?user='.$row['userid'].'">'. $row['username'].'</a></a>
              <form action="./includes/followers.php?user='.$row['userid'].'" method="POST" class="infoPost">
              <button name="followBTN" id="followBTN"><div class="wrapper"><div class="icon"><span class="tooltip">Follow</span>
              <span><img src="./img/icon/memories-follow.jpg" alt="Memories Follow Icon"></span></div></div></button></form><form action="./includes/likes.inc.php?post='.$row['postid'] .'" method="POST" class="infoPost">
              <button type="submit" name="likeBTN" value="like" id="likeBTN"><div class="wrapper" style="width:50%;"><div class="icon"><span class="tooltip" style="color:#DC2626;">Like</span>
              <span><img src="./img/icon/memories-like.jpg" alt="Memories Follow Icon"></span></div></div></button><div id="likeAmount" style="width:50%;">'.
              $likeAmount.'</div></form>
              <p id="postLocation" class="infoPost"><img src="./img/icon/location-pin.svg" alt="location icon" style="width:1.5rem;">'.$row['location'].'</p>
              <p class="infoPost" id="captionPost">'.$row['caption'].'</p>
              <p style="margin-top:0;" class="infoPost" id="postDate">'.$row['postDate'].'</p>';
      


            if(isset($_SESSION['userid']) && $row['userid'] == $_SESSION['userid']){
           $output .= '<div class="adminBTN infoPost"><a href="./includes/deletepost.inc.php?post='. $row['postid'] .'"><img src="./img/icon/memories-delete.jpg" alt="Delete Button"></a>
            <a href="./editpost.php?post='. $row['postid'] .'"><img src="./img/icon/memories-edit.jpg" alt="Edit Button"></a></div>';
          }
          $output .= '</div>
          </div></div>';
        }
  
      echo $output;
        }
?>
</section>
<!-- POST SECTION END -->

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
<script src="./js/alertBTN.js"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> 

</body>
</html>