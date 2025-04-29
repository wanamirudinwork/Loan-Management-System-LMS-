<?php

// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!');
// $pdf->Output();

//db connection
// $con = mysqli_connect('localhost','root','');
// mysqli_select_db($con,'invoicedb');

//get invoices data
// $query = mysqli_query($con,"select * from invoice
// 	inner join clients using(clientID)
// 	where
// 	invoiceID = '".$_GET['invoiceID']."'");
// $invoice = mysqli_fetch_array($query);

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

class PDF extends FPDF {
	// Page Header
	function Header() {
		$logo = "../backpanel/images/logo.png";
		// Logo
	    // $this->Image($logo,10,20,50);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(30,5,'CAMBREX~HENKEL (M) SDN. BHD',0,1,'C');
	    // Subtitle
	    // $this->Cell(80);
	    $this->SetFont('Arial','B',7);
	    $this->Cell(190,4,'Company Reg No.:422347-P  GST No.:000079118336',0,1,'C');
	    // Address
	    // $this->Cell(80);
	    $this->SetFont('Arial','',7);
	    $this->Cell(190,3,'25, Lintang Beringin 8, Diamond Valley Industrial Park,',0,1,'C');
	    // $this->Cell(80);
	    $this->Cell(190,3,'Off Jalan Permatang Damar Laut, 11960 Bayan Lepas, Penang, Malaysia.',0,1,'C');
	    // $this->Cell(80);
	    $this->Cell(190,3,'Tel: 604-6266403  Fax: 604-6266440  Email: cambrexhenkel@yahoo.com',0,1,'C');
	    // PDF Title
	    $this->SetFont('Arial','B',12);
	    $this->Cell(190,12,'TAX INVOICE',0,1,'C');
	    // Line separating the header
	    $this->Line(10, 40, 200, 40);
	    // Line break
	    $this->Ln(5);

	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$company = $customer['company'];
$address1 = $customer['address1'].',';
$address2 = $customer['address2'].',';
$address3 = $customer['zip'].' '.$customer['city'].',';
$address4 = $state['name'].'.';

$name = ucwords($customer['salutation']).'. '.$customer['firstname'].' ~ '.$customer['contact'];
$contact = $customer['contact'];
$tel = $customer['company_contact'];
$fax = $customer['company_fax'];

$code = $key['rorder_code'];
$date = date('m/d/Y', time());
$bankacc = $customer['bankacc'];
$po = '';
$term = $key['rorder_iterms'];

$i = '1';
$description = $product['title'];
$qty = $key['rorder_qty'];
$price = $product['price'];
$taxtype = 'SR';

$currencyWords = new currencyToWords(number_format($amount,'2','.',''));
$currency = number_format('100.10','2','.','');
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',10);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130	,5,'Billing Address',0,1);
// $pdf->Cell(59	,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','B',8);
$pdf->Cell(130	,4,$company,0,0);
$pdf->Cell(29	,4,'Invoice No.',0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30	,4,':  '.$code,0,1);//end of line

$pdf->Cell(130	,4,$address1,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(29	,4,'Date',0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30	,4,':  '.$date,0,1);//end of line

$pdf->Cell(130	,4,$address2,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(29	,4,'Customer A/C No.',0,0);
$pdf->SetFont('Arial','',8); 
$pdf->Cell(34	,4,':  '.$bankacc,0,1);//end of line

$pdf->Cell(130	,4,$address3,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(29	,4,'Our D/O No.',0,0);
$pdf->SetFont('Arial','',8); 
$pdf->Cell(34	,4,':  '.$code,0,1);//end of line

$pdf->Cell(130	,4,$address4,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(29	,4,'P/O No.',0,0);
$pdf->SetFont('Arial','',8); 
$pdf->Cell(34	,4,':  '.$po,0,1);//end of line

$pdf->SetFont('Arial','B',8);
$pdf->Cell(10	,4,'Attn: ',0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(120	,4,$name,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(29	,4,'Terms',0,0);
$pdf->SetFont('Arial','',8); 
$pdf->Cell(34	,4,':  '.$term,0,1);//end of line

$pdf->SetFont('Arial','B',8);
$pdf->Cell(10	,4,'TEL: ',0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40	,4,$tel,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10	,4,'FAX :',0,0);
$pdf->SetFont('Arial','',8); 
$pdf->Cell(34	,4,$fax,0,1);//end of line

// Line separating the header
$pdf->Line(10, 83, 200, 83);

// $pdf->SetFont('Arial','B',8);
// $pdf->Cell(130	,5,'Tel: ',0,0);
// $pdf->SetFont('Arial','',8);
// $pdf->Cell(130	,5,'[contact]',0,0);
// $pdf->SetFont('Arial','B',8);
// $pdf->Cell(30	,5,'Fax :',0,0);
// $pdf->SetFont('Arial','',8); 
// $pdf->Cell(34	,5,'[fax no]',0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,6,'',0,1);//end of line

//billing address
// $pdf->Cell(100	,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
// $pdf->Cell(10	,5,'',0,0);
// $pdf->Cell(90	,5,'name',0,1);

// $pdf->Cell(10	,5,'',0,0);
// $pdf->Cell(90	,5,'company',0,1);

// $pdf->Cell(10	,5,'',0,0);
// $pdf->Cell(90	,5,'address',0,1);

// $pdf->Cell(10	,5,'',0,0);
// $pdf->Cell(90	,5,'contact',0,1);

//make a dummy empty cell as a vertical spacer
// $pdf->Cell(189	,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',10);

$pdf->Cell(15	,10,'No',0,0);
$pdf->Cell(82	,10,'Description',0,0);
$pdf->Cell(15	,10,'Qty',0,0,'C');
$pdf->Cell(30	,10,'Price/Unit (RM)',0,0,'C');
$pdf->Cell(30	,10,'Amount (RM)',0,0,'C');
$pdf->Cell(18	,10,'Tax',0,1,'C');//end of line

// Line separating the content
$pdf->Line(10, 94, 200, 94);
$pdf->Cell(189	,3,'',0,1);//end of line

$pdf->SetFont('Arial','',10);

//Numbers are right-aligned so we give 'R' after new line parameter

//items
// $query = mysqli_query($con,"select * from item where invoiceID = '".$invoice['invoiceID']."'");
$tax = 0; //total tax
$amount = 0; //total amount

//display the items
// while($item = mysqli_fetch_array($query)){
// 	$pdf->Cell(130	,5,$item['itemName'],1,0);
// 	//add thousand separator using number_format function
// 	$pdf->Cell(25	,5,number_format($item['tax']),1,0);
// 	$pdf->Cell(34	,5,number_format($item['amount']),1,1,'R');//end of line
// 	//accumulate tax and amount
// 	$tax += $item['tax'];
// 	$amount += $item['amount'];
// }
$pdf->Cell(1	,5,'',0,0);
$pdf->Cell(15	,5,$i,0,0);
$pdf->Cell(82	,5,$description,0,0);
$pdf->Cell(15	,5,$qty,0,0,'C');
//add thousand separator using number_format function
$pdf->Cell(30	,5,$price,0,0,'C');
$pdf->Cell(30	,5,$price,0,0,'C');//end of line
$pdf->Cell(18	,5,$taxtype,0,1,'C');//end of line
//accumulate tax and amount
$tax += $price * 0.06;
$amount += $price;
$total = $tax + $amount;
// Line separating the content
$pdf->Line(10, 230, 200, 230);
$pdf->Cell(130	,131,'',0,1);
//summary
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(113	,5,'RINGGIT MALAYSIA: '.$currencyWords->convert(),0,0);
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(35	,5,'Total Excl. SST',0,0);
$pdf->Cell(36	,5,number_format((float)$amount,2,'.',''),1,1,'R');//end of line

$pdf->Cell(113	,5,'',0,0);
$pdf->Cell(35	,5,'SST Amt @ 6%',0,0);
$pdf->Cell(36	,5,number_format((float)$tax,2,'.',''),1,1,'R');//end of line

$pdf->SetFont('Arial','BU',8.5);
$pdf->Cell(113	,6,'OCBC BANK (MALAYSIA) BERHAD - ACCOUNT NO: 732-10026-68',0,0);
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(35	,5,'Total Incl. SST',0,0);
$pdf->Cell(36	,5,number_format((float)$total,2,'.',''),1,1,'R');//end of line

$pdf->SetFont('Arial','',8.6);
$pdf->Cell(130	,5,'',0,1);
$pdf->Cell(115	,10,'This is computer generated. No signature are required.',0,1);

$pdf->Line(11, 263, 66, 263);
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(55	,10,'CAMBREX-HENKEL (M) SDN BHD',0,1,'C');



















$pdf->Output();
?>
