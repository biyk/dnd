<head>
    <title></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.16/d3.min.js"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
<div class="container"></div>
<button type="button" value="click to toggle fullscreen" onclick="toggleFullScreen()" style="

    position: absolute;
    z-index:1;
    font-size: 25px;

">▢</button>
<button type="button" value="click to toggle fullscreen" onclick="startTimer()" style="
    top: 50px;
    position: absolute;
    z-index:1;
    font-size: 25px;

">▶️</button>


<img src="image.png" id="image" style="width: 100%;top: -7%;display: block;position: relative;">


<div id="player" style="display:none"></div>

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

    $(document).ready(function() {
        setInterval(()=>{
            let image = document.getElementById('image');
            let url = 'image.png';
            image.src='image.png'+'?'+Math.random();

            $.ajax({
                url:'config.php'+'?'+Math.random(),
                dataType : "json",
                success: function(json){
                    console.log(json,yid)
                    if (json && json.locale && json.videos[json.locale]!=yid) {
                        videos = json.videos;
                        yid = json.videos[json.locale]
                        player.loadVideoById(yid)
                    }
                }
            })
        }, 2000);
    });



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


</body>