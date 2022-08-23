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
        $_SESSION['error'] = '<p class="ignore shortenlink" style="color:#fe5151;">' . "ssib.al/" . $_POST['custom'] . "</p><p class='ignore shorten'>은 이미 존재합니다.</p>";
    }
}

if (isset($_POST['url']) && !$errors) {
    $orignalURL = $_POST['url'];
    
    if (!$insertCustom) {
        if ($uniqueCode = $urlShortener->validateUrlAndReturnCode($orignalURL)) {
            $_SESSION['success'] = $urlShortener->generateLinkForShortURL($uniqueCode);
        }
        
        else {
            $_SESSION['error'] = "잘못된 URL로 접근하셨습니다.";
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