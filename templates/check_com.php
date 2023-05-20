<?php
include ("../app/database-reg/database.php");
if(!empty($_GET)){
    $id = $_GET['number'];
    if(isset($_SESSION['id'])){
        $msg = '';
        $task = selectOne('tasks', ['id' => $id]);
        $task['answer'] = trim($task['answer']);

        $user = selectOne('users', ['id' => $_SESSION['id']]);
        //test($task);
        $check_user = selectOne('tasks_users', ['id_task' => $task['id'], 'id_user' => $user['id']]);
        if(!empty($check_user)){
            if($check_user['task_status'] === '1'){
                $msg = $check_user['user_func'];
            }
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-submit-result'])){
            $tmp_1 = '"';
            $tmp_2 = "'";

            $user_decision = selectOne('tasks_users', ['id_user' => $user['id'], 'id_task' => $task['id']]);

            $params = [
                'id_user' => $user['id'],
                'id_task' => $id
            ];
            delete_tmp_user_task('tmp_user_tasks', $id, $user['id']);
            $tmp = selectALL_tmp('tmp_user_tasks', ['id_user' => $user['id']]);
            //test($tmp);
            insert('tmp_user_tasks', $params);
            $tmp = selectALL_tmp('tmp_user_tasks', ['id_user' => $user['id']]);
            //test($tmp);
            $data = $_POST;
            //test($data);

            $msg = $data['result_code'];
            if($msg === ''){
                $res = "print('')";
            }else{
                if(!$user_decision){
                    $t = str_replace($tmp_2, $tmp_1, $msg);
                    $tasks_users = [
                        'id_task' => $task['id'],
                        'id_user' => $user['id'],
                        'user_func' => $t
                    ];
                    insert('tasks_users', $tasks_users);
                }else{
                    $t = str_replace($tmp_2, $tmp_1, $msg);
                    $tasks_users = [
                        'user_func' => $t
                    ];
                    update_users_tasks('tasks_users', $user['id'], $task['id'], $tasks_users);

                }


                $res = $data['result_code'] . "\n" . $task['test'];
            }

        }
    }else{
        header("Location: ../Registration2.php");
    }
}else{
    header("Location: ../Registration2.php");
}



