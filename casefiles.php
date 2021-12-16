
<?php  include_once("includes/sessions.php"); require_once('includes/header.php'); //include the template top
include_once("includes/dbconn.php"); ?>

<div class="container">
<div class="col-md-4">
<input style="float:right;" type="text" id="searchTerm" class="search_box form-control add-todo" placeholder="Type to search..." onkeyup="doSearch()" />
</div>
<hr>
<div class="col=md-12">
<table id="dataTable" class="table table-striped table-bordered table-hover table-condensed table-responsive display">
<tbody>
<tr><?php if($_SESSION["level"] == 1){?><th>Court</th><?php } ?><th>Case</th><th>Number</th><th>Date Filed</th><th>Parties</th><th>Location</th><th>Advocate</th><th>Latest Details</th><th><img src="img/attachment.png" height="22.5" width="22.5" title="Attachments" /></th><th>Latest Orders</th>
<?php if($_SESSION["level"] != 1){?><th colspan="2">Action</th><?php } ?></tr>
<?php 
$sql = '';
if($_SESSION['category'] == 'CMs_Admin' || $_SESSION['category'] == 'Chief_Magistrate_Courts') {$sql="SELECT * FROM casedetails where court = 'Chief_Magistrate_Courts' and not existence = 'deleted' ORDER BY case_type";}
			 
else if($_SESSION['category'] == 'HC_Admin' || $_SESSION['category'] == 'High_Court') {$sql="SELECT * FROM casedetails where court = 'High_Court' and not existence = 'deleted' ORDER BY case_type";}
			 
else if($_SESSION['category'] == 'ELC_Admin' || $_SESSION['category'] == 'ELC') {$sql="SELECT * FROM casedetails where court = 'ELC' and not existence = 'deleted' ORDER BY case_type";}
else if($_SESSION['category'] == 'Kadhi_Admin' || $_SESSION['category'] == 'Kadhi') {$sql="SELECT * FROM casedetails where court = 'Kadhi' and not existence = 'deleted' ORDER BY case_type";}
else {$sql="SELECT * FROM casedetails  ORDER BY court";}


$result=$conn->query($sql);
if($result->num_rows>0){
while($row=$result->fetch_assoc()){

$court = $row["court"];
if($court=='Chief_Magistrate_Courts'){$court = 'CMs';}
else if($court=='High_Court'){$court = 'HC';}
else{$court = $court;}

echo "<tr> ";
if($_SESSION["level"] == 1){ echo "<td> ".$court." </td>"; }
echo "<td> ".$row["case_type"]." </td>
<td> ".$row["num"]." </td>
<td> ".$row["date_in"]." </td> 
<td> ".$row["parties"]."</td>
<td> ".$row["file_location"]."</td> 
<td> ".$row["advocate"]." </td>
<td>  <a href='print.php?print=$row[sr]'> ".$row["status"]." </a></td> <td>";
if($row["has_attachment"] == 'Yes'){echo "<a href='attachments.php?id=$row[sr]'> <img src='img/attachment.png' height='22.5' width='22.5' title='Download/Open' /> </a>";}
echo "</td><td> ".$row["orders"]."</td>";
if($_SESSION["level"] != 1){
echo "<td>  <a href='editCase.php?edit=$row[sr]'>Edit</a></td>";}
if($_SESSION["level"] == 2){
echo "<td>  <a href='javascript:confirmDeleteCase($row[sr])'>Delete</a></td>";} 
echo "</tr>";}
echo "</tbody></table> ";

echo "</div>
 <hr>
  </div>";
}
else{
//When table is empty
echo ("<script language='javascript'> window.alert('There are no cases in the system')</script>"); 
	if($_SESSION["level"] != 3){ echo "<meta http-equiv='refresh' content='0;url=admin.php'> ";}
else{echo "<meta http-equiv='refresh' content='0;url=addcase.php'> ";}
exit();
}
?>


  
<?php require_once('includes/footer.php'); //include footer template ?>
