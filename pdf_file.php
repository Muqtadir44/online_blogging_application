<?php
require 'FPDF/fpdf.php';
require 'require/database_settings.php';
require 'require/database_class.php';
$obj = new database($hostname,$username,$password,$database);
$pdf = new FPDF();
if (isset($_GET['action']) && $_GET['action'] == 'download_file') {

	extract($_GET);
	$result = $obj->file_generate($email);
	$row = mysqli_fetch_assoc($result);
	$pdf->AddPage();
	$pdf->Image('images/logo.png',5,10,20,20,"Png");
	$pdf->setDrawColor(0,179,0);
	$pdf->SetLineWidth(1);
	$pdf->Line(0,33,220,33);
	$pdf->SetFont('Arial','B','20');
	$pdf->SetTextColor(0, 125, 0);
	$pdf->Cell(60,33,"Blogger",0,0,"C",0);
	$pdf->Ln();
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFontSize(14);
	$pdf->MultiCell(0,5,"Thank you for registering on Blogger. You are now a valued member of our Blogger community.");
	$pdf->SetTextColor(0,179,0);
	$pdf->Cell(0,10,"Your Login Credentials:");
	$pdf->Ln();
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFontSize(12);
	$pdf->Cell(20,5,"Email: {$row['email']}",0,1);
	$pdf->Cell(20,5,"Password: {$row['password']}");
	$pdf->setDrawColor(0,179,0);
	$pdf->SetLineWidth(1);
	$pdf->Line(0,80,80,80);
	$pdf->Ln(15);
	$pdf->Cell(0,10,"Your given information");
	$pdf->Ln();
	$pdf->Cell(20,5,"First Name: {$row['first_name']}",0,1);
	$pdf->Cell(20,5,"Last Name: {$row['last_name']}",0,1);
	$pdf->Cell(20,5,"Gender: {$row['gender']}",0,1);
	$pdf->Cell(20,5,"Date of Birth: {$row['date_of_birth']}",0,1);
	$pdf->Cell(20,5,"Address: {$row['address']}",0,1);
	$pdf->Output('D',"Blogger_File.pdf");
}

elseif (isset($_GET['action']) && $_GET['action'] == 'generate_file') {

	extract($_GET);
	$result = $obj->file_generate($email);
	$row = mysqli_fetch_assoc($result);
	$pdf->AddPage();
	$pdf->Image('images/logo.png',5,10,20,20,"Png");
	$pdf->setDrawColor(0,179,0);
	$pdf->SetLineWidth(1);
	$pdf->Line(0,33,220,33);
	$pdf->SetFont('Arial','B','20');
	$pdf->SetTextColor(0, 125, 0);
	$pdf->Cell(60,33,"Blogger",0,0,"C",0);
	$pdf->Ln();
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFontSize(14);
	$pdf->MultiCell(0,5,"Thank you for registering on Blogger. You are now a valued member of our Blogger community.");
	$pdf->SetTextColor(0,179,0);
	$pdf->Cell(0,10,"Your Login Credentials:");
	$pdf->Ln();
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFontSize(12);
	$pdf->Cell(20,5,"Email: {$row['email']}",0,1);
	$pdf->Cell(20,5,"Password: {$row['password']}");
	$pdf->setDrawColor(0,179,0);
	$pdf->SetLineWidth(1);
	$pdf->Line(0,80,80,80);
	$pdf->Ln(15);
	$pdf->Cell(0,10,"Your given information");
	$pdf->Ln();
	$pdf->Cell(20,5,"First Name: {$row['first_name']}",0,1);
	$pdf->Cell(20,5,"Last Name: {$row['last_name']}",0,1);
	$pdf->Cell(20,5,"Gender: {$row['gender']}",0,1);
	$pdf->Cell(20,5,"Date of Birth: {$row['date_of_birth']}",0,1);
	$pdf->Cell(20,5,"Address: {$row['address']}",0,1);
	$pdf->Output('I',"Blogger_File.pdf");
}



?>
