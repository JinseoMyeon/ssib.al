<?php

session_start();

require_once(__DIR__."/../config.php");
require_once(__DIR__."/UrlShortener.php");

$errors       = false;
$insertCustom = false;

$urlShortener = new UrlShortener();

if (!$_POST['custom'] == '') {
    $customCode = $_POST['custom'];
    
    if (!$urlShortener->checkUrlExistInDatabase($customCode)) {
        $insertCustom = true;
    }
    
    else {
        $errors            = true;
        $_SESSION['error'] = '<p id="resultText">이 링크는 이미 누군가가 쓰고 있어요.</p>';
    }
}

if (isset($_POST['url']) && !$errors) {
    $orignalURL = $_POST['url'];
    
    if (!$insertCustom) {
        if ($uniqueCode = $urlShortener->validateUrlAndReturnCode($orignalURL)) {
            $_SESSION['success'] = $urlShortener->generateLinkForShortURL($uniqueCode);
        }
        
        else {
            $_SESSION['error'] = '<p id="resultText">잘못된 링크로 접속하셨어요.</p>';
        }
    }
    
    else {
        if ($urlShortener->returnCustomCode($orignalURL, $customCode)) {
            $_SESSION['success'] = $urlShortener->generateLinkForShortURL($customCode);
        }
        
        else {
            header("Location: ../index.php?error=inurl");
            die();
        }
    }
}

header("Location: ../index.php");
exit();

?>