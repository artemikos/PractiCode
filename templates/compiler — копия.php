<?php
include ("check_com.php");
?>

<!doctype html>
<html class="h-full bg-slate-900">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- install tailwindcss from cdn, don't do this for production application -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- install pyodide version 0.20.0 -->
    <script src="https://cdn.jsdelivr.net/pyodide/v0.21.3/full/pyodide.js"></script>
    <!-- import codemirror stylings -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.css" />
    <!-- install codemirror.js version /5.63.3 from cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.3/codemirror.min.js"
              integrity="sha512-XMlgZzPyVXf1I/wbGnofk1Hfdx+zAWyZjh6c21yGo/k1zNC4Ve6xcQnTDTCHrjFGsOrVicJsBURLYktVEu/8vQ=="
              crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- install codemirror python language support -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.3/mode/python/python.min.js"
              integrity="sha512-/mavDpedrvPG/0Grj2Ughxte/fsm42ZmZWWpHz1jCbzd5ECv8CB7PomGtw0NAnhHmE/lkDFkRMupjoohbKNA1Q=="
              crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- import codemirror dracula theme styles from cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.3/theme/dracula.css"/>

    <?php
    if(isset($_POST['button-submit-result'])):
    ?>
    <link rel="stylesheet" href="https://pyscript.net/latest/pyscript.css" />
    <script defer src="py-script.js"></script>
    <?php
    endif;
    ?>
    <style>
        .CodeMirror {
            height: 100%;
        }
        pre {
            tab-size: 4;
            -o-tab-size: 4;
            -moz-tab-size: 4;
        }
        .py-terminal {
            background-color: gray;
            color: yellow;
        }
        #py-internal-0{
            display: none;
        }


    </style>
</head>
<body class="h-full overflow-hidden max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8" style="overflow: visible">
<script>/**
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


<p class="text-slate-200 text-3xl my-4 font-extrabold mx-2 pt-8">Run Python in your browser</p>
    <!-- run button to pass the code to pyodide.runPython() -->
<form id="feedback" method="post" onsubmit="return false">
    <div class="h-3/4 flex flex-row">

        <div class="grid w-2/3 border-dashed border-2 border-slate-500 mx-2">
            <!-- our code editor, where codemirror renders it's editor -->
            <textarea id="code" name="code" class="h-full"></textarea>
        </div>
        <div class="grid w-1/3 border-dashed border-2 border-slate-500 mx-2">
            <!-- output section where we show the stdout of the python code execution -->
            <textarea readonly class="p-8 text-slate-200 bg-slate-900" id="output" name="output"></textarea>
        </div>


    </div>


    <button onclick="evaluatePython()" type="button" class="mx-2 my-4 h-12 px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm bg-green-700 hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-700 text-slate-300">Run</button>
    <!-- clean the output section -->
    <button onclick="clearHistory()" type="button" class="mx-2 my-4 h-12 px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm bg-red-700 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 text-slate-300">Clear History</button>
    <script src="/select/static/js/main.js"></script>
</form>



<form name="result" method="post">
    <textarea name="result_code" style="height: 400px; width: 600px" id="input"><?php
        if(isset($_POST['button-submit-result'])):
            echo $msg;
        endif;?></textarea>
    <button type="submit" name="button-submit-result">ОТПРАВИТЬ</button>
    <textarea name="res" class="answer" hidden><?php
        if(isset($_POST['button-submit-result'])):
            echo $task['answer'];
        endif;?></textarea>
    <py-script><?php
        if(isset($_POST['button-submit-result'])):
            echo $res;
        endif;
        ?></py-script>
    <py-terminal hidden></py-terminal>
</form>

<?php
if (isset($_POST['button-submit-result'])):
?>
<script type="text/javascript">

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function delayedGreeting() {
        await sleep(5000);
        //let output = document.getElementsByClassName("py-terminal")[0];
        let output = document.getElementsByClassName("py-terminal")[0];
        let out_str = output.textContent;
        console.log(out_str);

        let answer = document.getElementsByClassName('answer')[0];
        let ans_str = answer.textContent;
        console.log(ans_str);
        if (ans_str === out_str){
            alert("Успешно");
            window.location.href = "update_user_rating.php";
        }
        else{
            alert("При проверке с нашими данными произошла ошибка! Измените решение");
        }
    }

    delayedGreeting();
</script>
<?php endif; ?>


</body>
</html>