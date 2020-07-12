<?php
namespace MyApp\Model;

class ChatModel extends \MyApp\Model {

  // 投稿されたチャットをデータベースに格納
  public function chatPost($name,$text,$date,$icon,$id){
    try{
      $sql = "insert into chat".$id."(name,text,modified,icon) values(:name,:text,:modified,:icon)";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue(':name',$name,\PDO::PARAM_STR);
      $stmt->bindValue(':text',$text,\PDO::PARAM_STR);
      $stmt->bindValue(':modified',$date);
      $stmt->bindValue(':icon',$icon,\PDO::PARAM_STR);
      $stmt->execute();
    }catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  // チャット本文を取得
  public function getBody($id){
    $sql = "select * from chat".$id." order by id desc";
    $stmt = $this->db->query($sql);
    return  $stmt->fetchAll(\PDO::FETCH_CLASS, 'stdClass');
  }

  // 登録しているキャラの名前とIDを取得
  public function getName(){
    $sql= "select name,id,icon from chars where plId =".$_SESSION['me']->id;
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // 選択したキャラの基本情報を取得
  public function getCharData($id){
    $sql= "select * from chars where id =".$id;
    $stmt = $this->db->query($sql);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }
  // 選択したキャラの技能情報を取得
  public function getSkillData($id){
    $sql= "select * from skills where charId =".$id;
    $stmt = $this->db->query($sql);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }
  // 選択したキャラの技能初期値情報を取得
  public function getSkillDefData($id){
    $sql= "select * from skills_def where charId =".$id;
    $stmt = $this->db->query($sql);

    // 配列のキーを数字に直す
    $temp = $stmt->fetch(\PDO::FETCH_ASSOC);
    $res = [];
    $i = 0;

    // セッションがセットされてない時のためにif
    if($temp !== false){
      foreach($temp as $value){
        $res[$i] = $value;
        $i++;
      }
    }
    return $res;
  }

  public function getSkillType($value){
    $sql = "select name from skill_data where value = :value";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':value' => $value
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function diceResult($value,$result,$charId){
    $test = $value;
    $sql = "select ".$test." from skills where charId = :charId";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      // ':test' => $test,
      ':charId' => $charId
    ]);
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $res[$test];
  }

  public function setTempPlayer($id,$userName){
    try{
      $sql = "insert into temp_player(roomId,userName) values(:roomId,:userName)";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue(':roomId', $id, \PDO::PARAM_INT);
      $stmt->bindValue(':userName', $userName, \PDO::PARAM_STR);
      $stmt->execute();
    }catch (\PDOException $e) {
      echo $e->getMessage('おかしいで');
      exit;
    }
  }

  // 現在の部屋に参加中のプレイヤーデータ更新
  public function updateTempPlayer($roomId, $charName,$userName, $hp, $mp, $san, $charId){
    try{
      $sql = "update temp_player set 
      charName = :charName,
      charHP = :hp,
      charMP = :mp,
      charSAN = :san,
      charId = :charId
      where roomId = :roomId and userName = :userName";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue(':charName', $charName, \PDO::PARAM_STR);
      $stmt->bindValue(':hp', $hp, \PDO::PARAM_INT);
      $stmt->bindValue(':mp', $mp, \PDO::PARAM_INT);
      $stmt->bindValue(':san', $san, \PDO::PARAM_INT);
      $stmt->bindValue(':charId', $charId, \PDO::PARAM_INT);
      $stmt->bindValue(':roomId', $roomId, \PDO::PARAM_INT);
      $stmt->bindValue(':userName', $userName, \PDO::PARAM_STR);
      $stmt->execute();
    }catch (\PDOException $e) {
      echo $e->getMessage('おかしいで');
      exit;
    }
  }

  public function getAllCharID($roomId){
    $sql = "select charId from temp_player where roomId = :roomId";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':roomId' => $roomId
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getCharId($plId){
    $sql = "select id from chars where plId = :plId";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':plId' => $plId
    ]);
    return $stmt->fetch(\PDO::FETCH_COLUMN);
  }

  public function addSecondRoom($charId, $userName){
    // 登録されているゲストプレイヤーを削除
    $sql = "delete from temp_player where charName = '前向 ララ' and roomId = 11";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    // ２番目の部屋に前向ララを登録
    $sql = "insert into temp_player(roomId, charName, charId, charHP, charMP, charSAN, userName) values(11, '前向 ララ', :charId, 10, 17, 80, :userName)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':charId', $charId, \PDO::PARAM_INT);
    $stmt->bindValue(':userName', $userName, \PDO::PARAM_STR);
    $stmt->execute();

    $sql = "insert into userType(roomId, userName, type) values(11, :userName, 'player')";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':userName', $userName, \PDO::PARAM_STR);
    $stmt->execute();
  }
}