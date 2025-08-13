# TCC-ETEC
eteconnect

---

**caue**: tirar tabela de endereço endereço ser coluna user, usuario poder ter muitos cursos e professores muitas etecs.
ai depois de ficar igual uma vadia alterado essas porras mudar perfil pra poder ver o dos outros tbm . nice

**messi**: paginação dos post, conectar home com user, comentários, posts, add post, add comentario, curtida e outras paginas
p paginação usar isso:

$page =isset($_SERVER['HTTP_X_PAGE']) ? (int)$_SERVER['HTTP_X_PAGE']: 1;
$limit =isset($_SERVER['HTTP_X_LIMIT']) ? (int)$_SERVER['HTTP_X_LIMIT'] : 10;

$offset = ($page - 1) * $limit; 
