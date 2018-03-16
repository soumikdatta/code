<?php
	session_start();

	include 'smarthealth.php';

	$st=new smarthealth();
	
	$title = "SmartHealth - Add Doctor";

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
	
	$speciality=$st->getSpeciality();
	
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--  <link rel="stylesheet" href="css/style.css">	-->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	  $( function() {
		var availableSpeciality = [
		  <?php
			echo $speciality;
		  ?>
		];
		$( "#speciality" ).autocomplete({
		  source: availableSpeciality
		});
	  } );

	</script>
	<div id="page">
		<div id="content">
			<form method=post action="doctorAdded.php">
				<input class="form-control" type=text id="doctor_name" name="doctor_name" required placeholder="Doctor Name">
				<br>
				<textarea class="form-control" id="doctor_address" name="doctor_address" required placeholder="Doctor Address" rows=5></textarea>
				<br>
				<input class="form-control" type=text id="doctor_email" name="doctor_email" required placeholder="Doctor Email">
				<br>
				<input class="form-control" type=text id="doctor_phone" name="doctor_phone" required placeholder="Doctor Phone">
				<br>
				<input class="form-control" type=text id="doctor_regn" name="doctor_regn" required placeholder="Doctor Regn. No">
				<br>
				<input class="form-control" type=text id="speciality" name="speciality" required placeholder="Speciality">
				<br>
				<input class="form-control" type=number min="0" max="100" id="doctor_exp" required name="doctor_exp" placeholder="Experience in years" maxlength=2>
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