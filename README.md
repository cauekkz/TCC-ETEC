# TCC-ETEC
eteconnect

---

**caue**: arrumar posição do btn change theme e terminar de mudar o css do tema escuro

**messi**: 
Paginzação no header. lixo
$page =isset($_SERVER['HTTP_X_PAGE']) ? (int)$_SERVER['HTTP_X_PAGE']: 1;
$limit =isset($_SERVER['HTTP_X_LIMIT']) ? (int)$_SERVER['HTTP_X_LIMIT'] : 10;

$offset = ($page - 1) * $limit; 
