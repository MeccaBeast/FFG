<?php
// connect to local database
    $db_host = 'localhost';
    $db_name = 'ffg';
    $db_user = 'root';
    $db_pass = '';

    try{
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name",$db_user,$db_pass);
        // set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

?>