<?php
/**
 * Created by PhpStorm.
 * User: action
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";

$template = new Template();

$template->header();

$template->sidebar();

$template->mainpanel();

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Report</h4>
                        <p class='category'>Reports list</p>
                    </div>
                    <div class='content'>
                        <ul>
                            <li>PDF report with list of all beneficiaries and their respective data in alphabetical order - <i class="ti-export"></i><a href="reportPDF/genericReportPDF.php?report=1" target="_blank"> Export PDF</a></li>
                            <li>PDF report with a list of all types and a city, with all the data of the beneficiary and the city, sorted by the city and affluent by the name of the beneficiary - <i class="ti-export"></i><a href="reportPDF/genericReportPDF.php?report=2" target="_blank"> Export PDF</a></li>
                            <li>PDF report with list of payments including their respective data - <i class="ti-export"></i><a href="reportPDF/genericReportPDF.php?report=3" target="_blank"> Export PDF</a></li>
                            <li>PDF report with number of beneficiaries per city and total amount paid per city, per month, sorted by total decreasing value - <i class="ti-export"></i><a href="reportPDF/genericReportPDF.php?report=4" target="_blank"> Export PDF</a></li>
                            <li>PDF report with the sum of times the beneficiary has received aid - <i class="ti-export"></i><a href="reportPDF/genericReportPDF.php?report=5" target="_blank"> Export PDF</a></li>
                            <li>PDF report with the total amount of payments per region in alphabetical order - <i class="ti-export"></i><a href="reportPDF/genericReportPDF.php?report=6" target="_blank"> Export PDF</a></li>
                            <li>PDF report with the total amount of payments per state in alphabetical order - <i class="ti-export"></i><a href="reportPDF/genericReportPDF.php?report=7" target="_blank"> Export PDF</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$template->footer();
?>
