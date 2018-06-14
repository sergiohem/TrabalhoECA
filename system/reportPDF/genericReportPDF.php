<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 05/01/2018
 * Time: 18:56
 */

require_once('../vendor/autoload.php');
require_once("../db/reportDAO.php");


class MYPDF extends TCPDF
{

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $report = (isset($_GET["report"]) && $_GET["report"] != null) ? $_GET["report"] : "";

    $pdf = new MYPDF();
    $reportDAO = new reportDAO();

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('ECA');
    $pdf->SetTitle('Report');
    $pdf->SetSubject('Trabalho ECA');
    $pdf->SetKeywords('TCPDF, PDF, Report');
    $pdf->Cell(0, 0, 'A4 PORTRAIT', 1, 1, 'C');

    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    $pdf->AddPage('L', 'A4');

    $html = "";

    switch ($report){
        case "1":
            $html = $reportDAO->report1();
            break;
        case "2":
            $html = $reportDAO->report2();
            break;
        case "3":
            $html = $reportDAO->report3();
            break;
        case "4":
            $html = $reportDAO->report4();
            break;
        case "5":
            $html = $reportDAO->report5();
            break;
        case "6":
            $html = $reportDAO->report6();
            break;
        case "7":
            $html = $reportDAO->report7();
            break;
        default:
            break;
    }

    $pdf->writeHTML($html);

    $pdf->Output('report.pdf', 'I');
}

?>