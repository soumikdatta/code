<?php

session_start();
include 'open_db.php';
include 'smarthealth.php';

$st=new smarthealth();

$salt1 = "9IJrH";
$salt2 = "OjLlk";

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script type="text/javascript">

function login_error()
{
	alert("Login error. ID or Password mismatch");
	window.location="login.php";
}
function login_success()
{
	//alert("Login error. ID or Password mismatch");
	window.location="home.php";
}
function login_success_admin()
{
	//alert("Login error. ID or Password mismatch");
	window.location="index.php";
}

</script>
</head>


<?php

echo "<img src='images/loading-wheel.gif' width='80%'>";

$login_id=strtoupper(mysql_real_escape_string($_POST["emp_id"]));
$password=$salt1.mysql_real_escape_string($_POST["pssw"]).$salt2;

$offset_from_server_time = 5.5;
$my_time = time() + ( 60 * 60 * $offset_from_server_time );
$date=gmdate("Y-m-d", $my_time);
$time=gmdate("H:i:s", $my_time);
$login_time=$date." ".$time;

/* $emp_id=$st->getLoginValid($login_id,$password);

if($emp_id=="ADMIN" || $emp_id!="")
{
	$q_log_hist=mysql_query("insert into login_history (emp_id, login_time) values ('".$login_id."', '".$login_time."')");
	//$login_srl=mysql_insert_id();
}
 */
if($login_id=="ADMIN" && $password==$salt1."Admin@123".$salt2)
{
	$_SESSION["user_id"]=mysql_real_escape_string($_POST["emp_id"]);
	$_SESSION["login_time"]=$login_time;
	//$_SESSION["login_srl"]=$login_srl;
	//echo "ADMIN";
?>
<body onLoad="javascript:login_success_admin();">
</body>
</html>
<?php
}
/* else if($emp_id!="")
{
	//$login_query=mysql_query("insert into user_login_details (emp_id,login_time) values ('".$emp_id."','".$login_time."')") or die("Error 2");
	$_SESSION["user_id"]=$emp_id;
	$_SESSION["login_time"]=$login_time;
	//$_SESSION["login_srl"]=$login_srl;
	//header('Location: entry.php');
?>
<body onLoad="javascript:login_success();">
</body>
</html>
<?php
}
 */
else
{
?>
<body onLoad="javascript:login_error();">
</body>
</html>
<?php
	//header('Location: index.php');
}
?>