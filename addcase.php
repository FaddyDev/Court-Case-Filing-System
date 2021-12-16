
<?php require_once("includes/sessions.php");  require_once('includes/header.php'); //include the template top
include_once("includes/dbconn.php"); ?>
<?php 
/*
$unsold = 0; $sold = 0; $totcash = 0;
$sql1="SELECT SUM(quantity) FROM books where owner='".$_SESSION["username"]."'";
$result1=$conn->query($sql1);
if($result1->num_rows>0){
if($row1=$result1->fetch_assoc()){
$unsold = $row1["SUM(quantity)"];
}}


$sql1="SELECT SUM(quantity_bot),SUM(total_amout) from books,sales WHERE books.book_code=sales.book_code and books.owner='".$_SESSION["username"]."' ORDER BY sales.id"; 
$result1=$conn->query($sql1);
if($result1->num_rows>0){
if($row1=$result1->fetch_assoc()){
$sold = $row1["SUM(quantity_bot)"];
$totcash = $row1["SUM(total_amout)"];
}}*/

 ?>
 <script src="jquery.js"></script>
<script type="text/javascript">



 
</script>



<div class="container">
<p align="center" style="color:#FF0000;" id="success_para" ></p>
<hr>
<div class="col-md-2">
</div>



<div class="col-md-8">
<h2>Add Case File</h2>
<form class="form-horizontal well" id="addcaseform" action="addcase.php" method="post" enctype="multipart/form-data">

 <div class="">
Case Type: <select class="form-control" name="type" id="case" required>
		  			 
		   <?php //Show different case types for different registries
		   		     $reg = $_SESSION["category"];
				if($reg=='Chief_Magistrate_Courts'){ 
					echo "<option value=''>Select CM's Case</option>
                  			 <option value='Criminal'>Criminal</option>
                  			<option value='P and C'>Protection and care</option>
  							<option value='Sexual offence'>Sexual offence</option>
							<option value='Election offence'>Election offence</option>
							<option value='Anti-corruption'>Anti-corruption</option>
							<option value='Traffic'>Traffic</option>
							<option value='Custody and Maintenance'>Custody and Maintenance</option>
							<option value='Guardianship'>Guardianship</option>
							<option value='Miscelleneous'>Miscelleneous</option>
							<option value='Divorce'>Divorce</option>
							<option value='Inquest'>Inguest</option>";
						 }						
						//HC CASES
						else if($reg=='High_Court'){ 
						echo "<option value=''>Select High Court Case</option>
                  			<option value='Criminal'>Criminal</option>
                  			<option value='Criminal appeal'>Criminal appeal</option>
							<option value='Civil'>Civil</option>
							<option value='Civil appeal'>Civil appeal</option>
							<option value='Constitutional petition'>Constitutional petition</option>
							<option value='Misc petition'>Misc petition</option>
							<option value='Misc'>Misc </option>
							<option value='Adoprion cause'>Adoption cause</option>
							<option value='Divorce'>Divorce</option>
							<option value='P and A'>P and A</option>
							<option value='P and A appeal'>P and A appeal</option>
							<option value='Judicial review'>Judicial review</option>
							<option value='Criminal misc appeal'>Criminal misc appeal</option>
							<option value='Election petition'>Election petition</option>
							<option value='Pre-election appeal'>Pre-election petition appeal</option>
							<option value='Election petition appeal'>Election petition appeal</option>";
						 }
						//Kadhi's court cases
						else if($reg=='Kadhi'){ 
                echo "<option value=''>Select Kadhi\'s Court Case</option>
				<option value='Marriage'>Marriage</option>
				<option value='Divorce'>Divorce</option>
				<option value='Succession'>Succession</option>
				<option value='Misc Application'>Misc Application</option>";
				  
				 }
					//ELC Cases
							else if($reg=='ELC'){ 
                 echo "<option value='ELC'>ELC case</option>";
						}
						
						 ?>
</select>
  Case Number: <input class="form-control add-todo" type="text" placeholder="E.g. 10 of 2017" placeholder="" id="num" name="case_num" required/>
  Judicial Officer/Judge: <input class="form-control add-todo" type="text" placeholder="Name of Judicial officer"  id="jofficer" name="jofficer" required/>
   Date Filed: <input type="text" class="form-control add-todo datepicker"  placeholder="case filing date" id="date" name="date" onKeyDown="return false" autocomplete="off" required/> 
   File Location: <input class="form-control add-todo" type="text" placeholder="E.g. in registry A"  id="location" name="file_location" required/> Parties:  <input class="form-control add-todo" type="text" placeholder="Parties involved" id="parties" name="parties" required/> 
   Latest Details:  <textarea class="form-control add-todo" name="details" id="details" placeholder="Record latest case details here" required/></textarea></div>
 <div class="">Advocate: <input type="text" class="form-control add-todo" placeholder="Put N/A if no advocate" id="advocate" name="advocate" required/> Latest Orders:  <input type="text" class="form-control add-todo" onKeyPress="" placeholder="Enter latest case orders" id="orders" name="orders" required/>
 Upload any file associated with this case<input type="file" readonly="true" title="Click to upload" accept="application/msword,application/pdf,.doc,.docx,.odt" name="file" id="file"/></div>
            
		<input type="reset" class="btn btn-primary"  style="float: left;" value="Reset All" />
        <input type="submit" class="btn btn-primary" style="float: right;" value="Submit" id="submit" name="registerbtn" /> 
		</form> 
</div>
<div class="col-md-2"></div>
 <hr>
</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
<?php
if(isset($_POST['registerbtn']) ){
//create a PHP statement that gets the new contact details
$regd_by = $_SESSION["username"];
$file_location = $_POST["file_location"];
$jofficer = $_POST["jofficer"];
$court = $_SESSION["category"];
$type = $_POST['type'];
$file = $_FILES["file"];
$date = $_POST['date'];
$num = $_POST['case_num'];
$orders = $_POST['orders'];
$details = $_POST['details'];
$advocate = $_POST['advocate'];
$parties = $_POST['parties'];


//Confirm that all fields are set
if(isset($date) & isset($num) & isset($orders) & isset($details) & isset($advocate) & isset($parties) & isset($regd_by) & isset($court)& isset($file_location) & isset($type) & isset($jofficer) ) 
{

$sql="SELECT * FROM casedetails WHERE num='".$num."' AND court='".$court."' AND case_type='".$type."' ";
$result=$conn->query($sql);
//if(!$result){echo "Sorry!";}
//If there exists such rows

if($row=$result->fetch_assoc()){
//echo "Case File Exists!\nKindly cofirm the number and try again";
echo ("<script language='javascript'> window.alert('Case File Exists.')</script>");
echo "<meta http-equiv='refresh' content='0;url=addcase.php'> ";
}

else{

$court=mysqli_real_escape_string($conn,$court); 
$file_location=mysqli_real_escape_string($conn,$file_location);
$jofficer=mysqli_real_escape_string($conn,$jofficer); 
$type=mysqli_real_escape_string($conn,$type); 
$num=mysqli_real_escape_string($conn,$num);
$num = str_replace("  "," ",$num);
$parties=mysqli_real_escape_string($conn,$parties); 
$date=mysqli_real_escape_string($conn,$date); 
$orders=mysqli_real_escape_string($conn,$orders); 
$details=mysqli_real_escape_string($conn,$details); 
$regd_by=mysqli_real_escape_string($conn,$regd_by);
$advocate=mysqli_real_escape_string($conn,$advocate); 

//Save info in case details table
$sql = "INSERT INTO casedetails(court, case_type, user, num, parties, date_in, orders, advocate,file_location,jofficer, status) values ( '".$court."','".$type."','".$regd_by."','".$num."','".$parties."','".$date."','".$orders."','".$advocate."','".$file_location."','".$jofficer."','".$details."')";

$query=mysqli_query($conn,$sql);
if(!$query){die("Not submitted 1".mysqli_error($conn));}
//Fetch unique id
$id = '';
$sql="SELECT * FROM casedetails WHERE num='".$num."' AND user='".$regd_by."' AND case_type='".$type."' AND parties='".$parties."' AND date_in='".$date."' AND orders='".$orders."' AND advocate='".$advocate."' AND file_location='".$file_location."' AND jofficer='".$jofficer."' AND status='".$details."' ";//Haha, just to make sure it is the unique one coz the cases are not split by type under this scope, so it may be tricky to get the unique one
$result=$conn->query($sql);
if($result){
if($row=$result->fetch_assoc()){
$id = $row["sr"];}
}


//Save file if uploaded
if(isset($file) & $file != ""){ 
$allowedExts = array("pdf", "doc", "docx", "odt");
$extension = end(explode(".", $file["name"]));
if (in_array($extension, $allowedExts))
{
$filename = $file["name"];
$mycourt = str_replace("_"," ",$court);
if (!file_exists('uploads/'.$mycourt.'/'.$type.'/'.$num)) {
   mkdir('uploads/'.$mycourt.'/'.$type.'/'.$num, 0777, true);
}

$filepath = 'uploads/'.$mycourt.'/'.$type.'/'.$num.'/'.$filename;
$filepath = str_replace("'","_",$filepath);
//$filenameee=$filename.'.'.$extension;
$upload = move_uploaded_file($_FILES["file"]["tmp_name"],$filepath);
if($upload){
$id=mysqli_real_escape_string($conn,$id);
$filename=mysqli_real_escape_string($conn,$filename);
$filepath=mysqli_real_escape_string($conn,$filepath);
//save status in uploads table
$sql = "insert into uploads (id,date_time,filename,path)  values ('".$id."','".date('d/m/Y H:i')."','".$filename."','".$filepath."')";
$query=mysqli_query($conn,$sql);

//Update cases table 
$sql = "UPDATE casedetails SET has_attachment='Yes' WHERE sr='".$id."' ";
$query=mysqli_query($conn,$sql);
}else{
echo "File Not uploaded!!!! Go back";
}
}else{
echo "null";}
}



//save status in statuses table
$sql = "insert into statuses (id,court,user,num,mod_date,status)  values ( '".$id."','".$court."','".$regd_by."','".$num."','".date('d/m/Y H:i')."','".$details."')";

$query=mysqli_query($conn,$sql);

if(!$query){die("Not submitted ".mysqli_error($conn));}
else{
//echo "New case file saved successfully";
echo ("<script language='javascript'> window.alert('Case file saved successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=addcase.php'> ";
}

//Anti-duplicate checker ends here
}

//Isset checker ends here

}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=addcase.php'> ";}

}

//Close session expiry

?>