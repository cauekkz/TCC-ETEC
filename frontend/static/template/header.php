<?php
$cssPath = "frontend/static/css/$pageTitle.css";
$pageTitles = [
    'home' => 'Feed', 'login' => 'Entrar', 'signup' => 'Criar conta', 'profile' => 'Perfil',
    'servers' => 'Servidores', 'events' => 'Eventos', 'projects' => 'Projetos de TCC',
    'notices' => 'Avisos', 'messages' => 'Mensagens', 'resetPassword' => 'Redefinir senha', '404' => 'Página não encontrada',
];
$pageTitleText = $pageTitles[$pageTitle] ?? 'ETEConnect';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F5F4F0">
    <title><?= htmlspecialchars($pageTitleText) ?> · ETEConnect</title>
    <script>
        (function () {
            try {
                var t = localStorage.getItem('eteconnect-theme');
                if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                }
            } catch (e) {}
        })();
        function uiEscape(value) {
            return String(value ?? '').replace(/[&<>"']/g, function (c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,500;0,6..72,600;0,6..72,700;1,6..72,500;1,6..72,600&family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/frontend/static/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/frontend/static/css/general.css">
    <link rel="stylesheet" href="/frontend/static/css/theme.css">
    <link rel="stylesheet" href="/frontend/static/css/accessibility.css">
    <link rel="stylesheet" href="/frontend/static/css/confirmationModal.css">
    <link rel="stylesheet" href="/<?= $cssPath ?>">
    <link rel="icon" type="image/png" href="/frontend/static/img/logo.png">

    <script src="/frontend/static/js/themeManager.js"></script>
    <script src="/frontend/static/js/accessibility.js"></script>
    <script src="/frontend/static/js/confirmationModal.js"></script>
</head>
<body class="page-<?= htmlspecialchars($pageTitle) ?>">
