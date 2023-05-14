<head>
    <title></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.16/d3.min.js"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
<button type="button" value="click to toggle fullscreen" onclick="startListen()" style="
    top: 12px;
    position: absolute;
    z-index:1;
    font-size: 25px;

">▶️</button>
<div class="container" style="margin-top: 54px;"><span class="js_pre_container"></span><br><textarea class="js_container"></textarea></div>


<script>
    // Создаем распознаватель
    var recognizer = new webkitSpeechRecognition();

    // Ставим опцию, чтобы распознавание началось ещё до того, как пользователь закончит говорить
    recognizer.interimResults = true;

    // Какой язык будем распознавать?
    recognizer.lang = 'ru-Ru';

    // Используем колбек для обработки результатов
    recognizer.onresult = function (event) {
        var result = event.results[event.resultIndex];
		$('.js_pre_container').text( result[0].transcript.trim());
		
        if (result.isFinal) {
            let result_text = result[0].transcript.trim().toLowerCase();
			$('.js_container').val( $('.js_container').val() +" "+result_text);
            $.ajax({
                url: '../api',
                data:{
                    type:'locale',
                    text:result_text,
                }
            })
		
            console.log('результат:', result_text);
        } else {
            //console.log('Промежуточный результат:', result[0].transcript);
        }
    };

	recognizer.onaudioend = function(){
		 setTimeout(()=>{
			 try {
					recognizer.start();
				} catch (err) {
					recognizer.abort();
					setTimeout(()=>{recognizer.start()},300);
					console.log(err)
				}
		},200)
	}


    let startListen = function(){
        // Начинаем слушать микрофон и распознавать голос
        recognizer.start();
    }

    let stopListen = function(){
        // Начинаем слушать микрофон и распознавать голос
        recognizer.abort();
    }

</script>

</body>