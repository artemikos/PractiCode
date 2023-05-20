<?php

$easy_tasks = selectALL_tmp('tasks', ['difficulty' => 'easy']);

if(isset($_SESSION['id'])){
    $completed_tasks = selectALL_tmp('tasks_users', ['id_user' => $_SESSION['id'], 'task_status' => '1']);

}else{
    $completed_tasks[0] = [
        'id_task' => -2
    ];
    $completed_tasks[1] = [
        'id_task' => -1
    ];
}
