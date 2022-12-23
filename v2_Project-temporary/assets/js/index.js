function restrictionOpen() {
    document.getElementById("restrictionInfo").style.visibility = "visible";
    document.getElementById("restrictionInfo").style.opacity = "0.7";

    document.getElementById("restrictionBackground").style.visibility = "visible";
    document.getElementById("restrictionBackground").style.opacity = "1";
}

function restrictionClose() {
    document.getElementById("restrictionInfo").style.visibility = "hidden";
    document.getElementById("restrictionInfo").style.opacity = "0.0";

    document.getElementById("restrictionBackground").style.visibility = "hidden";
    document.getElementById("restrictionBackground").style.opacity = "0.0";
}