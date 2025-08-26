<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$server_id;
if (isset($_GET['server_id'])) {
    $server_id = $_GET['server_id'];
} else {
    $res->set_status('error');
    $res->set_error_message("Server ID");
    $res->response();
    exit;
}


$page =isset($_SERVER['HTTP_X_PAGE']) ? (int)$_SERVER['HTTP_X_PAGE']: 1;
$limit =isset($_SERVER['HTTP_X_LIMIT']) ? (int)$_SERVER['HTTP_X_LIMIT'] : 10;

$offset = ($page - 1) * $limit;

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];



$sql = "SELECT 
    p.id, 
    p.id_author, 
    p.content, 
    COUNT(l.id) AS total_likes, 
    CASE WHEN l2.id IS NULL THEN 0 ELSE 1 END AS user_liked, 
    p.created_at, 
    u.name AS author_name, 
    u.role, 
    u.profile_photo_path,
    GROUP_CONCAT(
        CONCAT(pm.media_url, '|', pm.media_type, '|', pm.media_order) 
        ORDER BY pm.media_order ASC 
        SEPARATOR ';'
    ) AS media_data
FROM post p 
LEFT JOIN likes l ON l.content_type = 'post' AND l.content_id = p.id 
LEFT JOIN likes l2 ON l2.content_type = 'post' AND l2.content_id = p.id AND l2.user_id = :user_id 
LEFT JOIN user u ON u.id = p.id_author
LEFT JOIN post_media pm ON pm.post_id = p.id
WHERE p.server_id = :server_id 
GROUP BY p.id, p.id_author, p.content, p.created_at, user_liked, u.name, u.role, u.profile_photo_path 
ORDER BY p.created_at DESC 
LIMIT $limit OFFSET $offset;";

$params = ['server_id' => $server_id,"user_id"=>$user_id];
$response = $db->execute_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

// Processar posts e mídia
$posts = $response->results;
foreach ($posts as $post) {
    // Processar mídia do GROUP_CONCAT
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
    unset($post->media_data); // Remover campo temporário
}


$res->set_response_data($posts);
$res->response();



