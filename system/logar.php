<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 10/01/2018
 * Time: 11:11
 */

require_once "db/conexao.php";

session_start();
$login = $_POST['user'];
$passwd = $_POST['pwd'];

try {
    $statement = $pdo->prepare("SELECT str_name, str_username, str_password, str_type FROM tb_user WHERE str_username = :username and str_password = :password");
    $statement->bindValue(":username", $login);
    $statement->bindValue(":password", sha1($passwd));
    if ($statement->execute()) {
        $rs = $statement->fetch(PDO::FETCH_OBJ);
        $username = $rs->str_username;
        $name = $rs->str_name;
        $type = $rs->str_type;
        $password = $rs->str_password;
        if($username != null and $password != null and $type != null)
        {
            $_SESSION['nameuser'] = $name;
            $_SESSION['password'] = $password;
            $_SESSION['typeUser'] = $type;
            header('location:index.php');
        }
        else{
            unset ($_SESSION['nameuser']);
            unset ($_SESSION['password']);
            unset ($_SESSION['typeUser']);
            header('location:index.php');

        }
    } else {
        throw new PDOException("Erro: Não foi possível executar a declaração sql");
    }
} catch (PDOException $erro) {
    echo "Erro: ".$erro->getMessage();
}

?>