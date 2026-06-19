<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Bookstore App') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="nav-brand"> Bookstore</a>
            <div class="nav-links">
                <a href="/">Dashboard</a>
                <a href="/books">Books</a>
                <a href="/books/create">+ Book</a>
                <a href="/orders">Orders</a>
                <a href="/orders/create">+ Order</a>
                <a href="/health" target="_blank">Health</a>
            </div>
        </div>
    </nav>

    <main class="container">
        <?php if ($success = flash_get('success')): ?>
            <div class="flash-success"> <?= e($success) ?></div>
        <?php endif; ?>
        
        <?php if ($error = flash_get('error')): ?>
            <div class="flash-error"> <?= e($error) ?></div>
        <?php endif; ?>
        
        <?= $content ?? '' ?>
    </main>
</body>
</html>