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
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $code = (isset($_POST["code"]) && $_POST["code"] != null) ? $_POST["code"] : "";
    $name = (isset($_POST["name"]) && $_POST["name"] != null) ? $_POST["name"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $code = NULL;
    $name = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $action = new action($id, '', '');

    $resultado = $object->atualizar($action);
    $code = $resultado->getCode();
    $name = $resultado->getName();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $code != "" && $name != "") {
    $action = new action($id, $code, $name);
    $msg = $object->salvar($action);
    $id = null;
    $code = null;
    $name = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $action = new action($id, '', '');
    $msg = $object->remover($action);
    $id = null;
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

                        <form action="?act=save&id=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Code:
                            <input type="text" size="15" name="code" value="<?php
                            // Preenche o code no campo code com um valor "value"
                            echo (isset($code) && ($code != null || $code != "")) ? $code : '';

                            ?>"/>
                            Name:
                            <input type="text" size="40" name="name" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($name) && ($name != null || $name != "")) ? $name : '';
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
