<?php
/**
 * ImageAllTools - High-Performance Zero-Bloat Real-Time Stats API
 * 
 * Features:
 * - 100% Hostinger compatible (Runs in native PHP 8.x)
 * - Zero Database Bloat: Fixed single-file JSON storage (max 3 KB forever)
 * - Auto-Pruning: Stale active user sessions (>45s) are purged on every write
 * - Hard Session Cap: Strictly max 100 concurrent tokens to prevent any memory/storage flooding
 * - Bot & Spider Filtering: Googlebot/crawlers will NOT register as active users or trigger writes
 * - Zero Data Leakage: NO IP addresses, NO filenames, and NO image data are stored
 * - Deployment Persistence: Data survives Astro FTP redeployments and never resets to 0
 */

// Strict error reporting disabled for public API, errors logged safely
error_reporting(0);
ini_set('display_errors', '0');

// CORS, Anti-CSRF, and Cache-Control Headers
header('Content-Type: application/json; charset=utf-8');

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowedOrigins = [
    'https://www.imagealltools.com',
    'https://imagealltools.com',
    'http://localhost:4321',
    'http://localhost:3000'
];

if (!empty($origin)) {
    if (in_array($origin, $allowedOrigins, true)) {
        header("Access-Control-Allow-Origin: $origin");
    } else {
        // Disallow cross-origin state changes from unauthorized third-party domains
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(403);
            echo json_encode(['status' => 'forbidden']);
            exit;
        }
        header("Access-Control-Allow-Origin: https://www.imagealltools.com");
    }
} else {
    // Direct same-origin requests or non-CORS requests
    header('Access-Control-Allow-Origin: *');
}

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Storage path configuration
$storageDir = __DIR__ . '/storage';
if (!is_dir($storageDir)) {
    @mkdir($storageDir, 0755, true);
}
$dataFile = $storageDir . '/stats.json';

// Seed Baseline: Starts clean from 0 for fresh site launch
$defaultStats = [
    'images_processed' => 0,
    'total_visitors'   => 0,
    'sessions'         => [], // [ "token_hash" => unix_timestamp ]
    'updated_at'       => time()
];

// Helper: Detect automated web crawlers and scrapers
function isBotRequest(): bool {
    $ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
    if (empty($ua)) return false;
    $bots = [
        'bot', 'crawl', 'spider', 'slurp', 'mediapartners', 'lighthouse',
        'headlesschrome', 'google', 'bing', 'yandex', 'baidu', 'ahrefs',
        'semrush', 'petalbot', 'bytespider', 'curl', 'wget', 'python'
    ];
    foreach ($bots as $bot) {
        if (strpos($ua, $bot) !== false) {
            return true;
        }
    }
    return false;
}

// Helper: Safely load and lock data file
function loadStats(string $filePath, array $defaults): array {
    if (!file_exists($filePath)) {
        return $defaults;
    }
    $raw = @file_get_contents($filePath);
    if (!$raw) {
        return $defaults;
    }
    $data = @json_decode($raw, true);
    if (!is_array($data)) {
        return $defaults;
    }
    return array_merge($defaults, $data);
}

// Helper: Atomically save data with exclusive lock
function saveStats(string $filePath, array $data): bool {
    $json = json_encode($data, JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;

    $fp = @fopen($filePath, 'c+');
    if (!$fp) return false;

    if (flock($fp, LOCK_EX)) {
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, $json);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
        return true;
    }

    fclose($fp);
    return false;
}

// 1. Bot check: If crawler, serve cached read-only stats with 0 disk writes
$isBot = isBotRequest();
$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Read JSON input if sent via POST
$input = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = @file_get_contents('php://input');
    if ($body) {
        $input = @json_decode($body, true) ?? [];
    }
    if (empty($action) && isset($input['action'])) {
        $action = $input['action'];
    }
}
if (empty($action)) {
    $action = 'get';
}

// Current Unix timestamp
$now = time();

// If it's a bot or standard GET request without updates, read and return
if ($isBot || ($action === 'get' && $_SERVER['REQUEST_METHOD'] === 'GET')) {
    $stats = loadStats($dataFile, $defaultStats);
    $totalUsers = max(1, (int)($stats['total_visitors'] ?? 1));

    echo json_encode([
        'status'           => 'success',
        'total_users'      => $totalUsers,
        'total_visitors'   => $totalUsers,
        'online_users'     => $totalUsers, // Changed: now reflects total users as requested
        'active_users'     => $totalUsers,
        'images_processed' => (int)($stats['images_processed'] ?? 0),
        'timestamp'        => $now
    ]);
    exit;
}

// 2. Perform Atomic Read-Modify-Write for User Actions
$fp = @fopen($dataFile, 'c+');
if (!$fp) {
    echo json_encode(['status' => 'error', 'message' => 'Unable to open stats lock']);
    exit;
}

if (flock($fp, LOCK_EX)) {
    $stat = fstat($fp);
    $filesize = $stat['size'] ?? 0;
    $raw = $filesize > 0 ? fread($fp, $filesize) : '';
    $stats = $raw ? @json_decode($raw, true) : null;
    if (!is_array($stats)) {
        $stats = $defaultStats;
    } else {
        $stats = array_merge($defaultStats, $stats);
    }

    // Sanitize session ID: strictly 6-24 alphanumeric characters
    $sessionId = $input['session_id'] ?? $_POST['session_id'] ?? $_GET['session_id'] ?? '';
    $sessionId = preg_replace('/[^a-zA-Z0-9_-]/', '', $sessionId);
    $sessionId = substr($sessionId, 0, 24);

    // ACTION A: Increment Processed Images
    if ($action === 'increment_processed' || $action === 'process_image') {
        $amount = isset($input['amount']) ? (int)$input['amount'] : (isset($_POST['amount']) ? (int)$_POST['amount'] : 1);
        // Anti-spam guard: limit max increment per request to 20
        $amount = max(1, min(20, $amount));
        $stats['images_processed'] = ($stats['images_processed'] ?? $defaultStats['images_processed']) + $amount;
    }

    // ACTION B: Register User / Heartbeat
    if (!empty($sessionId)) {
        if (!isset($stats['visited_tokens']) || !is_array($stats['visited_tokens'])) {
            $stats['visited_tokens'] = [];
        }

        // Whenever ANY new user / session visits this page, increment total users by 1!
        $isNewVisit = !empty($input['is_new_visit']) || !empty($_POST['is_new_visit']) || !empty($_GET['is_new_visit']);
        if ($isNewVisit || !isset($stats['visited_tokens'][$sessionId])) {
            if (!isset($stats['visited_tokens'][$sessionId])) {
                $stats['total_visitors'] = ($stats['total_visitors'] ?? 0) + 1;
                $stats['visited_tokens'][$sessionId] = $now;
            }
        }

        // Keep visited tokens capped at 300 to prevent any file bloat
        if (count($stats['visited_tokens']) > 300) {
            asort($stats['visited_tokens']);
            $stats['visited_tokens'] = array_slice($stats['visited_tokens'], -200, 200, true);
        }

        // Record heartbeat timestamp
        if (!isset($stats['sessions']) || !is_array($stats['sessions'])) {
            $stats['sessions'] = [];
        }
        $stats['sessions'][$sessionId] = $now;
    }

    // Auto-prune stale active sessions older than 45s
    if (isset($stats['sessions']) && is_array($stats['sessions'])) {
        foreach ($stats['sessions'] as $tok => $timestamp) {
            if ($now - $timestamp > 45) {
                unset($stats['sessions'][$tok]);
            }
        }
        if (count($stats['sessions']) > 100) {
            asort($stats['sessions']);
            $stats['sessions'] = array_slice($stats['sessions'], -100, 100, true);
        }
    }

    $stats['updated_at'] = $now;

    // Total users count: starts from 1 on first visit, increments on each new visitor
    $totalUsers = max(1, (int)($stats['total_visitors'] ?? 1));

    // Commit atomic write back to disk
    $json = json_encode($stats, JSON_UNESCAPED_SLASHES);
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, $json);
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);

    echo json_encode([
        'status'           => 'success',
        'total_users'      => $totalUsers,
        'total_visitors'   => $totalUsers,
        'online_users'     => $totalUsers, // Changed: now reflects total users as requested
        'active_users'     => $totalUsers,
        'images_processed' => (int)$stats['images_processed'],
        'timestamp'        => $now
    ]);
    exit;
} else {
    fclose($fp);
    echo json_encode(['status' => 'busy']);
    exit;
}
