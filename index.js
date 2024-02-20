function makeRequest(method, url) {
    return new Promise(function (resolve, reject) {
        let xhr = new XMLHttpRequest();
        xhr.open(method, url);
        xhr.onload = function () {
            if (this.status >= 200 && this.status < 300) {
                resolve(this.status);
            } else {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            }
        };
        xhr.onerror = function () {
            reject({
                status: this.status,
                statusText: xhr.statusText
            });
        };
        xhr.send();
    });
}

let reloadImage = ()=>{
    let image = document.getElementById('image');
    let url = 'image.png';
    if (image) image.src='image.png'+'?'+Math.random();
}

let developMode = ()=>{

}
let reloadVideo = ()=>{
    $.ajax({
        url:'json/videos.json'+'?'+Math.random(),
        dataType : "json",
        success: function(json){
            videos = json;
        }
    });
}

function toDataURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result);
        }
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
}

toDataURL('https://www.gravatar.com/avatar/d50c83cc0c6523b4d3f6085295c953e0', function(dataUrl) {
    console.log('RESULT:', dataUrl)
})


function UrlExists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}

function toggleFullScreen() {
    player.playVideo();
    if ((document.fullScreenElement && document.fullScreenElement !== null) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}


function startTimer(timeLimit=60){
    var width = 400,
        height = 400,
        timePassed = 0;

    var fields = [{
        value: timeLimit,
        size: timeLimit,
        update: function() {
            return timePassed = timePassed + 1;
        }
    }];

    var nilArc = d3.svg.arc()
        .innerRadius(width / 3 - 133)
        .outerRadius(width / 3 - 133)
        .startAngle(0)
        .endAngle(2 * Math.PI);

    var arc = d3.svg.arc()
        .innerRadius(width / 3 - 55)
        .outerRadius(width / 3 - 25)
        .startAngle(0)
        .endAngle(function(d) {
            return ((d.value / d.size) * 2 * Math.PI);
        });

    var svg = d3.select(".container").append("svg")
        .attr("width", width)
        .attr("height", height);

    var field = svg.selectAll(".field")
        .data(fields)
        .enter().append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
        .attr("class", "field");

    var back = field.append("path")
        .attr("class", "path path--background")
        .attr("d", arc);

    var path = field.append("path")
        .attr("class", "path path--foreground");

    var label = field.append("text")
        .attr("class", "label")
        .attr("dy", ".35em");

    (function update() {

        field
            .each(function(d) {
                d.previous = d.value, d.value = d.update(timePassed);
            });

        path.transition()
            .ease("elastic")
            .duration(500)
            .attrTween("d", arcTween);

        if ((timeLimit - timePassed) <= 10)
            pulseText();
        else
            label
                .text(function(d) {
                    return d.size - d.value;
                });

        if (timePassed <= timeLimit)
            setTimeout(update, 1000 - (timePassed % 1000));
        else
        {
            //timePassed = 0
            destroyTimer();
        }

    })();

    function pulseText() {
        back.classed("pulse", true);
        label.classed("pulse", true);

        if ((timeLimit - timePassed) >= 0) {
            label.style("font-size", "120px")
                .attr("transform", "translate(0," + +4 + ")")
                .text(function(d) {
                    return d.size - d.value;
                });
        }

        label.transition()
            .ease("elastic")
            .duration(900)
            .style("font-size", "90px")
            .attr("transform", "translate(0," + -10 + ")");
    }

    function destroyTimer() {
        label.transition()
            .ease("back")
            .duration(700)
            .style("opacity", "0")
            .style("font-size", "5")
            .attr("transform", "translate(0," + -40 + ")")
            .each("end", function() {
                field.selectAll("text").remove()
            });

        path.transition()
            .ease("back")
            .duration(700)
            .attr("d", nilArc);

        back.transition()
            .ease("back")
            .duration(700)
            .attr("d", nilArc)
            .each("end", function() {
                field.selectAll("path").remove()
            });

        document.getElementsByClassName('container')[0].innerHTML = '';
    }

    function arcTween(b) {
        var i = d3.interpolate({
            value: b.previous
        }, b);
        return function(t) {
            return arc(i(t));
        };
    }
}

function checkConfig() {
    $.ajax({
        url: 'config.php' + '?' + Math.random(),
        dataType: "json",
        success: function (json) {
            //console.re.log(json, yid)
            if (json.command) {
                eval(json.command);
            }
            if (json.locale && json.locale != yid) {
                yid = json.locale;
                player.loadVideoById(yid);
				
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            //console.error("Error loading config.php:", textStatus, errorThrown);
        }
    });
}


function checkInit() {
    $.ajax({
        url: 'api/json.php?file=init.json' + '&' + Math.random(),
        dataType: "json",
        success: function (json) {
			let round = json.round;
			let _try = json.try;
			if (round && _try){
				let current = json.all.filter(e=>e.init==json.try)[0];
				let next = json.all.filter(e=>e.init==json.next)[0];
				$('.js-init').html('Раунд:'+json.round+'| Ход: '+current.name+'| Далее: '+next.name).show();
			} else {
				$('.js-init').hide();
			}
            showAlert(json.rating);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.error("Error loading config.php:", textStatus, errorThrown);
        }
    });
}

function checkTime() {
    $.ajax({
        url: 'api/?time=0&type=time',
        dataType: "json",
        success: function (json) {

            $('.now-time').text(json.currentDateTime);
        },
        error: function (xhr, textStatus, errorThrown) {
            //console.error("Error loading config.php:", textStatus, errorThrown);
        }
    });
}

function checkMap() {
    $.ajax({
        url: 'api/json.php?file=map.json' + '&' + Math.random(),
        dataType: "json",
        success: function (json) {
			$.each(json, function(chunk,e){
				if (e=='true'){
					$('#'+chunk).css('opacity',1);
				} else {
					$('#'+chunk).css('opacity',0);
				}
			})
        },
        error: function (xhr, textStatus, errorThrown) {
            console.error("Error loading map.json:", textStatus, errorThrown);
        }
    });
}

function loadDemo(src=null){
    if (src){
        $('#demo').css('opacity',1).attr('src',src).stop().animate({
            opacity:0
        }, 15*60*1000);
    }
}


function showMapChunk(chunk = null){
	$('#'+chunk).css('opacity',1);
}

$(document).ready(function() {

    reloadImage();
    reloadVideo();
    setInterval(checkConfig, 2000);
    setInterval(checkMap, 2000);
    setInterval(checkInit, 2000);
    setInterval(checkTime, 2000);



    listenKeys();
});


function loadMapPos(){
    $.ajax({
        url: 'api/json.php?file=map_position.json' + '&' + Math.random(),
        dataType: "json",
        success: function (json) {
            console.log(json);
            let {css_left, css_top,scale,hash} = json
            $('.map-wrapper').css({
                left:css_left,
                top:css_top,
                transform:'scale('+scale+')',
            });
            $('.allhash').toggle(hash=='true');

        },
        error: function (xhr, textStatus, errorThrown) {
            console.error("Error loading map.json:", textStatus, errorThrown);
        }
    });
}

function listenKeys() {

    loadMapPos();

    $('.floating-buttons button').on('click', function () {
        let div = 50;
        let $wrapper = $('.map-wrapper');
        let css_top = parseInt($wrapper.css('top'));
        let css_left = parseInt($wrapper.css('left'));
        let scale = parseMatrixTransform($wrapper.css('transform')) ? parseMatrixTransform($wrapper.css('transform')).scaleX : 1;
        let $this = $(this);
        if ($this.hasClass('left')) {
            css_left+=div;
            $wrapper.css({left:css_left});
        }
        if ($this.hasClass('up')) {
            css_top += div;
            $wrapper.css({top:css_top})
        }
        if ($this.hasClass('down')) {
            css_top-=div;
            $wrapper.css({top:css_top})
        }
        if ($this.hasClass('right')) {
            css_left-=div;
            $wrapper.css({left:css_left})
        }
        if ($this.hasClass('plus')) {
            scale+=0.1;
            $wrapper.css({transform:'scale('+scale+')'})
        }
        if ($this.hasClass('minus')) {
            scale-=0.1;
            $wrapper.css({transform:'scale('+scale+')'})
        }
        if ($this.hasClass('hash')) {
            $('.allhash').toggle();
        }

        $.ajax({
            url:'api/',
            data: {
                scale,
                css_top,
                css_left,
                hash:$('.allhash').is(':visible'),
                type: 'map_position'
            }
        });

    });
}


function parseMatrixTransform(matrixValue) {
    // Разбиваем строку на массив чисел, используя регулярное выражение
    var matches = matrixValue.match(/^matrix\((.+)\)$/);
    if (matches) {
        // Разбиваем полученные числа по запятой и удаляем лишние пробелы
        var nums = matches[1].split(',').map(function(num) {
            return parseFloat(num.trim());
        });
        // Возвращаем объект с коэффициентами масштабирования по осям X и Y
        return {
            scaleX: nums[0],
            scaleY: nums[3]
        };
    } else {
        return null; // Возвращаем null, если строка не соответствует ожидаемому формату
    }
}


function showAlert(num= 0) {
    $('[name="rating"]').prop('checked', false);
    $('.rating-area').toggle(num>0);
    if (num) {
        $('[name="rating"][value="'+num+'"]').prop('checked', 'checked')
    }
}

/**
 * Показывает страницу с подсказкой
 */
function shoPage(page=null){
    if (page){
        $('#helper').attr('src',page).show();
    }
}