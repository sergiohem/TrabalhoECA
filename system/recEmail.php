<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 08/01/2018
 * Time: 16:21
 */

require_once "vendor/autoload.php";
require_once "db/userDAO.php";
require_once "classes/user.php";

$user = new user(0, '', '','','','','');
$userDAO = new userDAO();
$username = null;
$email = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = (isset($_POST["username"]) && $_POST["username"] != null) ? $_POST["username"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
    $user = $userDAO->buscarPorUsernameEEmail($username, $email);
}

//require "libs/PHPMailer/src/PHPMailer.php";
//require "libs/PHPMailer/src/SMTP.php";
//require "libs/PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer;

$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

$mail->Host = 'smtp.gmail.com';

$mail->Port = 587;

$mail->SMTPSecure = 'ssl';

$mail->SMTPAuth = true;

$mail->Username = "sergiohenriquemarques22@gmail.com";
$mail->Password = "soueumesmo";


$mail->setFrom($user->getEmail(), $user->getName());

//$mail->addReplyTo('tassio@tassio.eti.br', 'Tassio Sirqueira');

$mail->addAddress('sergiohenriquemarques22@gmail.com', 'Sergio Marques');

$mail->Subject = 'Recuperação de login - EconomiC Analyzer';

$mail->msgHTML("Sua senha temporária é 123456 <br> Não perca novamente!");

//$mail->addAttachment('phpmailer.png');

if (!$mail->send()) {
    echo "Erro ao enviar o E-mail: " . $mail->ErrorInfo;
} else {
    $user->setPassword(sha1('123456'));
    $userDAO->atualizar($user);
    echo "E-mail enviado com sucesso!";
}