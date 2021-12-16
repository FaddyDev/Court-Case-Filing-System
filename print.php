<?php
//Connect to database via another page
include_once("includes/sessions.php");
include_once("includes/dbconn.php"); ?>

<?php
//PDF USING MULTIPLE PAGES

require('fpdf/fpdf.php');

//Create new pdf file
$pdf=new FPDF();
if(isset($_GET['print']))
{
$pdf->SetAutoPageBreak(false);

//Add page
$pdf->AddPage("P","A4");
$mod_date='';
$mod_by='';
$status='';



$id=$_GET['print'];
$sql="SELECT * FROM casedetails WHERE sr='".$id."' ";
$result=$conn->query($sql);


$court = '';
while($row=$result->fetch_assoc()){
$regd_by = $row["user"];
$court = str_replace("_"," ",$row["court"]);
//$court = preg_replace('_', '/\s+/', $row["court"]);
$case = $row["case_type"];
$num = $row["num"];
$date = $row["date_in"];
$parties = $row["parties"];
$jofficer = $row["jofficer"];


//Covert case to uppercase
$court = strtoupper($court);
$case = strtoupper($case);
if($court == 'ELC'){$case = '';}

//Print heading/title
$pdf->SetFont("Times","U","14");
$pdf->SetX(130);
$pdf->Image("img/Court.png",90, 7, -200);
//$pdf->Image('logo.png',10,10,-300);

$pdf->SetY(20);
$pdf->SetX(90);
$pdf->Cell(10,8,"MURANG'A LAW COURTS",0,1,"C");
$pdf->SetX(100);
$pdf->Cell(10,8," PROCEEDINGS OF  ".$court." ".$case." CASE NUMBER ".$num."  ",0,2,"C");

$pdf->SetX(10);
//1st row, Registered by
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("","B","14");
$pdf->Multicell(30,8,"Before:",0);
$pdf->setXY($x+30,$y);
$pdf->SetFont("","","14");
$pdf->Multicell(160,8,"".$jofficer."",1);

//2nd row, P.J No.
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("","B","14");
$pdf->Multicell(30,8,"Regd. By:",0);
$pdf->setXY($x+30,$y);
$pdf->SetFont("","","14");
$pdf->Multicell(160,8,"".$regd_by."",1);

//3rd row, P.J No.
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("","B","14");
$pdf->Multicell(30,8,"Filed On:",0);
$pdf->setXY($x+30,$y);
$pdf->SetFont("","","14");
$pdf->Multicell(160,8,"".$date."",1);

//4th row, Parties
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("","B","14");
$pdf->Multicell(30,8,"Parties:",0);
$pdf->setXY($x+30,$y);
$pdf->SetFont("","","14");
$pdf->Multicell(160,8,"".$parties."",1);



//5 blank lines below
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->setXY($x,$y+5);

$pdf->SetFont("","B","14");
$pdf->Cell(110,8,"STATUS",1,0,"C",FALSE);
$pdf->Cell(40,8,"UPDATED BY",1,0,"C",FALSE);
$pdf->Cell(40,8,"UPDATED ON",1,1,"C",FALSE);

//initialize counter
$rowCount=0;
$sql="SELECT COUNT(*) FROM statuses WHERE id='".$id."' ORDER BY sr";
$result=$conn->query($sql);
while($row = mysqli_fetch_array($result))
{
$rowCount = $row["COUNT(*)"];}

//create for loop to print all rows in the table
for(($i = 0);($i < $rowCount); ($i++)){

$sql="SELECT * FROM statuses WHERE id='".$id."' ORDER BY sr";
$result=$conn->query($sql);


while($row = mysqli_fetch_array($result))
{
$pdf->SetFillColor(255,255,255);
$pdf->SetFont("","","11");	

$mod_date = $row["mod_date"];
$mod_by = $row["user"];
$status = $row["status"];

$pdf->SetFont("","","14");

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Multicell(110,8,"".$status."",1);

$h = $pdf->GetY();
$pdf->setXY($x+110,$y);
if($h<=8){$h=8;} else{$h=$h-$y;}
$pdf->Multicell(40,$h,"".$mod_by."",1,"C",1);

$h = $pdf->GetY();
$pdf->setXY($x+150,$y);
if($h<=8){$h=8;} else{$h=$h-$y;}
$pdf->Multicell(40,$h,"".$mod_date."",1,"C",1);


//To force page break when cell height is larger than space left at the bottom
$height_of_cell = 20; // mm
$page_height = 286.93; // mm (portrait letter)
$bottom_margin = -5; // mm
  for($i=0;$i<=100;$i++) :
    $block=floor($i/6);
    $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
      if ($i/6==floor($i/6) && $height_of_cell > $space_left) {
        $pdf->AddPage(); // page break
      }
  endfor;

//for loop ends here
}

mysqli_close($conn);

//Send file
$pdf->Output();
//While loop ends here
}
//isset ends here
}

}



?>


