<?php
	session_start();

	include 'smarthealth.php';

	$st=new smarthealth();
	
	$title = "SmartHealth - Doctor Added";

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
				$doctor_name=$_POST["doctor_name"];
				$doctor_address=str_replace("\r\n",", ",$_POST["doctor_address"]);
				$doctor_email=$_POST["doctor_email"];
				$doctor_phone=$_POST["doctor_phone"];
				$doctor_regno=$_POST["doctor_regn"];
				$speciality=strtoupper($_POST["speciality"]);
				$doctor_exp=$_POST["doctor_exp"];
				
				if($doctor_name!="" && $doctor_address!="" && $doctor_phone!="" && $doctor_email!="" && $doctor_regno!="" && $speciality!="" && $doctor_exp!=0)
				{
					$q=mysql_query("insert into tbl_credential (user_id, password, user_type) values ('".$doctor_email."', '".$doctor_regno."', 'DOCTOR')");
					$doctor_id = mysql_insert_id();
					$q1=mysql_query("insert into tbl_doctor (doctor_id , doctor_name ,  doctor_address ,  doctor_email ,  doctor_phone ,  doctor_regno ,  speciality ,  doctor_exp) 
					values ('".$doctor_id."' ,  '".$doctor_name."' ,  '".$doctor_address."' ,  '".$doctor_email."' ,  '".$doctor_phone."' ,  '".$doctor_regno."' ,  '".$speciality."' ,  '".$doctor_exp."')");
					
					if(!$q)
						echo "Doctor already exists.";
					else if($q1)
						echo "Doctor created successfully.";
					else
						echo "Doctor couldn't be created.";
				}
				else
					echo "<font color=red><b>Please enter proper values</b></font>";
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