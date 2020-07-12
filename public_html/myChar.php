 <?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\CharList();
$app_s = new MyApp\Controller\CharCreateConfirm();
$uploader = new \MyApp\Controller\ImageUploader();

$uploader->upload();
$char = $app->CharData();
list($skills,$skills_def) = $app->SkillsData();
list($sum_jobP,$sum_hobP,$sum_etcP) = $app->InputData();

$i = 2;

if(!function_exists('imagecreatetruecolor')){
  echo 'GD not installed';
  exit;
}

var_dump($_SESSION['me']->name);
var_dump($_SESSION['charName']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9,minimum-scale=0.9,user-scalable=no">
  <title><?= h($char['name']); ?></title>
  <link rel="stylesheet" href="sty.css">
</head>
<body>
  <div class="title">
    <h1 class="pageTitle"><?= h($char['name']); ?></h1>
  </div>
  <a href="char_list.php" class="returnHome">戻る</a>
  <div class="myCharIconWrap">
    <h3 class="subTitle">●キャラ画像</h3>
    <div class="borderContain">
      <p>
        <form action="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="imageUpload" value="go">
          <input type="hidden" name="MAX_FILE_SIZE" value="<?= h(MAX_FILE_SIZE); ?>">
          <input type="file" name="image">
          <input type="submit" value="アップロード">
        </form>
      </p>
      <img src="<?= h($char['icon']); ?>">
    </div>
  </div>
  
  <div class="myCharStatusWrap">
    <h3 class="subTitle">●ステータス</h3>
    <div class="borderContain">
      <p>性別：<?= h($char['sex']); ?>　職業：<?= h($char['job']); ?>　年齢：<?= h($char['age']); ?>歳</p>
      <p>STR:<?= h($char['str']); ?>　DEX:<?= h($char['dex']); ?>　INT:<?= h($char['intel']); ?>　CON:<?= h($char['con']); ?>　SIZ:<?= h($char['siz']); ?>　APP:<?= h($char['app']); ?>　POW:<?= h($char['pow']); ?>　SAN:<?= h($char['san']); ?>　MAXSAN:<?= h($char['maxSan']); ?>　EDU:<?= h($char['edu']); ?>　HP:<?= h($char['hp']); ?>　MP:<?= h($char['mp']); ?></p>
      <p>アイデア:<?= h($char['idea']); ?>　知識:<?= h($char['know']); ?>　幸運:<?= h($char['luck']); ?>　ダメージボーナス:<?= h($char['db']); ?></p>
    </div>
  </div>

  <div class="myCharSkillsWrap">
    <h3 class="subTitle">●各種技能</h3>
    <div class="borderContain">
      <?php echo $app_s->show($skills,$skills_def); ?>
      <p>職業技能点合計：<?= h($char['sum_jobP']); ?></p>
      <p>趣味技能点合計：<?= h($char['sum_hobP']); ?></p>
      <p>成長技能点合計：<?= h($char['sum_etcP']); ?></p>
      <div class="skillTableConfirm">
        <table border="1">
          <tr>
            <th>技能名</th><th>初期値</th><th>職業P</th><th>興味P</th><th>成長等</th><th>合計</th>
          </tr>
          <?php foreach($skills as $key => $value): ?>
            <!-- キー名がidかcharidなら飛ばす -->
            <?php if($key == 'id' || $key == 'charId'){ continue; } ?>
            <tr>
              <td><?= $key; ?></td>
              <td><?= $skills_def[$i]; ?></td>
              <td><?= $sum_jobP[$i]; ?></td>
              <td><?= $sum_hobP[$i]; ?></td>
              <td><?= $sum_etcP[$i]; ?></td>
              <td><?= $value; ?></td>
            </tr>
            <?php $i++; ?>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>

  <div class="myCharStatusWrap">
    <h3 class="subTitle">●その他情報</h3>
    <div class="borderContain">
      <p>プロフィール:<?= '<br />'.nl2br($char['profile']); ?></p>
      <p>備考:<?= '<br />'.nl2br($char['subProfile']); ?></p>
    </div>
  </div>

  <div class="center">
    <button type="button" class="decideButtonDouble"><a href="char_modify.php">編集する</a></button>
    <button type="button" class="decideButtonDouble"><a href="char_modify.php">削除する</a></button>
  </div>
</body>
</html>