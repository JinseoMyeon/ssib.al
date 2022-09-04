<?php

require_once("./UrlShortener.php");
require_once("../config.php");

$urlShortener = new UrlShortener();

if (isset($_GET['secret'])) {
    $conns = mysqli_connect(HOST_NAME, USER_NAME, USER_PASSWORD, DB_NAME);
    $uniqueCode = $_GET['secret'];
    $orignalUrl = $urlShortener->getOrignalURL($uniqueCode);
    $dbQuery = $this->db->query("SELECT * FROM link WHERE code = '{$uniqueCode}'");
    $getResult = mysqli_query($conns, $dbQuery);
    $getResult = mysqli_fetch_array($getResult);
    $getCount = $row['used_count'] + 1;
    $updateInDatabase = $this->db->query("UPDATE link SET used_count = '{$getCount}' WHERE code = '{$uniqueCode}'");
    $updateInDatabase = $this->db->query("UPDATE link SET last_used = NOW() WHERE code = '{$uniqueCode}'");
    header("Location: {$orignalUrl}");
    die();
}

header("Location: index.php");
die();

?>