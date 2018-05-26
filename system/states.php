<?php
/**
 * Created by PhpStorm.
 * User: state
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/stateDAO.php";
require_once "classes/state.php";

$template = new Template();
$object = new stateDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idState = (isset($_POST["idState"]) && $_POST["idState"] != null) ? $_POST["idState"] : "";
    $uf = (isset($_POST["uf"]) && $_POST["uf"] != null) ? $_POST["uf"] : "";
    $nameState = (isset($_POST["nameState"]) && $_POST["nameState"] != null) ? $_POST["nameState"] : "";
    $regionState = (isset($_POST["regionState"]) && $_POST["regionState"] != null) ? $_POST["regionState"] : "";
} else if (!isset($idState)) {
    // Se não se não foi setado nenhum valor para variável $idState
    $idState = (isset($_GET["idState"]) && $_GET["idState"] != null) ? $_GET["idState"] : "";
    $uf = NULL;
    $nameState = NULL;
    $regionState = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idState != "") {

    $state = new state($idState, '', '', '');

    $resultado = $object->atualizar($state);
    $uf = $resultado->getUf();
    $nameState = $resultado->getNameState();
    $regionState = $resultado->getPeriodicity();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $uf != "" && $nameState != "" && $regionState != "") {
    $state = new state($idState, $uf, $nameState, $regionState);
    $msg = $object->salvar($state);
    $idState = null;
    $uf = null;
    $nameState = null;
    $regionState = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idState != "") {
    $state = new state($idState, '', '', '');
    $msg = $object->remover($state);
    $idState = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>State</h4>
                        <p class='category'>States list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&idState=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="idState" value="<?php
                            // Preenche o idState no campo idState com um valor "value"
                            echo (isset($idState) && ($idState != null || $idState != "")) ? $idState : '';
                            ?>"/>
                            UF:
                            <input type="text" size="15" name="uf" value="<?php
                            echo (isset($uf) && ($uf != null || $uf != "")) ? $uf : '';
                            ?>"/>
                            Name:
                            <input type="text" size="15" name="nameState" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($nameState) && ($nameState != null || $nameState != "")) ? $nameState : '';
                            ?>"/>
                            Region:
                            <select name="regionState">
                                <?php
                                $query = "SELECT * FROM tb_region order by str_name_region;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_region == $regionState) {
                                            echo "<option value='$rs->id_region' selected>$rs->str_name_region</option>";
                                        } else {
                                            echo "<option value='$rs->id_region'>$rs->str_name_region</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
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
