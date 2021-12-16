
<?php include_once("includes/sessions.php"); 
require_once('includes/header.php'); //include the template top 
include_once("includes/dbconn.php");?>

 <script src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#submit").click(function() {
var num = $("#num").val();
var case_date = $("#date").val();
var case_orders = $("#orders").val();
var case_parties = $("#parties").val();
var case_advocate = $("#advocate").val();
var case_details = $("#details").val();
var case_oriji_details = $("#oriji_details").val();
var case_id = $("#id").val();
if (num == '' || case_date == '' || case_orders == '' || case_parties == '' || case_advocate == '' || case_details == ''|| case_oriji_details == ''|| case_id == '') {
$('#success__para').html("Insertion Failed Some Input Fields are Blank....!!");
} else {
// Returns successful data submission message when the entered information is stored in database.
$.post("editCase.php", {
 case_num:num,
   date:case_date,
   orders:case_orders,
   details:case_details,
   oriji_details:case_oriji_details,
   id:case_id,
   advocate:case_advocate,
   parties:case_parties
  }, function(data) {
alert(data);
//$('#editcaseform')[0].reset(); // To reset form fields
 success: function (response) {
   $('#success__para').html("Changes saved");
  }
});
}
});
});
</script>


<div class="container">
<p align="center" style="color:#FF0000;" id="success_para" ></p>
<hr>
<h2>Edit Case Details</h2>
<div class="col-md-6">
<?php
//Just ensuring that we only continue if the user is logged in

if(isset($_GET['edit']))
{
$id=$_GET['edit'];
$sql="SELECT * FROM casedetails WHERE sr='".$id."' ";
$result=$conn->query($sql);
if($result->num_rows>0){
while($row=$result->fetch_assoc()){ ?><? //echo $row["category"];?>
<form class="form-horizontal well" action="editCase.php"  id="editcaseform" method="post" enctype="multipart/form-data">
 Case Type:     <select class="form-control" name="casetype" id="case" required>
		  			  <option value="<?php  echo  $row['case_type'];?>"><?php  echo  $row['case_type'];?></option>
		   <?php //Show different case types for different registries
		     $reg = $_SESSION["category"];
				if($reg=='Chief_Magistrate_Courts' || $_SESSION['category'] == 'CMs_Admin'){ 
					echo " <option value='Criminal'>Criminal</option>
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
						else if($reg=='High_Court' || $_SESSION['category'] == 'HC_Admin'){ 
						echo "<option value='Criminal'>Criminal</option>
                  			<option value='Criminal appeal'>Criminal appeal</option>
							<option value='Civil'>Civial</option>
							<option value='Civil appeal'>Civial appeal</option>
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
							<option value='Pre-election appeal'>Election petition appeal</option>
							<option value='Election petition appeal'>Election petition appeal</option>";
						 }
						//Kadhi's court cases
						else if($reg=='Kadhi' || $_SESSION['category'] == 'Kadhi_Admin'){ 
                echo "<option value='Marriage'>Marriage</option>
				<option value='Divorce'>Divorce</option>
				<option value='Succession'>Succession</option>
				<option value='Misc Application'>Misc Application</option>";
				  
				 }
					//ELC Cases
							else if($reg=='ELC' || $_SESSION['category'] == 'ELC_Admin'){ 
                 echo "<option value='ELC'>ELC</option>";
						}
						
						 ?>
</select> Case Number: <input class="form-control add-todo" type="text" value="<?php  echo  $row['num'];?>" placeholder="E.g. 10 of 2017" placeholder="" id="num" name="num" required/>
Judicial Officer/Judge: <input class="form-control add-todo" type="text" placeholder="Name of Judicial officer" value="<?php  echo  $row['jofficer'];?>"  id="jofficer" name="jofficer" required/> 
 Date Filed:  <input type="text" class="form-control add-todo datepicker" value="<?php  echo  $row['date_in'];?>" placeholder="case filing date" id="date" name="date" onKeyDown="return false" autocomplete="off" required/>     
 File Location: <input class="form-control add-todo" type="text" value="<?php  echo  $row['file_location'];?>"  id="location" name="file_location" required/></div>  
 <div class="col-md-6" style="background-color:#f5f5f5; border-radius:5px; border-color:#FF0000; border-style:groove; border:thick;">
 Parties:   <input class="form-control add-todo" type="text" value="<?php  echo  $row['parties'];?>" placeholder="Parties involved" id="parties" name="parties" required/>
Latest Details:    <textarea class="form-control add-todo"  name="details" id="details" placeholder="Record latest case details here" required/><?php  echo  $row['status'];?></textarea>  
Advocate:  <input type="text" class="form-control add-todo" value="<?php  echo  $row['advocate'];?>" placeholder="Put N/A if no advocate" id="advocate" name="advocate" required/>  
Latest Orders:   <input type="text" class="form-control add-todo" value="<?php  echo  $row['orders'];?>" onKeyPress="" placeholder="Enter latest case orders" id="orders" name="orders" required/>  
Upload any file associated with this case<input type="file" readonly="true" title="Click to upload" accept="application/msword,application/pdf,.doc,.docx,.odt" name="attachment" id="file" />
<input type="hidden"  value="<?php  echo  $row['court'];?>" id="court" name="court" required/>
<input type="hidden"  value="<?php  echo  $row['status'];?>" id="oriji_details" name="oriji_details" required/>
<input type="hidden"  value="<?php  echo $id;?>" id="id" name="id" required/>
      </div>
          
		  <input type="reset" class="btn btn-primary" style="float: left;" value="Reset All" />
        <input type="submit" id="submit" class="btn btn-primary" style="float: right;" value="Save Changes" name="registerbtn" /> 
		</form> 
		<?php }}}?>

</div>
 </div>
<?php require_once('includes/footer.php'); //include footer template ?>

<?php
include_once("includes/dbconn.php");
if(isset($_POST['registerbtn'])){

//create a PHP statement that gets the new contact details
$court = $_POST["court"];
$file_location = $_POST["file_location"];
$jofficer = $_POST["jofficer"];
$type = $_POST['casetype'];
$regd_by = $_SESSION["username"];
$date = $_POST['date'];
$num = $_POST['num'];
$orders = $_POST['orders'];
$details = $_POST['details'];
$oriji_details = $_POST['oriji_details'];
$advocate = $_POST['advocate'];
$parties = $_POST['parties'];
$id = $_POST['id'];


//Confirm that all fields are set
if(isset($date) & isset($num) & isset($orders) & isset($details) & isset($advocate) & isset($parties) & isset($regd_by)& isset($oriji_details)& isset($id) & isset($court) & isset($type)& isset($file_location)& isset($jofficer) ) 
{

$sql="SELECT * FROM casedetails WHERE num='".$num."' AND court='".$court."' AND case_type='".$type."' ";
$result=$conn->query($sql);

//If there exists such rows
if($result->num_rows>1){
if($row=$result->fetch_assoc()){

echo ("<script language='javascript'> window.alert('Case File Exists.')</script>");
echo "<meta http-equiv='refresh' content='0;url=casefiles.php'> ";
}
}
else{
//assemble insert string that allows entry of special characters
$court=mysqli_real_escape_string($conn,$court); 
$file_location=mysqli_real_escape_string($conn,$file_location);
$jofficer=mysqli_real_escape_string($conn,$jofficer); 
$type=mysqli_real_escape_string($conn,$type);
$num=mysqli_real_escape_string($conn,$num);  ; 
$parties=mysqli_real_escape_string($conn,$parties); 
$date=mysqli_real_escape_string($conn,$date); 
$orders=mysqli_real_escape_string($conn,$orders); 
$details=mysqli_real_escape_string($conn,$details); 
$oriji_details=mysqli_real_escape_string($conn,$oriji_details);
$regd_by=mysqli_real_escape_string($conn,$regd_by);
$advocate=mysqli_real_escape_string($conn,$advocate); 
$id=mysqli_real_escape_string($conn,$id); 

//Save file if uploaded
if(isset($_FILES["attachment"]) & $_FILES["attachment"] != ""){ 
$file = $_FILES["attachment"];
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
//$filename=date('d/m/Y H:i') . $_FILES[$file]["name"];
$upload = move_uploaded_file($_FILES["attachment"]["tmp_name"],$filepath);
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
if(!$query){die("Not submitted ".mysqli_error($conn));}
}else{
echo "File Not uploaded!!!! Go back";
}
}else{
echo "";}
}



//save status in statuses table
if($oriji_details!=$details){
$sql = "insert into statuses (id,court,user,num,mod_date,status)  values ( '".$id."','".$court."','".$regd_by."','".$num."','".date('d/m/Y H:i')."','".$details."')";
$query=mysqli_query($conn,$sql);

//echo $oriji_details;
}

$sql = "UPDATE casedetails,statuses SET casedetails.num='".$num."',casedetails.case_type='".$type."',casedetails.user='".$regd_by."',casedetails.parties='".$parties."',casedetails.date_in='".$date."',casedetails.orders='".$orders."',casedetails.advocate='".$advocate."',casedetails.status='".$details."',casedetails.file_location='".$file_location."',casedetails.jofficer='".$jofficer."',statuses.court='".$court."',statuses.user='".$regd_by."',statuses.num='".$num."' WHERE casedetails.sr='".$id."' AND statuses.id='".$id."' ";

$query=mysqli_query($conn,$sql);


if(!$query){die("Not submitted ".mysqli_error($conn));}
else{
//echo "Changes saved successfully";
echo ("<script language='javascript'> window.alert('Changes saved successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=casefiles.php'> ";
exit();
}

//Anti-duplicate checker ends here
}

//Isset checker ends here

}
else { 
echo ("<script language='javascript'> window.alert('Kindly fill all fields')</script>");
echo "<meta http-equiv='refresh' content='0;url=casefiles.php'> ";}

}


?>