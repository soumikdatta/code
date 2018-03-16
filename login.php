<!DOCTYPE html>
<html dir="ltr">
<?php
	
	$title = "SmartHealth - Login";
			
	include_once 'include/header.php';
	include_once 'include/index_menu.php';
?>
<div style="float:left;width:100%;overflow:visible;margin-bottom:60px;">
<!--	<div style="float:left;background-color:#ff6a6a;height:60%;width:20%;position:absolute;">&nbsp;Mistu</div>	-->
	<div id="page">
		<h1>Login</h1>
			<h5>with your User ID and password</h5>
			<br>
			<form name="login" method=post action="login_process.php">
			<p><input class="form-control" type=text name="emp_id" placeholder="Employee ID" style="width:300px;"></p>
			<p><input class="form-control" type=password name="pssw" placeholder="Password" style="width:300px;"></p>
			<p><input type=submit class="btn btn-primary" value="Login"></p>
			</form>
	</div>
<!--
	<div id="page">
		Not registered yet? <a href="registration.php">Register</a> here.
	</div>
-->
</div>
<?php
	include_once 'include/footer.php';
?>