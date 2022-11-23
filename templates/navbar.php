<!-- NAVBAR START -->
<nav class="navbar navbar-expand-lg" style="background-color: var(--brand-color);">
  <div class="container-fluid ms-5 me-5">
    <a class="navbar-brand" href="./home.php"><img src="./img/logo/memories-logo.jpg" alt="memories logo" style="width:4rem ;"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse nav justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item me-5">
          <a class="nav-link" href="./home.php">home</a>
        </li>
        <li class="nav-item me-5">
          <!-- Button trigger modal -->
<button type="button" class="navBTN" data-bs-toggle="modal" data-bs-target="#profileModal">
  profile
</button>
        </li>
        <li class="nav-item me-5">
          <a class="nav-link" href="./post.php">post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-logout w-100" href="./includes/logout.inc.php">log out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- NAVBAR END -->