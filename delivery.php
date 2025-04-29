<?php

require_once "../phpqrcode/qrlib.php";
require_once('TCPDF-test/vendors/TCPDF/tcpdf.php');

require_once '../lib/config.php';
require_once '../lib/limonade.php';

$cms = new cms($db);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 9);

// add a page
$pdf->AddPage();

$date = date('d/m/y');
$products = array();

$data = $cms->productRentInvoice($_GET['id']);
$customer = $data['customer'];
$rentOrder = $data['rentOrder'];
$products = $data['product'];
$state = $data['state']['name'];
$country = $data['country']['name'];

$html = '
	<table style="" >
		<tr style="line-height: 15px;">
			<td style="text-align: center; padding: 10px;">
				<img src="images/logo.png" alt="logo" width="60" height="60" border="0">
			</td>
			<td style="text-align: center; " width="60%">
				<strong style="font-size:20px;">
					CAMBREX~HENKEL (M) SDN. BHD
				</strong><br>
				<small style="font-size:9px;">
					<strong>Company Reg No.:422347-P  GST No.:000079118336</strong><br>
					25, Lintang Beringin 8, Diamond Valley Industrial Park,<br>
					Off Jalan Permatang Damar Laut, 11960 Bayan Lepas, Penang, Malaysia. <br>
					Tel: 604-6266403  Fax: 604-6266440  Email: cambrexhenkel@yahoo.com 
				</small>
			</td>
			<td width="30%"></td>
		</tr>
		<tr style="line-height: 30px;">
			<td></td>
			<td style="font-size:15px; text-align: center;" width="30%"><strong>DELIVERY ORDER</strong></td>
			<td width="50%"></td>
		</tr>
	</table>
	<hr>
	<table>
		<tr style="line-height: 30px;">
			<td><strong>Billing Address</strong></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr style="line-height: 18px;">
			<td><strong>'.strtoupper($customer['company']).'</strong></td>
			<td></td>
			<td><strong>D/O No.</strong></td>
			<td>: '.$rentOrder['rorder_code'].'</td>
		</tr>
		<tr style="line-height: 18px;">
			<td>'.$customer['address1'].'</td>
			<td></td>
			<td><strong>Date</strong></td>
			<td>: '.$date.'</td>
		</tr>
		<tr style="line-height: 18px;">
			<td>'.$customer['address2'].'</td>
			<td></td>
			<td><strong>Customer A/C No.</strong></td>
			<td>: '.$customer['bankacc'].'</td>
		</tr>
		<tr style="line-height: 18px;">
			<td>'.$customer['zip'].', '.$customer['city'].'</td>
			<td></td>
			<td><strong>Our Invoice No.</strong></td>
			<td>: '.$rentOrder['rorder_code'].'</td>
		</tr>
		<tr style="line-height: 18px;">
			<td>'.$state.', '.$country.'</td>
			<td></td>
			<td><strong>P/O No.</strong></td>
			<td>: [P/O No]</td>
		</tr>
		<tr style="line-height: 18px;">
			<td><strong>Attn</strong> : '.$customer['firstname'].' ~ '.$customer['contact'].'</td>
			<td></td>
			<td><strong>Terms</strong></td>
			<td>: '.$rentOrder['rorder_terms'].'</td>
		</tr>
		<tr style="line-height: 18px;">
			<td><strong>Tel</strong> : '.$customer['company_contact'].'</td>
			<td><strong>Fax</strong> : '.$customer['company_fax'].'</td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<br>
	<hr>
	<table>
		<tr style="line-height: 30px;">
			<th><strong>No</strong></th>
			<th><strong>Description</strong></th>
			<th><strong style="text-align: center;">Capacity</strong></th>
			<th><strong style="text-align: center;">Delivered Qty</strong></th>
			<th><strong style="text-align: center;">Return Qty (Empty Cyl)</strong></th>
			<th><strong style="text-align: center;">L/P</strong></th>
		</tr>
		<tr>
			<td><hr></td>
			<td><hr></td>
			<td><hr></td>
			<td><hr></td>
			<td><hr></td>
			<td><hr></td>
		</tr>';
$i = 1;
foreach($products as $product){
	$html.='
		<tr>
			<td>'.$i.'</td>
			<td>'.$product['title'].'</td>
			<td style="text-align:center;">'.$product['size'].' KG</td>
			<td style="text-align:center;">'.$rentOrder['rorder_qty'].' CYL</td>
			<td style="text-align:center;"></td>
			<td style="text-align:center;">[L]</td>
		</tr>';
	$i++;
}

$html.='<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
</table>
<table>
<tr>
<td height="100"></td>
</tr>
</table>
<hr>
<table>
	<tr>
		<td></td>
		<td></td>
		<td></td>
	</tr>
<table>
	<tr>
		<td width="30%" style="border: 1px solid black; text-align: center;"><strong>REMARK</strong></td>
		<td width="15%" style="border: 1px solid black; text-align: center;"><strong>RM</strong></td>
		<td width="15%"></td>
		<td width="50%"><strong>CAMBREX-HENKEL (M) SDN BHD</strong></td>
	</tr>
	<tr>
		<td width="30%" style="border: 1px solid black;"><strong>Rental To Be Collected</strong></td>
		<td width="15%" style="border: 1px solid black;"><strong></strong></td>
		<td width="15%"></td>
		<td width="50%"><strong>Computer Generated</strong></td>
	</tr>
	<tr>
		<td width="30%" style="border: 1px solid black;"><strong>Payment Collected</strong></td>
		<td width="15%" style="border: 1px solid black;"><strong></strong></td>
		<td width="15%"></td>
		<td width="30%"><strong><hr></strong></td>
	</tr>
	<tr>
		<td width="30%" style="border: 1px solid black;"><strong>Note</strong></td>
		<td width="15%" style="border: 1px solid black;"><strong></strong></td>
		<td width="15%"></td>
		<td width="25%"><strong>Received In Good Condition & Correct Quantity</strong></td>
	</tr>
	<tr>
		<td width="30%"></td>
		<td width="15%"></td>
		<td width="15%"></td>
		<td width="25%"></td>
	</tr>
	<tr>
		<td width="30%"></td>
		<td width="15%"></td>
		<td width="15%"></td>
		<td width="25%"></td>
	</tr>
	<tr>
		<td width="30%"></td>
		<td width="15%"></td>
		<td width="15%"></td>
		<td width="25%"></td>
	</tr>
	<tr>
		<td width="30%"></td>
		<td width="15%"></td>
		<td width="15%"></td>
		<td width="30%"><hr></td>
	</tr>
	<tr>
		<td width="30%"></td>
		<td width="15%"></td>
		<td width="15%"></td>
		<td width="25%"><strong>Customer Signature & Chop</strong></td>
	</tr>
</table>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');
?>