<?php
$host='127.0.0.1';
$db='db_webdredb_test';
$user='root';
$pass='';
try{
    $pdo=new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $stmt=$pdo->query('SELECT id,title,original_filename,status,page_count,error_message,created_at FROM ai_knowledge_documents ORDER BY created_at DESC LIMIT 20');
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$rows) { echo "NO_ROWS\n"; exit; }
    foreach($rows as $r) {
        echo implode(' | ', [ $r['id'],$r['title'],$r['original_filename'],$r['status'],$r['page_count'],$r['error_message']?:'-',$r['created_at'] ]) . "\n";
    }
}catch(Exception $e){
    echo "ERROR: ". $e->getMessage();
}
