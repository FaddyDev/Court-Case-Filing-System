<?php 
if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}
if (!(isset($_SESSION['loggedin']))) 
{
	echo ("<script language='javascript'> window.alert('You are not Logged In,Please Log In to continue')</script>");
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";}
else{

$duration=$_SESSION['duration'];
$startTime=$_SESSION['startTime'];

//If the difference btwn the current time and the session start time exceeds the duration, it means the users stayed idle for long, destroy session
if((time()-$startTime)>$duration){
unset($_SESSION['duration']);
unset($_SESSION['startTime']);
unset($_SESSION['level']);
unset($_SESSION['username']);
unset($_SESSION['category']);
unset($_SESSION['loggedin']);

echo ("<script language='javascript'> window.alert('Your session has expired, please log in again')</script>");
echo "<meta http-equiv='refresh' content='0;url=index.php'> ";
exit();
}
else{
//keep updating the startime with the current time
$_SESSION['startTime']=time(); 
}}
?>