<head>
    <title></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.16/d3.min.js"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
	<script src="//console.re/connector.js" data-channel="try-00cd-61d3-d316" id="consolerescript"></script>
</head>
<body style="margin: 0px">
<div class="container" style="z-index:100;"></div>
<button type="button" value="click to toggle fullscreen" onclick="toggleFullScreen()"
        style="position: absolute;z-index:100;font-size: 25px;"
>▢</button>
<span
        style="position: absolute;z-index:100;font-size: 18px;left: 39px;color: chartreuse;"
        class="js-init"
></span>
<div class="map-wrapper" style="position: relative">
    <?php
    $files = glob("img/*.*");
    foreach ($files as $num=>$filename) {
		$temp = explode('/',$filename);
		$id = md5(end($temp));
        ?>
        <img style="
            width: 100%;
            position:absolute;
			transition: opacity 10s, visibility 0.3s;
			opacity:0;
            z-index: <?=count($files)-$num;?>" 
			id="<?=$id?>"
			src="<?=$filename?>" class="d-block w-100 in_block" alt="...">

        <?php
    }
    ?>
</div>

<img src="image.png" id="image" style="width: 100%;top: -7%;display: block;position: relative;">
<img src="image.png" id="demo" style="opacity:0;z-index:100;width: 30%;right: 0%;display: block;position: absolute;top: 0px;border: 3px solid red;">
<audio id="audio_player" src style="display:none;"></audio>

<div id="player" style=""></div>
<div class="rating-area">
    <input type="radio" id="star-5" name="rating" value="5" >
    <label for="star-5" title="Оценка «5»"></label>
    <input type="radio" id="star-4" name="rating" value="4">
    <label for="star-4" title="Оценка «4»"></label>
    <input type="radio" id="star-3" name="rating" value="3">
    <label for="star-3" title="Оценка «3»"></label>
    <input type="radio" id="star-2" name="rating" value="2">
    <label for="star-2" title="Оценка «2»"></label>
    <input type="radio" id="star-1" name="rating" value="1" checked>
    <label for="star-1" title="Оценка «1»"></label>
</div>
<script>
    var videos = {};
    var yid = 'ncdK57339l0';
    var yid = 'dXIyMS61B68';
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

        window.YTLoaded = true;
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
<script src="index.js?<?=time()?>"></script>
<link rel="stylesheet" type="text/css" href="index.css?v=3.0.95">

</body>