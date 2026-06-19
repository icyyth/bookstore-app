<?php
class HealthController
{
    public function index(): void
    {
        header('Content-Type: application/json');
        
        try {
            $config = require __DIR__ . '/../../config/database.php';
            $pdo = (new Database($config))->getConnection();
            $pdo->query("SELECT 1");
            
            echo json_encode([
                'status' => 'ok',
                'database' => 'connected',
                'driver' => 'mysql',
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
            
        } catch (Exception $e) {
            log_error("Health check failed: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'database' => 'failed',
                'message' => 'Database connection failed',
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        }
    }
}