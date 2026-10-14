<?php
require_once __DIR__ . '/bootstrap.php';
header('Content-Type: application/json; charset=utf-8');
try {
    db()->query('SELECT 1');
    echo json_encode(['status' => 'ok', 'database' => 'ok']);
} catch (Throwable $e) {
    http_response_code(503);
    echo json_encode(['status' => 'error', 'database' => 'unavailable']);
}
