var element = document.createElement("p");

function alertSomething() {
    alert('Przykładowy alert z listenerem');
    var container = document.getElementsByClassName("container");

    var node = document.createTextNode("Click this one to prompt");
    element.appendChild(node);
    container[0].appendChild(element);
    element.addEventListener("click", prompter);
}
function prompter() {
    var name = prompt("Let me know, whats your name", "NONE");
    document.getElementById("miejsce").innerHTML = 'Witam Cię na stronie :)';
    element.innerHTML = name;
}
document.getElementById("alert").addEventListener("click", alertSomething);