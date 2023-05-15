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


<img src="image.png" id="image" style="width: 100%;top: -7%;display: block;position: relative;">
<img src="image.png" id="demo" style="width: 30%;right: 0%;display: block;position: absolute;top: 0px;border: 3px solid red;">
<audio id="audio_player" src style="display:none;"></audio>

<div id="player" style="display:none"></div>

<script>
    var videos = {};
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




</script>
<script src="index.js"></script>
<link rel="stylesheet" type="text/css" href="index.css?v=3.0.95">

</body>