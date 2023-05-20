<!DOCTYPE html>
<html>
<head>
 <title>Hard</title>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="css/hard.css">
 <script src="https://kit.fontawesome.com/5454ea3fcb.js" crossorigin="anonymous"></script>
</head>
<body>

  <?php include("header.php");
  include("app/controllers/task_choice/hard_tasks.php");
  ?>

   <main>
       <div class="text">
           <p><span class="first">УРОВЕНЬ: HARD<br></span>
               <i class="fa-solid fa-weight-hanging"></i>
               <span class="t">ШАРИШЬ ЗА СЛОЖНЫЕ ЗАДАЧИ? ТЕБЕ СЮДА!</span>
               <span> Мы разработали множество разнообразных задач, выполняя которые, Вы сможете
         ещё лучше понимать то, как устроена та или иная конструкция и когда именно стоит
         её использовать!
       <br></span></p>
       </div>
     <div class="text">
       <p>
       <i class="fa-solid fa-brain"></i>
       <span class="t">ПРАКТИКА &ndash; НАШЕ ВСЁ!</span>
       <span> Порою даже хорошему программисту нужна ежедневная практика, и этот раздел полностью
         соответствует данному тезису: вариативные упражнения на всевозможные методы и алгоритмы,
         которые расшевелят ваши извилины и заставят вспомнить забытое!
       <br></span></p>
     </div>
     <div class="text">
       <p>
       <i class="fa-solid fa-star"></i>
       <span class="t">СДЕЛАЛ ДЕЛО &ndash; ГУЛЯЙ СМЕЛО!</span>
       <span> Выполняя задачки данного раздела, Вы не только прокачиваете себя, как кодера и
            программиста, но и также получаете приятный бонус в виде 15 баллов в общий рейтинг пользователей
            сайта!
       <br></span></p>
     </div>
     <div id="dd" class="wrapper-dropdown-5">
        Выбрать задание
        <ul class="dropdown">
            <?php for($i = 0; $i < count($hard_tasks); $i++):
                $c = 0;
                for($j = 0; $j < count($completed_tasks); $j++):
                    if($hard_tasks[$i]['id'] === $completed_tasks[$j]['id_task']):
                        $c = 1;
                        break;
                    endif;
                endfor;
                if($c == 0):?>
                    <li><a href="templates/compiler.php?number=<?= $hard_tasks[$i]['id'] ?>">Задание <?= $i+1 ?></a></li>
                <?php else: ?>
                    <li><i class="fa-solid fa-check"></i><a class="done" href="templates/compiler.php?number=<?= $hard_tasks[$i]['id'] ?>">Задание <?= $i+1 ?></a></li>
                <?php endif; endfor; ?>
        </ul>
      </div>
      <div class="empty">&#160;</div>
   </main>

   <script type="text/javascript">
      function DropDown(el) {
        this.dd = el;
        this.initEvents();
        }
        DropDown.prototype = {
        initEvents : function() {
          var obj = this;

          obj.dd.on('click', function(event){
              $(this).toggleClass('active');
              event.stopPropagation();
          });
        }
      }
      $(function() {

				var dd = new DropDown( $('#dd') );

				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-5').removeClass('active');
				});

			});
   </script>

</body>
</html>
