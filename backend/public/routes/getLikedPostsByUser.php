<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];

$user_query_id = isset($_GET["user_id"])
    ? ($_GET["user_id"] === "mine" ? $user_id : $_GET["user_id"])
    : null;

if ($user_query_id === null) {
    $res->set_status("error");
    $res->set_error_message("erro ao pegar posts curtidos");
    $res->response();
    exit;
}


// =====================================================
// ✅ PEGAR APENAS POSTS QUE O USUÁRIO CURTIU
// =====================================================
$sql = "SELECT
    p.id,
    p.id_author,
    p.content,
    COUNT(DISTINCT l.id) AS total_likes,

    CASE 
        WHEN l2.id IS NULL THEN 0 
        ELSE 1 
    END AS user_liked,

    p.created_at,

    u.name AS author_name,
    u.role,
    u.profile_photo_path,

    GROUP_CONCAT(DISTINCT c.id ORDER BY c.name SEPARATOR ',')   AS campus_ids,
    GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ' | ') AS campus_names,

    pm_agg.media_data

FROM post p

-- garante que o post foi curtido pelo usuário passado
INNER JOIN likes l_user 
    ON l_user.content_type = 'post'
    AND l_user.content_id = p.id
    AND l_user.user_id = :user_query_id  

-- total de likes
LEFT JOIN likes l 
    ON l.content_type = 'post'
    AND l.content_id = p.id

-- se o usuário logado curtiu ou não (pra UI)
LEFT JOIN likes l2 
    ON l2.content_type = 'post'
    AND l2.content_id = p.id
    AND l2.user_id = :user_id

LEFT JOIN user u 
    ON u.id = p.id_author

-- múltiplos campus por autor
LEFT JOIN user_campus uc_post 
    ON uc_post.user_id = p.id_author

LEFT JOIN campus c 
    ON c.id = uc_post.campus_id

LEFT JOIN (
    SELECT
        post_id,
        GROUP_CONCAT(
            CONCAT(media_url, '|', media_type, '|', media_order)
            ORDER BY media_order ASC SEPARATOR ';'
        ) AS media_data
    FROM post_media
    GROUP BY post_id
) AS pm_agg 
    ON pm_agg.post_id = p.id

GROUP BY 
    p.id, 
    p.id_author, 
    p.content, 
    p.created_at,
    u.name, 
    u.role, 
    u.profile_photo_path,
    pm_agg.media_data

ORDER BY l_user.created_at DESC;
";

$params = [
    'user_query_id' => $user_query_id,
    'user_id'       => $user_id
];

$response = $db->execute_query($sql, $params);

$data = [];

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar posts curtidos");
    $res->response();
    exit;
}


// =====================================================
// ✅ PROCESSAR MÍDIA (IGUAL AO SEU)
// =====================================================
$posts = $response->results;
foreach ($posts as $post) {

    $post->media = [];

    if (!empty($post->media_data)) {
        $mediaItems = explode(';', $post->media_data);

        foreach ($mediaItems as $item) {
            $parts = explode('|', $item);

            if (count($parts) === 3) {
                $post->media[] = (object)[
                    'media_url'   => $parts[0],
                    'media_type'  => $parts[1],
                    'media_order' => (int)$parts[2]
                ];
            }
        }
    }

    unset($post->media_data);
}

$data["posts"] = $posts;

$res->set_response_data($data);
$res->response();
exit;
