<?php ob_start(); ?>
<?php $orders = $orders ?? []; ?>
<?php $page = $page ?? 1; ?>
<?php $totalPages = $totalPages ?? 1; ?>
<?php $total = $total ?? 0; ?>

<h1> ORDER MANAGEMENT</h1>

<a class="btn primary" href="/orders/create">+ Create Order</a>

<form method="get" action="/orders" class="toolbar">
    <input type="hidden" name="page" value="1">
    <input type="hidden" name="sort" value="<?= e($sort ?? '') ?>">
    <input type="hidden" name="direction" value="<?= e($direction ?? '') ?>">
    <input type="text" name="q" value="<?= e($q ?? '') ?>" placeholder="Search order code / customer..." class="search-input">
    <button type="submit" class="btn"> Search</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th><a href="/orders?<?= e(query_string(['sort' => 'order_code'])) ?>">Order Code</a></th>
            <th><a href="/orders?<?= e(query_string(['sort' => 'customer_name'])) ?>">Customer</a></th>
            <th>Email</th>
            <th>Phone</th>
            <th><a href="/orders?<?= e(query_string(['sort' => 'total_amount'])) ?>">Amount</a></th>
            <th>Status</th>
            <th><a href="/orders?<?= e(query_string(['sort' => 'created_at'])) ?>">Created</a></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($orders)): ?>
            <tr><td colspan="9" style="text-align:center;color:#666;">No orders found.</td></tr>
        <?php endif; ?>
        
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= e($order['id']) ?></td>
            <td><strong><?= e($order['order_code']) ?></strong></td>
            <td><?= e($order['customer_name']) ?></td>
            <td><?= e($order['customer_email']) ?></td>
            <td><?= e($order['customer_phone']) ?></td>
            <td><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
            <td><span class="badge badge-<?= e($order['status']) ?>"><?= e($order['status']) ?></span></td>
            <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
            <td>
                <a href="/orders/edit?id=<?= e($order['id']) ?>" class="btn-edit"> Edit</a>
                <form method="post" action="/orders/delete" class="inline" onsubmit="return confirm('Delete this order?')">
                    <input type="hidden" name="id" value="<?= e($order['id']) ?>">
                    <button type="submit" class="btn-delete"> Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/orders?<?= e(query_string(['page' => $page - 1])) ?>">← Prev</a>
    <?php endif; ?>
    
    <span>Page <?= e($page) ?> / <?= e($totalPages) ?> (Total: <?= e($total) ?> orders)</span>
    
    <?php if ($page < $totalPages): ?>
        <a href="/orders?<?= e(query_string(['page' => $page + 1])) ?>">Next →</a>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
$title = 'Order Management';
require __DIR__ . '/../layout.php';
?>