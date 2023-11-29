<?php
require_once('../tcpdf.php');
include "autoload.php";

class SANPDF extends TCPDF {

    public  $num;
    private $sqlServerHost;
    private $sqlServerDatabase;
    private $sqlServerUser;
    private $sqlServerPassword;

    public $isLastPage = false;
    protected $last_page_flag = false;

    public function __construct() {
        $this->num     = isset($_POST['num']) ? $_POST['num'] : "";

        $this->sqlServerHost      = '192.168.124.142\TALYS, 50092';
        $this->sqlServerDatabase  = 'x3v12prod';
        $this->sqlServerUser      = 'CA';
        $this->sqlServerPassword  = 'WesoKhu640Rfz0Yi';

        parent::__construct();
    }

    public function Header() {
        $this->setMargins(5, 60, 10);

        $image_file = K_PATH_IMAGES.'sanifer_logo.jpg';
        $this->Image($image_file, 10, 8, 45, '', 'JPG', '', 'T', true, 300, 'R', false, false, 0, false, false, false);

        $this->SetFont('helvetica', '', 10);
        $html = '<h1>SANIFER</h1>101 Antananarivo<br>Madagascar<br>STAT : 46900 11 1993 0 10053<br>NIF : 2000036135';

        $this->writeHTMLCell(0, 0, 6, 8, $html, 0, 0, false, true, 'L', true);
        $this->Ln();
        
    }


    public function Footer() {
        $this->Ln();
        $text = $this->getAliasNumPage().'/'.$this->getAliasNbPages();
        $this->Cell(0, 10, $text, 0, false, 'L', 0, '', 0, false, 'M', 'M');
    }

    public function getDetailArticle(){
        $ref = $this->num;
        if(is_array($ref)){
            $ref   = implode("','",$this->num);
        }

        $connectionInfo     = array("Database" => $this->sqlServerDatabase, "UID" => $this->sqlServerUser, "PWD" => $this->sqlServerPassword, "CharacterSet" => "UTF-8");
        $link               = sqlsrv_connect($this->sqlServerHost, $connectionInfo);
        if (!$link) {
             die( print_r( sqlsrv_errors(), true));
        }           

        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT 
                                IM.ITMREF_0 AS REF
                                ,IM.ITMDES1_0 AS DESS
                                ,IM.TSICOD_1 AS FAM
                                ,ISNULL(IM.YBPSEAN_0,'') AS CB
                                ,ISNULL(IB.BPSNUM_0,'') AS FOURN
                                ,ISNULL(BPS.BPSNAM_0,'') AS FOURNN
                                ,ISNULL(IB.ITMREFBPS_0,'') AS REF_F
                                ,SP.PRI_0 AS PV_TTC
                                
                            FROM 
                                [ZITMMASTER] IM 
                                LEFT JOIN [ZITMBPS] IB ON IB.ITMREF_0 = IM.ITMREF_0 AND IB.DEFBPSFLG_0 = 2
                                LEFT JOIN [ZBPSUPPLIER] BPS ON BPS.BPSNUM_0 = IB.BPSNUM_0
                                LEFT JOIN [ZSPRICLIST] SP ON SP.PLICRI1_0 = IM.ITMREF_0 AND SP.PLI_0 = 'TGEN'

                            WHERE
                                IM.ACCCOD_0 = 'SAN'
                                AND ( 
                                        IM.ITMREF_0 IN ('".$ref."')
                                    )
                            ORDER BY
                                IM.ITMREF_0";

        $resultat       = sqlsrv_query($link, $query, $queryParams, $queryOptions);
        if ($resultat == FALSE) {
            var_dump(sqlsrv_errors());
            return false;
        } elseif (sqlsrv_num_rows($resultat) == 0) {
            return false;
        } else {
            while($row = sqlsrv_fetch_array($resultat, SQLSRV_FETCH_ASSOC)){
                $data[] = $row;
            }
        }
        return $data;
    }

}

$pdf = new SANPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('WINNY');
$pdf->setTitle('SANIFER IMPRESSION ARTICLES');
$pdf->setSubject('IMPRESSION ARTICLES');
$pdf->setKeywords('SANIFER, ARTICLES, CODE BARRE, IMPRESSION');

$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' SANIFER ARTICLES', PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->setMargins(PDF_MARGIN_LEFT-9, PDF_MARGIN_TOP+20, PDF_MARGIN_RIGHT-12);
$pdf->setHeaderMargin(60);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setAutoPageBreak(TRUE);
$pdf->AddPage();
$pdf->Ln(-15);
$pdf->SetFont('helvetica', '', 9);
$pdf->writeHTML("<hr>", true, false, false, false, '');
$style = array(
            'position' => 'R',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => 0,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, 
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4 );

$art  = $pdf->getDetailArticle();
foreach ($art as $val) {  
    $pdf->SetFont('helvetica', 'B', 9);                      
    $pdf->Cell(0, 0, $val['REF'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Ln(6);
    $pdf->Cell(0, 0, $val['DESS'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
    $pdf->Ln(-10);
    $pdf->write1DBarcode($val['REF'], 'EAN13', '', '', '', 18, 0.4, $style, 'N');
    $pdf->writeHTML("<hr>", true, false, false, false, '');
    $pdf->Ln(4);
}

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/fra.php')) {
	require_once(dirname(__FILE__).'/lang/fra.php');
	$pdf->setLanguageArray($l);
}

$dossier     = dirname(__FILE__)."/uploads/";
$nom_fichier = "Articles_SANIFER_";

$pdf->Output($dossier.$nom_fichier.time().".pdf","FI");
//$pdf->Output("test".time().".pdf","D");

