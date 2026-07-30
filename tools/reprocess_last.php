<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Services\PdfMarkdownExtractor;

$host='127.0.0.1';
$db='db_webdredb_test';
$user='root';
$pass='';
try{
    $pdo=new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $row=$pdo->query('SELECT * FROM ai_knowledge_documents ORDER BY created_at DESC LIMIT 1')->fetch(PDO::FETCH_ASSOC);
    if(!$row){ echo "NO_DOCUMENTS\n"; exit; }
    $filePath = __DIR__ . '/../storage/app/' . $row['pdf_path'];
    if(!file_exists($filePath)){
        echo "PDF file not found at: $filePath\n"; exit;
    }
    $extractor = new PdfMarkdownExtractor();
    try{
        $res = $extractor->extract($filePath, $row['title']);
        $stmt = $pdo->prepare('UPDATE ai_knowledge_documents SET markdown = ?, page_count = ?, status = ?, error_message = NULL WHERE id = ?');
        $stmt->execute([$res['markdown'], $res['page_count'], 'ready', $row['id']]);
        echo "Document reprocessed and updated (id={$row['id']})\n";
    }catch(\Throwable $e){
        $stmt = $pdo->prepare('UPDATE ai_knowledge_documents SET status = ?, error_message = ? WHERE id = ?');
        $stmt->execute(['failed', $e->getMessage(), $row['id']]);
        echo "Reprocess failed: " . $e->getMessage() . "\n";
    }
}catch(Exception $e){
    echo "ERROR: " . $e->getMessage() . "\n";
}
