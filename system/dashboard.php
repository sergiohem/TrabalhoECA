<?php

require_once "classes/template.php";
require_once "db/beneficiaryDAO.php";
require_once "db/paymentDAO.php";


$object = new beneficiaryDAO();
$totalBeneficiarios = $object->totalBeneficiarios();

$object = new paymentDAO();
$totalPagamentos = $object->totalPagamentos();
$totalPagamentosUltimoMes = $object->totalPagamentosUltimoMes();
$mediaPagamentosUltimoMes = $object->mediaPagamentosUltimoMes();

$template = new template();

$template->header();

$template->sidebar();

$template->mainpanel();

date_default_timezone_set('America/Sao_Paulo');
$monthSelected = date('n');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $monthSelected = (isset($_GET["selectMonth"]) && $_GET["selectMonth"] != null) ? $_GET["selectMonth"] : "";
}



?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-warning text-center">
                                    <i class="ti-server"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Payments</p>
                                    <?= $totalPagamentos ?>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-info"></i> Total sum
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-success text-center">
                                    <i class="ti-wallet"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Payments</p>
                                    R$<?= number_format($totalPagamentosUltimoMes, 2, ',', ''); ?>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-calendar"></i> Last Month
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-danger text-center">
                                    <i class="ti-pulse"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Average</p>
                                    R$<?= number_format($mediaPagamentosUltimoMes, 2, ',', ''); ?>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-timer"></i> In the last month
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-info text-center">
                                    <i class="ti-user"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Beneficiaries</p>
                                    <?= $totalBeneficiarios ?>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="stats">
                                <i class="ti-info"></i> Total
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Monthly beneficiaries</h4>
                        <p class="category">Every year</p>
                    </div>
                    <div class="content">
                        <div id="chartHours" class="ct-chart" style="height: 400px;">
                            <img src="graphics/graphic1.php" />
                        </div>
                        <div class="footer">
                            <div class="stats">
                                <i class="ti-info-alt"></i> Historic Serie | <i class="ti-export"></i><a href="graphics/graphic1.php?pdf=1" target="_blank">Export PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Beneficiaries by state</h4>
                        <p class="category">Monthly update</p>
                    </div>
                    <div class="content">
                        <div id="chartPreferences" class="ct-chart ct-perfect-fourth" style="height: 400px;">
                            <img src="graphics/graphic2.php" />
                        </div>

                        <div class="footer">
                            <div class="stats">
                                <i class="ti-timer"></i> Total | <i class="ti-export"></i><a href="graphics/graphic2.php?pdf=1" target="_blank">Export PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card ">
                    <div class="header">
                        <h4 class="title">Values per state</h4>
                        <p class="category">Monthly update</p>
                    </div>
                    <div class="content">
                        <form method="get" action="?selectMonth=">
                            <label>Select the month: </label>
                            <select name="selectMonth">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">Octuber</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select><br/>
                            <button type="submit">Generate graphic</button>


                            <div id="chartActivity" class="ct-chart" style="height: 550px;">
                                <img Ssrc="graphics/graphic3.php?selectMonth=<?=$monthSelected?>" />
                            </div>
                        </form>

                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <i class="ti-check"></i> Last Month | <i class="ti-export"></i><a href="graphics/graphic3.php?pdf=1&selectMonth=<?=$monthSelected?>" target="_blank">Export PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$template->footer();

?>

<!--<script type="text/javascript">-->
<!--    $(document).ready(function () {-->
<!--        $("#generateGraphic3").on("submit", function () {-->
<!--            alert();-->
<!--        })-->
<!--    })-->
<!--</script>-->
