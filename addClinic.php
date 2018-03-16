<?php
	session_start();

	include 'smarthealth.php';

	$st=new smarthealth();
	
	$title = "SmartHealth - Add Clinic";

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
	  
		function toggle(source) {
		  checkboxes = document.getElementsByName('clinic_day[]');
		  for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
		  }
		}

	</script>
	<div id="page">
		<div id="content">
			<form method=post action="clinicAdded.php">
				<select class="form-control" id="doctor_id" name="doctor_id" required>
					<option value="" hidden >Doctor Name</option>
					<?php
						echo $st->getDoctorName();
					?>
				</select>
				<br>
				<select class="form-control" id="facility_id" name="facility_id" required>
					<option value="" hidden >Facility</option>
					<?php
						echo $st->getFacilityName();
					?>
				</select>
				<br>
				<label class="form-control" style="background-color:grey;">Clinic Days</label>
				<div class="row" style="margin: 15px;">
					<div class="col-sm-3"><input class="form-check-input" type=checkbox name="clinic_day[]" id="clinic_day[]" value="MONDAY"> MONDAY</div>
					<div class="col-sm-3"><input class="form-check-input" type=checkbox name="clinic_day[]" id="clinic_day[]" value="TUESDAY"> TUESDAY</div>
					<div class="col-sm-3"><input class="form-check-input" type=checkbox name="clinic_day[]" id="clinic_day[]" value="WEDNESDAY"> WEDNESDAY</div>
					<div class="col-sm-3"><input class="form-check-input" type=checkbox name="clinic_day[]" id="clinic_day[]" value="THURSDAY"> THURSDAY</div>
					<div class="col-sm-3"><input class="form-check-input" type=checkbox name="clinic_day[]" id="clinic_day[]" value="FRIDAY"> FRIDAY</div>
					<div class="col-sm-3"><input class="form-check-input" type=checkbox name="clinic_day[]" id="clinic_day[]" value="SATURDAY"> SATURDAY</div>
					<div class="col-sm-3"><input class="form-check-input" type=checkbox name="clinic_day[]" id="clinic_day[]" value="SUNDAY"> SUNDAY</div>
					<div class="col-sm-3"><input class="form-check-input" type=checkbox  onClick="toggle(this)"> EVERYDAY</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-3">
						<select class="custom-select" id="clinic_start_hr" name="clinic_start_hr" required>
							<option value="00" hidden >Start Hour</option>
							<?php
								for($i=0;$i<25;$i++)
									echo "<option>".$i."</option>";
							?>
						</select>
						<select class="custom-select" id="clinic_start_min" name="clinic_start_min" required>
							<option value="00" hidden >Start Minute</option>
							<option>00</option>
							<option>30</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<select class="custom-select" id="clinic_end_hr" name="clinic_end_hr" required>
							<option value="00" hidden >End Hour</option>
							<?php
								for($i=0;$i<25;$i++)
									echo "<option>".$i."</option>";
							?>
						</select>
						<select class="custom-select" id="clinic_end_min" name="clinic_end_min" required>
							<option value="00" hidden >End Minute</option>
							<option>00</option>
							<option>30</option>
						</select>
					</div>
				</div>
				<br>
				<input class="form-control" type=number required min="1" max="200" id="no_patient" name="no_patient" placeholder="No. of Patients" maxlength=3>
				<br>
				<input type=submit class="btn btn-primary" id="create" value="Create">
			</form>
				<br>
				<br>
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