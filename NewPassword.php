

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Восстановление пароля</title>
    <link rel="stylesheet" href="css/NewPasswordStyles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script language="javascript" type="text/javascript">
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

<?php
include("header.php");
include 'app/controllers/recov_pass.php';
?>

<div class="main">
    <div class="signup">
        <form>
            <label aria-hidden="true">Последний рывок!</label>
            <p id="error1" <?php if(empty($check)): ?>class="error"
                <?php else: ?> class="not_error" <?php endif ?>><?=$msg?></p>
            <input onclick="Error('error1')" type="password" name="newpass" placeholder="Введите новый пароль" required="">
            <input onclick="Error('error1')" type="password" name="newpass_rep" placeholder="Повторите пароль" required="">
            <input type="hidden" value="<?=$data['key']?>" name="key">
            <button type="submit" name="button-change">Сохранить</button>
        </form>
    </div>
</div>

</body>
</html>
