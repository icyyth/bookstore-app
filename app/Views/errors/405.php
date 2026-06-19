<?php ob_start(); ?>

<div class="error-page">
    <div class="error-content">
        <div class="error-code">405</div>
        <h1 class="error-title">Method Not Allowed</h1>
        <p class="error-message">The HTTP method is not supported for this URL.</p>
        <div class="error-actions">
            <a href="/" class="btn primary">🏠 Back to Dashboard</a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = '405 - Method Not Allowed';
require __DIR__ . '/../layout.php';
?>