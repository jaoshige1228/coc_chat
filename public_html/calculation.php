<?php
require_once(__DIR__ . '/../config/config.php');
$app = new MyApp\Controller\Chat();

if(isset($_GET['str'])){
  // ダメボ自動計算
  $db_sum=$_GET['str'] + $_GET['siz'];
  if($db_sum >= 2 && $db_sum <= 12){
    echo '-1d6';
  }else if($db_sum >= 13 && $db_sum <= 16){
    echo '-1d4';
  }else if($db_sum >= 17 && $db_sum <= 24){
    echo '0';
  }else if($db_sum >= 25 && $db_sum <= 32){
    echo '+1d4';
  }else if($db_sum >= 33 && $db_sum <= 40){
    echo '+1d6';
  }else if($db_sum >= 41 && $db_sum <= 56){
    echo '+2d6';
  }else if($db_sum >= 57 && $db_sum <= 72){
    echo '+3d6';
  }else{
    echo '0';
  }
}

if(isset($_POST['value'])){
  $value = $_POST['value'];
  $app->skillDiceRoll($value);
}

if(isset($_POST['skillLast'])){
  $id = $_POST['roomId'];
  $value = $_POST['skillLast'];
  $icon = $_POST['icon'];
  $app->diceLast($value,$id,$icon);
  echo $id;

}


// 部屋作成処理
if(isset($_POST['roomName'])){
  $value = $_POST['roomName'];
  echo $app->createRoomStandBy($value);
}

// ユーザー認証申請処理。ユーザータイプにデータをセット
// なおかつ、現在参加中のユーザー一覧にデータをセット
if(isset($_POST['request'])){
  $id = $_POST['roomId'];
  $userName = $_SESSION['me']->name;
  // なぜかここにechoがあった
  $app->setUserType($id,$userName);
  echo $id;
}

// KPが参加申請者を許可する時の処理
if(isset($_POST['userName'])){
  $userName = $_POST['userName'];
  $id = $_POST['roomId'];
  $app->userRecognize($userName,$id);
  $app->setTempPlayer($id,$userName);
  echo $id;
}

// HPSAN増減処理
if(isset($_POST['modifiData']) && $_POST['modifiData'] == 'on'){
  $hp = $_POST['hp'];
  $hpUD = $_POST['hpUD'];
  $mp = $_POST['mp'];
  $mpUD = $_POST['mpUD'];
  $san = $_POST['san'];
  $sanUD = $_POST['sanUD'];
  $id = $_POST['roomId'];
  $name = $_SESSION['me']->name;

  $app->modifiData($hp, $mp, $san, $hpUD, $mpUD, $sanUD, $id, $name);

  echo $id;
}