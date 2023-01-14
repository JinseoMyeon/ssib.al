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
        <p id='resultText'>잘못된 링크로 접속하셨어요.</p>
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
        <button id="restClose" name="restClose">
            <p id="restText">확인 완료</p>
        </button>
    </div>
    <div id="header">
        <div id="logo">
            <a href="index.php"><img src="assets/image/logo.svg" class="logo" alt="logo"></a>
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
                                    <input type="submit" class="submit" id="shortenButton" value="링크 줄이기">
                                </div>
                            </div>
                        </form>
                        <button id="restriction" name="restriction">
                            <img id="warning" src="./assets/image/linkShortenWarning.svg">
                            <p id="warningText">이런 사이트는 링크를 줄일 수 없어요.</p>
                        </button>
                    </div>
                </div>
                <div id="footer">
                    <div id="scrollDown">
                        <img id="scrollDownIcon" src="./assets/image/moreIcon.svg" alt="scrollDown">
                        <p id="scrollDownText">아래로 내려서 더보기</p>
                    </div>
                </div>
            </div>
            <div id="scrollSection2" class="section">
                <div id="content">
                    <div id="scrollUp">
                        <img id="scrollUpIcon" src="./assets/image/moreIcon.svg" alt="scrollUp">
                        <p id="scrollUpText">위로 올려서 링크 줄이기</p>
                    </div>
                    <div id="secondTitle">
                        <p>다른 서비스도 이용해보기</p>
                    </div>
                    <div id="upperBlock">
                        <div id="upperBlocks" onclick="location.href='https://ssib.al'">
                            <img id="upperBlock1Icon" src="./assets/image/linkShorten.svg" alt="shortenIcon">
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
                        <div id="bottomBlocks" onclick="location.href='https://ssib.al/source'">
                            <img id="bottomBlock1Icon" src="./assets/image/github.svg" alt="shortenIcon">
                            <p id="bottom1SmallText">소스코드를 확인해보고 싶으신가요?</p>
                            <p id="bottom1Text">GitHub 레포지토리로 가기</p>
                        </div>
                        <div id="bottomBlocks" onclick="location.href='https://ssib.al/discord'">
                            <img id="bottomBlock2Icon" src="./assets/image/discord.svg" alt="shortenIcon">
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
                    <p class="footerBoldText">ssib.al v2.0.2</p>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/index.js"></script>
</body>
</html>