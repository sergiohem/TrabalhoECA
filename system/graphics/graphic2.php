<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 09/01/2018
 * Time: 09:49
 */

require_once("PHPlot/phplot/phplot.php");

require_once("../db/conexao.php");

#Instancia o objeto e setando o tamanho do grafico na tela
//$grafico = new PHPlot(500,300);

#Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
//$grafico->SetTitle("Total of Beneficiaries");
//$grafico->SetXTitle("State");
//$grafico->SetYTitle("Month/Year");

//$id = $_GET['id'];

$query = "SELECT 
    count(ben.id_beneficiaries) AS beneficiaries_number, concat(pay.int_month, \"/\", pay.int_year) AS month_year, st.str_uf
FROM
    tb_beneficiaries AS ben
        JOIN
    tb_payments AS pay ON ben.id_beneficiaries = pay.tb_beneficiaries_id_beneficiaries
        JOIN
    tb_city AS city ON pay.tb_city_id_city = city.id_city
        RIGHT JOIN
    tb_state AS st ON city.tb_state_id_state = st.id_state
GROUP BY pay.int_month, st.id_state
order by pay.int_year, pay.int_month";
$statement = $pdo->prepare($query);
$statement->execute();
$rs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($rs as $value) {
    $resultado[] = $value;
}

$months = array();
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
        if (!in_array($r['month_year'], $months) && $r['month_year'] != null && $r['month_year'] != ''){
            array_push($months, $r['month_year']);
        }
    }

    foreach ($resultado as $r){
        if ($r['month_year'] != null && $r['month_year'] != ''){
            switch ($r['str_uf']) {
                case "AC":
                    array_push($acre, $r['beneficiaries_number']);
                    break;
                case "AL":
                    array_push($alagoas, $r['beneficiaries_number']);
                    break;
                case "AM":
                    array_push($amazonas, $r['beneficiaries_number']);
                    break;
                case "AP":
                    array_push($amapa, $r['beneficiaries_number']);
                    break;
                case "BA":
                    array_push($bahia, $r['beneficiaries_number']);
                    break;
                case "CE":
                    array_push($ceara, $r['beneficiaries_number']);
                    break;
                case "DF":
                    array_push($distrito, $r['beneficiaries_number']);
                    break;
                case "ES":
                    array_push($esanto, $r['beneficiaries_number']);
                    break;
                case "GO":
                    array_push($goias, $r['beneficiaries_number']);
                    break;
                case "MA":
                    array_push($maranhao, $r['beneficiaries_number']);
                    break;
                case "MG":
                    array_push($minas, $r['beneficiaries_number']);
                    break;
                case "MS":
                    array_push($mgrossosul, $r['beneficiaries_number']);
                    break;
                case "MT":
                    array_push($mgrosso, $r['beneficiaries_number']);
                    break;
                case "PA":
                    array_push($para, $r['beneficiaries_number']);
                    break;
                case "PB":
                    array_push($paraiba, $r['beneficiaries_number']);
                    break;
                case "PE":
                    array_push($pernambuco, $r['beneficiaries_number']);
                    break;
                case "PI":
                    array_push($piaui, $r['beneficiaries_number']);
                    break;
                case "PR":
                    array_push($parana, $r['beneficiaries_number']);
                    break;
                case "RJ":
                    array_push($rio, $r['beneficiaries_number']);
                    break;
                case "RN":
                    array_push($rgnorte, $r['beneficiaries_number']);
                    break;
                case "RO":
                    array_push($rondonia, $r['beneficiaries_number']);
                    break;
                case "RR":
                    array_push($roraima, $r['beneficiaries_number']);
                    break;
                case "RS":
                    array_push($rgsul, $r['beneficiaries_number']);
                    break;
                case "SC":
                    array_push($scantarina, $r['beneficiaries_number']);
                    break;
                case "SE":
                    array_push($sergipe, $r['beneficiaries_number']);
                    break;
                case "SP":
                    array_push($spaulo, $r['beneficiaries_number']);
                    break;
                case "TO":
                    array_push($tocantins, $r['beneficiaries_number']);
                    break;
                default:
                    break;
            }
        }
    }

    $data = array($acre, $alagoas, $amazonas, $amapa, $bahia,
        $ceara, $distrito, $esanto, $goias, $maranhao, $minas,
        $mgrossosul, $mgrosso, $para, $paraiba, $pernambuco, $piaui,
        $parana, $rio, $rgnorte, $rondonia, $roraima, $rgsul,
        $scantarina, $sergipe, $spaulo, $tocantins);

}

//echo "<pre>";
//print_r($months);
//echo "/<pre>";

$plot = new PHPlot(600, 400);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('stackedbars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

//$plot->SetTitle('Candy Sales by Month and Product');
$plot->SetYTitle('Number of beneficiaries');

# No shading:
$plot->SetShading(0);

$plot->SetLegend($months);
# Make legend lines go bottom to top, like the bar segments (PHPlot > 5.4.0)
$plot->SetLegendReverse(True);

$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

# Turn on Y Data Labels: Both total and segment labels:
$plot->SetYDataLabelPos('plotstack');

$plot->SetOutputFile('graphic2.jpg');

$plot->DrawGraph();
