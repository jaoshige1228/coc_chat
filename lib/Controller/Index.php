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

    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['key'] == 'easyLogin'){
      $this->_easyLogin();
    }
  }

  // かんたんログイン処理
  private function _easyLogin(){
    // ランダムなユーザー名とパスワードを生成
    $name = 'ゲスト' . substr(str_shuffle('1234567890'), 0, 5);
    $password = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);

    $userModel = new \MyApp\Model\User();
    $userModel->create([
      'name' => $name,
      'password' => $password
    ]);
    $user = $userModel->login([
      'name' => $name,
      'password' => $password
    ]);

    
    // login処理
    session_regenerate_id(true);
    $_SESSION['me'] = $user;
    
    // ダミーキャラシを登録する処理
    $this->_createEasyCharSheet();

    // ２番目の部屋に参加者として登録される
    $this->_addSecondRoom();

    // redirect to home
    header('Location: ' . SITE_URL . PUBLIC_URL_HEADER);
    exit;
  }

  private function _addSecondRoom(){
    $userName = $_SESSION['me']->name;
    $plId = $_SESSION['me']->id;
    $chatModel = new \MyApp\Model\ChatModel();
    $charId = $chatModel->getCharId($plId);
    $chatModel->addSecondRoom($charId, $userName);
  }

  private function _createEasyCharSheet(){
    $LaraId = 1;
    $userModel = new \MyApp\Model\User();
    $userModel->_createEasyCharSheet($_SESSION['me']->id, $LaraId);
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
  }

}

?>
