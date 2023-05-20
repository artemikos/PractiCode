<?php
include 'app/database-reg/database.php';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script language="javascript" type="text/javascript">

    <?php if(!isset($_SESSION['id'])): ?>
    function Transfer(id) {
        var entrance = "Registration2.php";

        document.location.href = entrance;
    }
    <?php endif; ?>
  function slowScroll(id) {
    var page = window.location.pathname;
    var substr = "index";
    if (page.includes(substr)) {
     $('html , body').animate({
     scrollTop: $(id).offset().top}, 750);
   }
   else {
     document.location.href="index.php";
   }
  }
  // проверка на скролл вниз чтобы изменить цвет шапки
  $(document).on("scroll", function(){
    if($(window).scrollTop() === 0)
      $("header").removeClass("fixed");
    else
    $("header").attr("class","fixed");
  });
</script>

<header class="clearfix">
  <div id="logo">
    <a onclick="slowScroll('#top')" id="index"><span>Practi.code</span></a>
  </div>
  <div>
    <nav id="links">
      <a href="rating.php" class="underline-one"><span>Рейтинг</span></a>
      <a href="task.php" class="underline-one"><span>Задания</span></a>
      <a href="AboutUs.php" class="underline-one"><span>О нас</span></a>
      <div class="dropdown">
          <?php if(isset($_SESSION['id'])): ?>
            <button class="dropbtn"><a id = "aut" onclick = "Transfer(id)">
                    <?php echo $_SESSION['login']; ?>
                </a></button>
            <div class="dropdown-content">
                <?php
                    if($_SESSION['admin'] === '1'):?>
                <a id = "adm" href="13admin.php">Админка</a>
                <?php endif; ?>
                <a id = "aut" href="Profile.php">Профиль</a>
                <a id = "reg" href="app/controllers/logout.php">Выход</a>
            </div>
          <?php else: ?>
              <button class="dropbtn"><a id = "aut" onclick = "Transfer(id)" class="underline-one">Регистрация</a></button>
              <div class="dropdown-content">
                  <!--<a id = "aut" onclick = "Transfer(id)">Авторизация</a>
                  <a id = "reg" onclick = "Transfer(id)">Регистрация</a>
              --></div>
          <?php endif; ?>
      </div>
    </nav>
  </div>
</header>
