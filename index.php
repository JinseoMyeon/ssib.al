<?php
    session_start();
    require_once("./config.php");
?>

<!DOCTYPE html>
<html>
<head lang="ko">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="url shortener">
    <meta name="color-scheme" content="dark light" />
    <meta name="naver-site-verification" content="b8c6d6c2cd25f58f7714a81dc07a2ff625124832" />
    <meta name="msvalidate.01" content="6E57E9298518AF4483787369C99AA184" />
    <meta name="description" content="한 번 들으면 잊을 수 없는 링크 단축 서비스.">
    <meta property="og:title" content="씨발 | 링크 단축 서비스">
    <meta property="og:description" content="한 번 들으면 잊을 수 없는 링크 단축 서비스.">
    <title>씨발 | 링크 단축 서비스</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="icon" href="./assets/images/favicon.ico">
</head>
<body>
    <svg id="toggleTheme" class="ignore logo" width="71" height="80" viewBox="0 0 71 80" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path class="bluesvg" d="M25.8506 30.2917V22.7159L36.7816 33.6485C37.1561 34.0173 37.5996 34.3086 38.0867 34.5059C38.5739 34.7031 39.0951 34.8024 39.6206 34.7981C40.4218 34.8028 41.2062 34.5682 41.8732 34.1242C42.5401 33.6803 43.0594 33.0473 43.3644 32.3063C43.6694 31.5653 43.7462 30.7501 43.5851 29.9652C43.4239 29.1803 43.032 28.4614 42.4597 27.9006L25.8506 11.2775V3.9546C25.8506 2.88748 25.4267 1.86406 24.6722 1.10949C23.9178 0.354929 22.8945 -0.0689697 21.8276 -0.0689697C20.7606 -0.0689697 19.7373 0.354929 18.9829 1.10949C18.2284 1.86406 17.8046 2.88748 17.8046 3.9546V13.0479V30.2917L1.18386 46.9033C0.800147 47.2771 0.495195 47.724 0.286959 48.2176C0.0787239 48.7112 -0.0285645 49.2416 -0.0285645 49.7773C-0.0285645 50.313 0.0787239 50.8433 0.286959 51.3369C0.495195 51.8305 0.800147 52.2774 1.18386 52.6513C1.55763 53.035 2.00448 53.34 2.49801 53.5483C2.99154 53.7566 3.52176 53.8639 4.05742 53.8639C4.59309 53.8639 5.12334 53.7566 5.61687 53.5483C6.1104 53.34 6.55722 53.035 6.93099 52.6513L21.8735 37.7066L36.816 52.6513C37.189 53.0221 37.6323 53.3148 38.1198 53.5122C38.6073 53.7096 39.1292 53.8077 39.6551 53.8009C40.4563 53.8056 41.2406 53.5709 41.9076 53.127C42.5746 52.683 43.0939 52.05 43.3989 51.309C43.7039 50.568 43.7807 49.7529 43.6195 48.9679C43.4584 48.183 43.0665 47.4641 42.4942 46.9033L25.8506 30.2917Z" fill="#333333"/>
        <path class="whitesvg" d="M69.8277 73.1369L53.207 56.5139V30.2917C53.207 29.2246 52.7831 28.2012 52.0287 27.4466C51.2742 26.6921 50.2509 26.2682 49.184 26.2682C48.117 26.2682 47.0937 26.6921 46.3393 27.4466C45.5848 28.2012 45.161 29.2246 45.161 30.2917V56.5713L28.5403 73.1945C27.7782 73.9491 27.347 74.9755 27.3416 76.0481C27.3362 77.1206 27.7571 78.1514 28.5115 78.9137C29.266 79.6759 30.2924 80.1071 31.3648 80.1125C32.4372 80.1179 33.4678 79.697 34.2299 78.9424L49.1725 63.9977L64.115 78.9424C64.8771 79.697 65.9077 80.1179 66.9802 80.1125C68.0526 80.1071 69.0789 79.6759 69.8334 78.9137C70.5879 78.1514 71.0087 77.1206 71.0033 76.0481C70.998 74.9755 70.5668 73.9491 69.8047 73.1945L69.8277 73.1369Z" fill="#297DFC"/>
    </svg>  
    <div class="description">
        <h1 class="title ignore">한 번 들으면 잊을 수 없는<br>링크 단축 서비스.</h1>
        <p class="urltext ignore">단축할 링크 원본</p>
    </div>
    <?php
    if (isset($_SESSION['success'])) {
        echo "<p>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    if (isset($_GET['error']) && $_GET['error'] == 'db') {
        echo "<p class='shortenlink ignore' style='color:#fe5151;'>오류가 발생했습니다.</p><p class='shorten ignore'>데이터베이스에 연결하는 데 실패했습니다.</p>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'inurl') {
        echo "<p class='shortenlink ignore' style='color:#fe5151;'>오류가 발생했습니다.</p><p class='shorten ignore'>잘못된 URL로 접근하셨습니다.</p>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'dnp') {
        echo "<p class='shortenlink ignore' style='color:#fe5151;'>오류가 발생했습니다.</p><p class='shorten ignore'>사이트를 여는 도중 오류가 발생했습니다.</p>";
    }
    ?>
    <form method="POST" action="functions/shorten.php">
        <div>
            <div>
                <input type="url" id="input" value="https://" name="url" class="input" placeholder="단축하려는 링크를 입력해주세요.">
            </div>
            <div>
                <p class="ssibal ignore">ssib.al/</p>
                <svg class="arrow ignore" width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="arrow" d="M1 1L6 6L1 11" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="text" id="custom" name="custom" class="inputsmall" placeholder="원하는 링크 이름(선택)">
            </div>
        </div>
        <input type="submit" class="submit" id="shortenButton" value="링크 줄이기">
    </form>
    <a href="https://github.com/jinseomyeon/ssib.al">
        <svg fill="#333333" class="ignore github" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.58 31.77"><path class="cls-1" d="M16.29,0a16.29,16.29,0,0,0-5.15,31.75c.82.15,1.11-.36,1.11-.79s0-1.41,0-2.77C7.7,29.18,6.74,26,6.74,26a4.36,4.36,0,0,0-1.81-2.39c-1.47-1,.12-1,.12-1a3.43,3.43,0,0,1,2.49,1.68,3.48,3.48,0,0,0,4.74,1.36,3.46,3.46,0,0,1,1-2.18c-3.62-.41-7.42-1.81-7.42-8a6.3,6.3,0,0,1,1.67-4.37,5.94,5.94,0,0,1,.16-4.31s1.37-.44,4.48,1.67a15.41,15.41,0,0,1,8.16,0c3.11-2.11,4.47-1.67,4.47-1.67A5.91,5.91,0,0,1,25,11.07a6.3,6.3,0,0,1,1.67,4.37c0,6.26-3.81,7.63-7.44,8a3.85,3.85,0,0,1,1.11,3c0,2.18,0,3.94,0,4.47s.29.94,1.12.78A16.29,16.29,0,0,0,16.29,0Z"/></svg>
    </a>
    <div class="infodiv">
        <img src="./assets/images/warning.svg" class="ignore icon">
        <p class="bold ignore warning">이런 사이트는 링크를 단축할 수 없어요.</p>
        <p class="ignore paragraph m-2">대한민국 법률 상 <strong>불법, 유해 사이트</strong>로 지정된 사이트</p>
        <p class="ignore paragraph m-1">해킹, 스미싱 등 <strong>불법적인 용도</strong>로 사용하는 사이트</p>
        <p class="ignore paragraph m-1"><strong>상업적인 용도</strong>로 사용하는 사이트</p>
        <p class="ignore paragraph p-small m-05 dline">(설마 이 링크로...?)</p>
        <p class="ignore paragraph m-1">이외 운영자가 <strong>링크 단축 서비스를 제공할 수 없다</strong>고 판단하는 사이트</p>
        <p class="ignore paragraph p-small m-05 dline">이런 사이트는 운영자에 의해 무통보 삭제될 수 있어요.</p>
        <p class="ignore paragraph p-small m-2">이 사이트는 <strong>링크 단축 서비스만</strong> 제공하고 있습니다.<br>
            이 서비스의 운영자는 해당 링크 단축 서비스를 이용해 발생하는<br>어떠한 사건에도 <strong>책임을 지지 않습니다.</strong></p>
    </div>
    <script src="./assets/js/index.js"></script>
</body>
</html>