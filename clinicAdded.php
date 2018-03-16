<?php
	session_start();

	include 'smarthealth.php';

	$st=new smarthealth();
	
	$title = "SmartHealth - Facility Added";

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
			<?php
				$doctor_id=$_POST["doctor_id"];
				$facility_id=$_POST["facility_id"];
				$clinic_start=$_POST["clinic_start_hr"].":".$_POST["clinic_start_min"];
				$clinic_end=$_POST["clinic_end_hr"].":".$_POST["clinic_end_min"];
				$no_patient=$_POST["no_patient"];
				$clinic_day = "";
				$i = 0;
				
				if(!empty($_POST['clinic_day'])) {
					foreach($_POST['clinic_day'] as $check) {
						if($i>0)
							$clinic_day .= ", ";
						$i++;
						$clinic_day .= $check;
					}
					//echo $clinic_day;
				}
				
				if($doctor_id!="" && $facility_id!="" && $no_patient!=0 && $clinic_day!="")
				{
				
					$q1=mysql_query("insert into tbl_chamber (facility_id ,  doctor_id ,  chamber_day ,  chamber_start ,  chamber_end ,  no_patient) 
					values ('".$facility_id."' ,  '".$doctor_id."' ,  '".$clinic_day."' ,  '".$clinic_start."' ,  '".$clinic_end."' ,  '".$no_patient."')");
					
					if($q1)
						echo "<center>Clinic created successfully.</center>";
					else
						echo "<center>Clinic couldn't be created.</center>";
				}
				else
					echo "<center><font color=red><b>Please enter proper values</b></font></center>";
			?>
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