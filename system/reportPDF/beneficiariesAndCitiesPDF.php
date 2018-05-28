<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 05/01/2018
 * Time: 18:56
 */

require_once('TCPDF/tcpdf.php');
require_once("../db/beneficiaryDAO.php");
include_once("../classes/beneficiary.php");

class MYPDF extends TCPDF
{

    // Page footer
    public function Footer()
    {
        $this->setFooterData();
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF();

$benefDAO = new beneficiaryDAO();

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ECA');
$pdf->SetTitle('Beneficiaries');
$pdf->SetSubject('Trabalho ECA');
$pdf->SetKeywords('TCPDF, PDF, Beneficiaries');

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->AddPage();

//$html = "<h2>BENEFICIARIES ORDER BY NAME</h2>
//<table class=\"table-striped table-bordered\">
//     <thead>
//       <tr class=\"active\">
//        <th>NIS</th>
//        <th>Name</th>
//       </tr>
//     </thead>
//     <tbody>";
//
//    foreach ($list as $benef){
//
//        //$b = new beneficiary(0,'','');
//        $b = $benefDAO->atualizar($benef);
//
//        $nis = $b->getNis();
//        $namePerson = $b->getNamePerson();
//        $html .= "<td>$nis</td><td>$namePerson</td>";
//    }
//
//    $html .="</tbody>
//     </table>
//";

$html = $benefDAO->listarBeneficiariosESuasCidades();


$pdf->writeHTML($html);

$pdf->Output('beneficiaries.pdf', 'I');

?>