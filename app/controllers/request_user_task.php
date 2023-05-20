<?php

$data = $_GET;
$msg = "";
$id = $_SESSION['id'];
$check = '';

if(isset($id)){
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['button-send-task'])){
        if($data['task'] && $data['function'] && $data['task_test']){
            $check = 'h';
            $msg = "Форма отправлена администрации";
            $insert = [
                'id_user' => $id,
                'descript' => $data['task'],
                'test' => $data['task_test'],
                'user_func' => $data['function'],
                'letter_type' => 'new_task'
            ];
            insert('admins_letters', $insert);
            header("Refresh: 5; url=/practicode.ru/Profile.php");
        }else{
            $msg = "Не все поля заполнены!";
        }
    }elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['button-send-bug'])){

        if(!$data['lvl'] && !$data['def'] && !$data['idea']){

            $msg = "Хотя бы 1 поле должно быть заполнено";
        }else{
            $check = 'h';
            $msg = "Форма отправлена администрации";
            $insert = [
                'id_user' => $id,
                'descript' => $data['def'],
                'test' => $data['lvl'],
                'user_func' => $data['idea'],
                'letter_type' => 'report'
            ];
            insert('admins_letters', $insert);
            header("Refresh: 5; url=/practicode.ru/Profile.php");
        }
    }
}else{
    header("Location: /practicode.ru/registration2.php");
}