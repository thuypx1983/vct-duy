var myWindow;
function openCenteredWindow(objA,w,h) {
    var width = 440;
    if (w > 0)
        width = w;
    var height = 320;
    if (h > 0)
        height = h;
    var left = parseInt((screen.availWidth/2) - (width/2));
    var top = parseInt((screen.availHeight/2) - (height/2));
    var windowFeatures = "status=no,resizable=no,scrollbars=no,toolbar=no,location=no,fullscreen=no,titlebar=yes,width=" + width + ",height=" + height + ",left=" + left + ",top=" + top + ",screenX=" + left + ",screenY=" + top;
    myWindow = window.open(objA.toString(), "subWind", windowFeatures);
    return false;
}
var myWindow2;
function openCenteredWindow2(objA) {
    var windowFeatures2 = "scrollbars=yes,resizable=yes,width=900"
    myWindow2 = window.open(objA.toString(), "subWind", windowFeatures2);
    return false;
}


var myWindow3;
function openCenteredWindow3(objA) {
    var windowFeatures3 = "scrollbars=yes,resizable=yes,width=550,height=350"
    myWindow3 = window.open(objA.toString(), "subWind", windowFeatures3);
    return false;
}