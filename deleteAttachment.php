
<?php
include_once("includes/sessions.php");
//Connect to database via another page
include_once("includes/dbconn.php");
?>

<?php
if(isset($_GET['del']))
{
$id=$_GET['del'];
$csr='';
$result=$conn->query("SELECT * FROM uploads where srr = '".$id."' ");
if($result->num_rows>0){
while($row=$result->fetch_assoc()){ 
$csr = $row['id'];
}}

$sql="DELETE FROM uploads WHERE srr='".$id."' ";
//$result=mysqli_query($sql) or die("Could not delete".mysqli_error());
$result=$conn->query($sql);

$result=$conn->query("SELECT * FROM uploads where srr = '".$id."' ");
if($result->num_rows<1){
$sql = "UPDATE casedetails SET has_attachment='' WHERE sr='".$csr."' ";
$query=mysqli_query($conn,$sql);
}


echo ("<script language='javascript'> window.alert('Attachment Deleted successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=casefiles.php'> ";
}


?>

