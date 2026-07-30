<?php
$host='127.0.0.1';
$db='db_webdredb_test';
$user='root';
$pass='';
try{
    $pdo=new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $pdo->exec('ALTER TABLE users ENGINE=InnoDB');
    echo "OK: users converted to InnoDB\n";
}catch(Exception $e){
    echo "ERROR: ". $e->getMessage() ."\n";
}
