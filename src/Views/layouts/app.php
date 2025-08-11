<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? config('app.name') ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= asset('assets/css/app.css') ?>" rel="stylesheet">
    <?= $additional_css ?? '' ?>
</head>
<body>
    <div class="app">
        <?php if (isset($user)): ?>
            <?php include __DIR__ . '/partials/header.php'; ?>
            <?php include __DIR__ . '/partials/sidebar.php'; ?>
        <?php endif; ?>
        
        <main class="main-content <?= isset($user) ? 'with-sidebar' : 'full-width' ?>">
            <?php include __DIR__ . '/partials/flash-messages.php'; ?>
            
            <div class="content">
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>
    
    <script src="<?= asset('assets/js/app.js') ?>"></script>
    <?= $additional_js ?? '' ?>
</body>
</html>