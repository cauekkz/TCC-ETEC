<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

// Verificar termo
if (!isset($_GET['q'])) {
    $res->set_status('error');
    $res->set_error_message("nenhum termo de pesquisa informado");
    $res->response();
    exit;
}
if (!isset($_GET['server_id']) || !is_numeric($_GET['server_id'])) {
    $res->set_status('error');
    $res->set_error_message("server_id inválido ou não informado");
    $res->response();
    exit;
}

$server_id = (int) $_GET['server_id'];

$term = "%" . $_GET['q'] . "%";

// Obter user_id do token JWT
$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];


//--------------------------------------------
// 1) BUSCAR PERFIS
//--------------------------------------------
$sqlUsers = "
SELECT 
    u.id,
    u.name,
    u.profile_photo_path,
    u.role,
    u.email
FROM user u
WHERE u.name LIKE :term
";

$responseUsers = $db->execute_query($sqlUsers, ["term" => $term]);
$users = $responseUsers->results ?? [];

// Processar campus
foreach ($users as $usr) {
    $usr->campus = [];

    if (!empty($usr->campus_data)) {
        $items = explode(';', $usr->campus_data);
        foreach ($items as $item) {
            $parts = explode('|', $item);
            if (count($parts) === 2) {
                $usr->campus[] = (object)[
                    'id' => (int)$parts[0],
                    'name' => $parts[1]
                ];
            }
        }
    }

    unset($usr->campus_data);
}



//--------------------------------------------
// 2) BUSCAR POSTS
//--------------------------------------------
$sqlPosts = "
SELECT 
    p.id, 
    p.id_author, 
    p.content, 
    COUNT(DISTINCT l.id) AS total_likes, 
    CASE WHEN l2.id IS NULL THEN 0 ELSE 1 END AS user_liked, 
    p.created_at, 
    u.name AS author_name, 
    u.role, 
    u.profile_photo_path,
    GROUP_CONCAT(
        DISTINCT CONCAT(pm.media_url, '|', pm.media_type, '|', pm.media_order) 
        ORDER BY pm.media_order ASC 
        SEPARATOR ';'
    ) AS media_data,
    GROUP_CONCAT(
        DISTINCT CONCAT(c.id, '|', c.name) 
        ORDER BY c.name ASC 
        SEPARATOR ';'
    ) AS campus_data
FROM post p 
LEFT JOIN likes l ON l.content_type = 'post' AND l.content_id = p.id 
LEFT JOIN likes l2 ON l2.content_type = 'post' AND l2.content_id = p.id AND l2.user_id = :user_id 
LEFT JOIN user u ON u.id = p.id_author
LEFT JOIN post_media pm ON pm.post_id = p.id
LEFT JOIN user_campus uc ON uc.user_id = p.id_author
LEFT JOIN campus c ON c.id = uc.campus_id
WHERE p.content LIKE :term
AND p.server_id = :server_id
GROUP BY p.id 
ORDER BY p.created_at DESC;
";

$paramsPosts = [
    "term" => $term,
    "user_id" => $user_id,
    "server_id" => $server_id
];
$responsePosts = $db->execute_query($sqlPosts, $paramsPosts);
$posts = $responsePosts->results ?? [];

// Processar mídia e campus
foreach ($posts as $post) {

    // mídia
    $post->media = [];
    if (!empty($post->media_data)) {
        $mediaItems = explode(';', $post->media_data);
        foreach ($mediaItems as $item) {
            $parts = explode('|', $item);
            if (count($parts) === 3) {
                $post->media[] = (object)[
                    'media_url' => $parts[0],
                    'media_type' => $parts[1],
                    'media_order' => (int)$parts[2]
                ];
            }
        }
    }
    unset($post->media_data);

    // campus
    $post->campus = [];
    if (!empty($post->campus_data)) {
        $campusItems = explode(';', $post->campus_data);
        foreach ($campusItems as $item) {
            $parts = explode('|', $item);
            if (count($parts) === 2) {
                $post->campus[] = (object)[
                    'id' => (int)$parts[0],
                    'name' => $parts[1]
                ];
            }
        }
    }
    unset($post->campus_data);
}
$res->set_response_data([
    "profiles" => $users,
    "posts" => $posts
]);

$res->response();
