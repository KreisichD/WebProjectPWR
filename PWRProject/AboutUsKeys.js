function start() {
    var toChange = document.getElementById("toChange");
    var isChanged = false;

    document.addEventListener("keydown", function (e) {
        if (e.altKey && e.shiftKey && e.ctrlKey)
            if (!isChanged) {
                toChange.style.fontSize = "50%";
                isChanged = true;
            }
            else {
                toChange.style.fontSize = "100%";
                isChanged = false;
            }
    })
}

window.addEventListener("load", start, false);