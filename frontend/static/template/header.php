<?php
$arquivoAtual = basename($_SERVER['SCRIPT_NAME'], '.php');
$caminhoCss = "frontend/static/css/$pageTitle.css";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'eteconnect') ?></title>
    <!-- tirar se quiser -->
    <link rel="stylesheet" href="frontend/static/bootstrap/bootstrap.min.css">
    <!--  -->
    <link rel="stylesheet" href="frontend/static/css/geral.css">
    <link rel="stylesheet" href="frontend/static/css/theme.css">
    <link rel="stylesheet" href="frontend/static/css/accessibility.css">
    <link rel="stylesheet" href="frontend/static/css/confirmationModal.css">
    <link rel="stylesheet" href="<?= $caminhoCss ?>">
    <link rel="icon" type="image/x-icon" href="frontend/static/img/logo.png">
    
    <!-- Scripts do sistema de temas -->
    <script src="frontend/static/js/themeManager.js"></script>
    <!-- Scripts do sistema de acessibilidade -->
    <script src="frontend/static/js/accessibility.js"></script>
    <!-- Scripts do modal de confirmação -->
    <script src="frontend/static/js/confirmationModal.js"></script>
</head>


<body>