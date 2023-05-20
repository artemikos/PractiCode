<?php

$driver = 'mysql';
$host = 'practicode.ru';
$db_name = 'register-db';
$db_user = 'misha_samuy_krutoy';
$db_pass = '123321awdDWA';
$charset = 'utf8';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try{
    $pdo = new PDO(
        "$driver:host=$host;dbname=$db_name;charset=$charset",
        $db_user, $db_pass, $options
    );
} catch(PDOException $i){
    die("Ошибка подключения к базе данных");
}

?>