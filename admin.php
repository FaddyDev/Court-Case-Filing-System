<?php include_once("includes/sessions.php"); require_once('includes/header.php'); //include the template top ?>


<div class="container">
<script src="jquery.js"></script>
<script type="text/javascript">

function checkPasswordMatch1() {
    var submt = document.getElementById("submit");
    var password = $("#pass").val();
    var confirmPassword = $("#pass2").val();
	
	if(confirmPassword == ''){ $("#divCheckPasswordMatch").html("");
		submt.style.display = 'none';}
	else{
    if (password != confirmPassword){
        $("#divCheckPasswordMatch").html("<font color='red'>Passwords do not match!</font>");
		submt.style.display = 'none';}
    else{
        $("#divCheckPasswordMatch").html("Passwords match.");
		submt.style.display = 'block';}
		}
}


function checkPasswordMatch() {
    var submt = document.getElementById("submit");
    var password = $("#pass").val();
    var confirmPassword = $("#pass2").val();
	
	if(password == ''){ $("#divCheckPasswordMatch").html("");
		submt.style.display = 'none';}
	else{
    if (password != confirmPassword){
        $("#divCheckPasswordMatch").html("<font color='red'>Passwords do not match!</font>");
		submt.style.display = 'none';}
    else{
        $("#divCheckPasswordMatch").html("Passwords match.");
		submt.style.display = 'block';}
		}
}

function confirm_pass(){
	var password = $("#pass").val();
    var confirmPassword = $("#pass2").val();
	 
	 if(password!=confirmPassword){
		 alert('Passwords do not match');
		 return false;
		 }
	
	 return true;
	 }
	 
function admin(){
 var c = document.getElementById("category");
 var u = document.getElementById("username");
var cat = c.options[c.selectedIndex].text;
if (cat == 'Admin'){
 //$("#username").html("Passwords match.");
 u.value='Admin';
 u.readOnly = true;
}
else{
 u.value='';
  u.readOnly = false;
}
//alert(cat);
}
</script>
 
<div class="col-md-4">
<!--<h2>Add Users</h2>-->
<fieldset><legend>Add Users</legend>
<form class="form-horizontal well" id="admin" action="admin.php" method="post" onsubmit="return confirm_pass();">

<table id="inputtable">	<? // echo "Faddy; ?>	
			
<tr><td> <select class="form-control" name="category" id="category" onnnchange="return admin();" required>
		 <?php 
		   
		  if($_SESSION['category'] == 'Admin') {
		 echo "<option value=''>Select Category</option>
             <option value='HC_Admin'>High Court Admin</option>
			 <option value='CMs_Admin'>CMs Courts Admin</option>
			 <option value='ELC_Admin'>ELC Admin</option>
			 <option value='Kadhi_Admin'>Kadhi's Court Admin</option>
			 <option value='Admin'>Admin</option>";}
			 
			else if($_SESSION['category'] == 'CMs_Admin') {echo "
             <option value='Chief_Magistrate_Courts'>CMs Courts User</option>";}
			 
			 else if($_SESSION['category'] == 'HC_Admin') {echo "
             <option value='High_Court'>High Court User</option>";}
			 
			 else if($_SESSION['category'] == 'ELC_Admin') {echo "
             <option value='ELC'>ELC User</option>";}
			 
			 else {echo "<option value='Kadhi_Admin'>Kadhi's Court User</option>";} ?>
			 
			 </select></td></tr>
 <tr><td><input class="form-control add-todo" type="text" autocomplete="off" placeholder="Enter username" id="username" name="username" required/></td></tr>
 <tr><td><input class="form-control add-todo" type="text" autocomplete="off" placeholder="Enter password" id="pass" name="pass" onkeyup="checkPasswordMatch1();" required/></td></tr>
  <tr><td><input class="form-control add-todo" type="text" autocomplete="off" placeholder="Re-Enter password" id="pass2" onkeyup="checkPasswordMatch();" name="pass2" required/></td></tr>
         <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
        </table>
            
		<input type="reset" class="btn btn-primary"  style="float: left;" value="Reset All" />
        <input type="submit" class="btn btn-primary" style="float: right;" value="Submit" id="submit" name="registerbtn" /> 
		</form> 
		</fieldset>
</div>

<div class="col-md-8">
<!--<h2>gvhg</h2> -->
<input style="float:right;" type="text" id="searchTerm" class="search_box form-control add-todo" placeholder="Type to search..." onkeyup="doSearch()" />
<table id="dataTable" class="table table-striped table-bordered table-hover table-condensed table-responsive display">
<tbody>
<tr><th>Category/Court</th><th>Username</th><th>Password</th><th colspan="2">Action</th></tr>
<?php 
include_once("includes/dbconn.php");
$sql = ''; 
if($_SESSION['category'] == 'Admin') {$sql="SELECT * FROM users where not level='3' ORDER BY category";}
			 
else if($_SESSION['category'] == 'CMs_Admin') {$sql="SELECT * FROM users where category = 'Chief_Magistrate_Courts' ORDER BY username";}
			 
else if($_SESSION['category'] == 'HC_Admin') {$sql="SELECT * FROM users where category = 'High_Court' ORDER BY username";}
			 
else if($_SESSION['category'] == 'ELC_Admin') {$sql="SELECT * FROM users where category = 'ELC' ORDER BY username";}
else {$sql="SELECT * FROM users where category = 'Kadhi' ORDER BY username";}

$result=$conn->query($sql);
if($result->num_rows>0){
while($row=$result->fetch_assoc()){
echo "<tr> 
<td> ".str_replace("_"," ",$row["category"])." </td>
<td> ".$row["username"]." </td> 
<td> ".$row["password"]."</td>";


echo "<td>  <a href='editUser.php?edit=$row[sr]'>Edit</a></td>
<td>  <a href='javascript:confirmDeleteUser($row[sr])'>Delete</a></td>"; 
echo "</tr>";}
echo "</tbody></table> ";

}
else{
//When table is empty
//echo ("<script language='javascript'> window.alert('There are no users in the system, add some in PhpMyAdmin first.')<//script>"); 
//echo "<meta http-equiv='refresh' content='0;url=index.php'> ";
echo "<table><tr> 
<td colspan='5'> There are no registered users, kindly register them. </td>
</tr></table>";
}



?>
 </div>
                 
                   


 <hr>

</div>
<?php require_once('includes/footer.php'); //include footer template ?>





<?php
if(isset($_POST['registerbtn'])){

//create a PHP statement that gets the new contact details
$category = $_POST['category'];
$username = $_POST['username'];
$password = $_POST['pass'];


//Confirm that all fields are set
if(isset($category) & isset($username) & isset($password) ) 
{

$sql="SELECT * FROM users WHERE category='".$category."' AND username='".$username."' AND password='".$password."' ";
$result=$conn->query($sql);

//If there exists such rows
if($result->num_rows>0){
if($row=$result->fetch_assoc()){
//echo "User already exists";
echo ("<script language='javascript'> window.alert('Case File Exists.')<//script>");
echo "<meta http-equiv='refresh' content='0;url=admin.php'> ";
}
}
else{
//assemble insert string that allows entry of special characters
$category=mysqli_real_escape_string($conn,$category); 
$username=mysqli_real_escape_string($conn,$username);  ; 
$password=mysqli_real_escape_string($conn,$password);  

$level = 0;
if($category == 'CMs_Admin' || $category == 'HC_Admin'|| $category == 'ELC_Admin'|| $category == 'Kadhi_Admin') {$level = 2;}
else if($category == 'High_Court' || $category == 'Chief_Magistrate_Courts' ||$category == 'ELC' ||$category == 'Kadhi' ) {$level = 3;}
else if($category == 'Archivist' ) {$level = 4;}
else {$level = 1;}
//Save info in case details table
$sql = "insert into users (level,category,username,password)  values ( '".$level."','".$category."','".$username."','".$password."')";

$query=mysqli_query($conn,$sql);

if(!$query){die("Not submitted ".mysqli_error($conn));}
else{
//echo "New User Added";
echo ("<script language='javascript'> window.alert('New User Added')</script>");
echo "<meta http-equiv='refresh' content='0;url=admin.php'> ";
}

//Anti-duplicate checker ends here
}

//Isset checker ends here

}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=admin.php'> ";}
}



?>
