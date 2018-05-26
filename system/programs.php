<?php
/**
 * Created by PhpStorm.
 * User: action
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/programDAO.php";
require_once "classes/program.php";

$template = new Template();
$object = new programDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idProgram = (isset($_POST["idProgram"]) && $_POST["idProgram"] != null) ? $_POST["idProgram"] : "";
    $codeProgram = (isset($_POST["codeProgram"]) && $_POST["codeProgram"] != null) ? $_POST["codeProgram"] : "";
    $nameProgram = (isset($_POST["nameProgram"]) && $_POST["nameProgram"] != null) ? $_POST["nameProgram"] : "";
} else if (!isset($idProgram)) {
    // Se não se não foi setado nenhum valor para variável $id
    $idProgram = (isset($_GET["idProgram"]) && $_GET["idProgram"] != null) ? $_GET["idProgram"] : "";
    $codeProgram = NULL;
    $nameProgram = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idProgram != "") {

    $program = new program($idProgram, '', '');

    $resultado = $object->atualizar($program);
    $codeProgram = $resultado->getCodeProgram();
    $nameProgram = $resultado->getNameProgram();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $codeProgram != "" && $nameProgram != "") {
    $program = new program($idProgram, $codeProgram, $nameProgram);
    $msg = $object->salvar($program);
    $idProgram = null;
    $codeProgram = null;
    $nameProgram = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idProgram != "") {
    $program = new program($idProgram, '', '');
    $msg = $object->remover($program);
    $idProgram = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Program</h4>
                        <p class='category'>Programs list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&idProgram=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="idProgram" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($idProgram) && ($idProgram != null || $idProgram != "")) ? $idProgram : '';
                            ?>"/>
                            Code:
                            <input type="text" size="15" name="codeProgram" value="<?php
                            // Preenche o code no campo code com um valor "value"
                            echo (isset($codeProgram) && ($codeProgram != null || $codeProgram != "")) ? $codeProgram : '';

                            ?>"/>
                            Name:
                            <input type="text" size="40" name="nameProgram" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($nameProgram) && ($nameProgram != null || $nameProgram != "")) ? $nameProgram : '';
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
