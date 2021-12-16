
<?php include_once("includes/sessions.php"); 
require_once('includes/header.php'); //include the template top
include_once("includes/dbconn.php"); ?>

<div class="container">
<div class="col-md-4">
</div>
<hr>
<table id="dataTable" class="table table-striped table-bordered table-hover table-condensed table-responsive display">

<?php 
if(isset($_GET['id']))
{
$id=$_GET['id'];
$result=$conn->query("SELECT * FROM casedetails where sr = '".$id."' ");
while($row=$result->fetch_assoc()){
if($result->num_rows>0){
$court = str_replace("_"," ",$row["court"]);
echo '<span class="danger"> Attachments for '.$court.' '.$row["case_type"].' case number '.$row["num"].'</span>'; 
}
}

$result=$conn->query("SELECT * FROM uploads,casedetails where uploads.id='".$id."' and casedetails.sr = '".$id."' ");
if($result->num_rows>0){


echo "<tbody>
<input style='float:right;' type='text' id='searchTerm' class='search_box form-control add-todo' placeholder='Type to search...' onkeyup='doSearch()' />
<tr><th>Attachment</th><th>Date Uploaded</th><th>Download/Open</th><th>Delete</th></tr>";

while($row=$result->fetch_assoc()){
echo "<tr> 
<td> ".$row["filename"]." </td> 
<td> ".$row["date_time"]."</td>
<td> <a href='".$row["path"]."'><img src='img/download2.png' height='22.5' width='22.5' title='Download/Open' /></a> </td> 
<td> <a href='javascript:confirmDeleteAttach($row[srr])'><img src='img/delete.jpg' height='22.5' width='22.5' title='Delete' /></a</td> <td>";
echo "</tr>";}
echo "</tbody></table> ";

}
else{
//When table is empty
echo ("<script language='javascript'> window.alert('There are no attachments in the system for this case')</script>"); 
echo "<meta http-equiv='refresh' content='0;url=casefiles.php'> ";

}
}

?>
 <hr>
</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
