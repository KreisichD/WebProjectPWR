var tryImages;

function main() {
    var startB = document.getElementById("startB");

    startB.addEventListener("click", start);

    tryImages = [
        document.getElementById("try1"),
        document.getElementById("try2"),
        document.getElementById("try3"),
        document.getElementById("try4"),
        document.getElementById("try5")
    ];
}

function start() {
    clear();
    var target = Math.floor(Math.random() * 10);
    var num;

    target = 5;

    var end = false;

    var i = 0;

    do {
        num = readNumber();

        while (num < 0 || num > 10) {
            switch (num) {
                case -1:
                    alert("I said number");
                    break;
                default:
                    alert("I said 0 to 10");
                    break;
            }
            
            num = readNumber();
        }
        if (num == target)
            tryImages[i].setAttribute("src", "MediaFiles/ok.png");
        else tryImages[i].setAttribute("src", "MediaFiles/wrong.png")

        i++;

        if (i >= 5 || num == target)
            end = true;

    } while (!end);

    if (num == target) 
        alert("Congrats!")
    else alert("Maybe next time")
}

function readNumber() {
    var num = parseInt(prompt("Your guess:"));

    if (isNaN(num))
        return -1;
    else return num;
}

function clear() {
    var i;
    for (i = 0; i < 5; i++) {
        tryImages[i].setAttribute("src", "MediaFiles/blank.png")
    }
}

window.addEventListener("load", main, false);