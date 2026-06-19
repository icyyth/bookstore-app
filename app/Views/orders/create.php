<?php ob_start(); ?>

<h1> Create New Order</h1>

<form method="post" action="/orders/store" class="card form-card">
    <div class="form-group">
        <label>Order Code <span class="required">*</span></label>
        <input type="text" name="order_code" value="<?= e($old['order_code'] ?? '') ?>" placeholder="BK-2026-XXXX">
        <?php if (!empty($errors['order_code'])): ?>
            <p class="error"><?= e($errors['order_code']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Customer Name <span class="required">*</span></label>
        <input type="text" name="customer_name" value="<?= e($old['customer_name'] ?? '') ?>" placeholder="Enter customer name">
        <?php if (!empty($errors['customer_name'])): ?>
            <p class="error"><?= e($errors['customer_name']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Customer Email</label>
        <input type="email" name="customer_email" value="<?= e($old['customer_email'] ?? '') ?>" placeholder="customer@email.com">
        <?php if (!empty($errors['customer_email'])): ?>
            <p class="error"><?= e($errors['customer_email']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Customer Phone</label>
        <input type="text" name="customer_phone" value="<?= e($old['customer_phone'] ?? '') ?>" placeholder="0909000000">
        <?php if (!empty($errors['customer_phone'])): ?>
            <p class="error"><?= e($errors['customer_phone']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Total Amount <span class="required">*</span></label>
        <input type="number" name="total_amount" value="<?= e($old['total_amount'] ?? 0) ?>" step="1000" min="0">
        <?php if (!empty($errors['total_amount'])): ?>
            <p class="error"><?= e($errors['total_amount']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Status <span class="required">*</span></label>
        <select name="status">
            <?php foreach (['pending', 'confirmed', 'shipping', 'delivered', 'cancelled'] as $status): ?>
                <option value="<?= e($status) ?>" <?= ($old['status'] ?? 'pending') === $status ? 'selected' : '' ?>>
                    <?= e($status) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['status'])): ?>
            <p class="error"><?= e($errors['status']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Shipping Address</label>
        <textarea name="shipping_address" rows="3" placeholder="Enter shipping address"><?= e($old['shipping_address'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label>Note</label>
        <textarea name="note" rows="2" placeholder="Additional notes"><?= e($old['note'] ?? '') ?></textarea>
    </div>

    <div class="form-actions">
        <button class="btn primary" type="submit"> Save Order</button>
        <a class="btn" href="/orders">← Back</a>
    </div>
</form>

<?php
$content = ob_get_clean();
$title = 'Create Order';
require __DIR__ . '/../layout.php';
?>