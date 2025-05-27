<?php
$this->layout = 'report';
App::import('Vendor', 'PDF', array('file' => 'dompdf/autoload.inc.php'));

use Dompdf\Dompdf;


// var_dump($_POST);
// exit();
// var_dump($qrysql[0]['prov']['namaProvinsi']);
// exit();

$dompdf = new Dompdf();

$html = '<html>';

$html = '<style>
            table{
                border-collapse: collapse;
                margin: 25px 0;
                font-size: 0.9em;
                border-radius: 5px 5px 0 0;
                overflow: hidden;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1)
                }
            table thead tr{
                background-color: #009879;
                color: #ffff;
                text-align: left;
                font-weight: bold;
            }
            table th,
            table td{
                padding: 12px 15px;
            }
            table tbody tr{
                border-bottom: 1px solid #dddd
            }
            table tbody tr:nth-of-type(even){
                background-color: #f3f3f3;
            }
            table tbody tr:last-of-type{
                border-bottom: 2px solid #009879;
            }
        </style>';
$html .= '<h3>Laporan Voucher</h3><hr/><br/>';
$html .= '<table class="table" width="100%">';
$html .= '

<thead>
    <tr>
        <th>NO</th>
        <th>KODE VOUCHER</th>
        <th>NILAI</th>
        <th>ED VOUCHER</th>
    </tr>
</thead>';

$html .= '
<tbody>';

$no = 1;
foreach ($kodeVoucher as $dataVoucher) {

    $html .= '<tr>
    <td>' . $no . '</td>
    <td>' . $dataVoucher . '</td>
    <td>Rp. ' . number_format($nilai, 0, ',', '.') . '</td>
    <td>' . date('d-m-Y', strtotime($edVoucher)) . '</td>
 

    
    
    </tr>';
    $no++;
}

$html .= '
</tbody>
</table>';














$dompdf->loadHtml($html);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'landscape');

// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('contoh.pdf', array('Attachment' => false));
exit();
