$(function() {
	"use strict";
	$(".mobile-search-icon").on("click", function() {
		$(".search-bar").addClass("full-search-bar")
	}), $(".search-close").on("click", function() {
		$(".search-bar").removeClass("full-search-bar")
	}), $(".mobile-toggle-menu").on("click", function() {
		$(".wrapper").addClass("toggled")
	}), $(".toggle-icon").click(function() {
		$(".wrapper").hasClass("toggled") ? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover")) : ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function() {
			$(".wrapper").addClass("sidebar-hovered")
		}, function() {
			$(".wrapper").removeClass("sidebar-hovered")
		}))
	}), $(document).ready(function() {
		$(window).on("scroll", function() {
			$(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
		}), $(".back-to-top").on("click", function() {
			return $("html, body").animate({
				scrollTop: 0
			}, 600), !1
		})
	}),

	$(document).ready(function () {
			$(window).on("scroll", function () {
				if ($(this).scrollTop() > 60) {
					$('.topbar').addClass('bg-dark');
				} else {
					$('.topbar').removeClass('bg-dark');
				}
			});
			$('.back-to-top').on("click", function () {
				$("html, body").animate({
					scrollTop: 0
				}, 600);
				return false;
			});
		});


	$(function() {
		for (var e = window.location, o = $(".metismenu li a").filter(function() {
				return this.href == e
			}).addClass("").parent().addClass("mm-active"); o.is("li");) o = o.parent("").addClass("mm-show").parent("").addClass("mm-active")
	}), $(function() {
		//$("#menu").metisMenu()
	}), $(".chat-toggle-btn").on("click", function() {
		$(".chat-wrapper").toggleClass("chat-toggled")
	}), $(".chat-toggle-btn-mobile").on("click", function() {
		$(".chat-wrapper").removeClass("chat-toggled")
	}), $(".email-toggle-btn").on("click", function() {
		$(".email-wrapper").toggleClass("email-toggled")
	}), $(".email-toggle-btn-mobile").on("click", function() {
		$(".email-wrapper").removeClass("email-toggled")
	}), $(".compose-mail-btn").on("click", function() {
		$(".compose-mail-popup").show()
	}), $(".compose-mail-close").on("click", function() {
		$(".compose-mail-popup").hide()
	}), $(".switcher-btn").on("click", function() {
		$(".switcher-wrapper").toggleClass("switcher-toggled")
	}), $(".close-switcher").on("click", function() {
		$(".switcher-wrapper").removeClass("switcher-toggled")
	}),


	$('#theme1').click(theme1);
    $('#theme2').click(theme2);
    $('#theme3').click(theme3);
    $('#theme4').click(theme4);
    $('#theme5').click(theme5);
    $('#theme6').click(theme6);
    $('#theme7').click(theme7);
    $('#theme8').click(theme8);
    $('#theme9').click(theme9);
    $('#theme10').click(theme10);
    $('#theme11').click(theme11);
    $('#theme12').click(theme12);


    function theme1() {
      $('body').attr('class', 'bg-theme bg-theme1');
    }

    function theme2() {
      $('body').attr('class', 'bg-theme bg-theme2');
    }

    function theme3() {
      $('body').attr('class', 'bg-theme bg-theme3');
    }

    function theme4() {
      $('body').attr('class', 'bg-theme bg-theme4');
    }
	
	function theme5() {
      $('body').attr('class', 'bg-theme bg-theme5');
    }
	
	function theme6() {
      $('body').attr('class', 'bg-theme bg-theme6');
    }

    function theme7() {
      $('body').attr('class', 'bg-theme bg-theme7');
    }

    function theme8() {
      $('body').attr('class', 'bg-theme bg-theme8');
    }

    function theme9() {
      $('body').attr('class', 'bg-theme bg-theme9');
    }

    function theme10() {
      $('body').attr('class', 'bg-theme bg-theme10');
    }

    function theme11() {
      $('body').attr('class', 'bg-theme bg-theme11');
    }

    function theme12() {
      $('body').attr('class', 'bg-theme bg-theme12');
    }


	$('.js_map_chunk').on('click', function(){
		let $this = $(this);
		let chunk = $this.val();
		let checked = $this.is(':checked');
		
		if(checked) {
			$('#'+chunk).css('opacity',1);
		} else {
			$('#'+chunk).css('opacity',0.3);	
		}
		$.ajax({
			url:'../api',
			data:{
				type:'map',
				chunk,
				checked
			}
		});
	});

	$('.js_save_videos').on('click', function () {
		let videos = {};
		$('.js_video').each(function () {
			let $this = $(this);
			let key = $this.find('[name="key"]').val();
			let video = $this.find('[name="video"]').val();

			if (video){
				videos[video] = key;
				$this.removeClass('empty');
			}
		});

		if ($('.js_video.empty').length==0){
			$('.js_video:last').after($('#new_video').html())
		}

		$.ajax({
			url:'../api',
			data:{
				type:'videos',
				videos
			}
		})
	});

	$('[name="selectVideo"]').on('click', function () {
		let $radio = $('[name="selectVideo"]:checked');
		let key = $radio.siblings('[name="key"]').val();
		$.ajax({
			url: '../api',
			data:{
				type:'locale',
				text:key,
			}
		})
	})

	$('#init_reset').on('click', function () {
		init = init || [];
		init.round = 0;
		init.try = null;
		init.all.map(item=>item.init=0);
		$.ajax({
			url:'../api',
			data:{
				type:'init',
				init
			}
		});
		$('.js-row-init').val('');
		$('.js-row-surprise').val('');
		saveInit();
	});

	$('#new_line').on('click', function () {
		let template = $('.js-init-row:last')[0].outerHTML;
		let $template = $(template)
		$template.find('.js-row-player').attr('checked',false);
		$template.find('.js-row-init').val('');
		$template.find('.js-row-name').val('');
		$('.js-init-row:last').after($template);
	});

	let checkRows = function () {
		$('.js-init-row').each(function () {
			let $this = $(this);
			let init = parseFloat($this.find('.js-row-init').val());
			let $doubles = $('.js-init-row').filter(function () {
				return $(this).find('.js-row-init').val() == init;
			});

			if ($doubles.length>1){
				$this.find('.js-row-init').val(Math.round(10*(init+0.1))/10);
				checkRows();
			}
		});
	}
	
	let saveInit = function(){
		init = init || [];
		init.all = [];
		init.try = init.try || '';
		init.next = getNextTry() || tryInfo['max'];

		$('.js-init-row').each(function () {
			let $this = $(this);
			init.all.push({
				init: $this.find('.js-row-init').val(),
				name: $this.find('.js-row-name').val(),
				player: $this.find('.js-row-player').is(':checked'),
				surprise: $this.find('.js-row-surprise').is(':checked'),
			});
		});

		init.rating = $('.js-rating').val();

		$.ajax({
			url:'../api',
			data:{
				type:'init',
				init
			}
		});
		drowRows();
	}

	let drowRows = function () {
		$('.js-init-row').removeClass('current next');
		$('.js-init-row').filter(function () {
			return $(this).find('.js-row-init').val()==init.try
		}).addClass('current');


		let next_try = getNextTry() || tryInfo['max'];

		$('.js-init-row').filter(function () {
			return $(this).find('.js-row-init').val()==next_try
		}).addClass('next');

		$('.js-init-round').text(init.round);
		if (tryInfo['init'][init.try]) $('.js-init-current').text(tryInfo['init'][init.try].name);
		if (tryInfo['init'][next_try]) $('.js-init-next').text(tryInfo['init'][next_try].name);
	}

	function getNextTry() {
		let next_try = 0;
		$.each(tryInfo['init'], (i, e) =>{
			let local_init = parseFloat(e.init);

			if (local_init < parseFloat(init.try) ) {
				next_try =  Math.max(next_try,local_init);
			}
		});
		next_try = next_try || null;
		console.log(next_try);
		return next_try;
	}


	$('.js-init-round').on('click', function(){
		init = init || [];
		let round = init.round = prompt('Номер раунда', init.round);
		init.try='';
		$('.js-init-round').text(round);
		saveInit();
	})
	$('#save_config').on('click', function () {
		checkRows();
		saveInit();
	});

	$('.js-remove-line').on('click', function(){
		$(this).parents('.js-init-row').remove();
		saveInit();
	});
	let tryInfo = {init:{}};

	function getTryInfo(){
		tryInfo = {init:{}};
		init.all.map(e=>{
			if (init.round==0){
				//console.log(e.surprise);
				if (e.surprise){
					let myInit = parseFloat(e.init);
					tryInfo['min'] = tryInfo['min']?Math.min(tryInfo['min'],myInit) : myInit;
					tryInfo['max'] = tryInfo['max']?Math.max(tryInfo['max'],myInit) : myInit;
					tryInfo['init'][myInit] = e;
				}
			} else {
				let myInit = parseFloat(e.init);
				tryInfo['min'] = tryInfo['min']?Math.min(tryInfo['min'],myInit) : myInit;
				tryInfo['max'] = tryInfo['max']?Math.max(tryInfo['max'],myInit) : myInit;
				tryInfo['init'][myInit] = e;
			}

		});
	}

	$('.js-lets-play').on('click', function () {
		//определяем какой это раунд
		window.temp = init;
		getTryInfo();

		// если битва еще не началась
		if(!init.try) {
			console.log('go');
			init.try = tryInfo['max'];
		} else {
			//поиск следующего игрока
			let next_try = getNextTry();
			console.log('next_try '+next_try);
			if (next_try) {
				init.try = next_try;
			} else {//если его нет следующий рануд и берем первого
				init.try = tryInfo['max'];
				init.round++;
			}
		}
		getTryInfo()
		console.log(init);
		saveInit();
		
	});

	$('.js-show-demo').on('click', function () {
		let {src} = $(this).data();
		$.ajax({
			url: '../api',
			data:{
				type:'demo',
				src
			}
		});
	});

	$('.js-get-event').on('click', function () {
		let $this = $(this);
		let id = $this.attr('id');
		let data = {
			location: $('[name="location"]').val()
		};
		let {url} = $this.data();

		$.ajax({
			url:url+'?'+Math.random(),
			data,
			success: function (text) {
				let $ta = $(`textarea[aria-describedby="${id}"]`).height(27);
				$ta.text(text);
				console.log(
					$ta.css('height', $ta[0].scrollHeight)
				)
			}
		})
	});


	$('.js-select-map').on('change', function () {
		let map = $(this).val();
		$.ajax({
			url: '../api',
			data:{
				type:'settings',
				map
			}
		});
	});

});

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
	$('[onclick="startListen()"]').text('🔴')
}

let stopListen = function(){
	// Начинаем слушать микрофон и распознавать голос
	recognizer.abort();
}


$(document).ready(function() {
	var dropArea = document.getElementById('drop-area');

	// Предотвращаем стандартное поведение браузера при перетаскивании
	['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
		dropArea.addEventListener(eventName, preventDefaults, false)
	});

	function preventDefaults (e) {
		e.preventDefault()
		e.stopPropagation()
	}

	// Обрабатываем перетаскивание файла
	dropArea.addEventListener('drop', handleDrop, false)

	function handleDrop(e) {
		let dt = e.dataTransfer
		let files = dt.files
		console.log(e);
		handleFiles(files)
	}

	// Обрабатываем выбранные файлы
	function handleFiles(files) {
		for (let i = 0; i < files.length; i++) {
			let file = files[i]

			// Проверяем, что выбранный файл - изображение
			if (file.type.match('image.*')) {
				let reader = new FileReader()

				// Читаем файл как Data URL
				reader.readAsDataURL(file)
				reader.onload = function () {

					let src = reader.result;

					$.ajax({
						method: 'POST',
						url: '../api/',
						data:{
							type:'demo',
							src
						}
					});
				}
			}
		}
	}
});