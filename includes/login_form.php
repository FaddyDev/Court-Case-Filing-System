 <h2>User Login</h2>
 
 <script type="text/javascript">
 function validate_login_form(){
	 var cat = document.loginform.cat.value;
	 var name = document.loginform.name.value;
	 var pass = document.loginform.pass.value;
	 
	 if(cat==""){
		 alert('Please Select Category');
		 return false;
		 }
	if(name==""){
		 alert('Please Enter Your Username');
		 return false;
		 }
		 
	 if(pass == ""){
			 alert('Please Enter Your Password');
			 return false;
			 }
	 
	 return true;
	 }
	 
function showSignUp(){	 
	 var div = document.getElementById("signup");
if(div.style.display!=='none')
{div.style.display='none';}
else{div.style.display='block';}
}


function checkname()
{
 var name=document.getElementById( "username" ).value;
	
 if(name)
 {
  $.ajax({
  type: 'post',
  url: 'includes/checkdata.php',
  data: {
   user_name:name,
  },
  success: function (response) {
   $( '#name_status' ).html(response);
   if(response=="Bingo!")	
   {
    return true;	
   }
   else
   {
    return false;	
   }
  }
  });
 }
 else
 {
  $( '#name_status' ).html("");
  return false;
 }
}


function checkpass()
{
 var pass=document.getElementById( "password" ).value;
	
 if(pass)
 {
  $.ajax({
  type: 'post',
  url: 'includes/checkdata.php',
  data: {
   user_pass:pass,
  },
  success: function (response) {
   $( '#pass_status' ).html(response);
   if(response=="Bingo!")	
   {
    return true;	
   }
   else
   {
    return false;	
   }
  }
  });
 }
 else
 {
  $( '#pass_status' ).html("");
  return false;
 }
}

  </script>
        <form name="loginform" method="post" action="includes/login_form.php" onnsubnmit="return validate_login_form();"> 
           <span class="text-danger"></span>
		     <select class="form-control" name="category" required>
		  <option value="">Select Category</option>
             <option value="High_Court">High Court</option>
			 <option value="Chief_Magistrate_Courts">Chief Magistrate's Courts</option>
			 <option value="ELC">ELC</option>
			 <option value="Kadhi">Kadhi's Court</option>
			 <!--<option value="Archivist">Archivist</option>-->
			 </select><br>
      <input type="text" class="form-control add-todo" placeholder="Enter your username" autocomplete="off" name="username" id="username" onnnnkeyup="checkname();" required>
	  <span id="name_status"></span><br>
	         <input type="password" class="form-control add-todo" placeholder="Enter your password" name="password" id="password" onnnnkeyup="checkpass();" required>
	  <span id="pass_status"></span>
        <input type="submit" class="btn btn-primary" style="float: right;" value="Login" name="loginbtn" /> 
	
        </form>
		
        <div style="clear:both"></div>            
    <hr>   
	
	
	<?php
//Connect to database via another page
include_once("dbconn.php");

?>
<?php
if(isset($_POST['loginbtn'])){
if($_POST['loginbtn']='Login'){
$category=$_POST['category'];
$username=$_POST['username'];
$pass=$_POST['password'];

$sql="SELECT COUNT(*) FROM users WHERE category='".$category."' AND username='".$username."' AND password='".$pass."' ";
$query=mysqli_query($conn,$sql);
$result=mysqli_fetch_array($query);

if($result[0]>0){

session_start();
//session will stay alive for 300 seconds (5 mins)  if user stays idle
$duration=180;
$_SESSION['duration']=$duration;
$_SESSION['startTime']=time();  //Get the current time
$level='';
$result=$conn->query("SELECT * FROM users WHERE category='".$category."' AND username='".$username."' AND password='".$pass."' ");
if($result->num_rows>0){
if($row=$result->fetch_assoc()){
$level = $row["level"];
}}

$_SESSION['level']=$level;
$_SESSION['username']=$username;
$_SESSION['category']=$category;
$_SESSION['loggedin']=TRUE;

header('Location:../addcase.php');

}
else{
echo ("<script language='javascript'> window.alert('Login failed, check username and password then try again')</script>");
echo "<meta http-equiv='refresh' content='0;url=../index.php'> ";
exit();
}
}}
?>