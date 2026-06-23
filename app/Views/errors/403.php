<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Negado - SOLYRA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; text-align: center;">
    <div style="padding: 2rem;">
        <h1 style="font-size: 6rem; color: #ef5350; margin-bottom: 1rem;">403</h1>
        <h2 style="margin-bottom: 1rem;">Acesso Negado</h2>
        <p style="margin-bottom: 2rem; color: var(--color-text-secondary);">
            Você não tem permissão para acessar esta página.
        </p>
        <a href="<?= baseUrl() ?>" class="btn btn-primary btn-lg">Voltar ao Início</a>
    </div>
</body>
</html>
