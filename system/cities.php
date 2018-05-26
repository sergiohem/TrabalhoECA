<?php
/**
 * Created by PhpStorm.
 * User: action
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/cityDAO.php";
require_once "classes/city.php";

$template = new Template();
$object = new cityDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $codSiafi = (isset($_POST["codSiafi"]) && $_POST["codSiafi"] != null) ? $_POST["codSiafi"] : "";
    $cityState = (isset($_POST["cityState"]) && $_POST["cityState"] != null) ? $_POST["cityState"] : "";
    $name = (isset($_POST["name"]) && $_POST["name"] != null) ? $_POST["name"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $codSiafi = NULL;
    $cityState = NULL;
    $name = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $city = new city($id, '', '','');

    $resultado = $object->atualizar($city);
    $codSiafi = $resultado->getCodSiafiCity();
    $cityState = $resultado->getCityState();
    $name = $resultado->getNameCity();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $codSiafi != "" && $cityState != "" && $name != "") {
    $city = new city($id, $name, $codSiafi, $cityState);
    $msg = $object->salvar($city);
    $id = null;
    $codSiafi = null;
    $cityState = null;
    $name = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $city = new city($id, '', '', '');
    $msg = $object->remover($city);
    $id = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>City</h4>
                        <p class='category'>Cities list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Code Siafi:
                            <input type="text" size="4" name="codSiafi" value="<?php
                            // Preenche o code no campo code com um valor "value"
                            echo (isset($codSiafi) && ($codSiafi != null || $codSiafi != "")) ? $codSiafi : '';
                            ?>"/>
                            State:
                            <input type="text" size="11" name="cityState" value="<?php
                            // Preenche o cityState no campo cityState com um valor "value"
                            echo (isset($cityState) && ($cityState != null || $cityState != "")) ? $cityState : '';
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
