<?php

require_once("./UrlShortener.php");
require_once("../config.php");

$urlShortener = new UrlShortener();

if (isset($_GET['secret'])) {
    $database = new mysqli(HOST_NAME, USER_NAME, USER_PASSWORD, DB_NAME);
    $uniqueCode = $_GET['secret'];
    $orignalUrl = $urlShortener->getOrignalURL($uniqueCode);
    $rows = $database->query("SELECT used_count FROM link WHERE code = '{$uniqueCode}'");
    $getCount = $rows->fetch_object();
    $count = int($rows->fetch_object()) + 1;
    $updateInDatabase = $database->query("UPDATE link SET used_count = '{$count}' WHERE code = '{$uniqueCode}'");
    header("Location: {$orignalUrl}");
    die();
}

header("Location: index.php");
die();

?>