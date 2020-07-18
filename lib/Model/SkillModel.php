<?php

namespace MyApp\Model;

class SkillModel extends \MyApp\Model {
  public function skillValueCount($value){
    $sql = "select count(*) as count from skill_data where value = :value";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':value' => $value 
    ]);
    $skill_count = $stmt->fetch(\PDO::FETCH_ASSOC);

    // 最悪のコード
    // 至急どうにかされたし
    if($value == '戦闘'){
      $slice_start_point = 2;
    }else if($value == '探索'){
      $slice_start_point = 14;
    }else if($value == '行動'){
      $slice_start_point = 26;
    }else if($value == '交渉'){
      $slice_start_point = 37;
    }else if($value == '知識'){
      $slice_start_point = 43;
    }
    return [$slice_start_point,$skill_count];
  }

  // キャラ確認画面にて該当するサブスキル名を取得
  public function getSpecialSkillName($key){
    $sql = "select ".$key." from skill_name where charId =".$_SESSION['charId'];
    $stmt = $this->db->query($sql);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  // キャラ修正画面にて表の中にサブスキル名を格納するための用意
  public function setSpecialSkillsName($charId){
    $sql = "select * from skill_name where charId =".$charId;
    $stmt = $this->db->query($sql);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }



}