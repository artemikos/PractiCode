<?php

session_start();

require('connect.php');

//Вывод данных из таблицы
function test($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

//Проверка выполнения запроса к БД
function dbCheckError($query){
    $errInfo = $query->errorInfo();
    if($errInfo[0] !== PDO::ERR_NONE){
        echo $errInfo[2];
        exit();
    }
    return true;
}

//Выборка всех данных из ондой таблицы
function selectALL($table, $params = []){
    global $pdo;
    $sql = "SELECT id, login FROM $table";                              //ЕСЛИ НУЖНО ВСЕ ПОМЕНЯТЬ НА *

    if(!empty($params)){
        $i = 0;
        foreach($params as $key => $value) {
            if (!is_numeric($value)){
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key = $value";
            } else {
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query -> execute();

    dbCheckError($query);

    //fetch() получает только одну строку. Если больше 1 строки - fetchAll();
    return $query->fetchAll();
}

function selectALL_tmp($table, $params = []){
    global $pdo;
    $sql = "SELECT * FROM $table";                              //ЕСЛИ НУЖНО ВСЕ ПОМЕНЯТЬ НА *

    if(!empty($params)){
        $i = 0;
        foreach($params as $key => $value) {
            if (!is_numeric($value)){
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key = $value";
            } else {
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query -> execute();

    dbCheckError($query);

    //fetch() получает только одну строку. Если больше 1 строки - fetchAll();
    return $query->fetchAll();
}

//Функция получения строки из таблицы
function selectOne($table, $params = []){
    global $pdo;
    $sql = "SELECT * FROM $table";

    if(!empty($params)){
        $i = 0;
        foreach($params as $key => $value) {
            if (!is_numeric($value)){
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key = $value";
            } else {
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }
//    $sql = $sql . " LIMIT 1";

    $query = $pdo->prepare($sql);
    $query -> execute();

    dbCheckError($query);

    //fetch() получает только одну строку. Если больше 1 строки - fetchAll();
    return $query->fetch();
}



//Функция выборки рейтинга
function ratingALL($table, $params = []){
    global $pdo;
    $rating = 'rating';
    $sql = "SELECT id, id_user, rating, count_of_task, @i:=@i+1 num FROM $table, (SELECT @i:=0) X ORDER BY $rating DESC";

    if(!empty($params)){
        $i = 0;
        foreach($params as $key => $value) {
            if (!is_numeric($value)){
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key = $value";
            } else {
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query -> execute();

    dbCheckError($query);

    //fetch() получает только одну строку. Если больше 1 строки - fetchAll();
    return $query->fetchAll();
}
//ФУНКЦИЯ НАХОДИТ ТВОЕ МЕСТО В РЕЙТИНГЕ
function ratingOne($table_1, $table_2, $dif, $id_user){
    global $pdo;
    $sql = "SELECT DISTINCT count($table_1.id_task) tasks_count, $table_1.id_user, $table_2.difficulty
            FROM $table_1 JOIN $table_2 ON $table_1.id_task = $table_2.id
            WHERE $table_2.difficulty = '$dif' AND $table_1.task_status = 1 AND $table_1.id_user = $id_user";

    /*if(!empty($params)){
        $i = 1;
        foreach($params as $key => $value) {
            if (!is_numeric($value)){
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key = $value";
            } else {
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }*/

    $query = $pdo->prepare($sql);
    $query -> execute();

    dbCheckError($query);

    //fetch() получает только одну строку. Если больше 1 строки - fetchAll();
    return $query->fetchAll();
}

function ratingOne_addition($table, $id, $id_task){
    global $pdo;
    $sql = "SELECT DISTINCT count(id_task) tasks_count, id_user FROM $table WHERE id_user = $id AND id_task = $id_task";


    $query = $pdo->prepare($sql);
    $query -> execute();

    dbCheckError($query);

    //fetch() получает только одну строку. Если больше 1 строки - fetchAll();
    return $query->fetchAll();
}

//Запись в таблицу БД
function insert($table, $params){
    global $pdo;
    $i = 0;
    $coll = '';
    $mask = '';
    foreach ($params as $key => $value){                //Разбираем массив на ключ и значение
        if ($i === 0){
            $coll = $coll . "$key";                     //Ключи - название колонок в таблице
            $mask = $mask . "'" . "$value" . "'";       //Значения - значения под запись
        }else {
            $coll = $coll . ", $key";
            $mask = $mask . ", '" . "$value" . "'";
        }
        $i++;
    }

    $sql = "INSERT INTO $table ($coll) VALUES($mask)";

//    test($sql);
//    exit();
    $query = $pdo->prepare($sql);
    $query -> execute($params);
    dbCheckError($query);

    return $pdo->lastInsertId();
}

//Функция обновления строки
function update($table, $id, $params){
    global $pdo;
    $i = 0;
    $str = '';
    foreach ($params as $key => $value){                //Разбираем массив на ключ и значение
        if ($i === 0){
            $str = $str . $key . " = '" . $value . "'";
        }else {
            $str = $str . ", " . $key . " = '" . $value . "'";
        }
        $i++;
    }

    $sql = "UPDATE $table SET $str WHERE id = $id";

//    test($sql);
//    exit();
    $query = $pdo->prepare($sql);
    $query -> execute($params);
    dbCheckError($query);

}

function update_tasks_users($table, $id, $params){
    global $pdo;
    $i = 0;
    $str = '';
    foreach ($params as $key => $value){                //Разбираем массив на ключ и значение
        if ($i === 0){
            $str = $str . $key . " = '" . $value . "'";
        }else {
            $str = $str . ", " . $key . " = '" . $value . "'";
        }
        $i++;
    }

    $sql = "UPDATE $table SET $str WHERE id_task = $id";

//    test($sql);
//    exit();
    $query = $pdo->prepare($sql);
    $query -> execute($params);
    dbCheckError($query);

}

function update_users_rating($table, $id, $params){
    global $pdo;
    $i = 0;
    $str = '';
    foreach ($params as $key => $value){                //Разбираем массив на ключ и значение
        if ($i === 0){
            $str = $str . $key . " = '" . $value . "'";
        }else {
            $str = $str . ", " . $key . " = '" . $value . "'";
        }
        $i++;
    }

    $sql = "UPDATE $table SET $str WHERE id_user = $id";

//    test($sql);
//    exit();
    $query = $pdo->prepare($sql);
    $query -> execute($params);
    dbCheckError($query);

}

//Функция обновления таблицы пользователь => задание
function update_users_tasks($table, $id_user, $id_task, $params){
    global $pdo;
    $i = 0;
    $str = '';
    foreach ($params as $key => $value){                //Разбираем массив на ключ и значение
        if ($i === 0){
            $str = $str . $key . " = '" . $value . "'";
        }else {
            $str = $str . ", " . $key . " = '" . $value . "'";
        }
        $i++;
    }
    $sql = "UPDATE $table SET $str WHERE id_task = $id_task AND id_user = $id_user";

//    test($sql);
//    exit();
    $query = $pdo->prepare($sql);
    $query -> execute($params);
    dbCheckError($query);

}


//Функция удаления
function delete($table, $id){
    global $pdo;

    $sql = "DELETE FROM $table WHERE id = $id";

//    test($sql);
//    exit();
    $query = $pdo->prepare($sql);
    $query -> execute();
    dbCheckError($query);

}

function delete_tmp_task_user($table, $id){
    global $pdo;

    $sql = "DELETE FROM $table WHERE id_user = $id";

//    test($sql);
//    exit();
    $query = $pdo->prepare($sql);
    $query -> execute();
    dbCheckError($query);

}

function delete_tmp_user_task($table, $id_task, $id_user){
    global $pdo;

    $sql = "DELETE FROM $table WHERE id_task != $id_task AND id_user = $id_user";

//    test($sql);
//    exit();
    $query = $pdo->prepare($sql);
    $query -> execute();
    dbCheckError($query);

}
//delete('users', 5);

//$param = [
//    'admin' => 0
//];
//
//update('users', 5, $param);

//Ассоциативный массив
//$arrData = [
//    'admin' => '0',
//    'login' => 'lo1',
//    'email' => 'log1@log',
//    'password' => '123123'
//];
//
//insert('users', $arrData);

//$params = [
//    'admin' => 1,
//    'login' => 'kaneki'
//];
//
////test(selectALL('users', $params));
//test(selectOne('users'));

?>