<?php
include ("../app/database-reg/database.php");

if(isset($_SESSION['id'])){
    $data = $_POST;
    $id_user = $_SESSION['id'];
    $task_tmp = selectALL_tmp('tmp_user_tasks', ['id_user' => $id_user]);
    //test($task_tmp);
    if ($task_tmp){
        $update_status_task = [
            'task_status' => 1
        ];
        update_tasks_users('tasks_users', $task_tmp[0]['id_task'], $update_status_task);
        $check_task_easy = ratingOne('tasks_users', 'tasks', 'easy', $id_user);
        //test($check_task_easy);
        $check_task_hard = ratingOne('tasks_users', 'tasks', 'hard', $id_user);
        $check_users_tasks = ratingOne_addition('tasks_users', $id_user, -1);
        //test($check_users_tasks);
        $check_users_reports = ratingOne_addition('tasks_users', $id_user, -2);
        //test($check_users_reports);

        $user_tasks = $check_users_tasks[0]['tasks_count'];
        $user_reports = $check_users_reports[0]['tasks_count'];
        $tasks_count = $check_task_easy[0]['tasks_count'] + $check_task_hard[0]['tasks_count'];
        $user_score = ( (int) $check_task_easy[0]['tasks_count'] * 5)
            + ( (int) $check_task_hard[0]['tasks_count'] * 15) + ( (int) $check_users_tasks[0]['tasks_count'] * 20 )
            + ( (int) $check_users_reports[0]['tasks_count'] * 50 );

        //echo $user_score;
        $params = [
            'rating' => $user_score,
            'count_of_task' => $tasks_count,
            'user_task_count' => $user_tasks,
            'reports' => $user_reports
        ];


        delete_tmp_task_user('tmp_user_tasks', $id_user);

        update_users_rating('users_rating', $id_user, $params);

        header("Location: ../task.php");
    }else{
        header("Location: ../task.php");
    }

}else{
    header("Location: ../");
}

