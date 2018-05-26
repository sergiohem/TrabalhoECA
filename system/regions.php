<?php
/**
 * Created by PhpStorm.
 * User: region
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/regionDAO.php";
require_once "classes/region.php";

$template = new Template();
$object = new regionDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idRegion = (isset($_POST["idRegion"]) && $_POST["idRegion"] != null) ? $_POST["idRegion"] : "";
    $nameRegion = (isset($_POST["nameRegion"]) && $_POST["nameRegion"] != null) ? $_POST["nameRegion"] : "";
} else if (!isset($idRegion)) {
    // Se não se não foi setado nenhum valor para variável $idRegion
    $idRegion = (isset($_GET["idRegion"]) && $_GET["idRegion"] != null) ? $_GET["idRegion"] : "";
    $nameRegion = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idRegion != "") {

    $region = new region($idRegion, '');

    $resultado = $object->atualizar($region);
    $nameRegion = $resultado->getNameRegion();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nameRegion != "") {
    $region = new region($idRegion, $nameRegion);
    $msg = $object->salvar($region);
    $idRegion = null;
    $nameRegion = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idRegion != "") {
    $region = new region($idRegion, '');
    $msg = $object->remover($region);
    $idRegion = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Region</h4>
                        <p class='category'>Regions list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&idRegion=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="idRegion" value="<?php
                            // Preenche o idRegion no campo idRegion com um valor "value"
                            echo (isset($idRegion) && ($idRegion != null || $idRegion != "")) ? $idRegion : '';
                            ?>"/>
                            Name:
                            <input type="text" size="40" name="nameRegion" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($nameRegion) && ($nameRegion != null || $nameRegion != "")) ? $nameRegion : '';
                            ?>"/>
                            <input type="submit" VALUE="Register"/>
                            <hr>
                        </form>


                        <?php

                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';

                        //chamada a paginação
                        $object->tabelaPaginada();

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$template->footer();
?>
