<?php
// Escape HTML
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Redirect
function redirect(string $path): void
{
    header("Location: {$path}");
    exit;
}

// Build query string
function query_string(array $params = []): string
{
    $current = $_GET;
    foreach ($params as $key => $value) {
        $current[$key] = $value;
    }
    return http_build_query($current);
}

// Flash messages
function flash_set(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function flash_get(string $key): ?string
{
    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $message;
}

// Load view
function view(string $path, array $data = []): void
{
    extract($data);
    require __DIR__ . '/../Views/' . $path . '.php';
}

// Log functions
function log_info(string $message): void
{
    $logFile = __DIR__ . '/../../storage/logs/app.log';
    $logDir = dirname($logFile);
    
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    file_put_contents(
        $logFile,
        date('Y-m-d H:i:s') . ' [INFO] ' . $message . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}

function log_error(string $message): void
{
    $logFile = __DIR__ . '/../../storage/logs/app.log';
    $logDir = dirname($logFile);
    
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    file_put_contents(
        $logFile,
        date('Y-m-d H:i:s') . ' [ERROR] ' . $message . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}