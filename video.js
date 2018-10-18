function startWebcam() {
    var video = document.querySelector('video');
    var constraints = window.constraints = {audio: false, video: true};
    var errorElement = document.querySelector('#errorMsg');

    navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
    var videoTracks = stream.getVideoTracks();
    console.log('Got stream with constraints:', constraints);
    console.log('Using video device: ' + videoTracks[0].label);
    stream.onremovetrack = function() {
        console.log('Stream ended');
    };
    window.stream = stream;
      video.srcObject = stream;
    })
    .catch(function(error) {
      if (error.name === 'ConstraintNotSatisfiedError') {
        errorMsg('The resolution ' + constraints.video.width.exact + 'x' +
            constraints.video.width.exact + ' px is not supported by your device.');
      } else if (error.name === 'PermissionDeniedError') {
        errorMsg('Permissions have not been granted to use your camera and ' +
          'microphone, you need to allow the page access to your devices in ' +
          'order for the demo to work.');
      }
      errorMsg('getUserMedia error: ' + error.name, error);
    });

    function errorMsg(msg, error) {
      errorElement.innerHTML += '<p>' + msg + '</p>';
      if (typeof error !== 'undefined') {
        console.error(error);
      }
    }
}
var recorder = new MediaRecorder(stream);

recorder.addEventListener('dataavailable', function(e) {
    // e.data contains the audio data! let's associate it to an <audio> element
    var el = document.querySelector('audio');
    el.src = URL.createObjectURL(e.data);
});




function stopWebcam() {
    recorder.start();
}

function stopman() {
    recorder.stop();
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

function convertCanvasToImage(canvas) {
	var image = new Image();
	image.src = canvas.toDataURL("image/png");
	return image;
}

function mm() {
    var im = document.getElementById("myCanvas");
    im.removeAttribute("style",'-webkit-filter');
    document.getElementById("ff").reset();
}

function myFunc()
{

    var imy = document.getElementById("myCanvas");


    
    var Blur = document.getElementById("blur").value;
    var Brightness = document.getElementById("brightness").value;
    var Saturate = document.getElementById("saturate").value;
    var Hue = document.getElementById("hue-rotate").value;
    var Contrast = document.getElementById("contrast").value;
    var Invert = document.getElementById("invert").value;
    var Grayscale = document.getElementById("grayscale").value;
    var Sepia = document.getElementById("sepia").value;
    imy.setAttribute("style",'-webkit-filter: blur(' + Blur + 'px)brightness('
                                                + Brightness + ')saturate('
                                                + Saturate + '%)hue-rotate('
                                                + Hue + 'deg)contrast('
                                                + Contrast + '%)invert('
                                                + Invert + '%)grayscale('
                                                + Grayscale + '%)sepia('
                                                + Sepia + '%)');
    imy.setAttribute("style",'-webkit-filter: blur(' + Blur.value + 'px)brightness('
                                                + Brightness.value + ')saturate('
                                                + Saturate.value + '%)hue-rotate('
                                                + Hue.value + 'deg)contrast('
                                                + Contrast.value + '%)invert('
                                                + Invert.value + '%)grayscale('
                                                + Grayscale.value + '%)sepia('
                                                + Sepia.value + '%)');
    imy.setAttribute("style",'-webkit-filter: blur(' + Blur.value + 'px)brightness('
                                                + Brightness.value + ')saturate('
                                                + Saturate.value + '%)hue-rotate('
                                                + Hue.value + 'deg)contrast('
                                                + Contrast.value + '%)invert('
                                                + Invert.value + '%)grayscale('
                                                + Grayscale.value + '%)sepia('
                                                + Sepia.value + '%)');
}

