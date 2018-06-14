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

#Instancia o objeto e setando o tamanho do grafico na tela
$plot = new PHPlot(900,400);

#Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
//$plot->SetTitle("Total of Beneficiaries");
$plot->SetXTitle("Month/Year");
$plot->SetYTitle("Beneficiaries");

//$id = $_GET['id'];

$query = "SELECT 
    concat(pay.int_month, \"/\", pay.int_year) AS month_year, count(ben.id_beneficiaries) AS beneficiaries_number
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
        $data[] = [$r['month_year'], $r['beneficiaries_number']];
    }
} else {
    $data[]=[null,null];
}

//$plot->SetDefaultTTFont('../assets/fonts/themify.ttf');
$plot->SetDataValues($data);

#Neste caso, usariamos o gráfico em barras
$plot->SetPlotType("lines");

#Exibimos o gráfico
if (isset($_GET["pdf"]) && $_GET["pdf"] == 1) {
    $plot->SetPrintImage(false);
}
$plot->DrawGraph();

$pdf = new PDF_MemImage();
$pdf->AddPage();
$pdf->GDImage($plot->img,30,20,140);
$pdf->Output('generate.pdf','I');