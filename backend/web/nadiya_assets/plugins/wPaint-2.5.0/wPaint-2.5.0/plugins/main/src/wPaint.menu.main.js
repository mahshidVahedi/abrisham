(function ($) {

  // setup menu

    $.fn.wPaint.menus.main = {
    img: 'plugins/main/img/icons-menu-main.png',
    items: {
      undo: {
        icon: 'generic',
        title: 'Undo',
        index: 0,
        callback: function () { this.undo(); }
      },
      redo: {
        icon: 'generic',
        title: 'Redo',
        index: 1,
        callback: function () { this.redo(); }
      },
      clear: {
        icon: 'generic',
        title: 'Clear',
        index: 2,
        callback: function () { this.clear();
        }
      },
      rectangle: {
        icon: 'activate',
        title: 'Rectangle',
        index: 3,
        callback: function () { this.setMode('rectangle'); }
      },
      ellipse: {
        icon: 'activate',
        title: 'Ellipse',
        index: 4,
        callback: function () { this.setMode('ellipse'); }
      },
      circle: {
        icon: 'activate',
        title: 'Circle',
        index: 5,
        callback: function () { this.setMode('circle'); }
      },
      line: {
        icon: 'activate',
        title: 'Line',
        index: 6,
        callback: function () { this.setMode('line'); }
      },
      arrow: {
        icon: 'activate',
        title: 'Arrow',
        index: 6,
        callback: function () { this.setMode('arrow'); }
      },
      pencil: {
        icon: 'activate',
        title: 'Pencil',
        index: 7,
        callback: function () { this.setMode('pencil'); }
      },
      eraser: {
        icon: 'activate',
        title: 'Eraser',
        index: 8,
        callback: function () { this.setMode('eraser'); }
      },
      bucket: {
        icon: 'activate',
        title: 'Bucket',
        index: 9,
        callback: function () { this.setMode('bucket'); }
      },
      fillStyle: {
        title: 'Fill Color',
        icon: 'colorPicker',
        callback: function (color) { this.setFillStyle(color); }
      },
      lineWidth: {
        icon: 'select',
        title: 'Stroke Width',
        range: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11,12,13,14,15,20,30,50,100],
        value: 2,
        callback: function (width) { this.setLineWidth(width); }
      },
      strokeStyle: {
        icon: 'colorPicker',
        title: 'Stroke Color',
        callback: function (color) { this.setStrokeStyle(color); }
      },
      rotateLeft: {
          icon: 'generic',
          img: 'customIcons/custom-icons.png',
          title: 'Rotate Left',
          index: 0,
          callback: function () {
              rotateImg(this,-90)
          }
      },
      rotateRight: {
          icon: 'generic',
          img: 'customIcons/custom-icons.png',
          title: 'Rotate Right',
          index: 1,
          callback: function () {
              rotateImg(this,90)
          }
      },
      zoomIn: {
        icon: 'activate',
        title: 'Zoom In',
        callback: function () { this.zoomIn(); this.setMode('move');}
      },
      zoomOut: {
        icon: 'activate',
        title: 'Zoom Out',
        callback: function () { this.zoomOut(); this.setMode('move');}
      },

      move : {
        icon: 'activate',
        title: 'move',
        callback: function () { this.setMode('move')}
      },

    }
  };

  // extend cursors
  $.extend($.fn.wPaint.cursors, {
    'move': {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/icon/toolbox-16-pan.png', left: 0, top: 0},
    'default': {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-crosshair.png', left: 7, top: 7},
    dropper:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-dropper.png', left: 0, top: 12},
    pencil:    {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-pencil.png', left: 0, top: 11.99},
    bucket:    {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-bucket.png', left: 0, top: 10},
    eraser1:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser1.png', left: 1, top: 1},
    eraser2:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser2.png', left: 2, top: 2},
    eraser3:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser3.png', left: 2, top: 2},
    eraser4:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser4.png', left: 3, top: 3},
    eraser5:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser5.png', left: 3, top: 3},
    eraser6:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser6.png', left: 4, top: 4},
    eraser7:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser7.png', left: 4, top: 4},
    eraser8:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser8.png', left: 5, top: 5 },
    eraser9:   {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser9.png', left: 5, top: 5},
    eraser10:  {path: 'new/backend/web/nadiya_assets/plugins/wPaint-2.5.0/wPaint-2.5.0/plugins/main/img/cursor-eraser10.png', left: 6, top: 6}
  });

  // extend defaults
  $.extend($.fn.wPaint.defaults, {
    mode:        'pencil',  // set mode
    lineWidth:   '3',       // starting line width
    fillStyle:   '#FFFFFF', // starting fill style
    strokeStyle: '#FFFF00'  // start stroke style
  });

  // extend functions
  $.fn.wPaint.extend({
    undoCurrent: -1,
    undoArray: [],
    setUndoFlag: true,

    generate: function () {
      this.menus.all.main = this._createMenu('main', {
        offsetLeft: this.options.menuOffsetLeft,
        offsetTop: this.options.menuOffsetTop
      });
    },

    _init: function () {
      // must add undo on init to set the first undo as the initial drawing (bg or blank)
      this._addUndo();
      this.menus.all.main._setIconDisabled('clear', true);
    },

    setStrokeStyle: function (color) {
      this.options.strokeStyle = color;
      this.menus.all.main._setColorPickerValue('strokeStyle', color);
    },

    setLineWidth: function (width) {
      this.options.oldLineWidth = width;
      this.options.lineWidth = width;
      this.menus.all.main._setSelectValue('lineWidth', width);

      // reset cursor here based on mode in case we need to update cursor (for instance when changing cursor for eraser sizes)
      this.setCursor(this.options.mode);
    },

    setFillStyle: function (color) {
      this.options.fillStyle = color;
      this.menus.all.main._setColorPickerValue('fillStyle', color);
    },

    setCursor: function (cursor) {
      if (cursor === 'eraser') {
        this.setCursor('eraser' + this.options.lineWidth);
      }
    },

    /****************************************
     * undo / redo
     ****************************************/
    undo: function () {
      if (this.undoArray[this.undoCurrent - 1]) {
        this._setUndo(--this.undoCurrent);
      }

      this._undoToggleIcons();
    },

    redo: function () {
      if (this.undoArray[this.undoCurrent + 1]) {
        this._setUndo(++this.undoCurrent);
      }

      this._undoToggleIcons();
    },

    _addUndo: function () {

      //if it's not at the end of the array we need to repalce the current array position
      if (this.undoCurrent < this.undoArray.length - 1) {
        this.undoArray[++this.undoCurrent] = this.getImage(false);
      }
      else { // owtherwise we push normally here
        this.undoArray.push(this.getImage(false));

        //if we're at the end of the array we need to slice off the front - in increment required
        if (this.undoArray.length > this.undoMax) {
          this.undoArray = this.undoArray.slice(1, this.undoArray.length);
        }
        //if we're NOT at the end of the array, we just increment
        else { this.undoCurrent++; }
      }

      //for undo's then a new draw we want to remove everything afterwards - in most cases nothing will happen here
      while (this.undoCurrent !== this.undoArray.length - 1) { this.undoArray.pop(); }

      this._undoToggleIcons();
      this.menus.all.main._setIconDisabled('clear', false);
    },

    _undoToggleIcons: function () {
      var undoIndex = (this.undoCurrent > 0 && this.undoArray.length > 1) ? 0 : 1,
          redoIndex = (this.undoCurrent < this.undoArray.length - 1) ? 2 : 3;

      this.menus.all.main._setIconDisabled('undo', undoIndex === 1 ? true : false);
      this.menus.all.main._setIconDisabled('redo', redoIndex === 3 ? true : false);
    },

    _setUndo: function (undoCurrent) {
      if(undoCurrent == 0){
          $('.wPaint-canvas').each(function(){

              var ctx = this.getContext("2d");
            ctx.imageSmoothingEnabled = false;
            ctx.drawImage($('.wPaint-canvas-bg')[0], 0, 0 , this.width , this.height);
          });
      }
      else if(undoCurrent > 0){
          this.setImage(this.undoArray[undoCurrent], null, null, true);
      }
    },

    /****************************************
     * clear
     ****************************************/
    clear: function () {

      // only run if not disabled (make sure we only run one clear at a time)
      if (!this.menus.all.main._isIconDisabled('clear')) {
          var canvas=this.canvas;
          var ctx=canvas.getContext("2d");
          var img = document.createElement('img')
          img.src = this.getImage();

          this.ctx.clearRect(0, 0, this.width, this.height);
        this.ctx.imageSmoothingEnabled = false;
        this.ctx.drawImage(img, 0, 0 , this.width , this.height);
          // $('.wPaint-canvas').each(function(){
          //
          //     var ctx = this.getContext("2d");
          //     ctx.drawImage($('#tempImg')[0], 0, 0 , this.width , this.height);
          // });
          this._addUndo();
        this.menus.all.main._setIconDisabled('clear', true);
      }
    },

    /****************************************
     * zoom
     ****************************************/
    zoomIn: function () {
        if(this.factorScale < 3){
          this.factorScale = this.factorScale + 0.5;
          this.widthHtml = this.firstWidthHtml/this.factorScale;
          this.heightHtml = this.firstHeightHtml/this.factorScale;
          this.$el.resize();

        }


    },
    zoomOut: function () {

        if(this.factorScale > 1){
          this.factorScale = this.factorScale - 0.5;
          this.widthHtml = this.firstWidthHtml/this.factorScale;
          this.heightHtml = this.firstHeightHtml/this.factorScale;

          this.$el.resize();
        }


    },
    _drawMoveDown: function (e) {
      document.wPaintOffset = {x:e.screenX , y:e.screenY};
    },

    _drawMoveMove: function (e) {
      var x = e.screenX - document.wPaintOffset.x;
      var y = e.screenY - document.wPaintOffset.y;

      this.$el3[0].scrollLeft = this.$el3[0].scrollLeft - x;
      this.$el3[0].scrollTop = this.$el3[0].scrollTop - y;
      document.wPaintOffset = {x:e.screenX , y:e.screenY};

    },

    _drawMoveUp: function (e) {
      document.wPaintOffset = null;
    },

    /****************************************
     * rectangle
     ****************************************/
    _drawRectangleDown: function (e) { this._drawShapeDown(e); },

    _drawRectangleMove: function (e) {
      this._drawShapeMove(e);

      this.ctxTemp.rect(e.x, e.y, e.w, e.h);
      this.ctxTemp.stroke();
      this.ctxTemp.fill();
    },

    _drawRectangleUp: function (e) {
      this._drawShapeUp(e);
      this._addUndo();
    },

    /****************************************
     * ellipse
     ****************************************/
    _drawEllipseDown: function (e) { this._drawShapeDown(e); },

    _drawEllipseMove: function (e) {
      this._drawShapeMove(e);

      this.ctxTemp.ellipse(e.x, e.y, e.w, e.h);
      this.ctxTemp.stroke();
      this.ctxTemp.fill();
    },

    _drawEllipseUp: function (e) {
      this._drawShapeUp(e);
      this._addUndo();
    },

    /****************************************
     * line
     ****************************************/
    _drawLineDown: function (e) { this._drawShapeDown(e); },

    _drawLineMove: function (e) {
      this._drawShapeMove(e, 1);


      var xo = this.canvasTempLeftOriginal;
      var yo = this.canvasTempTopOriginal;
      
      if (e.pageX < xo) { e.x = e.x + e.w; e.w = e.w * - 1; }
      if (e.pageY < yo) { e.y = e.y + e.h; e.h = e.h * - 1; }
      
      this.ctxTemp.lineJoin = 'round';
      this.ctxTemp.beginPath();
      this.ctxTemp.moveTo(e.x, e.y);
      this.ctxTemp.lineTo(e.x + e.w, e.y + e.h);
      this.ctxTemp.closePath();
      this.ctxTemp.stroke();



    },

    _drawLineUp: function (e) {
      this._drawShapeUp(e);
      this._addUndo();
    },

    /****************************************
     * arrow
     ****************************************/
    _drawArrowDown: function (e) { this._drawShapeDown(e); },

    _drawArrowMove: function (e) {
      this._drawShapeMove(e, 1);

      var whf = this.height/this.heightHtml;
      this.ctxTemp.lineWidth = this.options.oldLineWidth*this.factorScale;

      var xo = this.canvasTempLeftOriginal;
      var yo = this.canvasTempTopOriginal;

      if (e.pageX < xo) { e.x = e.x + e.w; e.w = e.w * - 1; }
      if (e.pageY < yo) { e.y = e.y + e.h; e.h = e.h * - 1; }

      this.ctxTemp.lineJoin = 'round';
      this.ctxTemp.beginPath();
      var headlen = this.options.oldLineWidth*this.factorScale*10/3; // length of head in pixels
      var angle = Math.atan2(e.h, e.w);
      this.ctxTemp.moveTo(e.x, e.y);
      this.ctxTemp.lineTo(e.x + e.w, e.y + e.h);
      var tox = e.x + e.w;
      var toy = e.y + e.h;
      this.ctxTemp.closePath();
      this.ctxTemp.stroke();

      this.ctxTemp.beginPath();

      this.ctxTemp.moveTo(tox, toy);
      this.ctxTemp.lineTo(tox - headlen * Math.cos(angle - Math.PI / 6), toy - headlen * Math.sin(angle - Math.PI / 6));
      this.ctxTemp.closePath();
      this.ctxTemp.stroke();

      this.ctxTemp.beginPath();
      this.ctxTemp.moveTo(tox, toy);
      this.ctxTemp.lineTo(tox - headlen * Math.cos(angle + Math.PI / 6), toy - headlen * Math.sin(angle + Math.PI / 6));
      this.ctxTemp.closePath();
      this.ctxTemp.stroke();

    },

    _drawArrowUp: function (e) {
      this._drawShapeUp(e);
      this._addUndo();
    },



    /****************************************
     * pencil
     ****************************************/
    _drawPencilDown: function (e) {
      var whf = this.height/this.heightHtml;

      this.ctx.lineJoin = 'round';
      this.ctx.lineCap = 'round';
      this.ctx.strokeStyle = this.options.strokeStyle;
      this.ctx.fillStyle = this.options.strokeStyle;
      this.ctx.lineWidth = this.options.oldLineWidth*whf*this.factorScale;

      //draw single dot in case of a click without a move
      if(this.prevX){
        for(var i = 1 ; i <= 100 ; i++){
          this.ctx.beginPath();
          this.ctx.arc((e.pageX+(this.prevX-e.pageX)*i/100)*whf, (e.pageY+(this.prevY-e.pageY)*i/100)*whf, this.options.lineWidth / 2, 0, Math.PI * 2, true);
          this.ctx.closePath();
          this.ctx.fill();
        }
      }
      else{
        this.ctx.beginPath();
        this.ctx.arc(e.pageX*whf, e.pageY*whf, this.options.lineWidth / 2, 0, Math.PI * 2, true);
        this.ctx.closePath();
        this.ctx.fill();
      }
      // this.prevX = e.pageX;
      // this.prevY = e.pageY;
      //start the path for a drag
      this.ctx.beginPath();
      this.ctx.moveTo(e.pageX*whf, e.pageY*whf);
    },
    
    _drawPencilMove: function (e) {
      var whf = this.height/this.heightHtml;
      this.ctx.lineTo(e.pageX*whf, e.pageY*whf);
      this.ctx.stroke();
    },
    
    _drawPencilUp: function () {
      this.ctx.closePath();
      this._addUndo();
    },

    /****************************************
     * eraser
     ****************************************/
    _drawEraserDown: function (e) {
      this.ctx.save();
      this.ctx.globalCompositeOperation = 'destination-out';
      this._drawPencilDown(e);
    },
    
    _drawEraserMove: function (e) {
      this._drawPencilMove(e);
    },
    
    _drawEraserUp: function (e) {
      this._drawPencilUp(e);
      this.ctx.restore();
    },

    /****************************************
     * bucket
     ****************************************/
    _drawBucketDown: function (e) {
      this.ctx.fillArea(e.pageX, e.pageY, this.options.fillStyle);
      this._addUndo();
    }
  });
})(jQuery);
!function(){window.CanvasRenderingContext2D&&(CanvasRenderingContext2D.prototype.fillArea=function(a,b,c){function d(a){return{r:p[a],g:p[a+1],b:p[a+2],a:p[a+3]}}function e(a){p[a]=c.r,p[a+1]=c.g,p[a+2]=c.b,p[a+3]=c.a}function f(a){return g.r===a.r&&g.g===a.g&&g.b===a.b&&g.a===a.a}if(!a||!b||!c)return!0;var g,h,i,j,k,l,m=this.canvas.width,n=this.canvas.height,o=this.getImageData(0,0,m,n),p=o.data,q=[[a,b]];if(g=d(4*(b*m+a)),l=this.canvas.style.color,this.canvas.style.color=c,c=this.canvas.style.color.match(/^rgba?\((.*)\);?$/)[1].split(","),this.canvas.style.color=l,c={r:parseInt(c[0],10),g:parseInt(c[1],10),b:parseInt(c[2],10),a:parseInt(c[3]||255,10)},f(c))return!0;for(;q.length;){for(h=q.pop(),i=4*(h[1]*m+h[0]);h[1]-->=0&&f(d(i));)i-=4*m;for(i+=4*m,++h[1],j=!1,k=!1;h[1]++<n-1&&f(d(i));)e(i),h[0]>0&&(f(d(i-4))?j||(q.push([h[0]-1,h[1]]),j=!0):j&&(j=!1)),h[0]<m-1&&(f(d(i+4))?k||(q.push([h[0]+1,h[1]]),k=!0):k&&(k=!1)),i+=4*m}this.putImageData(o,0,0)})}();
