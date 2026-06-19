<?php
class Database
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        try {
            $dsn = sprintf(
                 'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['database'],
                $config['charset']
            );

            $options = [
                 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->pdo = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $options
            );
            
            log_info("Database connection successful");
            
        } catch (PDOException $e) {
            log_error("Database connection failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}