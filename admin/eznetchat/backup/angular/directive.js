var Myapp=angular.module("myapp");
Myapp.directive("drawing", function(){
  return {
    restrict: "A",
    scope: true,
    link: function(scope, element, attrs){
      //console.log(element[0].clientWidth);
     // var width = element[0].clientWidth;
     // var height = element[0].clientHeight;
      var width=275;
      var height=71;
      var canvas = document.createElement('canvas');
      var ctx = canvas.getContext('2d');
      canvas.id = 'canvas';
      canvas.width = width;
      canvas.height = height;
      
      element[0].appendChild(canvas);
      // Creating a tmp canvas
      var canvas_buffer = document.createElement('canvas');
      var buffer_ctx = canvas_buffer.getContext('2d');
      canvas_buffer.id = 'canvas_buffer';
      canvas_buffer.width = canvas.width;
      canvas_buffer.height = canvas.height;

      element[0].appendChild(canvas_buffer);
      
      var mouse = {x: 0, y: 0};
      var last_mouse = {x: 0, y: 0};
      
      // Pencil Points
      var ppts = [];
      
      /* Mouse Capturing Work */
      canvas_buffer.addEventListener('mousemove', function(e) {
        mouse.x = typeof e.offsetX !== 'undefined' ? e.offsetX : e.layerX;
        mouse.y = typeof e.offsetY !== 'undefined' ? e.offsetY : e.layerY;
      }, false);
      
      
      /* Drawing on Paint App */
      buffer_ctx.lineWidth = 3;
      buffer_ctx.lineJoin = 'round';
      buffer_ctx.lineCap = 'round';
      buffer_ctx.strokeStyle = '#0000FF';
      buffer_ctx.fillStyle = 'blue';
      
      canvas_buffer.addEventListener('mousedown', function(e) {
        canvas_buffer.addEventListener('mousemove', onPaint, false);
        
        mouse.x = typeof e.offsetX !== 'undefined' ? e.offsetX : e.layerX;
        mouse.y = typeof e.offsetY !== 'undefined' ? e.offsetY : e.layerY;
        
        ppts.push({x: mouse.x, y: mouse.y});
        
        onPaint();
      }, false);
      
      canvas_buffer.addEventListener('mouseup', function() {
        canvas_buffer.removeEventListener('mousemove', onPaint, false);
        
        // Writing down to real canvas now
        ctx.drawImage(canvas_buffer, 0, 0);
        // Clearing tmp canvas
        buffer_ctx.clearRect(0, 0, canvas_buffer.width, canvas_buffer.height);
        
        // Emptying up Pencil Points
        ppts = [];
      }, false);
      
      function onPaint() {
        
        // Saving all the points in an array
        ppts.push({x: mouse.x, y: mouse.y});
        
        if (ppts.length < 3) {
          var b = ppts[0];
          buffer_ctx.beginPath();
          //ctx.moveTo(b.x, b.y);
          //ctx.lineTo(b.x+50, b.y+50);
          buffer_ctx.arc(b.x, b.y, buffer_ctx.lineWidth / 2, 0, Math.PI * 2, !0);
          buffer_ctx.fill();
          buffer_ctx.closePath();
          
          return;
        }
        
        // Tmp canvas is always cleared up before drawing.
        buffer_ctx.clearRect(0, 0, canvas_buffer.width, canvas_buffer.height);
        
        buffer_ctx.beginPath();
        buffer_ctx.moveTo(ppts[0].x, ppts[0].y);
        
        for (var i = 1; i < ppts.length - 2; i++) {
          var c = (ppts[i].x + ppts[i + 1].x) / 2;
          var d = (ppts[i].y + ppts[i + 1].y) / 2;
          
          buffer_ctx.quadraticCurveTo(ppts[i].x, ppts[i].y, c, d);
        }
        
        // For the last 2 points
        buffer_ctx.quadraticCurveTo(
          ppts[i].x,
          ppts[i].y,
          ppts[i + 1].x,
          ppts[i + 1].y
        );
        buffer_ctx.stroke();
        
      };
      
    }
  }
});
