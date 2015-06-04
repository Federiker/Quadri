var MagnifierMaker = function () { };
MagnifierMaker.prototype.originalImg = "";
MagnifierMaker.prototype.originalImgId = "";
MagnifierMaker.prototype.largeImg = "";
MagnifierMaker.prototype.largeImgId = "";
MagnifierMaker.prototype.divideBy = 3;
MagnifierMaker.prototype.forceWidth = 0;
MagnifierMaker.prototype.forceHeight = 0;
MagnifierMaker.prototype.make = function () {
    var me = this;
    document.getElementById(this.originalImgId).onload = function () {
        if (me.largeImg.trim() == "") {
            if (me.originalImg.trim() == "") {
                me.largeImg = this.src;
            }
            else {
                me.largeImg = me.originalImg;
            }
        }
        var evt = new Event();
        var m = new Magnifier(evt);
        var mainImgH, mainImgW = 0;
        if (me.divideBy == 0 && me.forceWidth > 0) {
            mainImgH = this.clientHeight * (me.forceWidth / this.clientWidth);
            mainImgW = me.forceWidth;
        }
        else if (me.divideBy == 0 && me.forceHeight > 0) {
            mainImgH = me.forceHeight;
            mainImgW = this.clientWidth * (me.forceHeight / this.clientHeight);
        }
        else if (me.divideBy == 0) {
            mainImgH = this.clientHeight;
            mainImgW = this.clientWidth;
        }
        else {
            mainImgH = this.clientHeight / me.divideBy;
            mainImgW = this.clientWidth / me.divideBy;
        }

        var s = document.createElement("style");
        s.innerHTML = "#" + me.largeImgId + " {width: " + (mainImgW).toString() + "px;height: " + (mainImgH).toString() + "px;}";
        document.getElementsByTagName("body").item(0).appendChild(s);

        m.attach({
            thumb: "#" + me.originalImgId,
            large: me.largeImg,
            largeWrapper: me.largeImgId,
            zoom: 2,
            zoomable: true,
            onthumbenter: function () {
            },
            onthumbmove: function () {
            },
            onthumbleave: function () {
            },
            onzoom: function (data) {
            }
        });
    }
};

var ImageResizer = function () { };
ImageResizer.prototype.width = 0;
ImageResizer.prototype.height = 0;
ImageResizer.prototype.url = "";
ImageResizer.prototype.success = function (o) { };
ImageResizer.prototype.error = function (e) {
    console.log(e);
};

ImageResizer.prototype.go = function () {
    
    var me = this;
    try {
        var data, canvas, ctx;
        var img = new Image();

        img.crossOrigin = "anonymous";
        img.onload = function () {
            // Create the canvas element.
            var h = 0;
            var w = 0;
            canvas = document.createElement('canvas');
            if (me.height == 0 && me.width == 0) {
                w = img.width;
                h = img.height;
            }
            else if (me.height == 0) {
                w = me.width;
                h = img.height * (me.width / img.width);
            }
            else {
                h = me.height;
                w = img.width * (me.height / img.height);
            }
            canvas.width = w;
            canvas.height = h;

            // Get '2d' context and draw the image.
            ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0, w, h);
            // Get canvas data URL
            try {
                data = canvas.toDataURL();
                me.success({ image: img, data: data });
            } catch (e) {
                me.error(e);
            }
        }
        // Load image URL.
        try {
            img.src = me.url;
        } catch (e) {
            me.error(e);
        }
    } catch (er) {
        me.error(er);
    }
    
};

var Painting = function () { };
Painting.prototype.url = "";
Painting.prototype.containerId = "thumb-container";
Painting.prototype.originalWidth = 0;
Painting.prototype.originalHeight = 0;
Painting.prototype.zoomWidth = 0;
Painting.prototype.zoomHeight = 0;
Painting.prototype.zoomSize = 2;
Painting.prototype.originalId = "thumb";
Painting.prototype.zoomId = "preview";
Painting.prototype.setResize = false;
Painting.prototype.thumbUrl = "";
Painting.prototype.paint = function () {
    var me = this;
    var a = document.getElementById(this.containerId);
    a.href = this.url;
    var ir = new ImageResizer();
    if (this.originalWidth != 0) {
        ir.width = this.originalWidth;
    }
    if (this.originalHeight != 0) {
        ir.height = this.originalHeight;
    }
    ir.url = this.url;
    var i = document.createElement("img");
    var finish = function () {
        i.id = me.originalId;
        a.appendChild(i);
        var mm = new MagnifierMaker();
        mm.originalImgId = me.originalId;
        mm.largeImgId = me.zoomId;
        mm.largeImg = me.url;
        if (me.zoomWidth != 0) {
            mm.divideBy = 0;
            mm.forceWidth = me.zoomWidth;
        }
        if (me.zoomHeight != 0) {
            mm.divideBy = 0;
            mm.forceHeight = me.zoomHeight;
        }
        if (me.zoomHeight == 0 && me.zoomWidth == 0) {
            if (me.zoomSize == 0) {
                mm.divideBy = me.zoomSize;
            }
            else {
                mm.divideBy = 2;
            }
        }
        mm.make();
    }
    ir.success = function (o) {
        i.src = o.data;
        finish();
    };
    ir.error = function (e) {
        var i = document.createElement("img");
        i.src = me.url;
        
        i.id = me.originalId;
        if (me.originalWidth != 0) {
            i.style.width = me.originalWidth + "px";
        }
        if (me.originalHeight != 0) {
            i.style.height = me.originalHeight + "px";
        }
        a.appendChild(i);
    };
    if (this.setResize) {
        ir.go();
    }
    else {
        i.src = this.thumbUrl;
        finish();
    }

    
    
};