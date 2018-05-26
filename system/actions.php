<?php
/**
 * Created by PhpStorm.
 * User: action
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/actionDAO.php";
require_once "classes/action.php";

$template = new Template();
$object = new actionDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idAction = (isset($_POST["idAction"]) && $_POST["idAction"] != null) ? $_POST["idAction"] : "";
    $codeAction = (isset($_POST["codeAction"]) && $_POST["codeAction"] != null) ? $_POST["codeAction"] : "";
    $nameAction = (isset($_POST["nameAction"]) && $_POST["nameAction"] != null) ? $_POST["nameAction"] : "";
} else if (!isset($idAction)) {
    // Se não se não foi setado nenhum valor para variável $idAction
    $idAction = (isset($_GET["idAction"]) && $_GET["idAction"] != null) ? $_GET["idAction"] : "";
    $codeAction = NULL;
    $nameAction = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idAction != "") {

    $action = new action($idAction, '', '');

    $resultado = $object->atualizar($action);
    $codeAction = $resultado->getCodeAction();
    $nameAction = $resultado->getNameAction();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $codeAction != "" && $nameAction != "") {
    $action = new action($idAction, $codeAction, $nameAction);
    $msg = $object->salvar($action);
    $idAction = null;
    $codeAction = null;
    $nameAction = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idAction != "") {
    $action = new action($idAction, '', '');
    $msg = $object->remover($action);
    $idAction = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Action</h4>
                        <p class='category'>Actions list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&idAction=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="idAction" value="<?php
                            // Preenche o idAction no campo idAction com um valor "value"
                            echo (isset($idAction) && ($idAction != null || $idAction != "")) ? $idAction : '';
                            ?>"/>
                            Code:
                            <input type="text" size="15" name="codeAction" value="<?php
                            // Preenche o codeAction no campo codeAction com um valor "value"
                            echo (isset($codeAction) && ($codeAction != null || $codeAction != "")) ? $codeAction : '';

                            ?>"/>
                            Name:
                            <input type="text" size="40" name="nameAction" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($nameAction) && ($nameAction != null || $nameAction != "")) ? $nameAction : '';
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
