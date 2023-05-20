
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
 <title>Рейтинг</title>
 <link rel="stylesheet" href="css/rate.css">
</head>
<body>

	<?php
    include("header.php");
    include("app/controllers/rating_settings.php");
    ?>

	<div id="main">
	<div id="mtab">
        <?php if(isset($_SESSION['id'])): ?>
	<table class="table">
		<br>

		<CAPTION><H2>Твой рейтинг</H2></CAPTION>
		<!-- эт две строки показывают на каком месте пользователь -->
		<thead>
			<tr>
				<td>№</td>
				<td>Логин</td>
				<td>Решённые задачи</td>
				<td>Баллы</td>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><?=test($user_rating['num'])?></td>
				<td><?=test($user['login'])?></td>
				<td><?=test($user_rating['count_of_task'])?></td>
				<td><?=test($user_rating['rating'])?></td>
			</tr>
		</table>

		<br>
		<br>
        <?php endif; ?>
		<table class="table">
		<CAPTION><H2>Рейтинг пользователей</H2></CAPTION>
		<!-- эт две строки показывают на каком месте пользователь -->

		<!-- эт основная таблица -->
		<thead>
			<tr>
				<td>№</td>
				<td>Логин</td>
				<td>Решённые задачи</td>
				<td>Баллы</td>
			</tr>
		</thead>
		<tbody>
        <?php
        if ($count > 100):
            for($i = 0; $i < 100; $i++):?>
			<tr>
				<td>
                    <?php
                    $place = $ratingAll[$i];
                    test($place['num']);
                    ?>
                </td>
				<td>
                    <?php
                    $each_user = $ratingAll[$i];
                    $each_user = selectOne('users', ['id' => $each_user['id']]);
                    test($each_user['login']);
                    ?>
                </td>
				<td>
                    <?php
                    $each_count_tasks = selectOne('users_rating', ['id' => $each_user['id']]);
                    test($each_count_tasks['count_of_task']);
                    ?>
                </td>
				<td>
                    <?php
                    $each_rating = selectOne('users_rating', ['id' => $each_user['id']]);
                    test($each_rating['rating']);
                    ?>
                </td>
			</tr>
        <?php endfor;
        else:
            for($i = 0; $i < $count; $i++):
        ?>
        <tr>
            <td>
                <?php
                $place = $ratingAll[$i];
                test($place['num']);
                ?>
            </td>
            <td>
                <?php
                $each_user = $ratingAll[$i];
                $each_login = selectOne('users', ['id' => $each_user['id_user']]);
                test($each_login['login']);
                ?>
            </td>
            <td>
                <?php
                $each_count_tasks = selectOne('users_rating', ['id' => $each_user['id']]);
                test($each_count_tasks['count_of_task']);
                ?>
            </td>
            <td>
                <?php
                $each_rating = selectOne('users_rating', ['id' => $each_user['id']]);
                test($each_rating['rating']);
                ?>
            </td>
        </tr>
        <?php
        endfor;
        endif;
        ?>
		</tbody>
		</table>
		</div>
	</div>
</body>
</html>
