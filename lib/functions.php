<?php

function h($s){
  return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}

// function skill_list_view($skills,$def){
//   $i = 0;
//   foreach($skills as $skillName => $skillPoint){
//     if($def[$i] == $skillPoint){
//       $i++;
//       continue;
//     }
//     echo $skillName.'：'.$skillPoint.'</br>';
//     $_SESSION[$skillName] = $skillPoint;
//     $i++;
//   }
// }

  // function create_char(){
  //   $db = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
  //   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //   echo "落ち着こう";
  //   $stmt = $db->prepare("insert into chars(plId,name,sex,age,job,str,dex,intel,con,app,pow,siz,san,maxSan,edu,hp,mp,idea,luck,know,db,profile,subProfile) values(:plId,:name,:sex,:age,:job,:str,:dex,:intel,:con,:app,:pow,:siz,:san,:maxSan,:edu,:hp,:mp,:idea,:luck,:know,:db,:profile,:subProfile)");
  //   $stmt->bindValue(':plId',$_SESSION['me']->id,PDO::PARAM_STR);
  //   $stmt->bindValue(':name',$_SESSION['char_name'],PDO::PARAM_STR);
  //   $stmt->bindValue(':sex',$_SESSION['char_sex'],PDO::PARAM_STR);
  //   $stmt->bindValue(':age',$_SESSION['char_age'],PDO::PARAM_INT);
  //   $stmt->bindValue(':job',$_SESSION['char_job'],PDO::PARAM_STR);
  //   $stmt->bindValue(':str',$_SESSION['char_str'],PDO::PARAM_INT);
  //   $stmt->bindValue(':dex',$_SESSION['char_dex'],PDO::PARAM_INT);
  //   $stmt->bindValue(':intel',$_SESSION['char_int'],PDO::PARAM_INT);
  //   $stmt->bindValue(':con',$_SESSION['char_con'],PDO::PARAM_INT);
  //   $stmt->bindValue(':app',$_SESSION['char_app'],PDO::PARAM_INT);
  //   $stmt->bindValue(':pow',$_SESSION['char_pow'],PDO::PARAM_INT);
  //   $stmt->bindValue(':siz',$_SESSION['char_siz'],PDO::PARAM_INT);
  //   $stmt->bindValue(':san',$_SESSION['char_san'],PDO::PARAM_INT);
  //   $stmt->bindValue(':maxSan',$_SESSION['char_max_san'],PDO::PARAM_INT);
  //   $stmt->bindValue(':edu',$_SESSION['char_edu'],PDO::PARAM_INT);
  //   $stmt->bindValue(':hp',$_SESSION['char_hp'],PDO::PARAM_INT);
  //   $stmt->bindValue(':mp',$_SESSION['char_mp'],PDO::PARAM_INT);
  //   $stmt->bindValue(':idea',$_SESSION['char_idea'],PDO::PARAM_INT);
  //   $stmt->bindValue(':luck',$_SESSION['char_luck'],PDO::PARAM_INT);
  //   $stmt->bindValue(':know',$_SESSION['char_know'],PDO::PARAM_INT);
  //   $stmt->bindValue(':db',$_SESSION['char_db'],PDO::PARAM_STR);
  //   $stmt->bindValue(':profile',$_SESSION['char_profile'],PDO::PARAM_STR);
  //   $stmt->bindValue(':subProfile',$_SESSION['char_sub_profile'],PDO::PARAM_STR);
  //   $stmt->execute(); 

  //   $stmt = $db->prepare("insert into skills(plId,運転名前,製作名前,操縦名前,母国語名前,芸術名前,回避,キック,組み付き,こぶし,頭突き,投擲,マーシャルアーツ,拳銃,サブマシンガン,ショットガン,マシンガン,ライフル,応急手当,鍵開け,隠す,隠れる,聞き耳,忍び歩き,写真術,精神分析,追跡,登攀,図書館,目星,運転,機械修理,重機械操作,乗馬,水泳,製作,操縦,跳躍,電気修理,ナビゲート,変装,言いくるめ,信用,説得,値切り,母国語,医学,オカルト,化学,クトゥルフ神話,芸術,経理,考古学,コンピューター,心理学,人類学,生物学,地質学,電子工学,天文学,博物学,物理学,法律,薬学,歴史) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  //   $stmt->bindValue(1,$_SESSION['me']->id,PDO::PARAM_INT);
  //   $stmt->bindValue(2,$_SESSION['untenName'],PDO::PARAM_STR);
  //   $stmt->bindValue(3,$_SESSION['seisakuName'],PDO::PARAM_STR);
  //   $stmt->bindValue(4,$_SESSION['soujuName'],PDO::PARAM_INT);
  //   $stmt->bindValue(5,$_SESSION['bokokugoName'],PDO::PARAM_STR);
  //   $stmt->bindValue(6,$_SESSION['geijutuName'],PDO::PARAM_STR);
  //   $i = 7;
  //   foreach($_SESSION['all_skills'] as $skills){
  //     $stmt->bindValue($i,$skills,PDO::PARAM_INT);
  //     $i++;
  //   }  
  //   $stmt->execute();

    

  // }
