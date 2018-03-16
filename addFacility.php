<?php
	session_start();

	include 'smarthealth.php';

	$st=new smarthealth();
	
	$title = "SmartHealth - Add Facility";

	include_once 'include/header.php';
	if(isset($_SESSION["user_id"]))
	{
		if($_SESSION["user_id"]!="admin")
		{
			include_once 'include/reader_menu.php';
		}
		else if($_SESSION["user_id"]!="")
		{
			include_once 'include/admin_menu.php';
		}
	}
	else
	{
		include_once 'include/index_menu.php';
	}
	
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--  <link rel="stylesheet" href="css/style.css">	-->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<div id="page">
		<div id="content">
			<form method=post action="facilityAdded.php">
				<input class="form-control" type=text id="facility_name" name="facility_name" required placeholder="Facility Name">
				<br>
				<textarea class="form-control" id="facility_address" name="facility_address" required placeholder="Facility Address" rows=5></textarea>
				<br>
				<input class="form-control" type=text id="facility_phone" name="facility_phone" required placeholder="Facility Phone">
				<br>
				<input type=submit class="btn btn-primary" id="create" value="Create">
			</form>
		</div>
		<br class="clearfix">
			<div id="bookList" class="container">
			</div>
			<div style="clear: both;">&nbsp;</div>
		</div>
		<div style="clear: both;">&nbsp;</div>
	</div>
</div>
<?php
	include_once 'include/footer.php';
?>