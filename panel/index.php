<head>
    <title></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.16/d3.min.js"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>

<button type="button" value="click to toggle fullscreen" onclick="startListen()" style="
    top: 93px;
    position: absolute;
    z-index:1;
    font-size: 25px;

">▶️</button>

<script>
    var videos = [];
    var yid = 'sGkh1W5cbH4';
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height: '360',
            width: '640',
            videoId: yid,
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.

    var done = false;
    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.ENDED) {
            player.playVideo();
        }
    }
    function stopVideo() {
        player.stopVideo();
    }
    

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
</script>

<script>


    function startTimer(){
        var width = 400,
            height = 400,
            timePassed = 0,
            timeLimit = 60;

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


</script>

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
        if (result.isFinal) {
            let result_text = result[0].transcript.trim();
            if (videos[result_text]){
                yid = videos[result_text]
                player.loadVideoById(yid)
            }

            $.ajax({
                url: '../api',
                data:{
                    type:'locale',
                    text:result_text
                }
            })
            console.log('результат:', result_text);
        } else {
            console.log('Промежуточный результат:', result[0].transcript);
        }
    };

    let startListen = function(){
        // Начинаем слушать микрофон и распознавать голос
        recognizer.start();
    }

</script>

</body>