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
				$facility_name=$_POST["facility_name"];
				$facility_address=str_replace("\r\n",", ",$_POST["facility_address"]);
				$facility_phone=$_POST["facility_phone"];
				
				if($facility_name!="" && $facility_address!="" && $facility_phone!="")
				{
					$prepAddr = str_replace(' ','+',$facility_address);
					$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
					$output= json_decode($geocode, true);
					$facility_lat = $output['results'][0]['geometry']['location']['lat'];
					$facility_lng = $output['results'][0]['geometry']['location']['lng'];
				
					$q1=mysql_query("insert into tbl_facility (facility_name ,  facility_address ,  facility_lat ,  facility_lng ,  facility_phone) 
					values ('".$facility_name."' ,  '".$facility_address."' ,  '".$facility_lat."' ,  '".$facility_lng."' ,  '".$facility_phone."')");
					
					if($q1)
						echo "Facility created successfully.";
					else
						echo "Facility couldn't be created.";
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