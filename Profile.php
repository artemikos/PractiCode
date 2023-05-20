

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Личный кабинет</title>
		<link rel="stylesheet" href="css/Profile.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
		<script language="javascript" type="text/javascript">
			function Change(id) {
				if (id === "email" || id==="password" || id==="avatar") {
					if (	$ ("#" + id).css("display") !== "block")
						$ ("#" + id).css("display", "block");
				}
			}
			function Cancel(id) {
				if (id === "email" || id==="password" || id==="avatar") {
					if (	$ ("#" + id).css("display") !== "none")
						setTimeout(() => $ ("#" + id).css("display", "none"), 100);
				}
			}
			function Error(id) {
				var err = document.getElementById(id);
				if (err.textContent.length > 0) {
					$("#" + id).fadeTo(100, 0);
					setTimeout(() => err.textContent = "", 150);
				}
			}
		</script>
	</head>
	<body>

		<?php include("header.php");
        include("app/controllers/user_edit.php")
        ?>
		<div class="main">
				<div class="data">
					<form method="post" action="Profile.php" class="settings" enctype="multipart/form-data">

						<img src="<?=$avatar?>" alt="Аватар">
                        <span></span>
						<button class="change_img" onclick="Change('avatar')" type="button" name="change_img">Изменить аватар</button>
                        <a class="exit" href="#openModal">Выйти</a>
                        <div id="avatar" class="update3">
							<p>Выберите аватар. Изображение должно быть формата jpg, gif или png:</p>
							<label class="input-file">
								<input type="file" name="load_avatar">
								<span class="input-file-btn">Выберите файл</span>
							</label>
							<button type="submit" name="button-submit-avatar">Сохранить</button>
							<button class="save" onclick="Cancel('avatar')" type="reset">Отмена</button>
						</div>

						<p id="error1" <?php if(!empty($check)): ?> class="not_error" <?php else: ?> class="error" <?php endif; ?>><?=$msg_log, $msg_avatar, $msg_mail, $msg_pass?></p>
						<p class="title">Логин: </p>
						<input onclick="Error('error1')" type="text" name="login" value="<?=$login?>">
		                <button class="save" type="submit" name="button-submit-login">Сохранить</button>
		                <button type="reset">Отмена</button><br>

						<p class="title">Почта: </p>
						<input type="email" name="email" value="<?=$mail?>" disabled>
		                <button class="save" onclick="Change('email')" type="button" name="change_email">Изменить email</button><br>
						<div id="email" class="update1">
							<input onclick="Error('error1')" type="email" name="new_email" placeholder="Введите новую почту">
			                <input onclick="Error('error1')" type="password" name="pass__check" placeholder="Введите пароль">
							<button class="save" type="submit" name="button-submit-email">Сохранить</button>
			                <button onclick="Cancel('email')" type="reset">Отмена</button><br>
						</div>

						<button class="save" onclick="Change('password')" type="button" name="change_pass">Сменить пароль</button><br>
                        <div id="password" class="update2">
							<input onclick="Error('error1')" type="password" name="old__pass" placeholder="Введите старый пароль">
			                <input onclick="Error('error1')" type="password" name="new__pass" placeholder="Введите новый пароль">
			                <input onclick="Error('error1')" type="password" name="new__pass__repeat" placeholder="Повторите новый пароль">
			                <button class="save" type="submit" name="button-submit-password">Сохранить</button>
							<button onclick="Cancel('password')" type="reset">Отмена</button><br>
						</div>
					</form>
				</div>
		</div>

        <div id="openModal" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Покинуть личный кабинет?</h3>
                        <a href="#close" title="Закрыть" class="close">&times;</a>
                    </div>
                    <div class="modal-body">
                        <a href="app/controllers/user/logout.php"><button class="ex" type="button" name="exit">Да</button></a>
                        <button class="stay" type="button" name="stay"><a href="#close">Нет</a></button>
                    </div>
                </div>
            </div>
        </div>
		</main>
	</body>
</html>
