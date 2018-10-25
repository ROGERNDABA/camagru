var canvas, ctx, i = 0;
function removeElement(id) {
    var elem = document.getElementById(id);
    return elem.parentNode.removeChild(elem);
}
window.addEventListener("load", function() {

    canvas = document.getElementById("myCanvas");
    var pre = document.getElementById("preview");
    var ims = document.getElementById("saved_images");
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


document.getElementById("save").addEventListener("click", function () {
    if (document.getElementById("temp"))
        removeElement("temp");
    ctx.drawImage(video, 0,0, canvas.width, canvas.height);
    var ims = document.getElementById("saved_images");
    var ss = convertCanvasToImage(canvas);
    ims.appendChild(ss);
});

document.getElementById("c2").addEventListener("click", function()  {
    ctx.drawImage(video, 0,0, canvas.width, canvas.height);
});

function stopWebcam() {
    webcamStream.stop()
}

function stopman() {
    recorder.stop();
}



function convertCanvasToImage(canvas) {
    var image = new Image();
    var canv = document.getElementById("myCanvas");
    image.src = canv.toDataURL("image/png");
    image.setAttribute("alt", "myImage" + i++);
    image.width = pre.clientWidth;
    image.height = pre.clientHeight;
    // image.setAttribute("style", "height: 80%;");
    image.setAttribute("id", "temp");
	return image;
}


function save(){
    
}


document.getElementById("download").addEventListener("click", function() {
    var img = document.getElementById("temp"),
    a = document.getElementById("down");
    a.setAttribute("download", "YourFileName.png");
    a.setAttribute("href", img.src);
});
});



function reset() {
        var im = document.getElementById("myCanvas");
        im.removeAttribute("style",'-webkit-filter');
        document.getElementById("form").reset();
    }

function myFunc()
{
    var Blur = document.getElementById("blur").value;
    var Brightness = document.getElementById("brightness").value;
    var Saturate = document.getElementById("saturate").value;
    var Hue = document.getElementById("hue-rotate").value;
    var Contrast = document.getElementById("contrast").value;
    var Invert = document.getElementById("invert").value;
    var Grayscale = document.getElementById("grayscale").value;
    var Sepia = document.getElementById("sepia").value;
    canvas.setAttribute("style",'-webkit-filter: blur(' + Blur + 'px)brightness('
    + Brightness + ')saturate('
    + Saturate + '%)hue-rotate('
    + Hue + 'deg)contrast('
    + Contrast + '%)invert('
    + Invert + '%)grayscale('
    + Grayscale + '%)sepia('
    + Sepia + '%)');
}