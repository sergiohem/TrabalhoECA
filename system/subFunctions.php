<?php
/**
 * Created by PhpStorm.
 * User: action
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/subFunctionDAO.php";
require_once "classes/subFunction.php";

$template = new Template();
$object = new subFunctionDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idSubFunction = (isset($_POST["idSubFunction"]) && $_POST["idSubFunction"] != null) ? $_POST["idSubFunction"] : "";
    $codeSubFunction = (isset($_POST["codeSubFunction"]) && $_POST["codeSubFunction"] != null) ? $_POST["codeSubFunction"] : "";
    $nameSubFunction = (isset($_POST["nameSubFunction"]) && $_POST["nameSubFunction"] != null) ? $_POST["nameSubFunction"] : "";
} else if (!isset($idSubFunction)) {
    // Se não se não foi setado nenhum valor para variável $id
    $idSubFunction = (isset($_GET["idSubFunction"]) && $_GET["idSubFunction"] != null) ? $_GET["idSubFunction"] : "";
    $codeSubFunction = NULL;
    $nameSubFunction = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idSubFunction != "") {

    $subFunction = new subFunction($idSubFunction, '', '');

    $resultado = $object->atualizar($subFunction);
    $codeSubFunction = $resultado->getCodeSubFunction();
    $nameSubFunction = $resultado->getNameSubFunction();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $codeSubFunction != "" && $nameSubFunction != "") {
    $subFunction = new subFunction($idSubFunction, $codeSubFunction, $nameSubFunction);
    $msg = $object->salvar($subFunction);
    $idSubFunction = null;
    $codeSubFunction = null;
    $nameSubFunction = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idSubFunction != "") {
    $subFunction = new subFunction($idSubFunction, '', '');
    $msg = $object->remover($subFunction);
    $idSubFunction = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Subfunction</h4>
                        <p class='category'>Subfunctions list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&idSubFunction=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="idSubFunction" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($idSubFunction) && ($idSubFunction != null || $idSubFunction != "")) ? $idSubFunction : '';
                            ?>"/>
                            Code:
                            <input type="text" size="15" name="codeSubFunction" value="<?php
                            // Preenche o code no campo code com um valor "value"
                            echo (isset($codeSubFunction) && ($codeSubFunction != null || $codeSubFunction != "")) ? $codeSubFunction : '';

                            ?>"/>
                            Name:
                            <input type="text" size="40" name="nameSubFunction" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($nameSubFunction) && ($nameSubFunction != null || $nameSubFunction != "")) ? $nameSubFunction : '';
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
