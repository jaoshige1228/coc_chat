<?php

namespace MyApp\Model;

class User extends \MyApp\Model {
  public function create($values) {
    $stmt = $this->db->prepare("insert into users (name, password, created, modified) values (:name, :password, now(), now())");
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\DuplicateName();
    }
  }

  public function login($values) {
    $stmt = $this->db->prepare("select * from users where name = :name");
    $stmt->execute([
      ':name' => $values['name']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    if (empty($user)) {
      throw new \MyApp\Exception\UnmatchNameOrPassword();
    }

    if (!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchNameOrPassword();
    }

    return $user;
  }

  public function getMyId($name){
    $sql = "select id from users where name = :name";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':name' => $name
    ]);
    return $stmt->fetch(\PDO::FETCH_COLUMN);
  }

  // 簡単ログイン用のサンプルキャラを作成
  public function _createEasyCharSheet($userId, $id){
    $charId = $this->_copyCharStatus($userId, $id);
    $this->_copyCharSkills(1, $charId);
  }

  private function _copyCharSkills($id, $charId){
    // スキルの合計値を作成
    $sql = "insert into skills(
      回避,
      頭突き,
      応急手当,
      聞き耳,
      精神分析,
      図書館,
      ナビゲート,
      説得,
      心理学,
      母国語
    ) 
    select
      回避,
      頭突き,
      応急手当,
      聞き耳,
      精神分析,
      図書館,
      ナビゲート,
      説得,
      心理学,
      母国語
    from skills where id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);

    // 職業ポイントをコピー
    $sql = "insert into sum_jobP(
      聞き耳,
      精神分析,
      図書館,
      ナビゲート,
      説得,
      心理学
    )select
      聞き耳,
      精神分析,
      図書館,
      ナビゲート,
      説得,
      心理学
    from sum_jobP where id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);

    // 趣味ポイントをコピー
    $sql = "insert into sum_hobP(
      回避,
      頭突き,
      応急手当
    )select
      回避,
      頭突き,
      応急手当
    from sum_hobP where id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);

    // 回避、母国語の初期値をコピー
    $sql = "insert into skills_def(
      回避,
      母国語
    )select
      回避,
      母国語
    from skills_def where id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);

    // 各テーブルのidを取得
    $skillsId = $this->_getTableId('skills');
    $jobId = $this->_getTableId('sum_jobP');
    $hobId = $this->_getTableId('sum_hobP');
    $defId = $this->_getTableId('skills_def');

    // キャラのIDをセット
    $this->_setCharId('skills', $charId, $skillsId);
    $this->_setCharId('sum_jobP', $charId, $jobId);
    $this->_setCharId('sum_hobP', $charId, $hobId);
    $this->_setCharId('skills_def', $charId, $defId);
  }

  private function _copyCharStatus($userId, $id){
    $sql = "
    insert into chars(
      name,
      sex,
      age,
      job,
      str,
      dex,
      intel,
      con,
      app,
      pow,
      siz,
      san,
      maxSan,
      edu,
      hp,
      mp,
      Idea,
      luck,
      know,
      db,
      profile,
      subProfile,
      sum_jobP,
      sum_hobP,
      sum_etcP,
      icon
    )
     select 
      name,
      sex,
      age,
      job,
      str,
      dex,
      intel,
      con,
      app,
      pow,
      siz,
      san,
      maxSan,
      edu,
      hp,
      mp,
      Idea,
      luck,
      know,
      db,
      profile,
      subProfile,
      sum_jobP,
      sum_hobP,
      sum_etcP,
      icon
    from chars where id = :id
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);

    $charId = $this->_getTableId('chars');

    $sql = "update chars set plId = :plId where id = :charId";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':plId' => $userId,
      ':charId' => $charId
    ]);

    return $charId;
  }

  private function _setCharId($table, $charId, $id){
    $sql = "update ". $table ." set charId = :charId where id = :id";
    $stmt = $this->db->prepare($sql);
      $stmt->execute([
        ':charId' => $charId,
        ':id' => $id
      ]);
  }

  private function _getTableId($table){
    $sql = 'select id from '. $table . ' order by id desc';
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_COLUMN);
  }
  
}
