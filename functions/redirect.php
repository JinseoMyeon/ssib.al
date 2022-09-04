<?php

require_once("./UrlShortener.php");
require_once("../config.php");

$urlShortener = new UrlShortener();

if (isset($_GET['secret'])) {
    $database = new mysqli(HOST_NAME, USER_NAME, USER_PASSWORD, DB_NAME);
    $uniqueCode = $_GET['secret'];
    $getUniqueCode = $uniqueCode;
    $orignalUrl = $urlShortener->getOrignalURL($uniqueCode);
    $rows = $database->query("SELECT * FROM link WHERE code = '{$getUniqueCode}' AND url = '{$orignalUrl}' LIMIT 1");
    $count = ($rows->fetch_object()->used_count) + 1;
    $updateInDatabase = $database->query("UPDATE link SET used_count = '{$count}', last_used = NOW() WHERE code = '{$getUniqueCode}' AND url = '{$orignalUrl}'");
    header("Location: {$orignalUrl}");
    die();
}

header("Location: index.php");
die();

?>