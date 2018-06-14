<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 09/01/2018
 * Time: 09:49
 */

require_once("../vendor/autoload.php");
require('../vendor/mem_image.php');
require_once("../db/conexao.php");

$monthSelected = $_GET['selectMonth'];

$query = "SELECT 
    sum(pay.db_value) AS payments_total, concat(pay.int_month, \"/\", pay.int_year) AS month_year, st.str_uf
FROM
    tb_beneficiaries AS ben
        JOIN
    tb_payments AS pay ON ben.id_beneficiaries = pay.tb_beneficiaries_id_beneficiaries
        JOIN
    tb_city AS city ON pay.tb_city_id_city = city.id_city
        RIGHT JOIN
    tb_state AS st ON city.tb_state_id_state = st.id_state
WHERE pay.int_month = :monthSelected
GROUP BY st.id_state
order by st.str_uf";
$statement = $pdo->prepare($query);
$statement->bindValue(":monthSelected", $monthSelected);
$statement->execute();
$rs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($rs as $value) {
    $resultado[] = $value;
}

$states = array();
$data = array();

$acre = array('AC');
$alagoas = array('AL');
$amazonas = array('AM');
$amapa = array('AP');
$bahia = array('BA');
$ceara = array('CE');
$distrito = array('DF');
$esanto = array('ES');
$goias = array('GO');
$maranhao = array('MA');
$minas = array('MG');
$mgrossosul = array('MS');
$mgrosso = array('MT');
$para = array('PA');
$paraiba = array('PB');
$pernambuco = array('PE');
$piaui = array('PI');
$parana = array('PR');
$rio = array('RJ');
$rgnorte = array('RN');
$rondonia = array('RO');
$roraima = array('RR');
$rgsul = array('RS');
$scantarina = array('SC');
$sergipe = array('SE');
$spaulo = array('SP');
$tocantins = array('TO');


if(isset($resultado)) {

    foreach ($resultado as $r){
            switch ($r['str_uf']) {
                case "AC":
                    array_push($acre, $r['payments_total']);
                    break;
                case "AL":
                    array_push($alagoas, $r['payments_total']);
                    break;
                case "AM":
                    array_push($amazonas, $r['payments_total']);
                    break;
                case "AP":
                    array_push($amapa, $r['payments_total']);
                    break;
                case "BA":
                    array_push($bahia, $r['payments_total']);
                    break;
                case "CE":
                    array_push($ceara, $r['payments_total']);
                    break;
                case "DF":
                    array_push($distrito, $r['payments_total']);
                    break;
                case "ES":
                    array_push($esanto, $r['payments_total']);
                    break;
                case "GO":
                    array_push($goias, $r['payments_total']);
                    break;
                case "MA":
                    array_push($maranhao, $r['payments_total']);
                    break;
                case "MG":
                    array_push($minas, $r['payments_total']);
                    break;
                case "MS":
                    array_push($mgrossosul, $r['payments_total']);
                    break;
                case "MT":
                    array_push($mgrosso, $r['payments_total']);
                    break;
                case "PA":
                    array_push($para, $r['payments_total']);
                    break;
                case "PB":
                    array_push($paraiba, $r['payments_total']);
                    break;
                case "PE":
                    array_push($pernambuco, $r['payments_total']);
                    break;
                case "PI":
                    array_push($piaui, $r['payments_total']);
                    break;
                case "PR":
                    array_push($parana, $r['payments_total']);
                    break;
                case "RJ":
                    array_push($rio, $r['payments_total']);
                    break;
                case "RN":
                    array_push($rgnorte, $r['payments_total']);
                    break;
                case "RO":
                    array_push($rondonia, $r['payments_total']);
                    break;
                case "RR":
                    array_push($roraima, $r['payments_total']);
                    break;
                case "RS":
                    array_push($rgsul, $r['payments_total']);
                    break;
                case "SC":
                    array_push($scantarina, $r['payments_total']);
                    break;
                case "SE":
                    array_push($sergipe, $r['payments_total']);
                    break;
                case "SP":
                    array_push($spaulo, $r['payments_total']);
                    break;
                case "TO":
                    array_push($tocantins, $r['payments_total']);
                    break;
                default:
                    break;
            }
    }

    $states = array($acre, $alagoas, $amazonas, $amapa, $bahia,
        $ceara, $distrito, $esanto, $goias, $maranhao, $minas,
        $mgrossosul, $mgrosso, $para, $paraiba, $pernambuco, $piaui,
        $parana, $rio, $rgnorte, $rondonia, $roraima, $rgsul,
        $scantarina, $sergipe, $spaulo, $tocantins);

    foreach ($states as $st){
        if (isset($st[1])){
            array_push($data, $st);
        }
    }

}

$plot = new PHPlot(900,500);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('pie');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);

# Set enough different colors;
$plot->SetDataColors(array('red', 'green', 'blue', 'yellow', 'cyan',
    'magenta', 'brown', 'lavender', 'pink',
    'gray', 'orange', 'black', 'gold'));

//# Main plot title:
//$plot->SetTitle("World Gold Production, 1990\n(1000s of Troy Ounces)");

# Build a legend from our data array.
# Each call to SetLegend makes one line as "label: value".
foreach ($data as $row)
    $plot->SetLegend(implode(': ', $row));
# Place the legend in the upper left corner:
$plot->SetLegendPixels(5, 5);
$plot->SetLegendPosition(0.5, 0, 'title', 0.5, 1);

if (isset($_GET["pdf"]) && $_GET["pdf"] == 1) {
    $plot->SetPrintImage(false);
}

$plot->DrawGraph();

$pdf = new PDF_MemImage();
$pdf->AddPage();
$pdf->GDImage($plot->img,30,20,140);
$pdf->Output('generate.pdf','I');
