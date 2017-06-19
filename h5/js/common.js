var $_GET = (function() {
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if (typeof(u[1]) == "string") {
        u = u[1].split("&");
        var get = {};
        for (var i in u) {
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();

var log = function (str) {
    console.log(str);
};

// html font-size根据屏幕宽度适配。
(function(doc, win) {
    var docEl = doc.documentElement,
        resizeEvt = "orientationchange" in window ? "orientationchange" : "resize",
        recalc = function() {
            var clientWidth = docEl.clientWidth;
            if (!clientWidth) {
                return;
            }
            docEl.style.fontSize = 20 * (clientWidth / 320) + "px";
        };
    if (!doc.addEventListener) {
        return;
    }
    win.addEventListener(resizeEvt, recalc, false);
    doc.addEventListener("DOMContentLoaded", recalc, false);
}(document, window));
