<?php

$userAll = selectALL('users', );
$ratingAll = ratingALL('users_rating',);
$count = count($ratingAll);

if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];

    $user = selectOne('users', ['id' => $id]);
    $rating = selectOne('users_rating', ['id_user' => $id]);


    for($i = 0; $i < $count; $i++){
        $each = $ratingAll[$i];
        if($user['id'] === $each['id_user']){
            $user_rating = $each;
        }
    }

}