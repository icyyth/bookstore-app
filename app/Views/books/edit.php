<?php ob_start(); ?>

<h1> Edit Book</h1>

<form method="post" action="/books/update" class="card form-card">
    <input type="hidden" name="id" value="<?= e($old['id'] ?? (isset($book) ? $book['id'] : '')) ?>">
    
    <div class="form-group">
        <label>ISBN <span class="required">*</span></label>
        <input type="text" name="isbn" value="<?= e($old['isbn'] ?? '') ?>">
        <?php if (!empty($errors['isbn'])): ?>
            <p class="error"><?= e($errors['isbn']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Title <span class="required">*</span></label>
        <input type="text" name="title" value="<?= e($old['title'] ?? '') ?>">
        <?php if (!empty($errors['title'])): ?>
            <p class="error"><?= e($errors['title']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Author <span class="required">*</span></label>
        <input type="text" name="author" value="<?= e($old['author'] ?? '') ?>">
        <?php if (!empty($errors['author'])): ?>
            <p class="error"><?= e($errors['author']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Price <span class="required">*</span></label>
        <input type="number" name="price" value="<?= e($old['price'] ?? 0) ?>" step="1000" min="0">
        <?php if (!empty($errors['price'])): ?>
            <p class="error"><?= e($errors['price']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Stock <span class="required">*</span></label>
        <input type="number" name="stock" value="<?= e($old['stock'] ?? 0) ?>" min="0">
        <?php if (!empty($errors['stock'])): ?>
            <p class="error"><?= e($errors['stock']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Category</label>
        <select name="category">
            <?php foreach (['programming', 'database', 'web', 'mobile', 'general', 'design'] as $cat): ?>
                <option value="<?= e($cat) ?>" <?= ($old['category'] ?? 'general') === $cat ? 'selected' : '' ?>>
                    <?= e($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="3"><?= e($old['description'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status">
            <?php foreach (['available', 'out_of_stock', 'discontinued'] as $status): ?>
                <option value="<?= e($status) ?>" <?= ($old['status'] ?? 'available') === $status ? 'selected' : '' ?>>
                    <?= e($status) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-actions">
        <button class="btn primary" type="submit">Update Book</button>
        <a class="btn" href="/books">← Back</a>
    </div>
</form>

<?php
$content = ob_get_clean();
$title = 'Edit Book';
require __DIR__ . '/../layout.php';
?>