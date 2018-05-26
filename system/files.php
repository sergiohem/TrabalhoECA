<?php
/**
 * Created by PhpStorm.
 * User: action
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/fileDAO.php";
require_once "classes/file.php";

$template = new Template();
$object = new fileDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $month = (isset($_POST["month"]) && $_POST["month"] != null) ? $_POST["month"] : "";
    $year = (isset($_POST["year"]) && $_POST["year"] != null) ? $_POST["year"] : "";
    $name = (isset($_POST["name"]) && $_POST["name"] != null) ? $_POST["name"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $month = NULL;
    $year = NULL;
    $name = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $file = new file($id, '', '','');

    $resultado = $object->atualizar($file);
    $month = $resultado->getMonth();
    $year = $resultado->getYear();
    $name = $resultado->getNameFile();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $month != "" && $year != "" && $name != "") {
    $file = new file($id, $name, $month, $year);
    $msg = $object->salvar($file);
    $id = null;
    $month = null;
    $year = null;
    $name = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $file = new file($id, '', '', '');
    $msg = $object->remover($file);
    $id = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>File</h4>
                        <p class='category'>Files list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Month:
                            <input type="text" size="2" name="month" value="<?php
                            // Preenche o code no campo code com um valor "value"
                            echo (isset($month) && ($month != null || $month != "")) ? $month : '';
                            ?>"/>
                            Year:
                            <input type="text" size="4" name="year" value="<?php
                            // Preenche o year no campo year com um valor "value"
                            echo (isset($year) && ($year != null || $year != "")) ? $year : '';
                            ?>"/>
                            Name:
                            <input type="text" size="45" name="name" value="<?php
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
