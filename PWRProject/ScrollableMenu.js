var pointedImgs = 0;
var pointedLinks = 0;
var mouseMovements = 0;



function initialize() {
    var imgs = document.images;
    var links = document.links;
    var forms = document.forms;

    var imgCount = imgs.length;
    var linkCount = links.length;
    var formCount = forms.length;


    document.getElementById("imgcnt").innerHTML = imgCount;
    document.getElementById("linkcnt").innerHTML = linkCount;
    document.getElementById("formcnt").innerHTML = formCount;

    document.addEventListener('mousemove', movementSumming);

    for (var i = 0; i < imgs.length; i++) {
        imgs.item(i).addEventListener('mouseover', incrementImgs);
    }
    for (var i = 0; i < links.length; i++) {
        links.item(i).addEventListener('mouseover', incrementLinks);
    }
}

function incrementImgs() {
    pointedImgs++;
}

function incrementLinks() {
    pointedLinks++;
}


function movementSumming() {
    var ev = window.event;
    mouseMovements += Math.abs(ev.movementX) + Math.abs(ev.movementY);
}

function updateUI() {
    var pointedImgCountElem = document.getElementById("pointedImg");
    var pointedLinkCountElem = document.getElementById("pointedLinks");
    var mouseMvmtElem = document.getElementById("mousemvmntsum");

    pointedImgCountElem.innerHTML = pointedImgs;
    pointedLinkCountElem.innerHTML = pointedLinks;
    mouseMvmtElem.innerHTML = mouseMovements;
}
initialize();
setInterval(updateUI, 300);
