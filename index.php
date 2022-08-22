<?php
    session_start();
    require_once("./config.php");
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="url shortener">
    <title>씨발 | 링크 단축 서비스</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <img src="./assets/images/ssibal.svg" class="ignore logo">
    <div class="description">
        <h1 class="title ignore">한 번 들으면 잊을 수 없는<br>링크 단축 서비스.</h1>
        <p class="urltext ignore">단축할 링크 원본</p>
    </div>
    <?php
    if (isset($_SESSION['success'])) {
        echo "<p class='success'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p class='alert'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    if (isset($_GET['error']) && $_GET['error'] == 'db') {
        echo "<p class='alert'>데이터베이스에 연결하는 데 실패했습니다.</p>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'inurl') {
        echo "<p class='alert'>잘못된 URL로 접근하셨습니다.</p>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'dnp') {
        echo "<p class='alert'>오류가 발생했습니다.</p>";
    }
    ?>
    <form method="POST" action="functions/shorten.php">
        <div>
            <div>
                <input type="url" id="input" value="https://" name="url" class="input" placeholder="단축하려는 링크를 입력해주세요.">
            </div>
            <div>
                <p class="ssibal ignore">ssib.al/</p>
                <img class="arrow ignore" src="./assets/images/arrow.svg">
                <input type="text" id="custom" name="custom" class="inputsmall" placeholder="원하는 링크 이름(선택)">
            </div>
        </div>
        <input type="submit" class="submit" id="shortenButton" value="링크 줄이기">
    </form>
    <a href="https://github.com/jinseomyeon/ssib.al">
        <img src="./assets/images/github.svg" class="github ignore">
    </a>
    <div class="infodiv">
        <img src="./assets/images/warning.svg" class="ignore">
        <p class="bold ignore" style="font-size:1rem; margin-left:2rem; margin-top: -1.6rem; color:#333333;">이런 사이트는 링크를 단축할 수 없어요!</p>
    </div>
    <script href="./assets/js/index.js"></script>
</body>
</html>