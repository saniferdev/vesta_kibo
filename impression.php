<?php
session_start();
if (!empty($_SESSION["username"])) {
    $name = $_SESSION["username"];
} else {
    session_unset();
    $url = "./index.php";
    header("Location: $url");
}

if(isset($_GET['d']) && isset($_GET['f'])){
    $d = $_GET['d'];
    $f = $_GET['f'];
}
else {
    session_unset();
    $url = "./index.php";
    header("Location: $url");
} 

session_write_close();
include __DIR__ . "/config.php";
include __DIR__ . "/lib/Api.php";

$Api 				= new API();
$Api->link          = $link;
$mvt_casse          = $Api->getSortie($d,$f);

require_once('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();

$spreadsheet->getProperties()
    ->setTitle('KIBO SORTIE CASSE')
    ->setSubject('Mvt de sorties divers');

$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Date')
    ->setCellValue('B1', 'N°')
    ->setCellValue('C1', 'Ref')
    ->setCellValue('D1', 'Désignation')
    ->setCellValue('E1', 'Qte')
    ->setCellValue('F1', 'PMP')
    ->setCellValue('G1', 'Valeur PMP')
    ->setCellValue('H1', 'Fam n°')
    ->setCellValue('I1', 'Intitulé')
    ->setCellValue('J1', 'N° Fournisseur')
    ->setCellValue('K1', 'Intitulé Fournisseur');

$i   = 2;

foreach ($mvt_casse as $value) {
    $spreadsheet->getActiveSheet()
    ->setCellValue("A".$i, $value["DATES"]->format("d/m/Y"))
    ->setCellValue("B".$i, $value["NUM"])
    ->setCellValue("C".$i, $value["REF"])
    ->setCellValue("D".$i, $value["DESS"])
    ->setCellValue("E".$i, $value["QTE"])
    ->setCellValue("F".$i, $value["PMP"])
    ->setCellValue("G".$i, $value["V_PMP"])
    ->setCellValue("H".$i, $value["FAM"])
    ->setCellValue("I".$i, $value["INTITULE"])
    ->setCellValue("J".$i, $value["N_FOURN"])
    ->setCellValue("K".$i, $value["INT_FOURN"]);

    $i++;
}

$styleArray = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => 'FFA0A0A0',
        ],
        'endColor' => [
            'argb' => 'FFFFFFFF',
        ],
    ],
];

$spreadsheet->getActiveSheet()->getStyle('1:1')->applyFromArray($styleArray);

for($col = 'A';$col<'L';$col++){
    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}

$spreadsheet->getActiveSheet()->getPageSetup()
    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$spreadsheet->getActiveSheet()->getPageSetup()
    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

$filename   = "Mvt Sorties divers du ".date("d/m/Y",strtotime($d))." au ".date("d/m/Y",strtotime($f))." ".time();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');

$writer     = IOFactory::createWriter($spreadsheet, "Xlsx"); 
$writer->save('php://output');