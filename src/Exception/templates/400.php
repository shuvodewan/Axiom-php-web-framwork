<?php
$statusCode = 400;
$content = <<<HTML
    <div class="error-header">
        <h1 class="error-code">400</h1>
        <h2 class="error-title">Bad Request</h2>
    </div>
HTML;

include __DIR__ . '/layout.php';