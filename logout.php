<?php

session_start();
include 'api/config/open_db.php';

$offset_from_server_time = 5.5;
$my_time = time() + ( 60 * 60 * $offset_from_server_time );
$date=gmdate("Y-m-d", $my_time);
$time=gmdate("H:i:s", $my_time);
$logout_time=$date." ".$time;
$login_time=$_SESSION["login_time"];
$login_emp=$_SESSION["user_id"];
//echo "update login_history set logout_time='".$logout_time."' where login_time='".$login_time."'";
//$logout_query=mysql_query("update login_history set logout_time='".$logout_time."' where login_time='".$login_time."' and emp_id='".$login_emp."'");
//echo "delete from frei_session where username='".$login_emp."'";
//$logout_session=mysql_query("delete from frei_session where username='".$login_emp."'") or die("unable to clear session record");

session_destroy();
header('Location: login.php');

?>