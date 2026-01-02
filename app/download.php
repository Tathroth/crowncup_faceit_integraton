<?php
$basePath = realpath(__DIR__ . '/../storage');
$file = $_GET['file'] ?? '';

$fullPath = realpath($basePath . '/' . $file);

// Sikkerhet: path traversal-beskyttelse
if (!$fullPath || !str_starts_with($fullPath, $basePath)) {
    http_response_code(403);
    exit('Access denied');
}

if (!is_file($fullPath)) {
    http_response_code(404);
    exit('File not found');
}

$mime = mime_content_type($fullPath);
$filename = basename($fullPath);

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($fullPath));
header('Content-Disposition: inline; filename="' . $filename . '"');

readfile($fullPath);
exit;
