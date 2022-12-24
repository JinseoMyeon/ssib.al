document.getElementById("restriction").addEventListener("click", () => {
    document.getElementById("restrictionInfo").style.visibility = "visible";
    document.getElementById("restrictionInfo").style.opacity = "0.7";

    document.getElementById("restrictionBackground").style.visibility = "visible";
    document.getElementById("restrictionBackground").style.opacity = "1";
});

document.getElementById("restrictionInfo").addEventListener("click", () => {
    document.getElementById("restrictionInfo").style.visibility = "hidden";
    document.getElementById("restrictionInfo").style.opacity = "0.0";

    document.getElementById("restrictionBackground").style.visibility = "hidden";
    document.getElementById("restrictionBackground").style.opacity = "0.0";
});

document.getElementById("restClose").addEventListener("click", () => {
    document.getElementById("restrictionInfo").style.visibility = "hidden";
    document.getElementById("restrictionInfo").style.opacity = "0.0";

    document.getElementById("restrictionBackground").style.visibility = "hidden";
    document.getElementById("restrictionBackground").style.opacity = "0.0";
});

if (document.getElementById("shortenResult")) {
    document.getElementById("shortenResult").addEventListener("click", () => {
        const url = document.getElementById("resultLinkSuccess").innerText;
        if (url) {
            navigator.clipboard.writeText(`${url}`)
            .then(()=>{
                alert(`링크를 클립보드에 성공적으로 복사했어요!`);
            })
            .catch(()=> {
                alert(`복사에 실패했어요. 아쉽지만 주소를 직접 입력해주세요.`);
            })
        }
    });
}