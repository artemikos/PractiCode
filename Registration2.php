
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Регистрация</title>
		<link rel="stylesheet" href="css/RegAutStyles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
		<script language="javascript" type="text/javascript">
            function Error(id) {
                if ((id!=="registr") && (id!=="exit")) {
                    var err = document.getElementById(id);
                    if (err.textContent.length > 0) {
                        $("#" + id).fadeTo(100, 0);
                        setTimeout(() => {$ ("#" + id).css("margin-bottom", "25px"); err.textContent = "";}, 150);
                    }
                }
                else {
                    var err1 = document.getElementById("error1");
                    var err2 = document.getElementById("error2");
                    if (err1.textContent.length > 0) {
                        $("#error1").fadeTo(100, 0);
                        setTimeout(() => {$ ("#error1").css("margin-bottom", "25px"); err1.textContent = "";}, 150);
                    }
                    if (err2.textContent.length > 0) {
                        $("#error2").fadeTo(100, 0);
                        setTimeout(() => {$ ("#error2").css("margin-bottom", "25px"); err2.textContent = "";}, 150);
                    }
                }
            }

            function Onload() {
                var page = window.location.search;
                var title = document.querySelector("title");
                var substr = "checked";
                //let c = document.getElementById("chk");
                if (page.includes(substr)) {
                    //c.checked = true;
                    $ ("#chk").attr("checked", true);
                    title.textContent = "Вход";
                }

                var err1 = document.getElementById("error1");
                var err2 = document.getElementById("error2");
                if (err1.textContent.length > 72) {
                    $ ("#error1").css("margin-bottom", "-10px");
                }
                if (err2.textContent.length > 72) {
                    $ ("#error2").css("margin-bottom", "-10px");
                }

            }
		</script>
		</head>
		<body onload = "Onload()">

        <?php

        include("header.php");
        include("app/controllers/users.php");
        if(isset($_SESSION['id'])){
            header('Location: /practicode.ru');
        }
        ?>


        <div class="main">
			<input type="checkbox" id="chk" aria-hidden="true">
				<div class="signup">
					<form method="post" action="Registration2.php">
						<label id="label1" onclick="Error('registr')" for="chk" aria-hidden="true">Регистрация</label>
						<p id="error1" class="error"><?=$msg?></p>
						<input onclick="Error('error1')" type="text" name="login" value="<?=$login?>" placeholder="Введите логин" required="">
						<input onclick="Error('error1')" type="email" name="email" value="<?=$email?>" placeholder="Введите email" required="">
						<input onclick="Error('error1')" type="password" name="pass-first" placeholder="Введите пароль" required="">
	                    <input onclick="Error('error1')" type="password" name="pass-second" placeholder="Повторите пароль" required="">
						<button type="submit" name="button-reg">Зарегистрироваться</button>
					</form>
				</div>

				<div class="login">
					<form  method="post" action="Registration2.php">
						<label id="label2" onclick="Error('exit')" for="chk" aria-hidden="true">Вход</label>
						<p id="error2" class="error"><?=$msg?></p>
						<input onclick="Error('error2')" type="text" name="log_mail" value="<?=$mail, $login?>" placeholder="Введите логин" required="">
						<input onclick="Error('error2')" type="password" name="pass" placeholder="Введите пароль" required="">
						<button type="submit" name="button-log">Войти</button>
						<a href="Email.php" class="forget">Не помню пароль</a>
					</form>
				</div>
		</div>
        <script type="text/javascript">
            function ev() {
                var title = document.querySelector("title");
                if (title.textContent==="Регистрация")
                    title.textContent = "Вход";
                else
                    title.textContent = "Регистрация";
            }
            $( "#label1" ).on( "click", ev );
            $( "#label2" ).on( "click", ev );
        </script>
	</body>
</html>
