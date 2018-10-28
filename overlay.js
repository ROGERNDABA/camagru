var img_ele = null;

function zoom(zoomincrement) {
  img_ele = document.getElementById('drag-img');
  var pre_width = img_ele.getBoundingClientRect().width,
  		pre_height = img_ele.getBoundingClientRect().height;
  img_ele.style.width = (pre_width * zoomincrement) + 'px';
  img_ele.style.height = (pre_height * zoomincrement) + 'px';
  img_ele = null;
}

document.getElementById('overlay').addEventListener('wheel', function(e) {
    if (e.deltaY < 0) {
        zoom(1.5);
      }
      if (e.deltaY > 0) {
        zoom(0.5);
      }
})

function start_drag() {
  img_ele = this;
  x_img_ele = window.event.clientX - document.getElementById('drag-img').offsetLeft;
  y_img_ele = window.event.clientY - document.getElementById('drag-img').offsetTop;
	console.log("start drag");
}

function stop_drag() {
  img_ele = null;
  console.log("stop drag");
}

function while_drag() {
  var x_cursor = window.event.clientX;
  var y_cursor = window.event.clientY;
  if (img_ele !== null) {
    img_ele.style.left = (x_cursor - x_img_ele) + 'px';
    img_ele.style.top = ( window.event.clientY - y_img_ele) + 'px';
      console.log('dragging > img_left:' + img_ele.style.left+' | img_top: '+img_ele.style.top);
  }
}

document.getElementById('drag-img').addEventListener('mousedown', start_drag);
document.getElementById('overlay').addEventListener('mousemove', while_drag);
document.getElementById('overlay').addEventListener('mouseup', stop_drag);