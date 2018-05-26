<?php
/**
 * Created by PhpStorm.
 * User: source
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/sourceDAO.php";
require_once "classes/source.php";

$template = new Template();
$object = new sourceDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idSource = (isset($_POST["idSource"]) && $_POST["idSource"] != null) ? $_POST["idSource"] : "";
    $goal = (isset($_POST["goal"]) && $_POST["goal"] != null) ? $_POST["goal"] : "";
    $origin = (isset($_POST["origin"]) && $_POST["origin"] != null) ? $_POST["origin"] : "";
    $periodicity = (isset($_POST["periodicity"]) && $_POST["periodicity"] != null) ? $_POST["periodicity"] : "";
} else if (!isset($idSource)) {
    // Se não se não foi setado nenhum valor para variável $idSource
    $idSource = (isset($_GET["idSource"]) && $_GET["idSource"] != null) ? $_GET["idSource"] : "";
    $goal = NULL;
    $origin = NULL;
    $periodicity = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idSource != "") {

    $source = new source($idSource, '', '', '');

    $resultado = $object->atualizar($source);
    $goal = $resultado->getGoal();
    $origin = $resultado->getOrigin();
    $periodicity = $resultado->getPeriodicity();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $goal != "" && $origin != "" && $periodicity != "") {
    $source = new source($idSource, $goal, $origin, $periodicity);
    $msg = $object->salvar($source);
    $idSource = null;
    $goal = null;
    $origin = null;
    $periodicity = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idSource != "") {
    $source = new source($idSource, '', '', '');
    $msg = $object->remover($source);
    $idSource = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Source</h4>
                        <p class='category'>Sources list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&idSource=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="idSource" value="<?php
                            // Preenche o idSource no campo idSource com um valor "value"
                            echo (isset($idSource) && ($idSource != null || $idSource != "")) ? $idSource : '';
                            ?>"/>
                            Goal:
                            <input type="text" size="15" name="goal" value="<?php
                            echo (isset($goal) && ($goal != null || $goal != "")) ? $goal : '';
                            ?>"/>
                            Origin:
                            <input type="text" size="15" name="origin" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($origin) && ($origin != null || $origin != "")) ? $origin : '';
                            ?>"/>
                            Periodicity:
                            <input type="text" size="15" name="periodicity" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($periodicity) && ($periodicity != null || $periodicity != "")) ? $periodicity : '';
                            ?>"/>
                            <input type="submit" VALUE="Register"/>
                            <hr>
                        </form>


                        <?php

                        //chamada a paginação
                        $object->tabelaPaginada();

                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';

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
