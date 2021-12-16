<?php
// checkdata.php
include_once("dbconn.php");

if(isset($_POST['user_name']))
{
 $name=$_POST['user_name'];

 $checkdata=" SELECT username FROM users WHERE username='$name' and not level='3' ";
 $result=$conn->query($checkdata);
 if(!$result->num_rows>0)
 {
  echo "<font color='red'>Incorrect username: Keep typing...</font>";
 }
 else
 {
  echo "Bingo!";
 }
 exit();
}


if(isset($_POST['admin_name']))
{
 $name=$_POST['admin_name'];

 $checkdata=" SELECT username FROM users WHERE username='$name' and not level='3' ";
 $result=$conn->query($checkdata);
 if(!$result->num_rows>0)
 {
  echo "<font color='red'>Incorrect username: Keep typing...</font>";
 }
 else
 {
  echo "Bingo!";
 }
 exit();
}


if(isset($_POST['user_pass']))
{
 $pass=$_POST['user_pass'];

 $checkdata=" SELECT password FROM users WHERE password='$pass' and level='3' ";
 $result=$conn->query($checkdata);
 if(!$result->num_rows>0)
 {
  echo "<font color='red'>Incorrect password: Keep typing...</font>";
 }
 else
 {
  echo "Bingo!";
 }
 exit();
}



if(isset($_POST['admin_pass']))
{
 $pass=$_POST['admin_pass'];

 $checkdata=" SELECT password FROM users WHERE password='$pass' and not level='3' ";
 $result=$conn->query($checkdata);
 if(!$result->num_rows>0)
 {
  echo "<font color='red'>Incorrect password: Keep typing...</font>";
 }
 else
 {
  echo "Bingo!";
 }
 exit();
}
?>