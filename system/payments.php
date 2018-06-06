<?php
/**
 * Created by PhpStorm.
 * User: action
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/paymentDAO.php";
require_once "classes/payment.php";

$template = new Template();
$object = new paymentDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPayment = (isset($_POST["idPayment"]) && $_POST["idPayment"] != null) ? $_POST["idPayment"] : "";
    $city = (isset($_POST["city"]) && $_POST["city"] != null) ? $_POST["city"] : "";
    $function = (isset($_POST["function"]) && $_POST["function"] != null) ? $_POST["function"] : "";
    $subfunction = (isset($_POST["subfunction"]) && $_POST["subfunction"] != null) ? $_POST["subfunction"] : "";
    $program = (isset($_POST["program"]) && $_POST["program"] != null) ? $_POST["program"] : "";
    $action = (isset($_POST["action"]) && $_POST["action"] != null) ? $_POST["action"] : "";
    $beneficiary = (isset($_POST["beneficiary"]) && $_POST["beneficiary"] != null) ? $_POST["beneficiary"] : "";
    $source = (isset($_POST["source"]) && $_POST["source"] != null) ? $_POST["source"] : "";
    $file = (isset($_POST["file"]) && $_POST["file"] != null) ? $_POST["file"] : "";
    $dbValue = (isset($_POST["dbValue"]) && $_POST["dbValue"] != null) ? $_POST["dbValue"] : "";
    $month = (isset($_POST["month"]) && $_POST["month"] != null) ? $_POST["month"] : "";
    $year = (isset($_POST["year"]) && $_POST["year"] != null) ? $_POST["year"] : "";
} else if (!isset($idPayment)) {
    // Se não se não foi setado nenhum valor para variável $idPayment
    $idPayment = (isset($_GET["idPayment"]) && $_GET["idPayment"] != null) ? $_GET["idPayment"] : "";
    $city = null;
    $function = null;
    $subfunction = null;
    $program = null;
    $action = null;
    $beneficiary = null;
    $source = null;
    $file = null;
    $dbValue = null;
    $month = null;
    $year = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idPayment != "") {

    $payment = new payment($idPayment, '', '', '', '', '', '', '', '', '','','');

    $resultado = $object->atualizar($action);
    $city = $resultado->getCity();
    $function = $resultado->getFunction();
    $subfunction = $resultado->getSubfunction();
    $program = $resultado->getProgram();
    $action = $resultado->getAction();
    $beneficiary = $resultado->getBeneficiary();
    $source = $resultado->getSource();
    $file = $resultado->getFile();
    $dbValue = $resultado->getValue();
    $month = $resultado->getMonth();
    $year = $resultado->getYear();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $city != "" && $function != "" && $subfunction != "" && $program != "" && $action != ""
    && $beneficiary != "" && $source != "" && $file != "" && $dbValue != "" && $month != null && $year != null) {

    $dbValue = doubleval($dbValue);

    $payment = new payment($idPayment, $city, $function, $subfunction, $program, $action, $beneficiary, $source, $file, $dbValue, $month, $year);
    $msg = $object->salvar($payment);
    $idPayment = null;
    $city = null;
    $function = null;
    $subfunction = null;
    $program = null;
    $action = null;
    $beneficiary = null;
    $source = null;
    $file = null;
    $dbValue = null;
    $month = null;
    $year = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idPayment != "") {
    $payment = new payment($idPayment, '', '', '', '', '', '', '', '', '', '','');
    $msg = $object->remover($payment);
    $idPayment = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Payment</h4>
                        <p class='category'>Payments list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&idPayment=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="idPayment" value="<?php
                            // Preenche o idPayment no campo idPayment com um valor "value"
                            echo (isset($idPayment) && ($idPayment != null || $idPayment != "")) ? $idPayment : '';
                            ?>"/>
                            City:
                            <select name="city" style="width: 25%;">
                                <?php
                                $query = "SELECT * FROM tb_city order by str_name_city;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_city == $city) {
                                            echo "<option value='$rs->id_city' selected>$rs->str_name_city</option>";
                                        } else {
                                            echo "<option value='$rs->id_city'>$rs->str_name_city</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            Function:
                            <select name="function" style="width: 25%;">
                                <?php
                                $query = "SELECT * FROM tb_functions order by str_name_function;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_function == $function) {
                                            echo "<option value='$rs->id_function' selected>$rs->str_name_function</option>";
                                        } else {
                                            echo "<option value='$rs->id_function'>$rs->str_name_function</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            Subfunction:
                            <select name="subfunction" style="width: 25%;">
                                <?php
                                $query = "SELECT * FROM tb_subfunctions order by str_name_subfunction;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_subfunction == $subfunction) {
                                            echo "<option value='$rs->id_subfunction' selected>$rs->str_name_subfunction</option>";
                                        } else {
                                            echo "<option value='$rs->id_subfunction'>$rs->str_name_subfunction</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            Program:
                            <select name="program" style="width: 25%;">
                                <?php
                                $query = "SELECT * FROM tb_program order by str_name_program;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_program == $program) {
                                            echo "<option value='$rs->id_program' selected>$rs->str_name_program</option>";
                                        } else {
                                            echo "<option value='$rs->id_program'>$rs->str_name_program</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            Action:
                            <select name="action" style="width: 25%;">
                                <?php
                                $query = "SELECT * FROM tb_action order by str_name_action;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_action == $action) {
                                            echo "<option value='$rs->id_action' selected>$rs->str_name_action</option>";
                                        } else {
                                            echo "<option value='$rs->id_action'>$rs->str_name_action</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            Beneficiary:
                            <select name="beneficiary" style="width: 30%;">
                                <?php
                                $query = "SELECT * FROM tb_beneficiaries order by str_name_person, str_nis;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_beneficiaries == $beneficiary) {
                                            echo "<option value='$rs->id_beneficiaries' selected>$rs->str_nis - $rs->str_name_person</option>";
                                        } else {
                                            echo "<option value='$rs->id_beneficiaries'>$rs->str_nis - $rs->str_name_person</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            Source:
                            <select name="source" style="width: 25%;">
                                <?php
                                $query = "SELECT * FROM tb_source order by str_origin;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_source == $source) {
                                            echo "<option value='$rs->id_source' selected>$rs->str_origin</option>";
                                        } else {
                                            echo "<option value='$rs->id_source'>$rs->str_origin</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            File:
                            <select name="file" style="width: 25%;">
                                <?php
                                $query = "SELECT * FROM tb_files order by str_name_file;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_file == $file) {
                                            echo "<option value='$rs->id_file' selected>$rs->str_name_file</option>";
                                        } else {
                                            echo "<option value='$rs->id_file'>$rs->str_name_file</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            Value:
                            <input type="text" size="15" name="dbValue" value="<?php
                            echo (isset($dbValue) && ($dbValue != null || $dbValue != "")) ? $dbValue : '';
                            ?>"/>
                            Month:
                            <input type="text" size="2" name="month" value="<?php
                            echo (isset($month) && ($month != null || $month != "")) ? $month : '';
                            ?>"/>
                            Year:
                            <input type="text" size="4" name="year" value="<?php
                            echo (isset($year) && ($year != null || $year != "")) ? $year : '';
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
