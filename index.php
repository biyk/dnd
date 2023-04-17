<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.16/d3.min.js"></script>

<link type="text/css" href="index.css">
<div class="container"></div>
<div id="player"></div>
<button type="button" value="click to toggle fullscreen" onclick="toggleFullScreen();player.playVideo();" style="
 
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
<script>
setInterval(()=>{
	let image = document.getElementById('image');
	let header =  makeRequest('HEAD','image.php');
	header.then((result)=> {
	    if (result===200) image.src='image.php'+'?'+Math.random();
    }, ()=>{console.log('error')})

}, 2000);

</script>

<script>
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
            videoId: 'MXhWSh8pTPA',
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        //event.target.playVideo();
        document.getElementById('player').style.display = 'none';
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