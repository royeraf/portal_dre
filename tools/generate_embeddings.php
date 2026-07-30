<?php
require __DIR__ . '/../vendor/autoload.php';

use Smalot\PdfParser\Parser;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

$host = getenv('DB_HOST') ?: '127.0.0.1';
$db = getenv('DB_DATABASE') ?: 'db_webdredb_test';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$apiKey = getenv('OPENAI_API_KEY');
// fallback: try to parse .env directly if getenv failed
if (!$apiKey) {
    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), 'OPENAI_API_KEY=')) {
                $apiKey = substr(trim($line), strlen('OPENAI_API_KEY='));
                $apiKey = trim($apiKey, "\"\' ");
                break;
            }
        }
    }
}

if (!$apiKey) {
    echo "OPENAI_API_KEY not set in environment or .env.\n";
    exit(1);
}

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);

function chunkText(string $markdown, int $chunkSize = 900){
    $blocks = preg_split('/\n{2,}/', trim($markdown));
    $chunks = [];
    $current = '';
    $heading = '';

    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') continue;
        if (strpos($block, '#') === 0) {
            $heading = trim(ltrim($block, '# '));
            continue;
        }
        $piece = ($heading ? '['.$heading.'] ' : '') . $block;
        if (mb_strlen($current) + mb_strlen($piece) > $chunkSize) {
            if ($current !== '') {
                $chunks[] = $current;
                $current = '';
            }
        }
        $current .= ($current === '' ? '' : "\n\n") . $piece;
    }
    if (trim($current) !== '') $chunks[] = $current;
    return $chunks;
}

function openai_embedding(string $text, string $apiKey){
    $client = new \GuzzleHttp\Client();
    $resp = $client->post('https://api.openai.com/v1/embeddings', [
        'headers' => ['Authorization' => "Bearer $apiKey", 'Content-Type' => 'application/json'],
        'json' => ['model' => 'text-embedding-3-small', 'input' => $text],
        'timeout' => 30,
        // In local dev on Windows CA may not be present; set verify to false to avoid cURL SSL errors.
        'verify' => false,
    ]);
    $body = json_decode((string)$resp->getBody(), true);
    return $body['data'][0]['embedding'] ?? null;
}

$docs = $pdo->query("SELECT id, title, markdown FROM ai_knowledge_documents WHERE status='ready' AND is_published=1")->fetchAll(PDO::FETCH_ASSOC);
if (!$docs) { echo "No ready documents found.\n"; exit; }

foreach ($docs as $doc) {
    echo "Processing doc {$doc['id']} - {$doc['title']}\n";
    $chunks = chunkText($doc['markdown']);
    $pdo->beginTransaction();
    // delete existing chunks for doc
    $pdo->prepare('DELETE FROM ai_knowledge_chunks WHERE document_id = ?')->execute([$doc['id']]);
    $idx = 0;
    foreach ($chunks as $chunk) {
        $embedding = openai_embedding($chunk, $apiKey);
        $stmt = $pdo->prepare('INSERT INTO ai_knowledge_chunks (document_id, heading, text, embedding, chunk_index, created_at, updated_at) VALUES (?,?,?,?,?,?,?)');
        $now = date('Y-m-d H:i:s');
        $stmt->execute([$doc['id'], null, $chunk, json_encode($embedding), $idx, $now, $now]);
        $idx++;
        echo ".";
        usleep(150000); // small delay
    }
    $pdo->commit();
    echo "\nInserted {$idx} chunks.\n";
}

echo "Done.\n";
