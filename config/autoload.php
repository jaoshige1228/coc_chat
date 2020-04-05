<?php

/*
MyApp 全体の名前空間
index.phpに関するControllerクラスは、サブ名前空間を使い
MyApp/Controller/Index　とする

このためのクラスファイルはライブラリに配置するので
-> lib/Controller/Index.php
サブ名前空間と同じファイルと作る
*/

spl_autoload_register(function($class) {
  $prefix = 'MyApp\\';
  if (strpos($class, $prefix) === 0) {
    $className = substr($class, strlen($prefix));
    $classFilePath = __DIR__ . '/../lib/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classFilePath)) {
      require $classFilePath;
    }
  }
});
