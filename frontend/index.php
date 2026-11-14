<?php


require_once __DIR__ . '/../vendor/autoload.php';
session_start();

require_once __DIR__ . '/tools/middleware/loginMiddleware.php';
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
$router->map('GET', '/servers', function () {
    require __DIR__ . '/pages/servers.php';
}, "servers");
$router->map('GET', '/events', function () {
    require __DIR__ . '/pages/events.php';
}, "events");
$router->map('GET', '/projects', function () {
    require __DIR__ . '/pages/projects.php';
}, "projects");
$router->map('GET', '/notices', function () {
    require __DIR__ . '/pages/notices.php';
}, "notices");
$router->map('GET', '/messages', function () {
    require __DIR__ . '/pages/messages.php';
}, "messages");
$router->map('GET', '/resetpassword', function () {
    require __DIR__ . '/pages/resetPassword.php';
}, "resetPassword");



$match = $router->match();

if ($match && is_callable($match['target'])) {
    $pageTitle = $match["name"];
    require __DIR__ . '/static/template/header.php';

    call_user_func_array($match['target'], $match['params']);

    require __DIR__ . '/static/template/footer.php';
} else {
    $pageTitle = "404";
    require __DIR__ . '/static/template/header.php';
    require __DIR__ . '/pages/404.php';
    require __DIR__ . '/static/template/footer.php';
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