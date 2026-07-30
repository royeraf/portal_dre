<?php
$host='127.0.0.1';
$db='db_webdredb_test';
$user='root';
$pass='';
try{
    $pdo=new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $row=$pdo->query('SELECT MAX(batch) as maxb FROM migrations')->fetch(PDO::FETCH_ASSOC);
    echo 'MAX=' . ($row['maxb']===null ? 0 : $row['maxb']) . "\n";
}catch(Exception $e){
    echo "ERROR: ". $e->getMessage();
}
