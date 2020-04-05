<?php

ini_set('display_errors',1);

define('DSN', 'mysql:dbhost=localhost;dbname=coc_chat');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'kingdom');
// 画像処理に用いる定数群
  define('MAX_FILE_SIZE',1*1024*1024);
  define('THUMBNAIL_WIDTH',100);
  define('THUMBNAIL_HEIGHT',100);
  define('IMAGES_DIR', __DIR__ . '/../public_html/images');
  define('THUMBNAIL_DIR', __DIR__ . '/../public_html/thumbs');
// メイン画面に表示する最大の部屋数
define('MAX_SHOW_ROOM',10);
define('MAX_CHAT_ROOM',10);


define('SITE_URL','http://'.$_SERVER['HTTP_HOST']);

require_once(__DIR__ .'/../lib/functions.php');
require_once(__DIR__ .'/autoload.php');

session_start();
