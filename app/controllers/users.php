<?php


$isSubmit = false;
$msg = '';
$regStatus = '';


//Код для формы регистрации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])){


    $admin = 0;
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);
    $number = preg_match('@[0-9]@', $passF);
    $lowercase = preg_match('@[a-z]@', $passF);

    if($login === '' || $email === '' || $passF === ''){
        $msg = "Не все поля заполнены!";
    }elseif(mb_strlen($login, 'utf8') < 2){
        $msg = "Логин должен быть более 1-го символа";
    }elseif(mb_strlen($passF, 'utf8') < 8 || !$number || !$lowercase){
        $msg = "Пароль должен состоять более чем из 8 символов, а также иметь строчные буквы и цифры";
    }elseif($passF !== $passS){
        $msg = "Пароли не совпадают";
    }else{
        $existence_mail = selectOne('users', ['email' => $email]);
        $existence_log = selectOne('users', ['login' => $login]);

        if(!empty($existence_mail['email']) && $existence_mail['email'] === $email){
            $msg = "Введенная почта уже зарегистрирована";
        }elseif(!empty($existence_log['login']) && $existence_log['login'] === $login){
            $msg = "Введенный логин уже зарегистрирован";
        }else{
            $pass = password_hash($passF, PASSWORD_DEFAULT); //ХЕШИРУЕМ ПАРОЛЬ
            $post = [
                'admin' => $admin,
                'login' => $login,
                'email' => $email,
                'password' => $pass,
                'avatar' => 'css/images/avatars/default/default.jpg'
            ];
            $id = insert('users', $post);
            $rating = [
                'id_user' => $id,
                'rating' => 0,
                'count_of_task' => 0,
                'reports' => 0,
                'user_task_count' => 0
            ];
            insert('users_rating', $rating);
            $user = selectOne('users', ['id' => $id]);

            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['admin'] = $user['admin'];
            echo "<script>self.location='index.php';</script>";
            //header('Location: /select/index.php');
//            test($_SESSION);
//            exit();
        }
    }
}else{
    $login = '';
    $email = '';
}


//Код для формы авторизации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-log'])){

    $mail = trim($_POST['log_mail']);
    $log = trim($_POST['log_mail']);
    $pass = trim($_POST['pass']);
    if($mail === '' || $pass === '' || $log === ''){
        $msg = "Не все поля заполнены!";
    }else {
        $existence_m = selectOne('users', ['email' => $mail]);
        $existence_l = selectOne('users', ['login' => $log]);
        if($existence_m && password_verify($pass, $existence_m['password'])){

            $_SESSION['id'] = $existence_m['id'];
            $_SESSION['login'] = $existence_m['login'];


            $_SESSION['admin'] = $existence_m['admin'];
            echo "<script>self.location='index.php';</script>";
            //header('Location: /select/index.php');

        }elseif($existence_l && password_verify($pass, $existence_l['password'])){
            $_SESSION['id'] = $existence_l['id'];
            $_SESSION['login'] = $existence_l['login'];
            $_SESSION['admin'] = $existence_l['admin'];
            echo "<script>self.location='index.php';</script>";
            //header('Location: /select/index.php');
        }else{
            $msg = "Неверные данные";
        }
    }
}else{
    $mail = '';
}


?>