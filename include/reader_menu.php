<!--
	<div id="menu">
		<ul>
			<li class="first"><a href="index.php" accesskey="1" title="">What's HOT!!</a></li>
			<li><a href="catalog.php" accesskey="2" title="">Catalog</a></li>
			<li><a href="library.php" accesskey="3" title="">My Issue</a></li>
			<li><a href="contact.php" accesskey="4" title="">Contact Us</a></li>
			<li><a href="logout.php" accesskey="5" title="">Logout</a></li>
		</ul>
		<div id="emp_name">
			<?php
				echo "<font color=white> Welcome ".$emp_name."</font>";
				$count=$st->getNotificationCount($_SESSION["user_id"]);
			?>
		</div>
	</div>
-->
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">&nbsp;</a><?php
				echo "<font>".$emp_name."</font>";
			?>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">What's HOT!!</a>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Catalog
        </a>
		<div class="nav-item dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
			<a class="nav-item nav-link dropdown-item" href="catalog.php">Physical Book</a>
			<a class="nav-item nav-link dropdown-item" href="ecatalog.php">E-Book</a>
		</div>
      </li>
      <a class="nav-item nav-link" href="issue_history.php">My Issue</a>
      
	  <?php
		if($count>0)
			echo '<a class="nav-item nav-link" href="notification.php">Notification <span style="border-radius: 50%; width: 36px; height: 36px; background-color:red; text-align: center; color:white;">'.$count.'</span></a>';
	  ?>
      <a class="nav-item nav-link" href="contact.php">Contact Us</a>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
    </div>
  </div>
</nav>