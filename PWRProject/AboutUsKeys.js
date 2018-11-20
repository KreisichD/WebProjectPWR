function start() {
    var toChange = document.getElementById("toChange");
    var isChanged = false;

    document.addEventListener("keydown", function (e) {
        if (e.altKey && e.shiftKey && e.ctrlKey)
            if (!isChanged) {
                toChange.setAttribute("style", "font-size: 50%");
                isChanged = true;
            }
            else {
                toChange.setAttribute("style", "font-size: 100%");
                isChanged = false;
            }
    })
}

window.addEventListener("load", start, false);