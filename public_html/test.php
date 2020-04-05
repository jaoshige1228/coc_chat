<?php
require_once(__DIR__ . '/../config/config.php');
$app = new MyApp\Controller\Skills();

$app->test();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="sty.css">
</head>
<body>
  <form action="" method="post">
    <input type="text" name="text">
    <input type="submit" value="送信">
  </form>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script>
    $(function(){
    });
  </script>
</body>
</html>