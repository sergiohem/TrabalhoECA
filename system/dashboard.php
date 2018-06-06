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

$template = new Template();

$template->header();

$template->sidebar();

$template->mainpanel();



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
                                    R$<?= $totalPagamentosUltimoMes ?>
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
                                    R$<?= $mediaPagamentosUltimoMes ?>
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
                            <div class="chart-legend">
                                <i class="fa fa-circle text-info"></i> Value
                                <i class="fa fa-circle text-danger"></i> Value
                                <i class="fa fa-circle text-warning"></i> Value
                            </div>
                            <hr>
                            <div class="stats">
                                <i class="ti-info-alt"></i> Historic Serie | <i class="ti-export"></i><a href="reportPDF/genericReportPDF.php?report=graphic1"> Export PDF</a>
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
                                <i class="ti-timer"></i> Total | <i class="ti-export"></i><a> Export PDF</a>
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
                        <div id="chartActivity" class="ct-chart" style="height: 400px;"></div>

                        <div class="footer">
                            <div class="chart-legend">
                                <i class="fa fa-circle text-info"></i> Value
                                <i class="fa fa-circle text-warning"></i> Value
                            </div>
                            <hr>
                            <div class="stats">
                                <i class="ti-check"></i> Last Month | <i class="ti-export"></i><a> Export PDF</a>
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
