
<?php
//Connect to database via another page
include_once("includes/sessions.php");
include_once("includes/dbconn.php");
?>

<?php
if(isset($_GET['del']))
{
$id=$_GET['del'];

$court = '';
$num = '';
$details = 'File deleted';

$sql = "UPDATE casedetails SET existence='deleted',status='".$details."' WHERE sr='".$id."' ";
$query=mysqli_query($conn,$sql);

$sql="SELECT * FROM casedetails WHERE sr='".$id."' ";
$result=$conn->query($sql);
if($result->num_rows>0){
while($row=$result->fetch_assoc()){ 
$court = $row['court'];
$num = $row['num'];
}}

$sql = "insert into statuses (id,court,user,num,mod_date,status)  values ( '".$id."','".$court."','".$_SESSION['username']."','".$num."','".date('d/m/Y H:i')."','".$details."')";
$query=mysqli_query($conn,$sql);


echo ("<script language='javascript'> window.alert('Case Deleted successfully')</script>");
echo "<meta http-equiv='refresh' content='0;url=casefiles.php'> ";
}


?>