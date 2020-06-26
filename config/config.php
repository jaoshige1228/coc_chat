<?php

// ini_set('display_errors',1);

// ローカルサーバ用
define('DSN', 'mysql:dbhost=localhost;dbname=coc_chat');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'kingdom');
define('PUBLIC_URL_HEADER','');
define('SITE_URL','http://'.$_SERVER['HTTP_HOST']);

// 公開サーバー用
// define('DSN', 'mysql:host=mysql706.db.sakura.ne.jp;dbname=jaoshige_coc');
// define('DB_USERNAME', 'jaoshige');
// define('DB_PASSWORD', 'blitz7039');
// define('PUBLIC_URL_HEADER','/coc/public_html');
// define('SITE_URL','https://jaoshige.sakura.ne.jp');

// 画像処理に用いる定数群
  define('MAX_FILE_SIZE',1*1024*1024);
  define('THUMBNAIL_WIDTH',100);
  define('THUMBNAIL_HEIGHT',100);
  define('IMAGES_DIR', __DIR__ . '/../public_html/images');
  define('THUMBNAIL_DIR', __DIR__ . '/../public_html/thumbs');

// 1ページに表示する最大数
define('MAX_SHOW_ROOM',10);
define('MAX_CHAT_ROOM',10);


require_once(__DIR__ .'/../lib/functions.php');
require_once(__DIR__ .'/autoload.php');

session_start();
