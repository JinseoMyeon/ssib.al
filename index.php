<?php
    session_start();
    require_once("./config.php");
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="JinseoMyeon">
    <meta name="title" content="씨발 | ssib.al">
    <meta name="description" content="링크 단축을 위한 가장 강력한 이름.">
    <meta property="og:title" content="씨발 | ssib.al">
    <meta property="og:description" content="링크 단축을 위한 가장 강력한 이름.">
    <meta name="naver-site-verification" content="b8c6d6c2cd25f58f7714a81dc07a2ff625124832" />
    <meta name="msvalidate.01" content="6E57E9298518AF4483787369C99AA184" />
    <link rel="stylesheet" href="./assets/css/style.css?after">
    <link rel="icon" href="./assets/image/favicon.ico">
    <title>씨발 | ssib.al</title>
    
</head>
<body>
<?php
    if (isset($_SESSION['success'])) {
        echo "<div id='shortenResult' class='pointer'>
        <img id='resultImage' src='./assets/image/FinishedIcon.svg' alt='shortenFinished'>"
        . $_SESSION['success'] .
        "<p id='resultText'>링크를 줄이는 데 성공했어요!</p>
        </div>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<div id='shortenResult'>
        <img id='resultImage' src='./assets/image/FailedIcon.svg' alt='shortenFinished'>
        <p id='resultLinkFailed'>링크를 줄이는 데 실패했어요.</p>"
        . $_SESSION['error'] .
        "</div>";
        unset($_SESSION['error']);
    }
    if (isset($_GET['error']) && $_GET['error'] == 'db') {
        echo "<div id='shortenResult'>
        <img id='resultImage' src='./assets/image/FailedIcon.svg' alt='shortenFinished'>
        <p id='resultLinkFailed'>링크를 줄이는 데 실패했어요.</p>
        <p id='resultText'>데이터베이스 연결에 실패했어요.</p>
        </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'inurl') {
        echo "<div id='shortenResult'>
        <img id='resultImage' src='./assets/image/FailedIcon.svg' alt='shortenFinished'>
        <p id='resultLinkFailed'>오류가 발생했어요.</p>
        <p id='resultText'>오타가 있거나 잘못 입력했는지 확인해주세요.</p>
        </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'dnp') {
        echo "<div id='shortenResult'>
        <img id='resultImage' src='./assets/image/FailedIcon.svg' alt='shortenFinished'>
        <p id='resultLinkFailed'>오류가 발생했어요.</p>
        <p id='resultText'>사이트를 여는 도중 오류가 발생했어요.</p>
        </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'recursion') {
        echo "<div id='shortenResult'>
        <img id='resultImage' src='./assets/image/FailedIcon.svg' alt='shortenFinished'>
        <p id='resultLinkFailed'>링크를 줄이는 데 실패했어요.</p>
        <p id='resultText'>재귀함수를 여기서 만드시려는 건 아니죠?</p>
        </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'filter') {
        echo "<div id='shortenResult'>
        <img id='resultImage' src='./assets/image/FailedIcon.svg' alt='shortenFinished'>
        <p id='resultLinkFailed'>링크를 줄이는 데 실패했어요.</p>
        <p id='resultText'>단축 금지 사이트로 지정되어 있는 사이트에요.</p>
        </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'incorrect') {
        echo "<div id='shortenResult'>
        <img id='resultImage' src='./assets/image/FailedIcon.svg' alt='shortenFinished'>
        <p id='resultLinkFailed'>링크를 줄이는 데 실패했어요.</p>
        <p id='resultText'>들어가면 안 되는 문자가 포함되어 있어요.</p>
        </div>";
    }
?>
    <div id="restrictionInfo"></div>
    <div id="restrictionBackground" onclick="copy()">
        <div id="restrictionTexts">
            <p class="restrictionTitle">이런 사이트는 링크를 줄일 수 없어요!</p>
            <p class="restrictionText">
                1. 대한민국 법률 상 <strong>불법, 유해 사이트</strong>로 지정된 사이트<br>
                2. 해킹, 스미싱 등 <strong>불법적인 용도</strong>로 사용하는 사이트<br>
                3. <strong>상업적인 용도</strong>로 사용하는 사이트<br>
                4. 이외 운영자가 서비스를 제공할 수 없다고 판단하는 사이트
            </p>
            <p class="restrictionTextGray">
                이 사이트는 <strong>‘링크 단축 서비스'</strong> 입니다.<br>
                이 서비스의 운영자는 해당 서비스를 이용해 발생하는<br>
                어떠한 일에도 <strong>별도의 책임을 지지 않습니다</strong>.
            </p>
        </div>
        <button id="restClose" class="pointer" name="restClose">
            <p id="restText">확인 완료</p>
        </button>
    </div>
    <div id="header">
        <div id="logo">
            <a href="index.php">
                <svg class="logo" width="237" height="60" viewBox="0 0 237 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="svgFillWhite" d="M19.2967 22.7188V17.0369L27.4565 25.2364C27.7361 25.5129 28.0671 25.7314 28.4308 25.8794C28.7944 26.0273 29.1835 26.1018 29.5758 26.0986C30.1739 26.1021 30.7594 25.9261 31.2573 25.5931C31.7552 25.2602 32.1428 24.7854 32.3704 24.2297C32.5981 23.6739 32.6555 23.0626 32.5352 22.4739C32.4148 21.8852 32.1223 21.346 31.6951 20.9254L19.2967 8.45808V2.96592C19.2967 2.16558 18.9803 1.39801 18.4171 0.83209C17.8539 0.266166 17.0901 -0.0517578 16.2937 -0.0517578C15.4972 -0.0517578 14.7333 0.266166 14.1701 0.83209C13.607 1.39801 13.2906 2.16558 13.2906 2.96592V9.78587V22.7188L0.883565 35.1775C0.597131 35.4578 0.369491 35.793 0.214047 36.1632C0.0586041 36.5334 -0.0214844 36.9311 -0.0214844 37.3329C-0.0214844 37.7347 0.0586041 38.1325 0.214047 38.5027C0.369491 38.8729 0.597131 39.2081 0.883565 39.4884C1.16257 39.7762 1.49614 40.005 1.86455 40.1612C2.23296 40.3174 2.62876 40.3979 3.02862 40.3979C3.42848 40.3979 3.8243 40.3174 4.19271 40.1612C4.56113 40.005 4.89467 39.7762 5.17367 39.4884L16.328 28.2799L27.4822 39.4884C27.7607 39.7665 28.0915 39.986 28.4554 40.1341C28.8193 40.2821 29.209 40.3558 29.6015 40.3506C30.1996 40.3541 30.7851 40.1782 31.283 39.8452C31.7809 39.5122 32.1685 39.0375 32.3962 38.4817C32.6238 37.926 32.6812 37.3146 32.5609 36.7259C32.4406 36.1372 32.1481 35.598 31.7209 35.1775L19.2967 22.7188Z"/>
                    <path class="svgFillWhite" d="M52.1251 54.8527L39.7181 42.3854V22.7188C39.7181 21.9184 39.4018 21.1509 38.8386 20.585C38.2754 20.019 37.5115 19.7011 36.7151 19.7011C35.9186 19.7011 35.1547 20.019 34.5916 20.585C34.0284 21.1509 33.712 21.9184 33.712 22.7188V42.4285L21.305 54.8958C20.7361 55.4618 20.4142 56.2316 20.4102 57.0361C20.4062 57.8405 20.7203 58.6136 21.2835 59.1853C21.8467 59.7569 22.6129 60.0803 23.4134 60.0844C24.214 60.0884 24.9833 59.7728 25.5522 59.2068L36.7065 47.9983L47.8608 59.2068C48.4297 59.7728 49.199 60.0884 49.9995 60.0844C50.8001 60.0803 51.5662 59.7569 52.1294 59.1853C52.6926 58.6136 53.0068 57.8405 53.0028 57.0361C52.9987 56.2316 52.6769 55.4618 52.108 54.8958L52.1251 54.8527Z"/>
                    <path class="svgFillWhite" d="M96.4062 47.2344H91.8711V15.2422H96.4062V47.2344ZM68.2461 37.0742C69.5352 36.0781 70.5254 34.8477 71.2168 33.3828C71.9199 31.918 72.3945 30.3711 72.6406 28.7422C72.8867 27.1016 73.0156 25.2969 73.0273 23.3281V17.7734H77.1758V23.3281C77.1758 25.4961 77.3398 27.5176 77.668 29.3926C78.0078 31.2676 78.6348 32.9551 79.5488 34.4551C80.4395 32.9785 81.043 31.3203 81.3594 29.4805C81.6875 27.6289 81.8633 25.5781 81.8867 23.3281V17.7734H86.1758V23.3281C86.1523 26.3867 86.4629 29.0879 87.1074 31.4316C87.7637 33.7754 89.0234 35.6562 90.8867 37.0742L88.1445 40.2734C86.1875 38.7852 84.793 36.4824 83.9609 33.3652C83.0586 36.6348 81.5938 39.0195 79.5664 40.5195C77.5156 39.0195 76.0449 36.6641 75.1543 33.4531C74.3223 36.4414 72.9922 38.6562 71.1641 40.0977L68.2461 37.0742ZM104.757 20.4805H111.296V16.6836H115.796V30.6406H100.292V16.6836H104.757V20.4805ZM103.491 32.7148H124.725V41.3984H107.956V43.4727H125.639V47.0234H103.561V38.1992H120.26V36.1953H103.491V32.7148ZM111.296 27.125V23.8555H104.757V27.125H111.296ZM120.225 15.2422H124.725V21.4648H129.05V25.0859H124.725V31.5195H120.225V15.2422ZM143.852 47.5859H140.477V14.9609H143.852V47.5859ZM164.82 32.4277C164.673 31.7734 164.341 31.2656 163.824 30.9043C163.316 30.5332 162.642 30.3477 161.802 30.3477C161.216 30.3477 160.694 30.4404 160.235 30.626C159.776 30.8115 159.415 31.0654 159.151 31.3877C158.887 31.71 158.755 32.0713 158.755 32.4717C158.755 32.9502 158.951 33.3604 159.341 33.7021C159.742 34.0439 160.376 34.3125 161.246 34.5078L163.765 35.0938C165.23 35.4258 166.319 35.9482 167.032 36.6611C167.754 37.3643 168.121 38.2773 168.13 39.4004C168.121 40.3574 167.852 41.2119 167.325 41.9639C166.807 42.7061 166.06 43.2871 165.084 43.707C164.107 44.1172 162.955 44.3223 161.626 44.3223C159.732 44.3223 158.228 43.9219 157.115 43.1211C156.001 42.3105 155.347 41.1582 155.152 39.6641H158.345C158.628 41.0898 159.693 41.8027 161.539 41.8027C162.574 41.8027 163.394 41.6123 164 41.2314C164.615 40.8408 164.927 40.3086 164.937 39.6348C164.927 39.1172 164.722 38.6924 164.322 38.3604C163.931 38.0186 163.316 37.75 162.476 37.5547L159.986 37.0273C158.56 36.7148 157.476 36.1875 156.734 35.4453C155.992 34.6934 155.621 33.7656 155.621 32.6621C155.621 31.7246 155.875 30.8945 156.382 30.1719C156.9 29.4492 157.623 28.8877 158.55 28.4873C159.488 28.0869 160.562 27.8867 161.773 27.8867C162.935 27.8867 163.956 28.0723 164.834 28.4434C165.713 28.8145 166.407 29.3418 166.915 30.0254C167.422 30.709 167.73 31.5098 167.837 32.4277H164.82ZM179.513 32.4277C179.366 31.7734 179.034 31.2656 178.517 30.9043C178.009 30.5332 177.335 30.3477 176.495 30.3477C175.909 30.3477 175.387 30.4404 174.928 30.626C174.469 30.8115 174.108 31.0654 173.844 31.3877C173.58 31.71 173.448 32.0713 173.448 32.4717C173.448 32.9502 173.644 33.3604 174.034 33.7021C174.435 34.0439 175.069 34.3125 175.939 34.5078L178.458 35.0938C179.923 35.4258 181.012 35.9482 181.725 36.6611C182.447 37.3643 182.814 38.2773 182.823 39.4004C182.814 40.3574 182.545 41.2119 182.018 41.9639C181.5 42.7061 180.753 43.2871 179.776 43.707C178.8 44.1172 177.648 44.3223 176.319 44.3223C174.425 44.3223 172.921 43.9219 171.808 43.1211C170.694 42.3105 170.04 41.1582 169.845 39.6641H173.038C173.321 41.0898 174.386 41.8027 176.232 41.8027C177.267 41.8027 178.087 41.6123 178.692 41.2314C179.308 40.8408 179.62 40.3086 179.63 39.6348C179.62 39.1172 179.415 38.6924 179.015 38.3604C178.624 38.0186 178.009 37.75 177.169 37.5547L174.679 37.0273C173.253 36.7148 172.169 36.1875 171.427 35.4453C170.685 34.6934 170.314 33.7656 170.314 32.6621C170.314 31.7246 170.567 30.8945 171.075 30.1719C171.593 29.4492 172.316 28.8877 173.243 28.4873C174.181 28.0869 175.255 27.8867 176.466 27.8867C177.628 27.8867 178.649 28.0723 179.527 28.4434C180.406 28.8145 181.1 29.3418 181.608 30.0254C182.115 30.709 182.423 31.5098 182.53 32.4277H179.513ZM185.27 28.0918H188.405V44H185.27V28.0918ZM186.823 25.6309C186.471 25.6309 186.144 25.5479 185.842 25.3818C185.549 25.2158 185.309 24.9912 185.124 24.708C184.948 24.4248 184.86 24.1172 184.86 23.7852C184.86 23.4531 184.948 23.1455 185.124 22.8623C185.309 22.5791 185.553 22.3545 185.856 22.1885C186.169 22.0225 186.501 21.9395 186.852 21.9395C187.204 21.9395 187.531 22.0225 187.834 22.1885C188.136 22.3545 188.376 22.5791 188.551 22.8623C188.727 23.1455 188.815 23.4531 188.815 23.7852C188.815 24.127 188.722 24.4395 188.537 24.7227C188.361 25.0059 188.122 25.2305 187.819 25.3965C187.516 25.5527 187.184 25.6309 186.823 25.6309ZM191.877 22.7891H194.983V30.6699H195.159C195.442 30.1719 195.744 29.7324 196.067 29.3516C196.389 28.9707 196.853 28.6338 197.458 28.3408C198.074 28.0381 198.83 27.8867 199.729 27.8867C201.018 27.8867 202.17 28.2139 203.186 28.8682C204.201 29.5225 204.997 30.4697 205.574 31.71C206.15 32.9404 206.438 34.4004 206.438 36.0898C206.438 37.7598 206.15 39.2197 205.574 40.4697C204.997 41.71 204.206 42.6621 203.201 43.3262C202.195 43.9805 201.047 44.3125 199.758 44.3223C198.869 44.3223 198.118 44.1709 197.502 43.8682C196.897 43.5654 196.423 43.2188 196.081 42.8281C195.74 42.4277 195.432 41.9883 195.159 41.5098H194.924V44H191.877V22.7891ZM194.924 36.0312C194.924 37.1445 195.085 38.126 195.408 38.9756C195.73 39.8154 196.203 40.4746 196.828 40.9531C197.453 41.4219 198.196 41.6562 199.055 41.6562C199.944 41.6562 200.701 41.4121 201.326 40.9238C201.96 40.4355 202.439 39.7715 202.761 38.9316C203.083 38.082 203.244 37.1152 203.244 36.0312C203.244 34.9668 203.083 34.0244 202.761 33.2041C202.449 32.374 201.98 31.7246 201.355 31.2559C200.73 30.7871 199.963 30.5527 199.055 30.5527C198.176 30.5527 197.424 30.7773 196.799 31.2266C196.184 31.666 195.715 32.3008 195.393 33.1309C195.08 33.9512 194.924 34.918 194.924 36.0312ZM210.994 44.2051C210.623 44.2051 210.276 44.1123 209.954 43.9268C209.642 43.7412 209.388 43.4922 209.192 43.1797C209.007 42.8672 208.914 42.5254 208.914 42.1543C208.914 41.7734 209.007 41.4219 209.192 41.0996C209.378 40.7773 209.627 40.5234 209.939 40.3379C210.262 40.1426 210.613 40.0449 210.994 40.0449C211.365 40.0449 211.707 40.1377 212.019 40.3232C212.342 40.5088 212.596 40.7627 212.781 41.085C212.976 41.4072 213.074 41.7539 213.074 42.125C213.074 42.4961 212.976 42.8428 212.781 43.165C212.596 43.4775 212.342 43.7314 212.019 43.9268C211.707 44.1123 211.365 44.2051 210.994 44.2051ZM215.521 39.5176C215.511 37.8672 216.063 36.6904 217.176 35.9873C218.299 35.2842 219.73 34.8691 221.468 34.7422C223.724 34.6152 225.116 34.542 225.643 34.5225L225.628 33.248C225.638 32.3398 225.365 31.6416 224.808 31.1533C224.261 30.6553 223.46 30.4062 222.406 30.4062C221.517 30.4062 220.79 30.5918 220.223 30.9629C219.657 31.3242 219.291 31.8125 219.125 32.4277H216.019C216.117 31.5488 216.444 30.7676 217.001 30.084C217.557 29.3906 218.309 28.8535 219.256 28.4727C220.204 28.082 221.292 27.8867 222.523 27.8867C223.529 27.8867 224.496 28.043 225.423 28.3555C226.361 28.6582 227.152 29.2246 227.796 30.0547C228.441 30.875 228.763 31.998 228.763 33.4238V44H225.716V41.832H225.599C225.238 42.5254 224.662 43.1211 223.871 43.6191C223.08 44.1074 222.084 44.3516 220.882 44.3516C219.867 44.3516 218.949 44.1611 218.128 43.7803C217.318 43.3994 216.678 42.8477 216.209 42.125C215.751 41.3926 215.521 40.5234 215.521 39.5176ZM218.568 39.5469C218.568 40.2891 218.841 40.8604 219.388 41.2607C219.945 41.6514 220.677 41.8516 221.585 41.8613C222.406 41.8613 223.124 41.6953 223.739 41.3633C224.354 41.0312 224.828 40.5918 225.16 40.0449C225.492 39.4883 225.658 38.8926 225.658 38.2578L225.643 36.8076L221.908 37.0566C220.843 37.1348 220.018 37.3789 219.432 37.7891C218.856 38.1992 218.568 38.7852 218.568 39.5469ZM235.077 44H231.943V22.7891H235.077V44Z"/>
                </svg>
            </a>
        </div>
        <div id="changeMode">
            <img id="toggleThemeLight" class="pointer" src="./assets/image/dark.svg" alt="darkmode">
            <img id="toggleThemeDark" class="pointer disable" src="./assets/image/light.svg" alt="darkmode">
        </div>
    </div>
    <div id="wrapper">
        <div id="scrollSection">
            <div id="scrollSection1" class="section">
                <div id="content">
                    <div id="title">
                        <h1 class="title">한 번 들으면<br><span style="color:#297DEC">잊을 수 없는</span> 서비스.</h1>
                    </div>
                    <div id="userInput">
                        <form method="POST" action="functions/shorten.php">
                            <div id="originalURL">
                                <input type="url" name="url" id="input" class="draggable input" value="https://" placeholder="줄이고 싶은 링크를 입력해주세요." autocomplete="off">
                            </div>
                            <div id="shortenURL">
                                <div id="uniqueCode">
                                    <p id="uniqueCodePlaceholder">ssib.al/</p>
                                    <input type="text" name="custom" id="custom" class="draggable" placeholder="대신할 이름(선택)" autocomplete="off">
                                </div>
                                <div id="submit">
                                    <input type="submit" class="submit pointer" id="shortenButton" value="링크 줄이기">
                                </div>
                            </div>
                        </form>
                        <button id="restriction" class="pointer" name="restriction">
                            <img id="warning" src="./assets/image/linkShortenWarning.svg">
                            <p id="warningText">이런 사이트는 링크를 줄일 수 없어요.</p>
                        </button>
                    </div>
                </div>
                <div id="footer">
                    <div id="scrollDown">
                        <svg id="scrollDownIcon" width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="svgStrkc1" d="M2 14.7551L14.5 2L27 14.7551M2 27L14.5 14.2449L27 27" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p id="scrollDownText">아래로 내려서 더보기</p>
                    </div>
                </div>
            </div>
            <div id="scrollSection2" class="section">
                <div id="content">
                    <div id="scrollUp">
                        <svg id="scrollUpIcon" width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="svgStrkc1" d="M2 14.7551L14.5 2L27 14.7551M2 27L14.5 14.2449L27 27" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p id="scrollUpText">위로 올려서 링크 줄이기</p>
                    </div>
                    <div id="secondTitle">
                        <p>다른 서비스도 이용해보기</p>
                    </div>
                    <div id="upperBlock">
                        <div id="upperBlocks" class="pointer" onclick="location.href='https://ssib.al'">
                            <svg id="upperBlock1Icon" viewbox="0 0 88 88" xmlns="http://www.w3.org/2000/svg">
                                <path class="svgFillc1" d="M37.39,0h40.49c5.59,0,10.12,4.53,10.12,10.12h0c0,5.59-4.53,10.12-10.12,10.12H37.39c-5.59,0-10.12-4.53-10.12-10.12h0c0-5.59,4.53-10.12,10.12-10.12Z"/>
                                <path class="svgFillc2" d="M77.88,25.3h0c5.59,0,10.12,4.53,10.12,10.12h0c0,5.59-4.53,10.12-10.12,10.12h0c-5.59,0-10.12-4.53-10.12-10.12h0c0-5.59,4.53-10.12,10.12-10.12Z"/>
                                <path class="svgFillWhite" d="M17.65,5.12C7.9,5.12,0,13.02,0,22.77s7.9,17.65,17.65,17.65H60.16c2.76,0,5-2.24,5-5s-2.24-5-5-5H17.65c-4.23,0-7.65-3.43-7.65-7.65s3.43-7.65,7.65-7.65h2.02c2.76,0,5-2.24,5-5s-2.24-5-5-5h-2.02Z"/>
                            </svg>
                            <p id="upperBlockTextActivated">링크 줄이기</p>
                        </div>
                        <div id="upperBlocksNotActivated">
                            <img id="upperBlock2Icon" src="./assets/image/linkShorten.svg" alt="shortenIcon">
                            <p id="upperBlocksTextNotActivated">개발 예정</p>
                        </div>
                        <div id="upperBlocksNotActivated">
                            <img id="upperBlock3Icon" src="./assets/image/linkShorten.svg" alt="shortenIcon">
                            <p id="upperBlocksTextNotActivated">개발 예정</p>
                        </div>
                        <div id="upperBlocksNotActivated">
                            <img id="upperBlock4Icon" src="./assets/image/linkShorten.svg" alt="shortenIcon">
                            <p id="upperBlocksTextNotActivated">개발 예정</p>
                        </div>
                    </div>
                    <div id="bottomBlock">
                        <div id="bottomBlocks" class="pointer" onclick="location.href='https://ssib.al/source'">
                            <svg id="bottomBlock1Icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.58 31.77"><path class="cls-1" d="M16.29,0a16.29,16.29,0,0,0-5.15,31.75c.82.15,1.11-.36,1.11-.79s0-1.41,0-2.77C7.7,29.18,6.74,26,6.74,26a4.36,4.36,0,0,0-1.81-2.39c-1.47-1,.12-1,.12-1a3.43,3.43,0,0,1,2.49,1.68,3.48,3.48,0,0,0,4.74,1.36,3.46,3.46,0,0,1,1-2.18c-3.62-.41-7.42-1.81-7.42-8a6.3,6.3,0,0,1,1.67-4.37,5.94,5.94,0,0,1,.16-4.31s1.37-.44,4.48,1.67a15.41,15.41,0,0,1,8.16,0c3.11-2.11,4.47-1.67,4.47-1.67A5.91,5.91,0,0,1,25,11.07a6.3,6.3,0,0,1,1.67,4.37c0,6.26-3.81,7.63-7.44,8a3.85,3.85,0,0,1,1.11,3c0,2.18,0,3.94,0,4.47s.29.94,1.12.78A16.29,16.29,0,0,0,16.29,0Z"/></svg>
                            <p id="bottom1SmallText">소스코드를 확인해보고 싶으신가요?</p>
                            <p id="bottom1Text">GitHub 레포지토리로 가기</p>
                        </div>
                        <div id="bottomBlocks" class="pointer" onclick="location.href='https://ssib.al/discord'">
                            <svg id="bottomBlock2Icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127.14 96.36"><path d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,46,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,46,96.12,53,91.08,65.69,84.69,65.69Z"/></svg>
                            <div id="bottomTexts">
                                <p id="bottom2SmallText">관련 소식을 빠르게 접하고 싶으신가요?</p>
                                <p id="bottom2Text">디스코드 서버 접속하기</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="bFooter">
                    <p class="footerText">Copyright 2022-2023, <strong>JinseoMyeon</strong> All Rights Reserved.</p>
                    <p class="footerText">Email : i@ssib.al | GitHub : <a href="https://ssib.al/source">ssib.al/source</a></p>
                    <p class="footerBoldText">ssib.al v2.1.3</p>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/index.js"></script>
</body>
</html>