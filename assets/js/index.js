
var button = document.getElementById("shortenButton");
if(window.innerWidth < 768) {
    button.innerText("");
}
else if(window.innerWidth >= 768) {
    button.innerText("링크 줄이기");
}