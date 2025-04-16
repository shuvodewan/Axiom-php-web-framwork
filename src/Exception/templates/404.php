<?php
$statusCode = 404;
$content = <<<HTML
    <div class="error-header">
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Page Not Found</h2>
    </div>
HTML;

include __DIR__ . '/layout.php';