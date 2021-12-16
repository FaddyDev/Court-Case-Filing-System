
<?php include_once("includes/sessions.php"); require_once('includes/header.php'); //include the template top 
include_once("includes/dbconn.php");?>

 <script src="jquery.js"></script>
<script type="text/javascript">

function admin(){
 var c = document.getElementById("category");
 var u = document.getElementById("username");
 var u2 = document.getElementById("usnm").value;
var cat = c.options[c.selectedIndex].text;
if (cat == 'Admin'){
 //$("#username").html("Passwords match.");
 u.value='Admin';
 u.readOnly = true;
}
else{
  u.value=u2;
  u.readOnly = false;
}
//alert(cat);
}

</script>


<div class="container">
<p align="center" style="color:#FF0000;" id="success_para" ></p>
<hr>
<div class="col-md-3"></div>
<div class="col-md-6">
<?php
//Just ensuring that we only continue if the user is logged in

if(isset($_GET['edit']))
{
$id=$_GET['edit'];
$sql="SELECT * FROM users WHERE sr='".$id."' ";
$result=$conn->query($sql);
if($result->num_rows>0){
while($row=$result->fetch_assoc()){ ?>
<fieldset><legend>Edit Users</legend>
<form class="form-horizontal well" id="admin" action="editUser.php" method="post" onsubmit="return confirm_pass();">

<table id="inputtable">					
<tr><td> <select class="form-control" name="category" id="category" onnnchange="return admin();" required>
<?php  
		  $cart = $row["category"];
if($cart=='Chief_Magistrate_Courts'){$cart = 'CMs Courts User';}
else if($cart=='High_Court'){$cart = 'High Court User';}
else if($cart=='ELC'){$cart = 'ELC User';}
else if($cart=='Kadhi'){$cart = 'Kadhi\'s Court User';}
else if($cart=='HC_Admin'){$cart = 'High Court Admin';}
else if($cart=='CMs_Admin'){$cart = 'CMs Courts Admin';}
else if($cart=='ELC_Admin'){$cart = 'ELC Admin';}
else{$cart = $cart;}
?>
	   <option value="<?php echo  $row["category"];?>"><?php echo  $cart;?></option>
             <?php if($_SESSION['category'] == 'Admin') {echo "
             <option value='HC_Admin'>High Court Admin</option>
			 <option value='CMs_Admin'>CMs Courts Admin</option>
			 <option value='ELC_Admin'>ELC Admin</option>
			 <option value='Kadhi_Admin'>Kadhi's Court Admin</option>
			 <option value='Admin'>Admin</option>";}
			 
			else if($_SESSION['category'] == 'CMs_Admin') {echo "
             <option value='Chief_Magistrate_Courts'>CM's Courts User</option>";}
			 
			 else if($_SESSION['category'] == 'HC_Admin') {echo "
             <option value='High_Court'>High Court User</option>";}
			 
			 else if($_SESSION['category'] == 'ELC_Admin') {echo "
             <option value='ELC'>ELC User</option>";}
			 
			 else {echo "<option value='Kadhi'>Kadhi's Court User</option>";} ?>
			 </select></td></tr>
<input type="hidden"  value="<?php  echo  $row['username'];?>" id="usnm" name="usnm" required/>
 <tr><td><input class="form-control add-todo" type="text" autocomplete="off" value="<?php  echo  $row['username'];?>" placeholder="Username" id="username" name="username" required/></td></tr>
 <tr><td><input class="form-control add-todo" type="text" autocomplete="off" readonly='readonly' value="<?php  echo  $row['password'];?>" placeholder="Enter password: ID No" id="pass" name="pass" required/></td></tr>
  <tr><td><input class="form-control add-todo" type="text" autocomplete="off" placeholder="To change, enter the new password here" id="pass2" onkeyup="checkPasswordMatch();" name="pass2"/></td></tr>
  <input type="hidden"  value="<?php  echo $id;?>" id="id" name="id" required/>
         <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
        </table>
            
		<input type="reset" class="btn btn-primary"  style="float: left;" value="Reset All" />
        <input type="submit" class="btn btn-primary" style="float: right;" value="Submit Changes" id="submit" name="registerbtn" /> 
		</form> 
		</fieldset>
		<?php }}}?>
</div>
<div class="col-md-3"></div>
 <hr>
</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>

<?php
include_once("includes/dbconn.php");
if(isset($_POST['registerbtn'])){

//create a PHP statement that gets the new contact details
$category = $_POST['category'];
$username = $_POST['username'];
$password = $_POST['pass'];
$password2 = $_POST['pass2'];
$id = $_POST['id'];


//Confirm that all fields are set
if(isset($category) & isset($username) & isset($password)& isset($password2) & isset($id) ) 
{

$category=mysqli_real_escape_string($conn,$category); 
$username=mysqli_real_escape_string($conn,$username); 
$password=mysqli_real_escape_string($conn,$password); 
$password2=mysqli_real_escape_string($conn,$password2); 
$id=mysqli_real_escape_string($conn,$id); 

$sql = '';
if($password2 != ''){
$sql="SELECT * FROM users WHERE username='".$username."' AND password='".$password2."' ";
$result=$conn->query($sql);

//If there exists such rows
if($result->num_rows>0){
if($row=$result->fetch_assoc()){
//echo "Username or Password exists, try another!";
echo ("<script language='javascript'> window.alert('Username or Password exists\n Come by again and try another!')<//script>");
echo "<meta http-equiv='refresh' content='0;url=admin.php'> ";
}
}
else{
$sql = "UPDATE users SET category='".$category."',username='".$username."',password='".$password2."' WHERE sr='".$id."' ";
$query=mysqli_query($conn,$sql);
if(!$query){die("Not submitted ".mysqli_error($conn));}
else{
//echo "Changes saved successfully";
echo ("<script language='javascript'> window.alert('Changes saved successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=admin.php'> ";
}

}}
else {//if password 2 is empty

$sql = "UPDATE users SET category='".$category."',username='".$username."',password='".$password."' WHERE sr='".$id."' ";
$query=mysqli_query($conn,$sql);
if(!$query){die("Not submitted ".mysqli_error($conn));}
else{
//echo "Changes saved successfully";
echo ("<script language='javascript'> window.alert('Changes saved successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=admin.php'> ";
}
//Anti-duplicate checker ends here
}


//Isset checker ends here

}
else { 
//echo "Kindly fill all fields";
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=admin.php'> ";
}

}



?>