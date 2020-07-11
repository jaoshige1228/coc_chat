<?php
namespace MyApp\Controller;

class Chat extends \MyApp\Controller {
  public $name;
  public $char_data = [];
  public $char_skills = [];
  public $char_skills_def = [];

  private function _validateText($value){
    if($value == ''){
      throw new \MyApp\Exception\InvalidRoomCreate();
    }
  }
  
  public function chatPost($name,$text,$date,$icon){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(isset($_POST['post_chat']) && $_POST['post_chat'] == 'ok'){
        // アイコンがセットされてなければデフォルト
        $postIcon = ($_SESSION['charIcon'] == "") ? 'sys_img/user.png' : $_SESSION['charIcon'];
        // var_dump($postIcon);
        // exit;
        // if(isset($icon)){
        //   $icon = 'sys_img/user.png';
        // }
        // 送信の種類がダイスだった場合の特別処理
        if(isset($_POST['diceValue'])){
          $this->dice();
        }else{
          $chatModel = new \MyApp\Model\ChatModel();
          $chatModel->chatPost($_POST[$name],h($_POST[$text]),date($date),$postIcon,$_GET['roomId']);
          header('Location: ' . PUBLIC_URL_HEADER . '/chat_room.php/?roomId='.$_GET['roomId']);
        }
        // 時間更新処理
        $data = new \MyApp\Model\RoomModel();
        $data->roomModify($_GET['roomId']);
     }
    }
  }

  protected function dice(){
    switch($_POST['diceValue']){
      case '1d4':
        $this->diceOnText('1d4',mt_rand(1,4));
        break;
      case '1d6':
        $this->diceOnText('1d6',mt_rand(1,6));
        break;
      case '1d8':
        $this->diceOnText('1d8',mt_rand(1,8));
        break;
      case '1d10':
        $this->diceOnText('1d10',mt_rand(1,10));
        break;
      case '1d20':
        $this->diceOnText('1d20',mt_rand(1,20));
        break;
      case '1d100':
        $this->diceOnText('1d100',mt_rand(1,100));
        break;
    }
  }
  protected function diceOnText($value,$num){
    $icon = $_SESSION['charIcon'];
    // ユーザーの入力部分とシステムテキストを分ける
    $boldText = '<b>ダイスロール</b>';
    $diceText = '： '.'['.$value.'] = 【'.$num.'】';
    $text = $boldText.h($diceText);

    $chatModel = new \MyApp\Model\ChatModel();
    $chatModel->chatPost($_POST['chat_name'],$text,date('Y-m-d H:i:s'),$icon,$_GET['roomId']);
    header('Location: ' . PUBLIC_URL_HEADER . '/chat_room.php/?roomId='.$_GET['roomId']);
  }

  // チャットの全文表示
  public function chatPagenate(){
    $chatBody = new \MyApp\Model\ChatModel();
    $text = $chatBody->getBody($_GET['roomId']);
    // foreach($text as $chat){
    //   echo '
    //   <div class="mainChat">
    //     <div class="onchatIcon">
    //     <img src="/'.$chat->icon.'">
    //     </div>
    //     <div class="onchatInfo">
    //       <div class="otherInfo">
    //         <div class="id">
    //           '.$chat->id.'：
    //         </div>
    //         <div class="name">
    //           '.$chat->name.'
    //         </div>
    //         <div class="date">
    //           '.$chat->modified.'
    //         </div>
    //       </div>
    //       <div class="chat">
    //         '.nl2br($chat->text).'
    //       </div>
    //     </div>
    //   </div>';
    // }
    $pagenationMode = 'chat';
    return $this->pagenation($text,$pagenationMode);
  }

  public function show($dispData){
    foreach($dispData as $chat){
      echo '
      <div class="mainChat">
        <div class="onchatIcon">
        <img src="/'.$chat->icon.'">
        </div>
        <div class="onchatInfo">
          <div class="otherInfo">
            <div class="id">
              '.$chat->id.'：
            </div>
            <div class="name">
              '.$chat->name.'
            </div>
            <div class="date">
              '.$chat->modified.'
            </div>
          </div>
          <div class="chat">
            '.nl2br($chat->text).'
          </div>
        </div>
      </div>';
    }
  }

  // 登録しているキャラの名前とIdを取得
  public function getCharName(){
    $charName = new \MyApp\Model\ChatModel();
    $this->name = $charName->getName();
  }

  // キャラのIDを一斉取得
  public function getAllCharID($roomId){
    $data = new \MyApp\Model\ChatModel();
    return $data->getAllCharID($roomId);
  }

  // 参加中のキャラの全ステータスを取得
  public function getAllCharData($roomId,$charId){
    $data = new \MyApp\Model\ChatModel();
    // charIdの数だけキャラデータを取得
    for($i = 0; $i < count($charId); $i++){
      // 基本ステータスを取得
      $this->char_data[$i] = $data->getCharData($charId[$i]['charId']);
      // 技能データを取得
      $this->char_skills[$i] = $data->getSkillData($charId[$i]['charId']);
      // 技能の初期値データを取得
      $this->char_skills_def[$i] = $data->getSkillDefData($charId[$i]['charId']);
    }

    // return $this->char_data;
  }

  // その部屋で使用するキャラを選択
  public function charSelect(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(isset($_POST['post_char']) && $_POST['post_char'] == 'ok'){
        $_SESSION['selectedChar'] = $_POST['char_name'];
        $_SESSION['charId'] = $_POST['char_id'];
        $_SESSION['charIcon'] = $_POST['char_icon'];
        // update
        $this->_updateTempPlayer();
        header('Location: ' . PUBLIC_URL_HEADER . '/chat_room.php/?roomId='.$_GET['roomId']);
     }
    }
  }

  // 部屋に現在参加中のステータスをセット
  private function _updateTempPlayer(){
    $data = new \MyApp\Model\ChatModel();
    // キャラのHP,MP,SANを取得
    $this->char_data = $data->getCharData($_SESSION['charId']);
    $data->updateTempPlayer(
      $_GET['roomId'],
      $_SESSION['selectedChar'],
      $_SESSION['me']->name,
      $this->char_data['hp'],
      $this->char_data['mp'],
      $this->char_data['san'],
      $_SESSION['charId']);
  }

  // 現在参加中のユーザー(基盤)をセット
  public function setTempPlayer($id,$userName){
    $data = new \MyApp\Model\ChatModel();
    $data->setTempPlayer($id,$userName);
    
  }

  public function skillDiceRoll($value){
    $replace = mb_substr( $value , 0 , mb_strlen($value)-2 );
    $diceModel = new \MyApp\Model\ChatModel();
    $types = $diceModel->getSkillType($replace);
    foreach($types as $type){
      $html = '<li class="noMaru"><button type="button" class="skillLButton">'.$type['name'].'</button></li>';
      echo $html;
    }
  }

  public function diceLast($value,$id,$icon){
    $charId = $_SESSION['charId'];
    $roll = mt_rand(1,100);
    // echo $roll;
    $chatModel = new \MyApp\Model\ChatModel();
    $success = $chatModel->diceResult($value,$roll,$charId);
    // echo $success;
    $name = $_SESSION['selectedChar'];
    if($roll <= $success){
      $result = '成功！';
    }else{
      $result =  '失敗！';
    }
    // echo 'うんち';
    $this->skillDiceRollResult($name,$value,$roll,$success,$result,$id,$icon);
      // echo 'ロール結果：'.$result.'<br />';
      // echo '成功率：'.$success.'<br />';
      // echo '名前：'.$name.'<br />';
      // echo 'うんち';
  }

  protected function skillDiceRollResult($name,$value,$roll,$success,$result,$id,$icon){
    $boldText = '<b>技能ロール</b>';
    $diceText = '〜'.$value.'〜 ：[1d100 <= '.$success.']……【'.$roll.'】 '.$result;
    $text = $boldText.h($diceText);
    $chatModel = new \MyApp\Model\ChatModel();
    $chatModel->chatPost($name,$text,date('Y-m-d H:i:s'),$icon,$id);

    // 時間更新処理
    $data = new \MyApp\Model\RoomModel();
    $data->roomModify($id);
  }

  // Ajaxを用いた部屋作成処理
  public function createRoomStandBy($value){
    try{
      $this->_validateText($value);
      $data = new \MyApp\Model\RoomModel();
      $data->createRoom([
        'userName' => $_SESSION['me']->name,
        'roomName' => $value,
        'date' => date('Y-m-d H:i:s')
      ]);
    }catch(\MyApp\Exception\InvalidRoomCreate $e){
      $this->setErrors('roomCreate', $e->getMessage());
      return $this->getErrors('roomCreate');
    }
  }

  // 部屋の情報を取得
  public function getRoomInfo($id){
    $data = new \MyApp\Model\RoomModel();
    return $data->getRoomInfo($id);
  }

  // 入室した部屋の認証状態を確認
  public function getUserType($id){
    $data = new \MyApp\Model\RoomModel();
    $userName = $_SESSION['me']->name;
    $userType = $data->getUserType($id,$userName);

    if($userType === false){
      // 認証されていない
      $res['message'] = 'KPに承認されたユーザーのみ書き込むことができます';
      $res['windowClass'] = 'displayNone';
      $res['requestButtonclass'] = '';
      $res['kpOnlyButton'] = 'displayNone';
    }else if($userType['type'] == 'gest'){
      // 承認申請中
      $res['message'] = '現在、KPの承認待ちです';
      $res['windowClass'] = 'displayNone';
      $res['requestButtonclass'] = 'displayNone';
      $res['kpOnlyButton'] = 'displayNone';
    }else if($userType['type'] == 'keeper'){
      // KPだった場合
      $res['message'] = 'あなたはこの部屋のKPです';
      $res['windowClass'] = '';
      $res['requestButtonclass'] = 'displayNone';
      $res['kpOnlyButton'] = '';
    }else{
      // 承認済み
      $res['message'] = '';
      $res['windowClass'] = '';
      $res['requestButtonclass'] = 'displayNone';
      $res['kpOnlyButton'] = 'displayNone';
    }
    return $res;
  }

  // ユーザータイプにデータをセット
  public function setUserType($id,$userName){
    $data = new \MyApp\Model\RoomModel();
    $data->setUserType($id,$userName);
  }


  public function setDefaultSession(){
    if(empty($_SESSION['selectedChar'])){
      // echo 'うんち';
      $_SESSION['selectedChar'] = '';
      $_SESSION['charId'] = '';
      $_SESSION['charIcon'] = '';
    }
  }

  // 承認申請中のユーザー一覧を取得
  public function getRequestedUser(){
    $data = new \MyApp\Model\RoomModel();
    $roomId = $_GET['roomId'];
    return $data->getRequestedUser($roomId);
  }

  public function userRecognize($userName,$id){
    $data = new \MyApp\Model\RoomModel();
    $data->userRecognize($userName,$id);
  }

  // 現在参加中のキャラ一覧を取得
  public function getTempChars($roomId){
    $data = new \MyApp\Model\RoomModel();
    return $data->getTempChars($roomId);
  }

  public function LoginCheck(){
    if(!$this->isLoggedIn()){
      header('Location: ' . PUBLIC_URL_HEADER . '/signup.php');
    }
  }

  // HPSAN編集処理
  public function modifiData($hp, $mp, $san, $hpUD, $mpUD, $sanUD, $id, $name){
    $data = new \MyApp\Model\RoomModel();
    $data->modifiData($hp, $mp, $san, $hpUD, $mpUD, $sanUD, $id, $name);
  }


}