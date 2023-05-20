<!DOCTYPE html>
<html>
<head>
 <title>13 Сектор</title>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="css/13.css">
 <script src="https://kit.fontawesome.com/5454ea3fcb.js" crossorigin="anonymous"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
 <script language="javascript" type="text/javascript">
     function Change(id) {
       let arr = ["sector", "bug"];
       if (id === arr[0] || id===arr[1]) {
         if (id === arr[0]) {
           $ ("#" + arr[1]).css("display", "none");
         }
         else {
           $ ("#" + arr[0]).css("display", "none");
         }
         if (	$ ("#" + id).css("display") !== "block")
           $ ("#" + id).css("display", "block");
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
   include ("app/controllers/request_user_task.php");
   ?>

   <main>
     <div class="text">
       <p><span class="first">13 СЕКТОР! ЧТО ЭТО?!<br></span>
       <i class="fa-solid fa-circle-question"></i>
       <span class="t">СПЕЦИАЛЬНЫЙ РАЗДЕЛ!</span>
       <span>13 сектор является интерактивным разделом нашего сайта, где пользователи, то
         есть Вы, можете отправлять свои разнообразные задачки по указанной форме.
         Отправленные упражнения будут проверяться администрацией сайта, и в зависимости
         от некоторых критериев задание будет либо помещено в общий список, либо отклонено.
       <br></span></p>
     </div>
     <div class="text">
       <p>
       <i class="fa-solid fa-bug"></i>
       <span class="t">БАГ! МЫ НЕ ПРО ЖУКОВ!</span>
       <span> В данном разделе ты сможешь также поделиться с разработчиками о найденной проблеме
         в какой-либо задаче либо на самом ресурсе, а также предложить идею для нашего будещего
         развития!
       <br></span></p>
     </div>
     <div class="text">
       <p>
       <i class="fa-solid fa-star"></i>
       <span class="t">ВСЁ НЕ ЗРЯ!</span>
       <span> Вы не только делаете нас лучше, взаимодействуя с нашей командой,
            но и также за все ваши труды, изложенные выше, вы получаете приятный бонус
            в виде баллов в рейтинг (20 &ndash; за придуманное упражнение, 50 &ndash; за нахождение ошибки)!

       <br></span></p>
     </div>
     <div class="form">
       <button class="select" onclick="Change('sector')" type="button" name="select_13">Предложить задачу</button>
       <button class="select" onclick="Change('bug')" type="button" name="select_bug">Предложить идею</button>
         <p <?php if($check === 'h'): ?> class="good" <?php else: ?> class="error" <?php endif; ?> id="error1"><?= $msg ?></p>
     </div>
     <div class="text">

       <div id="sector">

           <form action="13.php" method="get">
                 <textarea onclick="Error('error1')" name="task" id="condition" placeholder="Введите условие вашей задачи" ></textarea>
                 <textarea onclick="Error('error1')" name="task_test" id="data" placeholder="Введите тестовые данные"></textarea>
                 <textarea onclick="Error('error1')" name="function" id="answer" placeholder="Введите ответ к вашей задаче - в виде функции"></textarea>
                 <button class="send" type="submit" name="button-send-task">Отправить</button>
           </form>
       </div>
       <div id="bug">
           <form action="13.php" method="get">
         <textarea onclick="Error('error1')" name="lvl" id="lvl" placeholder="Уровень сложности и номер задания, где была обнаружена ошибка"></textarea>
         <textarea onclick="Error('error1')" name="def" id="def" placeholder="Опишите в чём заключается ошибка"></textarea>
         <textarea onclick="Error('error1')" name="idea" id="idea" placeholder="Пожелания и идеи для улучшения проекта"></textarea>
         <button class="send" type="submit" name="button-send-bug">Отправить</button>
           </form>
       </div>
     </div>
   </main>

   <script>
   /**
    * Cимвол \t (tab ⇆ табуляция) в textarea при нажатии tab на клавиатуре.
    *
    * Добавляет началные отсутпы для выделенног текста при нажатии на клавишу `Tab`.
    * Или убирает начальный отступ (4пробела или TAB) при нажании на `Shift + Tab`.
    *
    * @Author Kama (wp-kama.ru)
    * @version 4.3
    */
   document.addEventListener( 'keydown', function( event ){

       if( 'TEXTAREA' !== event.target.tagName )
           return

       // not tab
       if( event.code !== 'Tab' )
           return

       event.preventDefault()

       // Opera, FireFox, Chrome
       let textarea     = event.target
       let selStart     = textarea.selectionStart
       let selEnd       = textarea.selectionEnd
       let before       = textarea.value.substring( 0, selStart )
       let slection     = textarea.value.substring( selStart, selEnd )
       let after        = textarea.value.substr( selEnd )
       let slection_new = ''

       // remove TAB indent
       if( event.shiftKey ){

           // fix selection
           let selectBefore = before.substr( before.lastIndexOf( '\n' ) + 1 )
           let isfix = /^\s/.test( selectBefore )
           if( isfix ){
               let fixed_selStart = selStart - selectBefore.length
               before   = textarea.value.substring( 0, fixed_selStart )
               slection = textarea.value.substring( fixed_selStart, selEnd )
           }

           let once = false
           slection_new = slection.replace( /^(\t|[ ]{2,4})/gm, ( mm )=>{

               if( isfix && ! once ){
                   once = true // do it once - for first line only
                   selStart -= mm.length
               }

               selEnd -= mm.length
               return ''
           })
       }
       // add TAB indent
       else {
           selStart++

           // has selection
           if( slection.trim() ){
               slection_new = slection.replace( /^/gm, ()=>{
                   selEnd++
                   return '\t'
               })
           }
           else {
               slection_new = '\t'
               selEnd++
           }
       }

       textarea.value = before + slection_new + after

       // cursor
       textarea.setSelectionRange( selStart, selEnd )
   });
   </script>

</body>
</html>
