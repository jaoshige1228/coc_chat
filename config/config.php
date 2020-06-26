<?php

// ローカルサーバ用
// define('DSN', 'mysql:dbhost=localhost;dbname=coc_chat');
// define('DB_USERNAME', 'dbuser');
// define('DB_PASSWORD', 'kingdom');
// define('PUBLIC_URL_HEADER','');

// 公開サーバー用
$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');
define('DSN', "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8");
define('DB_USERNAME', $db['user']);
define('DB_PASSWORD', $db['pass']);

// 画像処理に用いる定数群
define('MAX_FILE_SIZE',1*1024*1024);
define('THUMBNAIL_WIDTH',100);
define('THUMBNAIL_HEIGHT',100);
define('IMAGES_DIR', __DIR__ . '/../public_html/images');
define('THUMBNAIL_DIR', __DIR__ . '/../public_html/thumbs');

// 1ページに表示する最大数
define('MAX_SHOW_ROOM',10);
define('MAX_CHAT_ROOM',10);

define('SITE_URL','https://'.$_SERVER['HTTP_HOST']);

require_once(__DIR__ .'/../lib/functions.php');
require_once(__DIR__ .'/autoload.php');

session_start();
