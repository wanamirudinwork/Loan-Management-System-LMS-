<?php

require_once "../phpqrcode/qrlib.php";
require_once '../currencyToWords.php';
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
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

$data = $cms->productRentPDF($_GET['id']);

$qrcode = $data['qrcode'];
$product = $data['product'];
$brand = $data['brand'];
$category = $data['category'];
$color = array($product['color']);

if($product['status']){
    if($product['status'] == '1'){
        $status = 'Active';
    }
    if($product['status'] == '2'){
        $status = 'Inactive';
    }
}

$html = '
<style>
th, td {
    border: 1px solid #555;
}
</style>
<h2><u>Product Detail</u></h2>
<table>
    <tbody>
        <tr>
            <th width="20%"></th>
            <td width="80%" style="text-align: center;"><img src="'.$qrcode.'"></td>
        </tr>
        <tr>
            <th><strong>Title</strong></th>
            <td style="text-align: center;">'.$product['title'].'</td>
        </tr>
        <tr>
            <th><strong>Description</strong></th>
            <td style="text-align: center;">'.$product['description'].'</td>
        </tr>
        <tr>
            <th><strong>Brand</strong></th>
            <td style="text-align: center;">'.$brand['title'].'</td>
        </tr>
        <tr>
            <th><strong>Category</strong></th>
            <td style="text-align: center;">'.$category['title'].'</td>
        </tr>
        <tr>
            <th><strong>Quantity</strong></th>
            <td style="text-align: center;">'.$product['quantity'].'</td>
        </tr>
        <tr>
            <th><strong>Price</strong></th>
            <td style="text-align: center;">RM '.$product['price'].'</td>
        </tr>
        <tr>
            <th><strong>Color</strong></th>
            <td style="text-align: center;"></td>
        </tr>
        <tr>
            <th><strong>Size</strong></th>
            <td style="text-align: center;">'.$product['size'].'</td>
        </tr>
        <tr>
            <th><strong>Gas Type</strong></th>
            <td style="text-align: center;">'.$product['gas_type'].'</td>
        </tr>
        <tr>
            <th><strong>Status</strong></th>
            <td style="text-align: center;">'.$status.'</td>
        </tr>
    </tbody>
</table>
';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');
?>