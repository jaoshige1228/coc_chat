<?php
require_once(__DIR__ . '/../config/config.php');
$app = new MyApp\Controller\Chat();
$show = new MyApp\Controller\CharCreateConfirm();


// 参加中のキャラのIDを一斉取得
$charID = $app->getAllCharID($_GET['roomId']);

// 参加中のキャラの全ステータスを取得
$app->getAllCharData($_GET['roomId'],$charID);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>キャラシ一覧</title>
  <link rel="stylesheet" href="/sty.css">
</head>
<body>
  <div class="charSheetContainer">
    <?php for($i = 0; $i < count($charID); $i++): ?>
      <div class="charSheet">
        <h1>〜<?= $app->char_data[$i]['name']; ?>〜</h3>
        <p>性別：<?= $app->char_data[$i]['sex']; ?>　職業：<?= $app->char_data[$i]['job']; ?>　年齢：<?= $app->char_data[$i]['age']; ?>歳</p>
        <h3>ステータス</h3>
        <p>STR:<?= $app->char_data[$i]['str']; ?>　DEX:<?= $app->char_data[$i]['dex']; ?>　INT:<?= $app->char_data[$i]['intel']; ?>　CON:<?= $app->char_data[$i]['con']; ?>　SIZ:<?= $app->char_data[$i]['siz']; ?>　APP:<?= $app->char_data[$i]['app']; ?>　POW:<?= $app->char_data[$i]['pow']; ?>　SAN:<?= $app->char_data[$i]['san']; ?>　MAXSAN:<?= $app->char_data[$i]['maxSan']; ?>　EDU:<?= $app->char_data[$i]['edu']; ?>　HP:<?= $app->char_data[$i]['hp']; ?>　MP:<?= $app->char_data[$i]['mp']; ?>　アイデア:<?= $app->char_data[$i]['idea']; ?>　知識:<?= $app->char_data[$i]['know']; ?>　幸運:<?= $app->char_data[$i]['luck']; ?>　ダメージボーナス:<?= $app->char_data[$i]['db']; ?></p>
        <h3>各種技能</h3>
        <?php echo $show->show($app->char_skills[$i],$app->char_skills_def[$i]); ?>
        <h3>その他情報</h3>
        <p>プロフィール:<?= '<br />'.nl2br($app->char_data[$i]['profile']); ?></p>
        <p>備考:<?= '<br />'.nl2br($app->char_data[$i]['subProfile']); ?></p>
      </div>
    <?php endfor; ?>
  </div>
</body>
</html>