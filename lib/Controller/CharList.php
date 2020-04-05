<?php
namespace MyApp\Controller;

class CharList extends \MyApp\Controller {
  // 登録キャラ一覧を表示
  public function run(){
    $char = new \MyApp\Model\Char();
    return $char->name_list();
  }

  // 選択したキャラデータ一覧を取得
  public function CharData(){
    $char = new \MyApp\Model\Char();
    $temp = $char->char_data();
    $_SESSION['charName'] = $temp['name'];
    return $temp;
  }
  
  // 選択したキャラのスキル情報を所得
  public function SkillsData(){
    $skills = new \MyApp\Model\Char();
    list($res,$res2) = $skills->skills_data();

    return [$res,$res2];
  }

  // 選択したキャラのスキル合計点を取得
  public function InputData(){
    $input_data = new \MyApp\Model\Char();
    list($res,$res2,$res3) = $input_data->input_data();

    return [$res,$res2,$res3];
  }

  public function sliceSkills($skills,$value){
    $skill_value = new \MyApp\Model\SkillModel();
    list($slice_start_point,$skill_value_count) = $skill_value->skillValueCount($value);
    return array_slice(array_values($skills),$slice_start_point,$skill_value_count['count'],true);
  }

  public function setSpecialSkillsName($charId){
    if(isset($_SESSION['skillSubName'])){
      $data = new \MyApp\Model\SkillModel();
      $subName = $data->setSpecialSkillsName($charId);
      
      $unten = $subName['運転'];
      $souju = $subName['操縦'];
      $seisaku = $subName['製作'];
      $geijutu = $subName['芸術'];
      $bokokugo = $subName['母国語'];
      $hoka = $subName['他の言語'];

      return [$unten,$souju,$seisaku,$geijutu,$bokokugo,$hoka];
    }else{
      $unten = '';
      $souju = '';
      $seisaku = '';
      $geijutu = '';
      $bokokugo = '';
      $hoka = '';

      return [$unten,$souju,$seisaku,$geijutu,$bokokugo,$hoka];
    }
  }

  public function setSkillNameSession(){
    if(!isset($_SESSION['skillSubName'])){
      $_SESSION['skillSubName'] = ['運転','操縦','製作','芸術','他の言語','母国語'];
    }
  }


}