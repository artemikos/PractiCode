<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$data = $_POST;
$msg = '';
$check = '';

if(isset($data['button-recover'])){
    $user = selectOne('users', ['email' => trim($_POST['email'])]);
    if($user){
        $key = md5($user['login'].rand(1000,9999));
        $change = [
            'change_key' => $key,
        ];
        update('users',$user['id'],$change);


        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Настройки SMTP


        $mail->SMTPDebug = 0;

        $mail->isSMTP();
        $mail->Host = 'ssl://smtp.mail.ru';
        $mail->SMTPAuth = true;
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->Username = 'noreply2023@bk.ru';
        $mail->Password = 'DYYy7aV2bLZXVrJJrxi1';


        // От кого
        $mail->setFrom('noreply2023@bk.ru', 'Администрация PractiCode');

        // Кому
        $mail->addAddress($data['email'], 'Пользователь Practicode');

        // Тема письма

        $mail->Subject = 'Восстановление пароля';

        // Тело письма
        $url = 'http://localhost/practicode.ru/Newpassword.php?key=' . $key;
        $date = date('m/d/Y h:i:s a', time());
        $mail->msgHTML("<body>
		<p>Здравствуйте, поступил запрос на изменение пароля:</p>
		<p>Для изменения пароля перейдите по</p>
		<a href={$url}> ссылке </a>
		<p>Если это были не вы, рекомендуем изменить ваш пароль. Письмо отправлено {$date}<p>
		</body>");


        if ($mail->send()) {
            $check = '1000-7';
            $msg = 'Письмо успешно отправлено на Email!';
            header('Refresh: 5; url=index.php');
        } else {
            $msg = 'Ошибка: email должен существовать'; //. $mail->ErrorInfo;
        }


    }
    else{
        $msg = "Данный email не зарегистрирован";
    }
}

