<?php

define('API_VERSION', 'v1.0.0');


define('API_ACTIVE', true);
define('API_MESSAGE', '');

define('MYSQL_HOST', getenv('MYSQL_HOST') ?: 'localhost');
define('MYSQL_DBNAME', getenv('MYSQL_DBNAME') ?: 'tcc');
define('MYSQL_USER', getenv('MYSQL_USER') ?: 'root');
define('MYSQL_PASS', getenv('MYSQL_PASS') !== false ? getenv('MYSQL_PASS') : '');
define('OPENSSL_KEY', getenv('OPENSSL_KEY') ?: 'dev-only-openssl-key-change-me!!');
define('OPENSSL_IV', getenv('OPENSSL_IV') ?: 'dev-only-iv-0000');
define('JWT_SECRET', getenv('JWT_SECRET') ?: 'dev-only-jwt-secret-change-me-in-production');
