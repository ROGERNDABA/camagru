var loopFrame;
var canvas, ctx, i = 0, j = 0, issaved = 0, upload = 0;
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
    navigator.getUserMedia  =   navigator.getUserMedia ||
                                navigator.webkitGetUserMedia ||
                                navigator.mozGetUserMedia ||
                                navigator.msGetUserMedia;
            video = document.createElement('video');
            video.setAttribute('autoplay',true);

            window.vid = video;
            
            function getWebcam() {
                navigator.getUserMedia({ video: true, audio: false }, function(stream) {
                    video.srcObject = stream;
                    track = stream.getTracks()[0];
                }, function(e) {
                    console.error('Rejected!', e);
                });
            }
            
            getWebcam();
            
            
            
            
            function startLoop() {
                ctx.translate(width, 0);
                ctx.scale(-1, 1);
                loopFrame = loopFrame || requestAnimationFrame(loop);
            }
            
            video.addEventListener('loadedmetadata',function(){
                width = canvas.width = video.videoWidth;
                height = canvas.height = video.videoHeight;
                startLoop();
            });
            
            document.querySelector('#c2').onclick = function() {
                if (j == 0 ) {
                    cancelAnimationFrame(loopFrame); j = 1;
                    // window.alert(loopFrame);

                }else {
                    loopFrame = requestAnimationFrame(loop); j = 0;
                }
            }
});


// function load(url, element) {
//     req = new XMLHttpRequest();

//     req.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             console.log(req.responseText);
//         }
//     };
//     req.open("GET", url, true);
//     req.send(null); 
// }


document.getElementById("save").addEventListener("click", function () {
    var toto;
     var drg = document.getElementById('drag-img');
    if (issaved != loopFrame || upload == 1){
    if ((canvas.toDataURL() != document.getElementById('myCanvas2').toDataURL()) && j == 1) {
        var can2 = cloneCanvas(canvas);
        var   cetx = can2.getContext('2d');
        var image = new Image(1800, 1600);
        image.src = can2.toDataURL("image/png");
        image.setAttribute("alt", "myImage" + i++);
        image.setAttribute("style", "width:400px;height:300px");
        cetx.drawImage(image, 0,0 , canvas.width, canvas.height);
        $.ajax({
            type: 'POST',
            url: 'insert.php',                
            data: { x:drg.offsetLeft,
                    y:drg.offsetTop,
                    w:drg.width ,
                    h:drg.height,
                    dw:image.style.width,
                    dh:image.style.height,
                    src:drg.src, 
                    dst:image.src
            },
         success: function(response) {
             toto = response;
             console.log(response);
         }  
        })

        document.getElementById('re').innerHTML = toto;
        issaved = loopFrame;
        load('home.phtml', document.getElementById('scoop'));
    }

}
});

function cloneCanvas(oldCanvas) {
    var newCanvas = document.createElement('canvas');
    var context = newCanvas.getContext('2d');

    newCanvas.width = oldCanvas.width;
    newCanvas.height = oldCanvas.height;
    context.filter = 'blur(' +  document.getElementById("blur").value+ 'px)'
    + 'brightness(' + document.getElementById("brightness").value * 90 + '%)'
    + 'saturate(' + document.getElementById("saturate").value + '%)'
    + 'hue-rotate(' + document.getElementById("hue-rotate").value + 'deg)'
    + 'contrast(' + document.getElementById("contrast").value + '%)'
    + 'invert(' + document.getElementById("invert").value + '%)'
    + 'grayscale(' + document.getElementById("grayscale").value + '%)'
    + 'sepia(' + document.getElementById("sepia").value + '%)';
    context.drawImage(oldCanvas, 0, 0);
    return newCanvas;
}

function loop() {
    ctx.drawImage(video, 0, 0, width, height);
    loopFrame = requestAnimationFrame(loop);
}

// document.getElementById("download").addEventListener("click", function() {
//     var img = document.getElementById("temp"),
//     a = document.getElementById("down");
//     a.setAttribute("download", "YourFileName.png");
//     a.setAttribute("href", img.src);
// });


    document.addEventListener('input', function(){
        myFunc();
    });
    
     function galleryz() {
        var e = document.getElementById('scoop'),
        x = document.getElementById('gallery'),
        z = window.document.defaultView.getComputedStyle(e).getPropertyValue('z-index');
       if(z == 2) {
            e.style.zIndex = "-1";
            x.innerHTML = 'GALLERY';
       }
       else {
            e.style.zIndex = "2";
            x.innerHTML = 'BACK';
       }
    }
    
    
    document.getElementById('gallery').addEventListener('click', galleryz);

    function readImage() {
        if ( this.files && this.files[0] ) {
            var file_read= new FileReader();
            file_read.onload = function(e) {
               var imgU = new Image();

               imgU.setAttribute('style', 'width:500px;height:340px;');
               imgU.addEventListener("load", function() {
                cancelAnimationFrame(loopFrame); j = 1;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(imgU, 0, 0, canvas.width, canvas.height);
                upload = 1;
               });
               imgU.src = e.target.result;
            };       
            file_read.readAsDataURL( this.files[0] );
        }
    }
    
    document.getElementById('imageLoader').addEventListener("change", readImage, false);

});

function reset() {
        var im = document.getElementById("myCanvas");
        im.removeAttribute("style",'-webkit-filter');
        document.getElementById("form").reset();
    }
    

function myFunc(){
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

var clicked = 0;

function addSticker(x) {
    if (clicked == 0) {
        var n = document.getElementById('drag-img');
        n.setAttribute('src', x.src);
    }
}
