navigator.getUserMedia =(   navigator.getUserMedia ||
                            navigator.webkitGetUserMedia ||
                            navigator.mozGetUserMedia ||
                            navigator.msGetUserMedia);
var         video;
var         webcamStream;

function    startWebcam() {
    if (navigator.getUserMedia) {
        navigator.getUserMedia ({
           video: true,
           audio: false
        },
        function(localMediaStream) {
            video = document.querySelector('video');
            video.src = window.URL.createObjectURL(localMediaStream);
            webcamStream = localMediaStream;
        },
        function(error) {
           console.log("The following error occured: " + err);
        });
    } else {
        console.log("getUserMedia not supported");
    }  
}

function stopWebcam() {
    webcamStream.stop();
}

var canvas, ctx;

function init() {
    canvas = document.getElementById("myCanvas");
    ctx = canvas.getContext('2d');
}

function snapshot() {
    ctx.drawImage(video, 0,0, canvas.width, canvas.height);
    ctx.save();
}

function proccess_func(x) {
    // if (x.id == "none")
    // {
    //     ctx.restore();
    //     ctx.drawImage(video, 0,0, canvas.width, canvas.height);     
    // }
        ctx.restore();
        ctx.filter = x.id +'(100%)';
        ctx.drawImage(video,0,0, canvas.width, canvas.height);
        ctx.restore();
}
