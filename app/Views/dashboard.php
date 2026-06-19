<?php ob_start();
$totalBooks = $totalBooks ?? 0;
$totalOrders = $totalOrders ?? 0;
$totalRevenue = $totalRevenue ?? 0;
$pendingOrders = $pendingOrders ?? 0;
?>

<div class="dashboard">
    <h1> BOOKSTORE DASHBOARD</h1>
    <p style="color: #64748b; margin-bottom: 30px;">Welcome to Bookstore Management System</p>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"></div>
            <div class="stat-info">
                <span class="stat-label">TOTAL BOOKS</span>
                <span class="stat-value"><?= number_format($totalBooks) ?></span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"></div>
            <div class="stat-info">
                <span class="stat-label">TOTAL ORDERS</span>
                <span class="stat-value"><?= number_format($totalOrders) ?></span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"></div>
            <div class="stat-info">
                <span class="stat-label">TOTAL REVENUE</span>
                <span class="stat-value"><?= number_format($totalRevenue, 0, ',', '.') ?> đ</span>
            </div>
        </div>
        
        <div class="stat-card stat-pending">
            <div class="stat-icon"></div>
            <div class="stat-info">
                <span class="stat-label">PENDING ORDERS</span>
                <span class="stat-value"><?= number_format($pendingOrders) ?></span>
            </div>
        </div>
    </div>

    <div class="quick-actions">
        <h2> QUICK ACTIONS</h2>
        <div class="actions-grid">
            <a href="/books/create" class="action-card">
                <div class="action-icon"></div>
                <h3>Add New Book</h3>
                <p>Add a new book to inventory</p>
            </a>
            
            <a href="/orders/create" class="action-card">
                <div class="action-icon"></div>
                <h3>Create Order</h3>
                <p>Create a new customer order</p>
            </a>
            
            <a href="/books" class="action-card">
                <div class="action-icon"></div>
                <h3>Manage Books</h3>
                <p>View and edit book list</p>
            </a>
            
            <a href="/orders" class="action-card">
                <div class="action-icon"></div>
                <h3>Manage Orders</h3>
                <p>View and manage orders</p>
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Dashboard';
require __DIR__ . '/layout.php';
?>