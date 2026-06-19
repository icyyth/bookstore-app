<?php ob_start(); ?>

<div class="error-page">
    <div class="error-content">
        <div class="error-code">500</div>
        <h1 class="error-title">Something Went Wrong</h1>
        <p class="error-message">Sorry, something went wrong. Please try again later.</p>
        <div class="error-actions">
            <a href="/" class="btn primary">🏠 Back to Dashboard</a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = '500 - Server Error';
require __DIR__ . '/../layout.php';
?>