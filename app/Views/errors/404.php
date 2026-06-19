<?php ob_start(); ?>

<div class="error-page">
    <div class="error-content">
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">The page you are looking for does not exist.</p>
        <div class="error-actions">
            <a href="/" class="btn primary">🏠 Back to Dashboard</a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = '404 - Page Not Found';
require __DIR__ . '/../layout.php';
?>