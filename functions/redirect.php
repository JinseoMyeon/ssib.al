<?php

require_once("UrlShortener.php");
require_once("../config.php");

$urlShortener = new UrlShortener();

if (isset($_GET['secret'])) {

    $this->db = new mysqli(HOST_NAME, USER_NAME, USER_PASSWORD, DB_NAME);
    if ($this->db->connect_errno) {
        header("Location: ../index.php?error=db");
        die();
    }

    $uniqueCode = $_GET['secret'];
    $orignalUrl = $urlShortener->getOrignalURL($uniqueCode);
    $getCount = $this->db->query("SELECT used_count FROM link WHERE code = '{$uniqueCode}'");
    $getCount = $getCount + 1;
    $updateInDatabase = $this->db->query("UPDATE link SET used_count = '{$getCount}' WHERE code = '{$uniqueCode}'");
    $updateInDatabase = $this->db->query("UPDATE link SET last_used = NOW() WHERE code = '{$uniqueCode}'");
    header("Location: {$orignalUrl}");
    die();
}

header("Location: index.php");
die();

?>