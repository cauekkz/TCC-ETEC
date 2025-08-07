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
    <link rel="stylesheet" href="<?= $caminhoCss ?>">
</head>


<body>