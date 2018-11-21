var fontHelpMessage = "Use only listed fonts pls ;)"
var helper;

function start() {
    helper = document.getElementById("helper");

    registerInputListeners(document.getElementById("selectFont"));

    registerConfirmListeners(document.getElementById("pageSettings"));
}

function registerConfirmListeners(form) {
    form.addEventListener("submit",
        function () {
            var isConfirmed = confirm("Are yue sure want to submit?");
            if (isConfirmed) {
                applyChanges(form);
            }
        }, false);

    form.addEventListener("reset",
        function () {
            alert("Form reset complete");
        }, false);
}

function registerInputListeners(object) {
    object

    object.addEventListener("focus",
        function () {
            helper.innerHTML = fontHelpMessage;
        }, false);

    object.addEventListener("blur",
        function () {
            helper.innerHTML = "";
        }, false);
}

function applyChanges(form) {
    var backgroundColor = form.elements["selectBackground"];
    var fontColor = form.elements["selectFontColor"];
    var font = form.elements["selectFont"];

    document.body.style.backgroundColor = backgroundColor.value;
    document.body.style.fontFamily = font.value;
    
    document.getElementById("toChange").style.color = fontColor.value;
}

window.addEventListener("load", start, false);