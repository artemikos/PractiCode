<?php

if(isset($_SESSION['id']) && $_SESSION['admin'] === '1'){
    $msg = "";



    $user_task = selectOne('admins_letters', ['letter_type' => 'new_task']);
    $user_reports = selectOne('admins_letters', ['letter_type' => 'report']);

    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['button-send-task'])){
        $data = $_GET;

        if($user_task){
            $id_user = $user_task['id_user'];
            if($data['descript'] && $data['user_function'] && $data['test'] && $data['user_answer'] && isset($data['difficulty']) && $id_user){

                $params = [
                    'descript' => $data['descript'],
                    'task_function' => $data['user_function'],
                    'test' => $data['test'],
                    'answer' => $data['user_answer'],
                    'difficulty' => $data['difficulty'],
                    'id_user' => $user_task['id_user']
                ];
                $users_params = [
                    'id_task' => -1,
                    'id_user' => $user_task['id_user'],
                    'user_func' => 'new_task',
                    'task_status' => 1
                ];
                insert('tasks', $params);

                insert('tasks_users', $users_params);
                delete('admins_letters', $user_task['id']);
                $user_task = selectOne('admins_letters', ['letter_type' => 'new_task']);
                //test($user_task);

            }else{
                $msg = "Вы заполнели не все поля!";
            }
        }elseif($data['descript'] && $data['user_function'] && $data['test'] && $data['user_answer'] && isset($data['difficulty'])){
            $params = [
                'descript' => $data['descript'],
                'task_function' => $data['user_function'],
                'test' => $data['test'],
                'answer' => $data['user_answer'],
                'difficulty' => $data['difficulty']
            ];
            insert('tasks', $params);

        }
    }elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['button-cancel-1'])) {
        $data = $_GET;
        if($user_task) {
            $id_user = $user_task['id_user'];
            delete('admins_letters', $user_task['id']);
            $user_task = selectOne('admins_letters', ['letter_type' => 'new_task']);
        }
    }elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['button-cancel-2'])) {
        $data = $_GET;
        if($user_reports) {
            $id_user = $user_reports['id_user'];
            delete('admins_letters', $user_reports['id']);
            $user_reports = selectOne('admins_letters', ['letter_type' => 'report']);
        }

    }elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['button-send-bug'])) {
        if($user_reports){
            $id_user = $user_reports['id_user'];
            delete('admins_letters', $user_reports['id']);
            $user_reports = selectOne('admins_letters', ['letter_type' => 'report']);
            if($user_reports['id_user']){
                $users_params = [
                    'id_task' => -2,
                    'id_user' => $user_reports['id_user'],
                    'user_func' => 'report',
                    'task_status' => 1
                ];
                insert('tasks_users', $users_params);
            }
        }
    }
}else{
    header("Location: /practicode.ru");
}
