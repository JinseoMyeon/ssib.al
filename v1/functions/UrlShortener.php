<?php

require_once("../config.php");

class UrlShortener {

    protected $db;
    
    public function __construct() {
        $this->db = new mysqli(HOST_NAME, USER_NAME, USER_PASSWORD, DB_NAME);
        
        if ($this->db->connect_errno) {
            header("Location: ../index.php?error=db");
            die();
        }
    }
    
    /**
     * Function to generate random unique code for new urls
     *
     * @param string $num row number of the link saved in database
     *
     * @return integer
     */
    
    public function generateUniqueCode($idOfRow) {
        //$idOfRow += 10000000;
        $idOfRow = rand(46656,2147483647);
        $idOfRow = base_convert($idOfRow, 10, 36);
        $sql = "SELECT * FROM link where code ='{$idOfRow}'";
        $result = mysqli_fetch_array(mysqli_query($this->db, $sql));
        while($result) {
            $idOfRow = rand(46656,2147483647);
            $idOfRow = base_convert($idOfRow, 10, 36);
            $sql= "SELECT * FROM link where code ='{$idOfRow}'";
            $result = mysqli_fetch_array(mysqli_query($this->db, $sql));
        }
        return $idOfRow;
    }
    
    /**
     * Validates URL, checks if already present in database and finally inserts
     * in database
     *
     * @param string $url Real Url
     *
     * @return string
     */
    
    public function validateUrlAndReturnCode($orignalURL) {

        function pingDomain($domain) {
            $starttime = microtime(true);
            $file      = fsockopen ($domain, 80, $errno, $errstr, 10);
            $stoptime  = microtime(true);
            $status    = 0;
        
            if(!$file)
            {
                $status = -1;
            }
            else
            {
                fclose($file);
                $status = ($stoptime - $starttime) * 1000;
                $status = floor($status);
            }
            return $status;
        }

        $orignalURL = trim($orignalURL);
        $orignalURL = str_replace("https://https://", "https://", $orignalURL);
        $orignalURL = str_replace("https://http://", "http://", $orignalURL);
        $orignalURL = str_replace("http://https://", "https://", $orignalURL);
        $orignalURL = str_replace("http://http://", "http://", $orignalURL);

        $pingURL = str_replace("https://", "", $orignalURL);
        $pingURL = str_replace("http://", "", $pingURL);
        $pingURL = explode('/',$pingURL);
        $pingResult = pingDomain($pingURL[0]);

        $getFilter  = $this->db->query("SELECT * FROM link_censored WHERE url LIKE '%$pingURL[0]%'");

        if ($getFilter->num_rows > 0) {
            header("Location: ../index.php?error=filter");
            $updateInDatabase = $this->db->query("UPDATE link_censored SET counts = counts + 1 WHERE url LIKE '%$pingURL[0]%'");
            die();
        }

        if (!filter_var($orignalURL, FILTER_VALIDATE_URL)) {
            header("Location: ../index.php?error=inurl");
            die();
        }

        else if ($pingResult == -1) {
            header("Location: ../index.php?error=inurl");
            die();
        }


        else {
            $orignalURL      = $this->db->real_escape_string($orignalURL);
            $orignalURL = str_replace("https://https://", "https://", $orignalURL);
            $orignalURL = str_replace("https://http://", "http://", $orignalURL);
            $orignalURL = str_replace("http://https://", "https://", $orignalURL);
            $orignalURL = str_replace("http://http://", "http://", $orignalURL);

            $existInDatabase = $this->db->query("SELECT * FROM link WHERE url ='{$orignalURL}'");
            
            if ($existInDatabase->num_rows) {
                $uniqueCode = $existInDatabase->fetch_object()->code;
                
                return $uniqueCode;
            }
            
            $insertInDatabase  = $this->db->query("INSERT INTO link (url,created) VALUES ('{$orignalURL}',NOW())");
            $fetchFromDatabase = $this->db->query("SELECT * FROM link WHERE url = '{$orignalURL}'");
            $getIdOfRow        = $fetchFromDatabase->fetch_object()->id;
            $uniqueCode        = $this->generateUniqueCode($getIdOfRow);
            $updateInDatabase  = $this->db->query("UPDATE link SET code = '{$uniqueCode}' WHERE url = '{$orignalURL}'");
            
            return $uniqueCode;
        }
    }
    
    /**
     * Insert url and custom short url on the database
     *
     * @param string $url Real Url
     * @param string $custom Custom short url wanted
     *
     * @return boolean
     */
    
    public function returnCustomCode($orignalURL, $customUniqueCode) {
        function pingDomain($domain) {
            $starttime = microtime(true);
            $file      = fsockopen ($domain, 80, $errno, $errstr, 10);
            $stoptime  = microtime(true);
            $status    = 0;
        
            if(!$file)
            {
                $status = -1;
            }
            else
            {
                fclose($file);
                $status = ($stoptime - $starttime) * 1000;
                $status = floor($status);
            }
            return $status;
        }

        $orignalURL       = trim($orignalURL);
        $customUniqueCode = trim($customUniqueCode);

        $pingURL = str_replace("https://", "", $orignalURL);
        $pingURL = str_replace("http://", "", $pingURL);
        $pingURL = explode('/',$pingURL);
        $pingResult = pingDomain($pingURL[0]);

        $getFilter  = $this->db->query("SELECT * FROM link_censored WHERE url LIKE '%$pingURL[0]%'");

        if ($getFilter->num_rows > 0) {
            header("Location: ../index.php?error=filter");
            $updateInDatabase = $this->db->query("UPDATE link_censored SET counts = counts + 1 WHERE url LIKE '%$pingURL[0]%'");
            die();
        }

        if(strpos(strtolower($orignalURL), "https://ssib.al/") !== false) {
            header("Location: ../index.php?error=recursion");
            die();
        }

        else if(strpos(strtolower($orignalURL), "http://ssib.al/") !== false) {
            header("Location: ../index.php?error=recursion");
            die();
        }

        else if ($pingResult == -1) {
            header("Location: ../index.php?error=inurl");
            die();
        }

        if (strpos($customUniqueCode, '"') !== false
        || strpos($customUniqueCode, "'") !== false
        || strpos($customUniqueCode, "&") !== false
        || strpos($customUniqueCode,"(") !== false
        || strpos($customUniqueCode,")") !== false
        || strpos($customUniqueCode, "=") !== false
        || strpos($customUniqueCode, "<") !== false
        || strpos($customUniqueCode, ">") !== false) {
            header("Location: ../index.php?error=incorrect");
            die();
        }
        
        if (filter_var($orignalURL, FILTER_VALIDATE_URL)) {
            $orignalURL      = $this->db->real_escape_string($orignalURL);
            $customUniqueCode = $this->db->real_escape_string($customUniqueCode);
            $insert = $this->db->query("INSERT INTO link (url,code,created) VALUES ('{$orignalURL}','{$customUniqueCode}',NOW())");
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Returns the orignal URL based on the shorten url
     *
     * @param string $string Real Url
     *
     * @return string
     */
    
    public function getOrignalURL($string) {
        $string = $this->db->real_escape_string(strip_tags(addslashes($string)));
        $rows   = $this->db->query("SELECT url FROM link WHERE code = '{$string}'");
        
        if ($rows->num_rows) {
            return $rows->fetch_object()->url;
        }
        
        else {
            header("Location: index.php?error=dnp");
            die();
        }
    }
    
    /**
     * Check if shorten code is already present in database
     *
     * @param string $short
     *
     * @return boolean
     */
    
    public function checkUrlExistInDatabase($customCode) {
        $customCode  = $this->db->real_escape_string(strip_tags(addslashes($customCode)));
        $fetchedRows = $this->db->query("SELECT url FROM link WHERE code = '{$customCode}' LIMIT 1");
        
        return $fetchedRows->num_rows > 0;
    }
    
    /**
     * Generates link tag for the new shorten url
     *
     * @param string $uniqueCode
     *
     * @return string
     */
    
    public function generateLinkForShortURL($uniqueCode = '') {
        return '<a class="shortenlink" href="' . BASE_URL . $uniqueCode . '">' . "ssib.al/" . $uniqueCode . '</a><p class="ignore shorten"> 링크로 단축했어요!</p>';
    }
}

?>