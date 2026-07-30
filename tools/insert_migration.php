<?php
$host='127.0.0.1';
$db='db_webdredb_test';
$user='root';
$pass='';
$mig='2026_07_24_000002_create_ai_knowledge_documents_table';
try{
    $pdo=new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $stmt=$pdo->prepare('INSERT INTO migrations (migration, batch) VALUES (?, ?)');
    $stmt->execute([$mig, 1]);
    echo "INSERTED\n";
}catch(Exception $e){
    echo "ERROR: ". $e->getMessage();
}
