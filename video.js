window.addEventListener("load", function() {

    var canvas, ctx, i = 0;
    canvas = document.getElementById("myCanvas");
    var pre = document.getElementById("preview");
    ctx = canvas.getContext('2d');



document.getElementById("c1").addEventListener("click", function(){
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
});

function removeElement(id) {
    var elem = document.getElementById(id);
    return elem.parentNode.removeChild(elem);
}

document.getElementById("c2").addEventListener("click", function()  {
    var pre = document.getElementById("preview");
    if (document.getElementById("temp"))
        removeElement("temp");
    ctx.drawImage(video, 0,0, canvas.width, canvas.height);
    var ss = convertCanvasToImage(canvas);
    pre.appendChild(ss);
});

function stopWebcam() {
    webcamStream.stop()
}

function stopman() {
    recorder.stop();
}





function convertCanvasToImage(canvas) {
	var image = new Image();
    image.src = canvas.toDataURL("image/png");
    image.setAttribute("alt", "myImage" + i++)
    image.setAttribute("style", "width: 100%; height:100%");
    // image.setAttribute("style", "height: 80%;");
    image.setAttribute("id", "temp");
	return image;
}

function mm() {
    var im = document.getElementById("myCanvas");
    im.removeAttribute("style",'-webkit-filter');
    document.getElementById("ff").reset();
}

function save(){

}});











function myFunc()
{

    var imy = document.getElementById("temp");
    
    var Blur = document.getElementById("blur");
    var Brightness = document.getElementById("brightness");
    var Saturate = document.getElementById("saturate");
    var Hue = document.getElementById("hue-rotate");
    var Contrast = document.getElementById("contrast");
    var Invert = document.getElementById("invert");
    var Grayscale = document.getElementById("grayscale");
    var Sepia = document.getElementById("sepia");
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
    imy.setAttribute("style",'-webkit-filter: blur(' + Blur.value + 'px)brightness('
                                                + Brightness.value + ')saturate('
                                                + Saturate.value + '%)hue-rotate('
                                                + Hue.value + 'deg)contrast('
                                                + Contrast.value + '%)invert('
                                                + Invert.value + '%)grayscale('
                                                + Grayscale.value + '%)sepia('
                                                + Sepia.value + '%)');
}