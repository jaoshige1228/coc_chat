<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\CharList();
$chars = $app->run();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="sty.css">
</head>
<body>
  <div class="title">
    <h1 class="pageTitle">登録キャラクター一覧</h1>
  </div>
  <a class="returnHome" href="index.php">ホームに戻る</a>

  <div class="myCharList">
    <?php for($i=0;$i < count($chars);$i++):?>
      <form action="myChar.php" method="post" name="myChar">
        <ul>
          <li>
            <input type="hidden" name="charList" value="call">
            <input type="hidden" name="charId" value="<?= $chars[$i]->id;?>">
            <a href="javascript:myChar<?php if(count($chars) > 1){echo '['.$i.']';}?>.submit()">
              ●<?= h($chars[$i]->name);?>
            </a>
          </li>
        </ul>
      </form>
    <?php endfor;?>
  </div>
</body>
</html>