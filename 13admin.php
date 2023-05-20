<!DOCTYPE html>
<html>
<head>
 <title>Админ. панель</title>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="css/13AdminPanel.css">
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
      include("app/controllers/admin/sector_admin.php")
      ?>

   <main>
     <p class="simple">Задача от пользователя</p>
     <p id="error1" class="error"><?= $msg ?></p>
     <div class="text">
         <form action="13admin.php" method="get">
       <div id="sector">
           <?php if($user_task): ?>
         <textarea name="descript" onclick="Error('error1')" id="condition" placeholder="Условие задачи"><?= $user_task['descript'] ?></textarea>
         <textarea name="user_function" onclick="Error('error1')" id="answer" placeholder="Ответ к задаче - в виде функции"><?= $user_task['user_func'] ?></textarea>
         <textarea name="test" onclick="Error('error1')" id="data" placeholder="Тестовые данные"><?= $user_task['test'] ?></textarea>
           <?php else: ?>
           <textarea name="descript" onclick="Error('error1')" id="condition" placeholder="Условие задачи"></textarea>
           <textarea name="user_function" onclick="Error('error1')" id="answer" placeholder="Ответ к задаче - в виде функции"></textarea>
           <textarea name="test" onclick="Error('error1')" id="data" placeholder="Тестовые данные"></textarea>
           <?php endif; ?>
           <textarea name="user_answer" onclick="Error('error1')" id="data" placeholder="Ответ задачи"></textarea>
         <p class="d">Сложность: </p>
         <div class="diff">
           <input type="radio" id="easy" name="difficulty" value="easy">
           <label for="easy">Easy</label><br>
           <input type="radio" id="hard" name="difficulty" value="hard">
           <label for="hard">Hard</label>
         </div>
            <button class="send" type="submit" name="button-send-task">Отправить</button>
            <button class="reset" type="submit" name="button-cancel-1">Отмена</button>

       </div>
         </form>
       <p class="simple">Идея/ошибка, найденная пользователем</p>
       <div id="bug">
           <form action="13admin.php" method="get">
               <?php if($user_reports): ?>
               <textarea onclick="Error('error1')" id="lvl" placeholder="Уровень сложности и номер задания, где была обнаружена ошибка"><?= $user_reports['test'] ?></textarea>
               <textarea onclick="Error('error1')" id="def" placeholder="Опишите в чём заключается ошибка"><?= $user_reports['descript'] ?></textarea>
               <textarea onclick="Error('error1')" id="idea" placeholder="Пожелания и идеи для улучшения проекта"><?= $user_reports['user_func'] ?></textarea>
               <?php else: ?>
               <textarea onclick="Error('error1')" id="lvl" placeholder="Уровень сложности и номер задания, где была обнаружена ошибка"></textarea>
               <textarea onclick="Error('error1')" id="def" placeholder="Опишите в чём заключается ошибка"></textarea>
               <textarea onclick="Error('error1')" id="idea" placeholder="Пожелания и идеи для улучшения проекта"></textarea>
                <?php endif; ?>
               <button class="send" type="submit" name="button-send-bug">Отправить</button>
               <button class="reset" type="submit" name="button-cancel-2">Отмена</button>
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
