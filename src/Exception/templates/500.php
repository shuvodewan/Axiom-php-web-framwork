<?php
$statusCode = 500;
$content = <<<HTML
    <div class="error-header">
        <h1 class="error-code">500</h1>
        <h2 class="error-title">Server Error</h2>
    </div>
HTML;

include __DIR__ . '/layout.php';