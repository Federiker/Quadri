var PaintingAsync = function () { };
PaintingAsync.prototype.stylesheets = new Array();
PaintingAsync.prototype.scripts = new Array();
PaintingAsync.prototype.paintingObject = null;
PaintingAsync.prototype.load = function () {
    var body = document.getElementsByTagName("body").item(0);
    for (var i = 0; i < this.stylesheets.length; i++) {
        var st = document.createElement("link");
        st.rel = "stylesheet";
        st.type = "text/css";
        st.href = this.stylesheets[i];
        body.appendChild(st);
    }

};