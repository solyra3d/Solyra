<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <?= seoMeta($seo ?? []) ?>
    
    <!-- Favicon -->
    <?php $favicon = setting('favicon'); ?>
    <?php if ($favicon): ?>
        <link rel="icon" href="<?= e(baseUrl($favicon)) ?>" type="image/x-icon">
    <?php else: ?>
        <link rel="icon" href="<?= asset('images/favicon.ico') ?>" type="image/x-icon">
    <?php endif; ?>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/animations.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    
    <!-- Google Analytics -->
    <?php $ga = setting('google_analytics'); ?>
    <?php if ($ga): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($ga) ?>"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e($ga) ?>');</script>
    <?php endif; ?>
    
    <!-- GTM -->
    <?php $gtm = setting('google_tag_manager'); ?>
    <?php if ($gtm): ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?= e($gtm) ?>');</script>
    <?php endif; ?>
    
    <!-- Schema.org -->
    <?= schemaOrganization() ?>
</head>
<body class="page-enter">
    <!-- Header -->
    <?php include ROOT_PATH . '/app/Views/partials/header.php'; ?>
    
    <!-- Main Content -->
    <main id="main-content">
        <?= $content ?>
    </main>
    
    <!-- Footer -->
    <?php include ROOT_PATH . '/app/Views/partials/footer.php'; ?>
    
    <!-- WhatsApp Float -->
    <?php include ROOT_PATH . '/app/Views/partials/whatsapp-float.php'; ?>
    
    <!-- Flash Messages -->
    <?php if ($successMsg = flashSuccess()): ?>
        <div class="flash-message flash-success" id="flash-msg">
            <span><?= e($successMsg) ?></span>
            <button onclick="this.parentElement.remove()" class="flash-close">&times;</button>
        </div>
    <?php endif; ?>
    <?php if ($errorMsg = flashError()): ?>
        <div class="flash-message flash-error" id="flash-msg">
            <span><?= e($errorMsg) ?></span>
            <button onclick="this.parentElement.remove()" class="flash-close">&times;</button>
        </div>
    <?php endif; ?>
    
    <!-- JavaScript -->
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
