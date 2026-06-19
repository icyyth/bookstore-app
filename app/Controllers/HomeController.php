<?php
class HomeController
{
    public function index(): void
    {
        try {
            $config = require __DIR__ . '/../../config/database.php';
            $pdo = (new Database($config))->getConnection();
            
            $stmt = $pdo->query("SELECT COUNT(*) as total_books FROM books");
            $totalBooks = $stmt->fetch()['total_books'] ?? 0;
            
            $stmt = $pdo->query("SELECT COUNT(*) as total_orders FROM orders");
            $totalOrders = $stmt->fetch()['total_orders'] ?? 0;
            
            $stmt = $pdo->query("SELECT SUM(total_amount) as total_revenue FROM orders WHERE status != 'cancelled'");
            $totalRevenue = $stmt->fetch()['total_revenue'] ?? 0;
            
            $stmt = $pdo->query("SELECT COUNT(*) as pending_orders FROM orders WHERE status = 'pending'");
            $pendingOrders = $stmt->fetch()['pending_orders'] ?? 0;
            
        } catch (Exception $e) {
            log_error("HomeController: " . $e->getMessage());
            $totalBooks = 0;
            $totalOrders = 0;
            $totalRevenue = 0;
            $pendingOrders = 0;
        }
        
        view('dashboard', compact('totalBooks', 'totalOrders', 'totalRevenue', 'pendingOrders'));
    }
}