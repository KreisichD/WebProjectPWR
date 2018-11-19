var examples = [
    "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam posuere ligula accumsan, ultrices odio sed, hendrerit odio. Morbi nec blandit eros, vitae feugiat leo. Morbi fermentum pretium elementum. Maecenas volutpat eros eu massa hendrerit porttitor. Maecenas rutrum laoreet nisl in pellentesque. Proin posuere erat mauris, et venenatis leo vulputate et. Morbi sed tincidunt quam, sed pretium ex. Praesent eget erat nulla. Proin faucibus enim",
    "Nam suscipit, dolor quis ullamcorper accumsan, tellus tortor porta justo,id auctor tortor tortor sit amet orci. Donec facilisis dui sit amet odio consectetur, sed fringilla orci iaculis. Aliquam mattis tellus quis sollicitudin ultrices. Nunc viverra, urna gravida placerat efficitur, purus nisl aliquet neque, id ullamcorper risus lorem varius est. Fusce a orci aliquet, finibus quam vel, ornare sapien. Nam tortor metus, sollicitudin non volutpat ut, cursus eget diam. Aenean felis lectus, sollicitudin ut augue et, condimentum dictum diam. Aliquam efficitur, sem ut tempor blandit, nulla elit maximus nisi, at hendrerit diam justo eu orci. Etiam auctor augue et risus auctor hendrerit. Ut euismod at magna sit amet consequat. Maecenas faucibus pulvinar felis eget consectetur. Suspendisse quis magna felis. Praesent porta rhoncus turpis at facilisis. Donec pharetra, mauris non",
    "Praesent id urna nisl. Aliquam sed laoreet sem. Suspendisse potenti. Proin maximus odio id libero rutrum fringilla. Curabitur lacinia ex egestas nisi fringilla, quis accumsan tortor cursus. Integer sit amet enim turpis. Integer vehicula consequat purus eget molestie. Morbi et ante cond",
    "Curabitur suscipit et sem eu dictum. Donec eget bibendum tellus. Aliquam non nulla maximus, tempus sem id, ultricies sapien. Integer faucibus tempus eros in pulvinar. Nulla nec lacus sed nibh placerat auctor. Sed cursus urna nec dolor convallis, in congue ante porttitor. Fusce convallis imperdiet fermentum. In quis luctus mi. Sed posuere ullamcorper tellus sit amet aliquet. Nam erat leo, pharetra a finibus ac, pulvinar vel erat. Cras vel ante lobortis, sodales metus ut, scelerisque eros. Sed sollicitudin, justo id interdum rhoncus, sapien mi placerat nisl, euismod varius felis mauris in quam. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam posuere ligula accumsan, ultrices odio sed, hendrerit odio. Morbi nec blandit eros",
    "Duis elementum eu diam ut suscipit. Cras vitae lacus eu metus posuere sollicitudin quis non diam. Nullam sagittis lacus et lorem convallis vulputate. Pellentesque elementum ultrices risus, at condimentum sapien euismod eu. Aenean sodales nisl velit, in volutpat leo tincidunt sit amet. Nam et "
];

var currentNode;
var idcount = 0;

function start() {
    document.getElementById("selectButton").addEventListener("click", select, false);
    document.getElementById("insertButton").addEventListener("click", insert, false);
    document.getElementById("appendButton").addEventListener("click", append, false);
    document.getElementById("replaceButton").addEventListener("click", replace, false);
    document.getElementById("removeButton").addEventListener("click", remove, false);
    document.getElementById("parentButton").addEventListener("click", parent, false);

    currentNode = document.getElementById("p1");
}

window.addEventListener("load", start, false);

function select() {
    var id = document.getElementById("selectedID").value;
    var target = document.getElementById(id);


    switchTo(target);
}

function insert() {
    var newNode = createNode();
    currentNode.parentNode.insertBefore(newNode, currentNode);
    switchTo(newNode);
}

function append() {
    var newNode = createNode();
    currentNode.appendChild(newNode);
    switchTo(newNode);
}

function replace() {
    var newNode = createNode();
    currentNode.parentNode.replaceChild(newNode, currentNode);
    switchTo(newNode);
}

function remove() {
    if (currentNode.parentNode == document.getElementById("toChange"))
        alert("What are you doing???");
    else {
        var oldNode = currentNode;
        switchTo(oldNode.parentNode);
        currentNode.removeChild(oldNode);
    }
}

function parent() {
    var target = currentNode.parentNode;

    if (target != document.getElementById("toChange"))
        switchTo(target);
    else
        alert("No parent");
}

function createNode() {
    var newNode = document.createElement("p");
    var nodeId = "new" + idcount;
    ++idcount;
    newNode.setAttribute("id", nodeId);
    var text = "[" + nodeId + "]" + randomText();
    newNode.appendChild(document.createTextNode(text));
    return newNode;
}

function randomText() {
    return examples[Math.floor(Math.random() * 5)];
}

function switchTo(newNode) {
    currentNode.setAttribute("class", "");
    currentNode = newNode;
    currentNode.setAttribute("class", "selected");
    document.getElementById("selectedID").value = currentNode.getAttribute("id");
}