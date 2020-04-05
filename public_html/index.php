<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();

$app->run();

if(isset($_SESSION['me'])){
  echo $_SESSION['me']->name;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>COCチャット</title>
  <link rel="stylesheet" href="/sty.css">
</head>
<body>

  <!-- ヘッダー -->
  <div class="title">
    <span class="titleImage">COC専用チャットサイト</span>
    <span class="btn_mypage">
      ボタン
    </span>
    <div class="siteGuide">
      <p>クトゥルフ神話TRPGを遊ぶことに特化したチャットサイトです。セッションを進めるにあたって便利な機能が揃っています。</p>
    </div>
  </div>

  <!-- マイページメニュー -->
  <div class="mypage_menu <?=$app->logout;?>">
    <ul>
      <li><a href="char_create.php" class="menuButton">■キャラシ登録</a></li>
      <li><a href="char_list.php" class="menuButton">■キャラ一覧</a></li>
      <li class="createRoomWindowOpen"><a class="menuButton">■部屋を建てる</a></li>
      <form action="/logout.php" method="post" id="logout">
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
      <li><a href="signup.php" class="menuButton">■アカウント作成</a></li>
      <li><a href="login.php" class="menuButton">■ログイン</a></li>
    </ul>
  </div>
  <div>
    <a href="test.php">テスト用</a>
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
            <span class="grayText modi">更新日時：<?= h($room['modified']); ?></span>　<a href="/chat_room.php/?roomId=<?= $room['id']; ?>"><span class="blueText"><?= h($room['roomName']);?></span></a>　　<span class="modi">部屋主：<?= h($room['userName']); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="pazing">
    <?php
    if($now > 1){
      echo "<a href='/?roomPage=".($now - 1)."'>前へ</a>"." ";
    }else{
      echo "前へ".' ';
    }
    ?>

    <?php for($i = 1;$i <= $pages_num;$i++){
      if($i == $now){
        echo $now." ";
      }else{
        echo "<a href='/?roomPage=".$i."'>".$i."</a>"." ";
      }

    } ?>

    <?php
    if($now < $pages_num){
      echo "<a href='/?roomPage=".($now + 1)."'>次へ</a>"." ";
    }else{
      echo "次へ".' ';
    }
    ?>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="/function_other.js"></script>
</body>
</html>