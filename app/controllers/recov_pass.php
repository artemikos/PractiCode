<?php
$data = $_GET;

$msg = '';
$check = '';

if(isset($data['button-change'])){
    $user = selectOne('users', ['change_key' => trim($_GET['key'])]);
    if(empty($user)){
        $msg = 'Ссылка недействительна!';
        header("Refresh: 10; url=/practicode.ru/index.php");
    }else{
        $new = password_hash($data['newpass'], PASSWORD_DEFAULT);
        $change = [
            'change_key' => null,
            'password' => $new
        ];
        $number = preg_match('@[0-9]@', $data['newpass']);
        $lowercase = preg_match('@[a-z]@', $data['newpass']);
        if(mb_strlen($data['newpass']) < 8 || !$lowercase || !$number){
            $msg = 'Пароль должен состоять более чем из 8 символов, а также иметь строчные буквы и цифры';
        }elseif ($data['newpass'] === $data['newpass_rep']){
            update('users', $user['id'], $change);
            $check = 'check';
            $msg = 'Вы успешно сменили пароль!';
            header('Refresh: 5; url=/practicode.ru/index.php');
        }else{
            $msg = 'Ошибка ввода! Пароли не совпадают!';
        }
    }

}
?>