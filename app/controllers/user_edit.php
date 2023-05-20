<?php

$msg_log = '';
$msg_mail = '';
$msg_pass = '';
$msg_avatar = '';
$check = '';




if (isset($_SESSION['id'])){
    //ЗАПОЛНЯЕМ ПЕРЕМЕННЫЕ

    $id = $_SESSION['id'];
    $user = selectOne('users', ['id' => $id]);
    $login = $user['login'];
    $mail = $user['email'];
    $admin = $user['admin'];
    $password = $user['password'];
    $avatar = $user['avatar'];

    //Сколько зарегестрирован
    $cur_date = time();
    $created = $user['created'];
    $created = strtotime($created);
    $created = ($cur_date - $created) / 60 / 60 / 24;

    $post = [
        'admin' => $admin,
        'login' => $login,
        'email' => $mail,
        'password' => $password
    ];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){              //ЕСЛИ МЕТОД ПОСТ
        if(isset($_POST['button-submit-login'])) {          //ЕСЛИ НАЖАТА КНОПКА СМЕНЫ ЛОГИНА
            $login = trim($_POST['login']);
            $post['login'] = $login;
            $existence = selectOne('users', ['login' => $post['login']]);
            if (!$existence){
                $check = "1000-7";
                update('users', $id, $post);
                $_SESSION['login'] = $login;
                $msg_log = 'Логин успешно изменен';
                header("Refresh: 3; url=Profile.php");
            }else{
                $msg_log = 'Данный логин уже зарегистрирован';
            }

        }elseif(isset($_POST['button-submit-email'])){      //КНОПКА СМЕНЫ ПОЧТЫ
            $new_mail = trim($_POST['new_email']);
            $pass = trim($_POST['pass__check']);
            $existence = selectOne('users', ['email' => $new_mail]);


            if(!$existence && password_verify($pass, $post['password'])){
                $post['email'] = trim($_POST['new_email']);
                update('users', $id, $post);
                $check = "1000-7";
                $mail = $post['email'];
                $msg_mail = 'Вы успешно сменили почту';
            }elseif ($existence){
                $msg_mail = 'Почта уже существует';
            }else {
                $msg_mail = 'Неверный пароль';
            }

        }elseif (isset($_POST['button-submit-password'])){          //МЕНЯЕМ ПАРОЛЬ
            $new_pass = trim($_POST['new__pass']);
            $new_pass_rep = trim($_POST['new__pass__repeat']);
            $old_pass = trim($_POST['old__pass']);

            $number = preg_match('@[0-9]@', $new_pass);
            $lowercase = preg_match('@[a-z]@', $new_pass);

            if (!password_verify($old_pass, $post['password'])){
                $msg_pass = 'Неверный старый пароль';
            }elseif (mb_strlen($new_pass) < 8 || !$number || !$lowercase){
            $msg_pass = 'Пароль должен состоять более чем из 8 символов, а также иметь строчные буквы и цифры';
            }elseif ($new_pass !== $new_pass_rep){
            $msg_pass = 'Новые пароли не совпадают';
            }elseif ($new_pass === $old_pass){
            $msg_pass = 'Новый пароль не должен совпадать со старым';
            }elseif(password_verify($old_pass, $post['password'])){
                $post['password'] = password_hash($new_pass, PASSWORD_DEFAULT);
                $check = "1000-7";
                update('users', $id, $post);
                $msg_pass = 'Вы успешно сменили пароль';
            }

        }elseif(isset($_POST['button-submit-avatar'])) {
            $path_to_90_directory = 'css/images/avatars/';   //папка, куда будет загружаться начальная картинка и ее сжатая копия
            if (preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/', $_FILES['load_avatar']['name'])) { //проверка формата исходного изображения
                $filename = $_FILES['load_avatar']['name'];
                $source = $_FILES['load_avatar']['tmp_name'];
                $target = $path_to_90_directory . $filename;
                move_uploaded_file($source, $target);                    //загрузка оригинала в папку $path_to_90_directory
                if(preg_match('/[.](GIF)|(gif)$/',    $filename)) {
                    $im = imagecreatefromgif($path_to_90_directory.$filename) ; //если оригинал был в формате gif, то создаем изображение в этом же формате. Необходимо для последующего сжатия
                }
                if(preg_match('/[.](PNG)|(png)$/',    $filename)) {
                    $im = imagecreatefrompng($path_to_90_directory.$filename) ; //если оригинал был в формате png то создаем изображение в этом же формате. Необходимо для последующего сжатия
                }

                if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',    $filename)) {
                    $im = imagecreatefromjpeg($path_to_90_directory.$filename); //если оригинал был в формате jpg, то создаем изображение в этом же формате. Необходимо для последующего сжатия
                }
                //СОЗДАНИЕ КВАДРАТНОГО ИЗОБРАЖЕНИЯ И ЕГО ПОСЛЕДУЮЩЕЕ СЖАТИЕ    ВЗЯТО С САЙТА www.codenet.ru
// Создание квадрата 90x90
                // dest - результирующее изображение
                // w - ширина изображения
                // ratio - коэффициент пропорциональности
                $w = 250;  //    квадратная 90x90. Можно поставить и другой размер.
// создаём исходное изображение на основе
                // исходного файла и определяем его размеры
                $w_src = imagesx($im); //вычисляем ширину
                $h_src = imagesy($im); //вычисляем высоту изображения
                // создаём    пустую квадратную картинку
                // важно именно truecolor!, иначе будем иметь 8-битный результат
                $dest = imagecreatetruecolor($w,$w);
                // вырезаем квадратную серединку по x, если фото горизонтальное
                if($w_src > $h_src)
                    imagecopyresampled($dest, $im, 0, 0,
                        round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                        0, $w, $w,    min($w_src,$h_src), min($w_src,$h_src));
                // вырезаем квадратную верхушку по y,
                // если фото вертикальное (хотя можно тоже серединку)
                if($w_src<$h_src)
                    imagecopyresampled($dest, $im, 0, 0,    0, 0, $w, $w,
                        min($w_src,$h_src),    min($w_src,$h_src));
                // квадратная картинка масштабируется без вырезок
                if ($w_src==$h_src)
                    imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);
                $date=time(); //вычисляем время в настоящий момент.
                imagejpeg($dest,$path_to_90_directory.$date.".jpg", 100);//сохраняем    изображение формата jpg в нужную папку, именем будет текущее время. Сделано,    чтобы у аватаров не было одинаковых имен.
//почему именно jpg? Он занимает очень мало места + уничтожается анимирование gif изображения, которое отвлекает пользователя. Не очень приятно читать его комментарий, когда краем глаза замечаешь какое-то    движение.
                $avatar = $path_to_90_directory.$date.".jpg";//заносим в переменную путь до аватара.
                $delfull = $path_to_90_directory.$filename;
                unlink ($delfull);//удаляем оригинал загруженного изображения, он нам больше не нужен. Задачей было - получить миниатюру.
                $ava = [
                    'avatar' => $avatar
                ];
                update('users', $id, $ava);
                $check = "1000-7";
            }
            else{
                //в случае несоответствия формата, выдаем соответствующее сообщение
                $msg_avatar = 'Неверный формат файла';
            }
            //конец процесса загрузки и присвоения переменной $avatar адреса    загруженной авы
        }
    }
}

    //$cur_date = date('d'.'m'.'y');
    //echo time();
    //test($user['created']);

else{
    header('Location: Registration2.php');
}
