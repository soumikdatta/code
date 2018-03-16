<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">&nbsp;</a><?php
				echo "<font>".$_SESSION["user_id"]."</font>";
			?>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">About</a>
	  <a class="nav-item nav-link" href="addFacility.php">Add Facility</a>
      <a class="nav-item nav-link" href="addDocotr.php">Add Doctor</a>
      <a class="nav-item nav-link" href="addClinic.php">Add Clinic</a>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
    </div>
  </div>
</nav>