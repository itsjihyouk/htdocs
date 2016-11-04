<?php
    function mb_basename($path) { return end(explode('/',$path)); } 
    function utf2euc($str) { return iconv("UTF-8","cp949//IGNORE", $str); }
    function is_ie() {
            if(!isset($_SERVER['HTTP_USER_AGENT']))return false;
            if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) return true; // IE8
            if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 6.1') !== false) return true; // IE11
            return false;
    }
    $idx=$_GET['idx'];
    include "dbCon.php";
    $idx = $_GET['idx'];
    $sql = "SELECT * FROM board WHERE idx=$idx";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    $filepath = '../'.$row['fileLocation'].$row['changedFilename'];//'./'.$row['fileLocation'];
    $filesize = filesize($filepath);
    $filename = mb_basename($filepath);
    if( is_ie() ) $filename = utf2euc($filename);

    header("Pragma: public");
    header("Expires: 0");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$row['originalFilename']."");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: $filesize");

    readfile($filepath);
?>