<?php
$host='127.0.0.1';
$db='db_webdredb_test';
$user='root';
$pass='';
try{
    $pdo=new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $stmt=$pdo->prepare('SELECT * FROM migrations WHERE migration = ?');
    $stmt->execute(['2026_07_24_000002_create_ai_knowledge_documents_table']);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row) print_r($row);
    else echo "NOT_FOUND\n";
}catch(Exception $e){
    echo "ERROR: ". $e->getMessage();
}
