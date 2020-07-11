<?php
require_once(__DIR__ . '/../config/config.php');
$app = new MyApp\Controller\Chat();
$show = new MyApp\Controller\CharCreateConfirm();

// 未ログイン状態であればサインアップ画面にリダイレクト
$app->LoginCheck();
// キャラが未登録の状態でもエラーが出ないようセッションを空に設定しておく
$app->setDefaultSession();

// ユーザータイプを識別
$userType = $app->getUserType($_GET['roomId']);
// var_dump($userType['requestButtonclass']);


// チャットが投稿された時のみ発動
$app->chatPost('chat_name','chat_text','Y-m-d H:i:s','chat_icon');


var_dump($_SESSION['charIcon']);

// 部屋で使うキャラを選択するときに発動
$app->charSelect();

// 登録しているキャラの名前を取得
$app->getCharName();

// 部屋の情報を読み込む
$room = $app->getRoomInfo($_GET['roomId']);

// 現在部屋に参加中のキャラクター
$tempChars = $app->getTempChars($_GET['roomId']);

$i = 0;

// if($_SESSION['charIcon'] !== ""){
//   $charImage = $_SESSION['charIcon'];
// }else{
//   $charImage = 'sys_img/unti.JPG';
// }

// $charImage = $_SESSION['charIcon'] !== "" ? $_SESSION['charIcon'] : 'sys_img/unti.JPG';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9,minimum-scale=0.9,user-scalable=no">
  <title><?= $room['roomName'];?></title>
  <link rel="stylesheet" href="/sty_second.css">
</head>
<body>
<header>
  <div class="roomName">
    <h1>〜<?= $room['roomName'];?>〜</h1>
  </div>
  <div class="btn_mypage">
    
  </div>
</header>
<!-- ajax処理時に使う部屋のIDを密かにセット -->
<input class="roomId" type="hidden" name="secretRoomId" value="<?= $_GET['roomId']; ?>">

<div class="allContainer">
  <div class="subContainer">
    <!-- キャラ選択ウィンドウ -->
    <div class="mypage_menu">
      <p>この部屋で使うキャラを選択</p>
      <?php for($i=0;$i < count($app->name);$i++):?>
        <form action="" method="post" name="charSelect">
          <input type="hidden" name="post_char" value="ok">
          <ul class="myCharList">
            <li>
              <input type="hidden" name="char_name" value="<?= $app->name[$i]['name'];?>">
              <input type="hidden" name="char_id" value="<?= $app->name[$i]['id'];?>">
              <input type="hidden" name="char_icon" value="<?= $app->name[$i]['icon'];?>">●
              <a href="javascript:charSelect<?php if(count($app->name) > 1){echo '['.$i.']';}?>.submit()">
              <?= $app->name[$i]['name'];?>
              </a>
            </li>
          </ul>
        </form>
      <?php endfor;?>
    </div>

    <!-- 左側 -->
    <div class="leftContainer">
      <p><a href="/index.php" class="returnHome">ホームに戻る</a></p> 
      <!-- 参加申請ウィンドウ -->
      <div class="joinWrap">
        <div class="joinRequest <?= $userType['requestButtonclass']; ?>">
          <button type="button">この部屋に参加申請</button>
        </div>
        <div class="kpOnlyButtonWindow <?= $userType['kpOnlyButton']; ?>">
          <button class="kpOnlyButton" type="button">参加申請中のユーザー</button>
        </div>
      </div>

      <div class="joinRequestWindow">
        <p>この部屋のKPに参加申請を送ります</p>
        <button type="button" class="joinRequestSubmit">はい</button>
      </div>
      <!-- KP専用認証ウィンドウ -->
      <div class="requestedMember">
        <ul>
          <?php foreach($app->getRequestedUser() as $values): ?>
            <li>
              <button class="requestedMemberList" type="button"><?= $values['userName']; ?></button>
            </li>
          <?php endforeach;?>
        </ul>
      </div>
      <div class="requestedConfirm">
        <span>うんち</span>をこの部屋の参加者として承認します。
        <p> <button type="button">はい</button></p>
      </div>
  
      <!-- 現在参加中の奴ら一覧 -->
      <div class="temp_char <?= $userType['windowClass']; ?> <?= $window; ?>">
        <p>参加中のキャラクター</p>
        <?php foreach($tempChars as $char):?>
          <div class="temp_charWrap">
            <p class="temp_charName"><?= h($char['charName']); ?><span class="tempUserName">＠<?= h($char['userName']); ?></span></p>
            <p class="temp_charName">HP:<?= h($char['charHP']); ?>　MP:<?= h($char['charMP']); ?>　SAN:<?= h($char['charSAN']); ?>　</p>
          </div>
        <?php endforeach; ?>
        <p><button type="button" class="showAllCharButton"> <a href="/allCharSheets.php/?roomId=<?= $_GET['roomId']; ?>" target="_blank">キャラシを一覧表示</a></button></p>
        <p><button type="button" class="modifiedHP">HP,SANの編集</button></p>
      </div>

      <div class="modifiData displayNone">
        <div>
          <p>
            HPが<input type="number" value="0" id="hp" min="0">
            <select id="hpUD">
              <option value="up">増</option>
              <option value="down">減</option>
            </select>
          </p>  
          <p>
            MPが<input type="number" value="0" id="mp" min="0">
            <select id="mpUD">
              <option value="up">増</option>
              <option value="down">減</option>
            </select>
          </p>  
          <p>
            SANが<input type="number" value="0" id="san" min="0">
            <select id="sanUD">
              <option value="up">増</option>
              <option value="down">減</option>
            </select>
          </p>
          <button type="button">更新</button>
        </div>
      </div>


    </div>
    <!-- 左側ここまで -->
  

    <!-- 中央 -->
    <div class="centerContainer">
      <div class="chatContaint">
        <div class="main_text">
          <?php list($dispData,$now,$pages_num) = $app->chatPagenate();?>
          <?= $app->show($dispData); ?>
        </div>
      </div>
      <div class="pagenation">
        <?php
          if($now > 1){
            echo "<a href='/chat_room.php/?roomId=".$_GET['roomId']."&roomPage=".($now - 1)."'>前へ</a>"." ";
          }else{
            echo "前へ".' ';
          }
        ?>
        <?php for($i = 1;$i <= $pages_num;$i++): ?>
          <?php
            if($i == $now){
              echo $now." ";
            }else{
              echo "<a href='/chat_room.php/?roomId=".$_GET['roomId']."&roomPage=".$i."'>".$i."</a>"." ";
            }
          ?>
        <?php endfor; ?>
        <?php
          if($now < $pages_num){
            echo "<a href='/chat_room.php/?roomId=".$_GET['roomId']."&roomPage=".($now + 1)."'>次へ</a>"." ";
          }else{
            echo "次へ".' ';
          }
        ?>
      </div>
    </div>
  

    <!-- 右側 -->
    <div class="rightContainer">
      <!-- 運命の技能ロール！ -->
      <div class="skillRollWrap <?= $userType['windowClass']; ?> <?= $window; ?>">
        <button class="skillRollStart <?= $userType['windowClass']; ?>" type="button">技能ロール</button>
        <button class="NormalDice <?= $userType['windowClass']; ?>" type="button">通常ダイス</button>
      </div>
      
      
      <!-- 右側ウィンドウ -->
      <div class="skillTypeWrap">
        <?php $skillTypeValue = array('戦闘技能','探索技能','行動技能','交渉技能','知識技能'); ?>
        <ul class="skillType">
          <?php foreach($skillTypeValue as $value):?>
            <li><button type="button" class="skillTypeButton"><?= $value; ?></button></li>
          <?php endforeach;?>
        </ul>
      </div>
      
      <!-- 運命の技能ロール〜技能を選べ〜 -->
      <div id="skillRoll">
      </div>
    
      <!-- 運命のダイスロール！ -->
      <div class="dice_box <?= $userType['windowClass']; ?> <?= $window; ?>">
        <?php $diceValue = array('1d4','1d6','1d8','1d10','1d20','1d100'); ?>
        <?php for($i=0;$i < count($diceValue);$i++):?>
          <form action="" method="post" name="dice">
            <input type="hidden" name="chat_name" value="<?= $_SESSION['selectedChar']; ?>">
            <input type="hidden" name="post_chat" value="ok">
            <ul class="normalDiceList">
              <li>
                <input type="hidden" name="diceValue" value="<?= $diceValue[$i];?>">
                <a href="javascript:dice[<?= $i ;?>].submit()">
                  <button class="normalDiceButton"><?= $diceValue[$i];?></button>
                </a>
              </li>
            </ul>
          </form>
        <?php endfor;?>
      </div>
    </div>
    </div>
    <!-- 右側ここまで -->

  
    </div>
  </div>
</div>

<section class="footer">
  <div class="textWindowWrap">
    <form action="" method="post" class="textWindow">
      <input type="hidden" name="post_chat" value="ok">
      <div class="name_icon">
        <span class="selectedChar"><?= $_SESSION['selectedChar']; ?></span>
        <img src="/<?= $charImage = $_SESSION['charIcon'] !== "" ? $_SESSION['charIcon'] : 'sys_img/user.png'; ?>" class="<?= $window; ?>">
        <input class="iconn" type="hidden" name="chat_icon" value="<?= h($_SESSION['charIcon']); ?>">
        <input type="hidden" name="chat_name" value="<?= $_SESSION['selectedChar']; ?>">
      </div>
      <div class="textArea">
        <textarea name="chat_text" class="chat_text" cols="30" rows="10" placeholder="<?= $userType['message'];?>"></textarea>
      </div>
      <input type="submit" value="送信" class="chat_submit <?= $userType['windowClass']; ?>">
    </form>
  </div>
</section>

<footer>
  <div class="test">
    <div id="home">
      <a href="/">戻</a>
    </div>
    <div id="SPmenu">
  
    </div>
  
    <div id="SPmenu2">
  
    </div>
  
    <div id="SPmenu">
  
    </div>
  </div>
</footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="/function_chatRoom.js"></script>
</body>
</html>