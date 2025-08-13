# TCC-ETEC
eteconnect

---

**caue**: arrumar form de upload pra se for teacher ou student, mudar perfil pra poder ver o dos outros tbm . nice

**messi**: paginação dos post, conectar home com user, comentários, posts, add post, add comentario, curtida e outras paginas
p paginação usar isso:

$page =isset($_SERVER['HTTP_X_PAGE']) ? (int)$_SERVER['HTTP_X_PAGE']: 1;
$limit =isset($_SERVER['HTTP_X_LIMIT']) ? (int)$_SERVER['HTTP_X_LIMIT'] : 10;

$offset = ($page - 1) * $limit; 
