<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SOLYRA Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="admin-login-body">
    <div class="admin-login-container">
        <div class="admin-login-card">
            <div class="admin-login-header">
                <span class="admin-login-brand">SOLYRA</span>
                <p>Painel Administrativo</p>
            </div>

            <?php if ($error = flashError()): ?>
                <div class="admin-flash admin-flash-error"><?= e($error) ?></div>
            <?php endif; ?>

            <form action="<?= baseUrl('admin/login') ?>" method="POST" class="admin-login-form">
                <?= csrfField() ?>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="admin@solyra.com.br" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Sua senha" required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
