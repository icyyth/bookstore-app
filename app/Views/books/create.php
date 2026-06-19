<?php ob_start(); ?>

<h1> Create New Book</h1>

<form method="post" action="/books/store" class="card form-card">
    <div class="form-group">
        <label>ISBN <span class="required">*</span></label>
        <input type="text" name="isbn" value="<?= e($old['isbn'] ?? '') ?>" placeholder="978-3-16-148410-0">
        <?php if (!empty($errors['isbn'])): ?>
            <p class="error"><?= e($errors['isbn']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Title <span class="required">*</span></label>
        <input type="text" name="title" value="<?= e($old['title'] ?? '') ?>" placeholder="Book title">
        <?php if (!empty($errors['title'])): ?>
            <p class="error"><?= e($errors['title']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Author <span class="required">*</span></label>
        <input type="text" name="author" value="<?= e($old['author'] ?? '') ?>" placeholder="Author name">
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
        <label>Category <span class="required">*</span></label>
        <select name="category">
            <?php foreach (['programming', 'database', 'web', 'mobile', 'general', 'design'] as $cat): ?>
                <option value="<?= e($cat) ?>" <?= ($old['category'] ?? 'general') === $cat ? 'selected' : '' ?>>
                    <?= e($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['category'])): ?>
            <p class="error"><?= e($errors['category']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="3" placeholder="Book description"><?= e($old['description'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label>Status <span class="required">*</span></label>
        <select name="status">
            <?php foreach (['available', 'out_of_stock', 'discontinued'] as $status): ?>
                <option value="<?= e($status) ?>" <?= ($old['status'] ?? 'available') === $status ? 'selected' : '' ?>>
                    <?= e($status) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['status'])): ?>
            <p class="error"><?= e($errors['status']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-actions">
        <button class="btn primary" type="submit"> Save Book</button>
        <a class="btn" href="/books">← Back</a>
    </div>
</form>

<?php
$content = ob_get_clean();
$title = 'Create Book';
require __DIR__ . '/../layout.php';
?>