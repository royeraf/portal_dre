<?php
require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Str;
use Illuminate\Database\Capsule\Manager as DB;

// bootstrap a minimal Eloquent environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

$config = [
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST') ?: '127.0.0.1',
    'database'  => getenv('DB_DATABASE') ?: 'db_webdredb_test',
    'username'  => getenv('DB_USERNAME') ?: 'root',
    'password'  => getenv('DB_PASSWORD') ?: '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];

$pdo = new PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['username'], $config['password']);

function findSources(PDO $pdo, string $message){
    $tokens = collect(preg_split('/[^\pL\pN]+/u', Str::lower($message)))
        ->filter(fn (?string $token) => mb_strlen($token ?? '') >= 4)
        ->unique()
        ->take(6)
        ->values();

    echo "Tokens: ".json_encode($tokens)."\n";

    if ($tokens->isEmpty()) return [];

    $applySearch = function ($table, $columns) use ($pdo, $tokens) {
        $sql = "SELECT * FROM {$table} WHERE ";
        $conds = [];
        $params = [];
        foreach ($tokens as $token) {
            $sub = [];
            foreach ($columns as $col) {
                $sub[] = "{$col} LIKE ?";
                $params[] = "%{$token}%";
            }
            $conds[] = '('.implode(' OR ', $sub).')';
        }
        $sql .= implode(' AND ', $conds) . ' LIMIT 5';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    };

    $knowledge = [];
    // search knowledge (ai_knowledge_documents)
    $rows = $applySearch('ai_knowledge_documents', ['title','markdown']);
    foreach ($rows as $item) {
        $knowledge[] = [
            'title' => $item['title'],
            'summary' => mb_substr(strip_tags($item['markdown']),0,240),
            'context' => mb_substr(strip_tags($item['markdown']),0,400),
            'url' => 'local',
        ];
    }

    return array_merge($knowledge,[]);
}

$tests = ['de que trata','revisalo','Plan-de-Gobierno-Reforzado_V2','plan de gobierno reforzado'];
foreach($tests as $t){
    echo "\n-- Query: {$t}\n";
    $res = findSources($pdo, $t);
    echo "Found: ".count($res)."\n";
    foreach($res as $r){
        echo " - ".($r['title'] ?? '<no title>')."\n";
    }
}
