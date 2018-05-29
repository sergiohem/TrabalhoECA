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
$grafico = new PHPlot(600,400);

#Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
$grafico->SetTitle("Test");
$grafico->SetXTitle("Regions");
$grafico->SetYTitle("Payments");

//$id = $_GET['id'];

$query = "SELECT 
    reg.str_name_region, count(pay.id_payment) AS payments_number
FROM
    tb_payments AS pay
        JOIN
    tb_city AS city ON pay.tb_city_id_city = city.id_city
        JOIN
    tb_state AS st ON city.tb_state_id_state = st.id_state
        JOIN
    tb_region AS reg ON st.tb_region_id_region = reg.id_region
GROUP BY reg.id_region
ORDER BY reg.str_name_region;";
$statement = $pdo->prepare($query);
$statement->execute();
$rs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($rs as $value) {
    $resultado[] = $value;
}

$data = array();

if(isset($resultado)) {
    foreach ($resultado as $r){
        $data[] = [$r['str_name_region'], $r['payments_number']];
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