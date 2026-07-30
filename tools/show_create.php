<?php
$host='127.0.0.1';
$db='db_webdredb_test';
$user='root';
$pass='';
try{
    $pdo=new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $stmt=$pdo->query('SHOW CREATE TABLE users');
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    echo $row['Create Table'];
}catch(Exception $e){
    echo "ERROR: ". $e->getMessage();
}
