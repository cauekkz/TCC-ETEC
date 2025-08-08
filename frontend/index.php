<?php


require_once __DIR__ . './../vendor/autoload.php';
session_start();

require_once __DIR__ . './tools/middleware/loginMiddleware.php';
$router = new AltoRouter();

$router->map('GET', '/', function () {
    require __DIR__ . '/pages/home.php';
}, "home");
$router->map('GET', '/login', function () {
    require __DIR__ . '/pages/login.php';
}, "login");
$router->map('GET', '/signup', function () {
    require __DIR__ . '/pages/signup.php';
}, "signup");
$router->map('GET', '/profile', function () {
    require __DIR__ . '/pages/profile.php';
}, "profile");


$match = $router->match();

if ($match && is_callable($match['target'])) {
    $pageTitle = $match["name"];
    require __DIR__ . '/static/template/header.php';

    call_user_func_array($match['target'], $match['params']);

    require __DIR__ . '/static/template/footer.php';
} else {
    http_response_code(404);
    echo "Página não encontrada";
}

/*
| Placeholder | entrada                      | Exemplo               |
| ----------- | ---------------------------- | --------------------- |
| `[i:var]`   | Só números                   | `/user/123`           |
| `[a:var]`   | Letras + números (sem hífen) | `/post/abc123`        |
| `[h:var]`   | Hexadecimal                  | `/color/ff6600`       |
| `[s:var]`   | String simples (sem `/`)     | `/page/sobre-nos`     |
| `[*:var]`   | Tudo até `/`                 | `/file/meu.pdf`       |
| `[**:var]`  | Tudo (inclusive `/`)         | `/download/pasta/abc` |
*/