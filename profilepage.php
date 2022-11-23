<?php require './templates/header.php'?>
<body>
<?php require './templates/navbar.php' ?>

<!-- PROFILE SECTION START -->
<section id="profileSection" class="container">
  <?php
if(isset($_GET['user'])){
  require './includes/connection.inc.php';

  $userid = mysqli_real_escape_string($conn, $_GET['user']);
  $userid = intval($userid);

  $sql = "SELECT posts.userid, users.username, users.firstname, users.lastname, users.bio, users.profilePic, posts.postImage, posts.caption, posts.postDate, posts.location, posts.postid FROM posts INNER JOIN users ON posts.userid=users.userid WHERE posts.userid=?";
  $statement = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($statement, $sql)){
    header("Location: ../profilepage.php?error=sqlError&user=" . $userid);
    exit();
  } else {
    mysqli_stmt_bind_param($statement, "i", $userid);
    mysqli_stmt_execute($statement);

    $results = mysqli_stmt_get_result($statement);
    $row = mysqli_fetch_assoc($results);
  
  }

} else {
  header("Location: ../home.php?error=forbidden");
  exit();
}

?>
  <div class="row" style="margin-top: 3rem;">
    <div class="col-4">
    <div class="profileOverviewSection">
    <img src="<?php if(!empty($_GET['user'])){echo $row['profilePic'];}?>" alt="">
  <h2><?php if(!empty($_GET['user'])){echo $row['username'];} ?></h2>
  <?php
  $sqlFollowers="SELECT * FROM followers WHERE followedUserid=$_GET[user];";
  if($results = mysqli_query($conn, $sqlFollowers)){
    $accountFollowers = mysqli_num_rows($results);
  }
  $sqlFollowing = "SELECT * FROM followers WHERE followerUserid=$_GET[user];";
  if($results = mysqli_query($conn, $sqlFollowing)){
    $accountFollowing = mysqli_num_rows($results);
  }
  ?>
  <p style="text-align: center;margin-let:0;">followers - <?php echo '<a class="link-brand underline" href="./followers.php?user='.$_GET['user'].'">'. $accountFollowers .'</a>'?>&nbsp;&nbsp;&nbsp;&nbsp;following - <?php 
  echo '<a class="link-brand underline" href="./following.php?user='.$_GET['user'].'">'. $accountFollowing .'</a>' ?></p>
  <p>name - <?php if(!empty($_GET['user'])){echo $row['firstname']; echo " "; echo $row['lastname'];} ?></p>
  <p>memories bio - <?php if(!empty($_GET['user'])){echo $row['bio'];} ?></p>
  <?php  $sql="SELECT * FROM posts WHERE userid=$row[userid];";
      if($results = mysqli_query($conn, $sql)){
        $postAmount = mysqli_num_rows($results);
        }  ?>
  <p id="numberOfPosts">number of posts - <?php echo $postAmount?></p>
  <?php
      $sql="SELECT * FROM likes WHERE userid=$row[userid];";
      if($results = mysqli_query($conn, $sql)){
        $likeAmount = mysqli_num_rows($results);
        } ?>
  <p id="likePosts">liked posts - <?php echo $likeAmount ?></p>
  <form action="./includes/followers.php?user=<?php echo $_GET['user']?>" method="POST"> 
              <button name="followBTN" id="followBTN"><div class="wrapper"><div class="icon"><span class="tooltip">Follow</span>
              <span><img src="./img/icon/memories-follow.jpg" alt="Memories Follow Icon"></span></div></div></button></form>
    </div>
    </div>
    <div class="col-7 ms-5 mt-5" id="profilePosts" style="display:grid;">
<?php
  if(isset($_GET['user'])){
  
    $userid = mysqli_real_escape_string($conn, $_GET['user']);
    $userid = intval($userid);
  
    $sql = "SELECT posts.userid, users.username, users.firstname, users.lastname, users.bio, users.profilePic, posts.postImage, posts.caption, posts.postDate, posts.location, posts.postid FROM posts INNER JOIN users ON posts.userid=users.userid WHERE posts.userid=?";
    $statement = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ../profilepage.php?error=sqlError&user=" . $userid);
      exit();
    } else {
      mysqli_stmt_bind_param($statement, "i", $userid);
      mysqli_stmt_execute($statement);
  
      $results = mysqli_stmt_get_result($statement);

    
    }
  
  } else {
    header("Location: ../home.php?error=forbidden");
    exit();
  }
if(mysqli_num_rows($results) <= 0){
  echo '<div id="noPostsProfile">
  <h3>this user currently has 0 posts</h3>
</div>';
} else {
  $output = "";
  while($row = mysqli_fetch_assoc($results)){
    $sqlLikes="SELECT * FROM likes WHERE postid=$row[postid];";
    if($result = mysqli_query($conn, $sqlLikes)){
      $likeAmount = mysqli_num_rows($result);
      };
  $output .= '<div class="row"><div class="card mt-3 mb-3 postBox col" style="width: 80%;">
  <img src="'.$row['postImage'].'" class="card-img-top" alt="..." style="height:20rem;">
  <div class="card-body"style="display:flex;flex-direction:row;">
  <form action="./includes/likes.inc.php?post='.$row['postid'] .'" method="POST" class="infoPost">
  <button type="submit" name="likeBTN" value="like" id="likeBTN"><div class="wrapper" style="width:50%;"><div class="icon"><span class="tooltip" style="color:#DC2626;">Like</span>
  <span><img src="./img/icon/memories-like.jpg" alt="Memories Follow Icon"></span></div></div></button><div id="likeAmount" style="width:50%;">'.
  $likeAmount.'</div></form>
  <p class="card-text text-center">'.$row['caption'].'</p>
  <p class="card-text text-center" id="postDate">'.$row['postDate'].'</p>';

        
      if(isset($_SESSION['userid']) && $row['userid'] == $_SESSION['userid']){
        $output .= '<div class="adminBTN"><a href="./includes/deletepost.inc.php?post='. $row['postid'] .'"><img src="./img/icon/memories-delete.jpg" alt="Delete Button"></a>
         <a href="./editpost.php?post='. $row['postid'] .'"><img src="./img/icon/memories-edit.jpg" alt="Edit Button"></a></div></div>';


     $output .= '</div>
    </div>
   ';

      
      }
    }echo $output;
 
 
}

?>

  


</div>
    </div>
    </div>

</section>
<!-- PROFILE SECTION END -->

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
