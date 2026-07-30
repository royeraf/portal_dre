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
    echo "Found document: id={$row['id']}, title={$row['title']}, pdf_path={$row['pdf_path']}\n";
    $filePath = __DIR__ . '/../storage/app/' . $row['pdf_path'];
    if(!file_exists($filePath)){
        echo "PDF file not found at: $filePath\n"; exit;
    }
    echo "File size: " . filesize($filePath) . " bytes\n";

    // Raw parse using Smalot
    $parser = new Smalot\PdfParser\Parser();
    $pdf = $parser->parseFile($filePath);
    $rawText = $pdf->getText();
    $rawLen = mb_strlen(trim($rawText));
    echo "Raw text length: $rawLen\n";
    echo "---- RAW TEXT (first 2000 chars) ----\n";
    echo mb_substr($rawText,0,2000) . "\n";
    echo "---- END RAW TEXT ----\n";

    // Use service
    $extractor = new PdfMarkdownExtractor();
    try{
        $res = $extractor->extract($filePath, $row['title']);
        echo "Extracted page_count: " . ($res['page_count'] ?? 'null') . "\n";
        echo "---- MARKDOWN (first 2000 chars) ----\n";
        echo mb_substr($res['markdown'] ?? '',0,2000) . "\n";
        echo "---- END MARKDOWN ----\n";
    }catch(\Throwable $e){
        echo "Extractor error: " . $e->getMessage() . "\n";
    }

}catch(Exception $e){
    echo "ERROR: " . $e->getMessage() . "\n";
}
