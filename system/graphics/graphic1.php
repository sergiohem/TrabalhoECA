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
$grafico = new PHPlot(500,300);

#Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
//$grafico->SetTitle("Total of Beneficiaries");
$grafico->SetXTitle("Month/Year");
$grafico->SetYTitle("Beneficiaries");

//$id = $_GET['id'];

$query = "SELECT 
    pay.int_month, pay.int_year, count(ben.id_beneficiaries) AS beneficiaries_number
FROM
    db_eca.tb_beneficiaries AS ben
        JOIN
    db_eca.tb_payments AS pay ON ben.id_beneficiaries = pay.tb_beneficiaries_id_beneficiaries
GROUP BY pay.int_month, pay.int_year
ORDER BY pay.int_year, pay.int_month";
$statement = $pdo->prepare($query);
$statement->execute();
$rs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($rs as $value) {
    $resultado[] = $value;
}

$data = array();

if(isset($resultado)) {
    foreach ($resultado as $r){
        $data[] = [$r['int_month'], $r['beneficiaries_number']];
    }
} else {
    $data[]=[null,null];
}

//$grafico->SetDefaultTTFont('../assets/fonts/themify.ttf');

$grafico->SetDataValues($data);

#Neste caso, usariamos o gráfico em barras
$grafico->SetPlotType("lines");

#Exibimos o gráfico
$grafico->DrawGraph();