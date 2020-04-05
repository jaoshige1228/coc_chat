<?php

namespace MyApp\Controller;

// ログイン中か否かでメニュー画面の内容を変える
class Index extends \MyApp\Controller {
  public $login;
  public $logout;
  public function run() {
    if ($this->isLoggedIn()) {
      $this->login = "invisible";
    }else{
      $this->logout = "invisible";
    }
  }


  // 部屋名一覧を取得
  // ついでにページネーション
  public function getRoomList(){
    // 検索がかかった時に呼び出される
    $data = new \MyApp\Model\RoomModel();
    if(isset($_POST['roomName']) && $_POST['roomName'] != ''){
      $roomName = $_POST['roomName'];
      // return $roomName;
      $roomList = $data->getSearchedRoomList($roomName);
      // header('Location:'.SITE_URL);
    }else{
      // 検索がない時に全ての部屋を呼び出す
      $roomList = $data->getRoomList();
    }

    $pagenationMode = 'room';
    return $this->pagenation($roomList,$pagenationMode);
    // 部屋数をカウントしページ数を定める
    // $rooms_num = count($roomList);
    // $pages_num = ceil($rooms_num / MAX_SHOW_ROOM);

    // if(!isset($_GET['roomPage'])){
    //   $now = 1;
    // }else{
    //   $now = $_GET['roomPage'];
    // }

    // $start_no =($now - 1) * MAX_SHOW_ROOM;

    // $dispData = array_slice($roomList, $start_no, MAX_SHOW_ROOM, true);

    // return [$dispData,$now,$pages_num];

  }

}

?>
