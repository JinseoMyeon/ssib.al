const storedTheme = localStorage.getItem("darkTheme");
let theme = document.querySelector(':root');
let styles = getComputedStyle(theme);
let darkmode = 0;

styles.getPropertyValue('--gray1');
styles.getPropertyValue('--gray2');
styles.getPropertyValue('--gray3');
styles.getPropertyValue('--gray4');
styles.getPropertyValue('--gray5');
styles.getPropertyValue('--gray6');
styles.getPropertyValue('--gray7');

styles.getPropertyValue('--brand1');
styles.getPropertyValue('--brand2');
styles.getPropertyValue('--brand3');
styles.getPropertyValue('--brand4');
styles.getPropertyValue('--brand5');
styles.getPropertyValue('--brand6');

if (storedTheme !== null) {
    if (storedTheme === "true") {
        darkmode = 1;
        changeThemeDark();
    }
} else if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
    darkmode = 1;
    changeThemeDark();
} else {
    changeThemeLight();
}

document.getElementById("toggleThemeLight").addEventListener("click", () => {
    darkmode = 1;
    changeThemeDark();
});

document.getElementById("toggleThemeDark").addEventListener("click", () => {
    darkmode = 0;
    changeThemeLight();
});

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
                alert(`복사에 실패했어요. 주소를 직접 입력해주세요.`);
            })
        }
    });
}

function changeThemeDark() {
    theme.style.setProperty('--white', '#2B2C31');
    theme.style.setProperty('--gray1', '#303137');
    theme.style.setProperty('--gray2', '#52565B');
    theme.style.setProperty('--sgray2', '#767B83');
    theme.style.setProperty('--gray3', '#9098A4');
    theme.style.setProperty('--gray4', '#52565B');
    theme.style.setProperty('--gray5', '#767B83');
    theme.style.setProperty('--gray6', '#52565B');
    theme.style.setProperty('--igray6', '#F2F4F8');
    theme.style.setProperty('--gray7', '#F2F4F8');
    theme.style.setProperty('--pgray7', '#ffffff');

    theme.style.setProperty('--hbrand', '#29436E');
    theme.style.setProperty('--brand1', '#297DFC');
    theme.style.setProperty('--brand2', '#2A6ED5');
    theme.style.setProperty('--brand3', '#2C5FAD');
    theme.style.setProperty('--brand4', '#2D5799');
    theme.style.setProperty('--brand5', '#2D4F86');
    theme.style.setProperty('--brand6', '#297DFC');

    document.getElementById("toggleThemeLight").classList.add("disable");
    document.getElementById("toggleThemeDark").classList.remove("disable");
}

function changeThemeLight() {
    theme.style.setProperty('--white', '#ffffff');
    theme.style.setProperty('--gray1', '#f2f4f8');
    theme.style.setProperty('--gray2', '#cad2df');
    theme.style.setProperty('--sgray2', '#cad2df');
    theme.style.setProperty('--gray3', '#a9b2c0');
    theme.style.setProperty('--gray4', '#9098a4');
    theme.style.setProperty('--gray5', '#767b83');
    theme.style.setProperty('--gray6', '#52565b');
    theme.style.setProperty('--igray6', '#52565b');
    theme.style.setProperty('--gray7', '#303137');
    theme.style.setProperty('--pgray7', '#ffffff');

    theme.style.setProperty('--hbrand', '#D5E5FE');
    theme.style.setProperty('--brand1', '#D5E5FE');
    theme.style.setProperty('--brand2', '#AACBFE');
    theme.style.setProperty('--brand3', '#94BEFE');
    theme.style.setProperty('--brand4', '#69A4FD');
    theme.style.setProperty('--brand5', '#5397FD');
    theme.style.setProperty('--brand6', '#297DFC');

    document.getElementById("toggleThemeLight").classList.remove("disable");
    document.getElementById("toggleThemeDark").classList.add("disable");
}