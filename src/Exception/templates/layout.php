<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?= $statusCode ?> | <?= config('app.name', 'Axiom') ?></title>
    <style>
        <?php include __DIR__ . '/style.css'; ?>
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-content">
            <?= $content ?>
        </div>
        <div class="error-footer">
            <p>&copy; <?= date('Y') ?> <?= config('app.name', 'Axiom') ?>. All rights reserved.</p>
            <p>Request ID: <?= uniqid() ?></p>
        </div>
    </div>
</body>
</html>