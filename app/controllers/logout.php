<?php
session_start();


unset($_SESSION['id']);
unset($_SESSION['login']);
//$_SESSION['admin'] = $existence['admin'];

header('Location: /practicode.ru/index.php');