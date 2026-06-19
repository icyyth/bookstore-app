<?php ob_start(); $books = $books ?? []; $page = $page ?? 1; $totalPages = $totalPages ?? 1; $total = $total ?? 0; ?>

<h1> BOOK MANAGEMENT</h1>

<a class="btn primary" href="/books/create">+ Create Book</a>

<form method="get" action="/books" class="toolbar">
    <input type="hidden" name="page" value="1">
    <input type="hidden" name="sort" value="<?= e($sort ?? '') ?>">
    <input type="hidden" name="direction" value="<?= e($direction ?? '') ?>">
    <input type="text" name="q" value="<?= e($q ?? '') ?>" placeholder="Search by title / ISBN / author..." class="search-input">
    <button type="submit" class="btn"> Search</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th><a href="/books?<?= e(query_string(['sort' => 'isbn'])) ?>">ISBN</a></th>
            <th><a href="/books?<?= e(query_string(['sort' => 'title'])) ?>">Title</a></th>
            <th><a href="/books?<?= e(query_string(['sort' => 'author'])) ?>">Author</a></th>
            <th><a href="/books?<?= e(query_string(['sort' => 'price'])) ?>">Price</a></th>
            <th><a href="/books?<?= e(query_string(['sort' => 'stock'])) ?>">Stock</a></th>
            <th>Status</th>
            <th><a href="/books?<?= e(query_string(['sort' => 'created_at'])) ?>">Created</a></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($books)): ?>
            <tr><td colspan="9" style="text-align:center;color:#666;">No books found.</td></tr>
        <?php endif; ?>
        
        <?php foreach ($books as $book): ?>
        <tr>
            <td><?= e($book['id']) ?></td>
            <td><?= e($book['isbn']) ?></td>
            <td><strong><?= e($book['title']) ?></strong></td>
            <td><?= e($book['author']) ?></td>
            <td><?= number_format($book['price'], 0, ',', '.') ?> đ</td>
            <td><?= e($book['stock']) ?></td>
            <td><span class="badge badge-<?= e($book['status']) ?>"><?= e($book['status']) ?></span></td>
            <td><?= date('d/m/Y', strtotime($book['created_at'])) ?></td>
            <td>
                <a href="/books/edit?id=<?= e($book['id']) ?>" class="btn-edit"> Edit</a>
                <form method="post" action="/books/delete" class="inline" onsubmit="return confirm('Delete this book?')">
                    <input type="hidden" name="id" value="<?= e($book['id']) ?>">
                    <button type="submit" class="btn-delete"> Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/books?<?= e(query_string(['page' => $page - 1])) ?>">← Prev</a>
    <?php endif; ?>
    
    <span>Page <?= e($page) ?> / <?= e($totalPages) ?> (Total: <?= e($total) ?> books)</span>
    
    <?php if ($page < $totalPages): ?>
        <a href="/books?<?= e(query_string(['page' => $page + 1])) ?>">Next →</a>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
$title = 'Book Management';
require __DIR__ . '/../layout.php';
?>