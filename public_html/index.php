<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();

$app->run();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9,minimum-scale=0.9,user-scalable=no">
  <title>COCチャット</title>
  <link rel="stylesheet" href="<?= PUBLIC_URL_HEADER; ?>/sty.css">
</head>
<body>

  <!-- ヘッダー -->
  <div class="title">
    <div class="titleFlexContainer">
      <span class="titleImage">COC専用チャットサイト</span>
        <img src="thumbs/myPage.png" class="btn_mypage">
    </div>
    <div class="siteGuide">
      <p>クトゥルフ神話TRPGを遊ぶことに特化したチャットサイトです。<span class="titleBr"></span>セッションを進めるにあたって便利な機能が揃っています。</p>
    </div>
  </div>

  <!-- マイページメニュー -->
  <div class="mypage_menu <?=$app->logout;?>">
    <ul>
      <li><a href="<?= PUBLIC_URL_HEADER; ?>/char_create.php" class="menuButton">■キャラシ登録</a></li>
      <li><a href="<?= PUBLIC_URL_HEADER; ?>/char_list.php" class="menuButton">■キャラ一覧</a></li>
      <li class="createRoomWindowOpen"><a class="menuButton">■部屋を建てる</a></li>
      <form action="<?= PUBLIC_URL_HEADER; ?>/logout.php" method="post" id="logout">
        <li class="logoutButton" onclick="document.getElementById('logout').submit();">■ログアウト</li>
        <input type="hidden" name="token" id="token" value="<?= h($_SESSION['token']); ?>">
      </form>
    </ul>
  </div>

  <p class="errorMessage"></p>
  <!-- 部屋作成メニュー -->
  <div class="createRoomWindow">
    <h3>部屋作成</h3>
    <p><input type="text" placeholder="部屋名を入力" class="roomName" maxlength="20" required></p>
    <p><input type="button" value="作成" class="createRoomButton"></p>
  </div>
  <div class="mypage_menu <?=$app->login;?>">
    <ul>
      <li><a href="<?= PUBLIC_URL_HEADER; ?>/signup.php" class="menuButton">■アカウント作成</a></li>
      <li><a href="<?= PUBLIC_URL_HEADER; ?>/login.php" class="menuButton">■ログイン</a></li>
    </ul>
  </div>

  <div class="mainPackage">
    <!-- 部屋名検索フォーム -->
    <div class="roomSearch">
      <form action="" method="post">
        <input type="text" name="roomName" placeholder="部屋名を検索" class="roomSearchForm"> <input type="submit" value="検索">
      </form>
    </div>
  
    <!-- 部屋一覧を表示 -->
    <div class="roomListPackage">
      <?php list($dispData,$now,$pages_num) = $app->getRoomList(); ?>
      <?php foreach($dispData as $room):?>
        <div class="roomList">
            <span class="grayText modi">更新日時：<?= h($room['modified']); ?></span>　<a href="<?= PUBLIC_URL_HEADER; ?>/chat_room.php/?roomId=<?= $room['id']; ?>"><span class="blueText"><?= h($room['roomName']);?></span></a>　　<span class="modi">部屋主：<?= h($room['userName']); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="pazing">
    <?php
    if($now > 1){
      echo "<a href='".PUBLIC_URL_HEADER."/?roomPage=".($now - 1)."' class='back'>前へ</a>"." ";
    }else{
      echo "<span class='back'>前へ</span>".' ';
    }
    ?>

    <?php for($i = 1;$i <= $pages_num;$i++){
      if($i == $now){
        echo $now." ";
      }else{
        echo "<a href='".PUBLIC_URL_HEADER."/?roomPage=".$i."'>".$i."</a>"." ";
      }

    } ?>

    <?php
    if($now < $pages_num){
      echo "<a href='".PUBLIC_URL_HEADER."/?roomPage=".($now + 1)."' class='back'>次へ</a>"." ";
    }else{
      echo "<span class='back'>次へ</span>".' ';
    }
    ?>
  </div>

  

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="<?= HEROKU_JS; ?>/function_other.js"></script>
</body>
</html>