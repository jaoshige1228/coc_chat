<?php
namespace MyApp\Model;

class RoomModel extends \MyApp\Model {
  public function createRoom($values){
    // 部屋の作成
    $sql = "insert into rooms(roomName,userName,created,modified) values(:roomName,:userName,:created,:modified)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':roomName',$values['roomName'],\PDO::PARAM_STR);
    $stmt->bindValue(':userName',$values['userName'],\PDO::PARAM_STR);
    $stmt->bindValue(':created',$values['date']);
    $stmt->bindValue(':modified',$values['date']);
    $stmt->execute();

    // 今し方作成した部屋のIDを取得
    $sql = "select id from rooms where userName = :userName order by id desc limit 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':userName' => $values['userName']
    ]);
    $roomId = $stmt->fetch(\PDO::FETCH_ASSOC);

    // チャット部屋テーブルの作成
    $sql = "create table chat".$roomId['id']."(
      id int(5) zerofill auto_increment primary key,
      name varchar(255),
      text varchar(6000),
      icon varchar(1000),
      modified datetime
    )";
    $stmt = $this->db->query($sql);


    // ユーザータイプにKPと設定
    $sql = "insert into userType(roomId,userName,type) values(:roomId,:userName,:type)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':roomId',$roomId['id'],\PDO::PARAM_INT);
    $stmt->bindValue(':userName',$values['userName'],\PDO::PARAM_STR);
    $stmt->bindValue(':type','keeper',\PDO::PARAM_STR);
    $stmt->execute();
  }

  // 全ての部屋一覧を取得
  public function getRoomList(){
    $sql = "select * from rooms order by modified desc";
    $stmt = $this->db->query($sql);

    $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $res;
  }
  // 検索された部屋のみを取得
  public function getSearchedRoomList($roomName){
    $sql = "select * from rooms where roomName like '%".$roomName."%'";
    $stmt = $this->db->query($sql);
    // $stmt = $this->db->prepare($sql);
    // $stmt->execute([
    //   ':roomName' => $roomName
    // ]);
    
    $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    // var_dump($res);
    return $res;
  }

  // 入室している部屋の情報を取得
  public function getRoomInfo($id){
    $sql = "select * from rooms where id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);

    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $res;
  }

  // 入室している部屋の認証状態を取得
  public function getUserType($id,$userName){
    $sql = "select * from userType where roomId = :roomId AND userName = :userName";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':roomId' => $id,
      ':userName' => $userName
    ]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  // ユーザータイプにデータをセット
  public function setUserType($id,$userName){
    $sql = "insert into userType(roomId,userName) values(:roomId,:userName)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':roomId',$id,\PDO::PARAM_INT);
    $stmt->bindValue(':userName',$userName,\PDO::PARAM_STR);
    $stmt->execute();
  }

  // 承認申請中のユーザー一覧を取得
  public function getRequestedUser($roomId){
    $sql = "select userName from userType where roomId = :roomId and type = 'gest'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':roomId' => $roomId
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // KPが承認したユーザーの状態を切り替える
  public function userRecognize($userName,$id){
    $sql = "update userType set type = 'player' where roomId = :id and userName = :userName";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':id' => $id,
      ':userName' => $userName
    ]);
  }

  // 現在参加中のキャラ一覧を取得
  public function getTempChars($roomId){
    $sql = "select * from temp_player where roomId = :roomId";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':roomId' => $roomId
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function roomModify($roomId){
    $sql = "update rooms set modified = now() where id = :roomId";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':roomId',$roomId,\PDO::PARAM_INT);
    $stmt->execute();
  }


  // HPSAN増減処理
  public function modifiData($hp, $mp, $san, $hpUD, $mpUD, $sanUD, $id, $name){
    $sql = "select * from temp_player where roomId = :roomId and userName = :name";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':roomId' => $id,
      ':name' => $name
    ]);
    $data = $stmt->fetch(\PDO::FETCH_ASSOC);
    $tempHP = $data['charHP'];
    $tempMP = $data['charMP'];
    $tempSAN = $data['charSAN'];
    $newHP = $this->DataCul($tempHP, $hp, $hpUD);
    $newMP = $this->DataCul($tempMP, $mp, $mpUD);
    $newSAN = $this->DataCul($tempSAN, $san, $sanUD);

    $sql = "update temp_player set 
    charHP = :newHP,
    charMP = :newMP,
    charSAN = :newSAN 
    where roomId = :roomId and userName = :name";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':newHP',$newHP,\PDO::PARAM_INT);
    $stmt->bindValue(':newMP',$newMP,\PDO::PARAM_INT);
    $stmt->bindValue(':newSAN',$newSAN,\PDO::PARAM_INT);
    $stmt->bindValue(':roomId',$id,\PDO::PARAM_INT);
    $stmt->bindValue(':name',$name,\PDO::PARAM_STR);
    $stmt->execute();
  }

  private function DataCul($temp, $data, $ud){
    if($ud == 'up'){
      $temp += $data;
    }else if($ud == 'down'){
      $temp -= $data;
    }
    return $temp;
  }
}