<?php
namespace MyApp\Controller;

class CharCreateConfirm extends \MyApp\Controller{

  // ポストされた数値をセッションに格納
  public function confirm($post){
    $_SESSION[$post] = $_POST[$post];
    echo nl2br($_SESSION[$post]);
  }

  public function all_skill_merge($po_fight,$po_find,$po_act,$po_neg,$po_know,$arrayName){
    require(__DIR__.'/../skill_list.php');
    // ジャンルごとにPOSTされた数値を、技能の名前と一致させる。
    $skills_fight = array_combine(array_keys($skill_fight_list),$_POST[$po_fight]);
    $skills_find = array_combine(array_keys($skill_find_list),$_POST[$po_find]);
    $skills_act = array_combine(array_keys($skill_act_list),$_POST[$po_act]);
    $skills_neg = array_combine(array_keys($skill_neg_list),$_POST[$po_neg]);
    $skills_know = array_combine(array_keys($skill_know_list),$_POST[$po_know]);

    // ジャンルごとに分かれている配列を一つにまとめて、一時的に保持
    $temp_skills = array_merge($skills_fight,$skills_find,$skills_act,$skills_neg,$skills_know);

    // 合計値ならtemp_skillsをそのまま返し、そうでなければ、各配列のキーを数字の連番に直す
    if($arrayName != 'all_sum_skills'){
      $all_skills =[];
      $i = 0;
      foreach($temp_skills as $value){
        $all_skills[$i] = $value;
        $i++;
      }
      $_SESSION[$arrayName] = $all_skills;
      return $all_skills;
    }else{
      $_SESSION[$arrayName] = $temp_skills;
      return $temp_skills;
    }
  }

  // キャラ作成確認画面にて、初期値を除いた技能を一覧表示する
  public function skill_list_view($skills,$def,$unten,$seisaku,$souju,$bokokugo,$geijutu,$hoka){
    $i = 0;
    foreach($skills as $skillName => $skillPoint){
      // 技能が初期値の場合処理をスキップ
      if($def[$i] == $skillPoint){
        $i++;
        continue;
      }
      // 技能にサブ名前がついてる場合、特別処理
      if($skillName == "運転"){
        echo $skillName.'<'.$_POST[$unten].'>'.'：'.$skillPoint.'</br>';
        $_SESSION[$unten] = $_POST[$unten];
        $i++;
        continue;
      }else if($skillName == '製作'){
        echo $skillName.'<'.$_POST[$seisaku].'>'.'：'.$skillPoint.'</br>';
        $_SESSION[$seisaku] = $_POST[$seisaku];
        $i++;
        continue;
      }else if($skillName == '操縦'){
        echo $skillName.'<'.$_POST[$souju].'>'.'：'.$skillPoint.'</br>';
        $_SESSION[$souju] = $_POST[$souju];
        $i++;
        continue;
      }else if($skillName == '母国語'){
        echo $skillName.'<'.$_POST[$bokokugo].'>'.'：'.$skillPoint.'</br>';
        $_SESSION[$bokokugo] = $_POST[$bokokugo];
        $i++;
        continue;
      }else if($skillName == '芸術'){
        echo $skillName.'<'.$_POST[$geijutu].'>'.'：'.$skillPoint.'</br>';
        $_SESSION[$geijutu] = $_POST[$geijutu];
        $i++;
        continue;
      }else if($skillName == '他の言語'){
        echo $skillName.'<'.$_POST[$hoka].'>'.'：'.$skillPoint.'</br>';
        $_SESSION[$hoka] = $_POST[$hoka];
        $i++;
        continue;
      }else{
        echo $skillName.'：'.$skillPoint.'</br>';
        $i++;
      }
    }
  }

  // キャラ作成時の処理
  public function create_or_update_char(){
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['decide'])) {
      if($_POST['decide'] == 'create'){
        $this->create_char();
      }else if($_POST['decide'] == 'update'){
        $this->update_char();
      }
    }
  }

  protected function create_char(){
    $charModel = new \MyApp\Model\Char();
    $charModel->create();
    header('Location: char_list.php');
  }

  protected function update_char(){
    $charModel = new \MyApp\Model\Char();
    $charId = $_SESSION['charId'];
    $charModel->update($charId);
    header('Location: char_list.php');
  }

  // 初期値の技能を除いてスキルを表示する処理
  public function show($skills,$def){
    $i = 0;
    foreach($skills as $key => $value){
        // 技能名が必要な特殊なものかどうかチェック
        // if($this->_checkSpecialSkills($key)){
        //   echo $key.'は該当するぜ！'.'<br />';
        // }
        
        if($value == $def[$i]){
          $i++;
          // echo '初期値です';
          continue;
        }else if($key == 'id'){
          $i++;
          // echo 'IDです';
          continue;
        }else if($key == 'charId'){
          $i++;
          // echo 'charIDです';
          continue;
        }else if($this->_checkSpecialSkills($key)){
          $name = $this->_getSpecialSkillName($key);
          echo $key.'<'.$name[$key].'>：'.$value.'<br />';
          // echo $key.'は該当するぜ！'.'<br />';
          // var_dump($name);
          $i++;
          continue;
        }else{
          echo $key.'：'.$value.'<br />';
          $i++;
        }
    }
  }

  private function _checkSpecialSkills($key){
    if(
      $key == '運転' ||
      $key == '製作' ||
      $key == '操縦' ||
      $key == '母国語' ||
      $key == '他の言語' ||
      $key == '芸術'
      ){
        return true;
      }else{
        return false;
      }
  }

  private function _getSpecialSkillName($key){
    $data = new \MyApp\Model\SkillModel();
    return $data->getSpecialSkillName($key);
  }

  public function test(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $charModel = new \MyApp\Model\Char();
      $charModel->test($_POST['text']);
    }
  }
}