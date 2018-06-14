<?php
/**
 * Created by PhpStorm.
 * User: action
 * Date: 16/03/2018
 * Time: 21:16
 */

include_once "classes/template.php";
require_once "db/userDAO.php";
require_once "classes/user.php";

$template = new Template();
$object = new userDAO();

$template->header();

$template->sidebar();

$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUser = (isset($_POST["idUser"]) && $_POST["idUser"] != null) ? $_POST["idUser"] : "";
    $name = (isset($_POST["name"]) && $_POST["name"] != null) ? $_POST["name"] : "";
    $username = (isset($_POST["username"]) && $_POST["username"] != null) ? $_POST["username"] : "";
    $password = (isset($_POST["password"]) && $_POST["password"] != null) ? $_POST["password"] : "";
    $type = (isset($_POST["type"]) && $_POST["type"] != null) ? $_POST["type"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
    $recPassword = (isset($_POST["recPassword"]) && $_POST["recPassword"] != null) ? $_POST["recPassword"] : "";
} else if (!isset($idUser)) {
    // Se não se não foi setado nenhum valor para variável $idUser
    $idUser = (isset($_GET["idUser"]) && $_GET["idUser"] != null) ? $_GET["idUser"] : "";
    $name = NULL;
    $username = NULL;
    $password = NULL;
    $type = NULL;
    $email = NULL;
    $recPassword = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idUser != "") {

    $user = new user($idUser, '', '','','','','');

    $resultado = $object->atualizar($user);
    $name = $resultado->getName();
    $username = $resultado->getUsername();
    $password = $resultado->getPassword();
    $type = $resultado->getType();
    $email = $resultado->getEmail();
    $recPassword = $resultado->getRecPassword();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $name != "" && $username != "" && $password != "" && $type != "" && $email != "" && $recPassword != "") {
    $user = new user($idUser, $name, $username, sha1($password), $type, $email, $recPassword);
    $msg = $object->salvar($user);
    $idUser = NULL;
    $name = NULL;
    $username = NULL;
    $password = NULL;
    $type = NULL;
    $email = NULL;
    $recPassword = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idUser != "") {
    $user = new user($idUser, '', '', '', '', '','');
    $msg = $object->remover($user);
    $idUser = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>User</h4>
                        <p class='category'>Users list</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&idUser=" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="idUser" value="<?php
                            // Preenche o idUser no campo idUser com um valor "value"
                            echo (isset($idUser) && ($idUser != null || $idUser != "")) ? $idUser : '';
                            ?>"/>
                            Name:
                            <input type="text" size="20" name="name" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($name) && ($name != null || $name != "")) ? $name : '';
                            ?>"/>
                            Username:
                            <input type="text" size="20" name="username" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($username) && ($username != null || $username != "")) ? $username : '';
                            ?>"/>
                            Password:
                            <input type="password" size="30" name="password" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($password) && ($password != null || $password != "")) ? $password : '';
                            ?>"/>
                            Type:
                            <select name="type">
                                <option value="Admin"<?php if(isset($type) && $type== "Admin") echo 'selected'?>>Admin</option>
                                <option value="User"<?php if(isset($type) && $type== "User") echo 'selected'?>>User</option>
                            </select>
                            <br/>
                            E-mail:
                            <input type="email" size="30" name="email" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($email) && ($email != null || $email != "")) ? $email : '';
                            ?>"/>
                            Rec. Password:
                            <select name="recPassword">
                                <option value="1"<?php if(isset($recPassword) && $recPassword== 1) echo 'selected'?>>Yes</option>
                                <option value="0"<?php if(isset($recPassword) && $recPassword== 0) echo 'selected'?>>No</option>
                            </select>
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
