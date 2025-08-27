<?php
require_once '../../_inc/init.php';
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

// Verificar se o usuário está logado
$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

if (!$resultJWT) {
    $res->set_status('error');
    $res->set_error_message('Token inválido');
    $res->response();
    exit;
}

$user_id = $resultJWT['id'];

// Verificar se o ID do post foi fornecido
if (!isset($_GET['post_id'])) {
    $res->set_status('error');
    $res->set_error_message('ID do post não fornecido');
    $res->response();
    exit;
}

$postId = $_GET['post_id'];

try {
    // Query para buscar o post específico com todas as informações
    $sql = "SELECT 
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
    WHERE p.id = :post_id 
    GROUP BY p.id";

    $params = ['user_id' => $user_id, 'post_id' => $postId];
    $response = $db->execute_query($sql, $params);
    
    if ($response->status != 'success') {
        $res->set_status('error');
        $res->set_error_message($response->mensagem);
        $res->response();
        exit;
    }
    
    $post = $response->results[0] ?? null;

    if (!$post) {
        $res->set_status('error');
        $res->set_error_message('Post não encontrado');
        $res->response();
        exit;
    }

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
    
    // Processar campus do GROUP_CONCAT
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
    unset($post->campus_data); // Remover campo temporário

    // Buscar comentários do post
    $commentSql = "SELECT 
        c.id,
        c.content,
        c.created_at,
        u.id as user_id,
        u.name as user_name,
        u.role as user_role,
        u.profile_photo_path as user_profile_photo
    FROM comment c
    LEFT JOIN user u ON c.user_id = u.id
    WHERE c.post_id = :post_id
    ORDER BY c.created_at ASC";

    $commentParams = ['post_id' => $postId];
    $commentResponse = $db->execute_query($commentSql, $commentParams);
    
    if ($commentResponse->status == 'success') {
        $post->comments = $commentResponse->results;
    } else {
        $post->comments = [];
    }

    $res->set_status('success');
    $res->set_response_data($post);
    $res->response();

} catch (PDOException $e) {
    $res->set_status('error');
    $res->set_error_message('Erro interno do servidor: ' . $e->getMessage());
    $res->response();
    exit;
}
?>
