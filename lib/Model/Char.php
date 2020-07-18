<?php
namespace MyApp\Model;

class Char extends \MyApp\Model {
  public function create(){

    // キャラの基本情報とステータスをデータベースに登録
    $stmt = $this->db->prepare("insert into chars(plId,name,sex,age,job,str,dex,intel,con,app,pow,siz,san,maxSan,edu,hp,mp,idea,luck,know,db,profile,subProfile,sum_jobP,sum_hobP,sum_etcP) values(:plId,:name,:sex,:age,:job,:str,:dex,:intel,:con,:app,:pow,:siz,:san,:maxSan,:edu,:hp,:mp,:idea,:luck,:know,:db,:profile,:subProfile,:sum_jobP,:sum_hobP,:sum_etcP)");
    $stmt->bindValue(':plId',$_SESSION['me']->id,\PDO::PARAM_STR);
    $stmt->bindValue(':name',$_SESSION['char_name'],\PDO::PARAM_STR);
    $stmt->bindValue(':sex',$_SESSION['char_sex'],\PDO::PARAM_STR);
    $stmt->bindValue(':age',$_SESSION['char_age'],\PDO::PARAM_INT);
    $stmt->bindValue(':job',$_SESSION['char_job'],\PDO::PARAM_STR);
    $stmt->bindValue(':str',$_SESSION['char_str'],\PDO::PARAM_INT);
    $stmt->bindValue(':dex',$_SESSION['char_dex'],\PDO::PARAM_INT);
    $stmt->bindValue(':intel',$_SESSION['char_int'],\PDO::PARAM_INT);
    $stmt->bindValue(':con',$_SESSION['char_con'],\PDO::PARAM_INT);
    $stmt->bindValue(':app',$_SESSION['char_app'],\PDO::PARAM_INT);
    $stmt->bindValue(':pow',$_SESSION['char_pow'],\PDO::PARAM_INT);
    $stmt->bindValue(':siz',$_SESSION['char_siz'],\PDO::PARAM_INT);
    $stmt->bindValue(':san',$_SESSION['char_san'],\PDO::PARAM_INT);
    $stmt->bindValue(':maxSan',$_SESSION['char_max_san'],\PDO::PARAM_INT);
    $stmt->bindValue(':edu',$_SESSION['char_edu'],\PDO::PARAM_INT);
    $stmt->bindValue(':hp',$_SESSION['char_hp'],\PDO::PARAM_INT);
    $stmt->bindValue(':mp',$_SESSION['char_mp'],\PDO::PARAM_INT);
    $stmt->bindValue(':idea',$_SESSION['char_idea'],\PDO::PARAM_INT);
    $stmt->bindValue(':luck',$_SESSION['char_luck'],\PDO::PARAM_INT);
    $stmt->bindValue(':know',$_SESSION['char_know'],\PDO::PARAM_INT);
    $stmt->bindValue(':db',$_SESSION['char_db'],\PDO::PARAM_STR);
    $stmt->bindValue(':profile',$_SESSION['char_profile'],\PDO::PARAM_STR);
    $stmt->bindValue(':subProfile',$_SESSION['char_sub_profile'],\PDO::PARAM_STR);
    $stmt->bindValue(':sum_jobP',$_SESSION['sum_jobP'],\PDO::PARAM_INT);
    $stmt->bindValue(':sum_hobP',$_SESSION['sum_hobP'],\PDO::PARAM_INT);
    $stmt->bindValue(':sum_etcP',$_SESSION['sum_etcP'],\PDO::PARAM_INT);
    $stmt->execute(); 

    // キャラIDを取得
    $stmt= $this->db->prepare("select id from chars where plId = :plId order by id desc limit 1");
    $stmt->execute([
      ':plId' => $_SESSION['me']->id
    ]);
    $tempId = $stmt->fetch(\PDO::FETCH_ASSOC);

    // 技能一覧を変数に格納しておく
    $skill_list = "charId,回避,キック,組み付き,こぶし,頭突き,投擲,マーシャルアーツ,拳銃,サブマシンガン,ショットガン,マシンガン,ライフル,応急手当,鍵開け,隠す,隠れる,聞き耳,忍び歩き,写真術,精神分析,追跡,登攀,図書館,目星,運転,機械修理,重機械操作,乗馬,水泳,製作,操縦,跳躍,電気修理,ナビゲート,変装,言いくるめ,信用,説得,値切り,母国語,他の言語,医学,オカルト,化学,クトゥルフ神話,芸術,経理,考古学,コンピューター,心理学,人類学,生物学,地質学,電子工学,天文学,博物学,物理学,法律,薬学,歴史";
    
    // はてなマークをカラムの数だけ用意
    $hatena = '';
    for($i=0;$i<61;$i++){
      if($i == 60){
        $hatena .= '?';
      }else{
        $hatena .= '?,';
      }
    }

    // 技能合計点をデーターベースに登録
    $sql = "insert into skills(".$skill_list.") values(".$hatena.")";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(1,$tempId['id'],\PDO::PARAM_INT);
    $i = 2;
    foreach($_SESSION['all_sum_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }  
    $stmt->execute();

    // 技能の初期値をデーターベースに登録
    $sql = "insert into skills_def(".$skill_list.") values(".$hatena.")";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(1,$tempId['id'],\PDO::PARAM_INT);
    $i = 2;
    foreach($_SESSION['def_input_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }
    $stmt->execute();

    // 入力した職業技能点の情報をデーターベースに登録
    $sql = "insert into sum_jobP(".$skill_list.") values(".$hatena.")";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(1,$tempId['id'],\PDO::PARAM_INT);
    $i = 2;
    foreach($_SESSION['job_input_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }
    $stmt->execute();

    // 入力した趣味技能点の情報をデーターベースに登録
    $sql = "insert into sum_hobP(".$skill_list.") values(".$hatena.")";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(1,$tempId['id'],\PDO::PARAM_INT);
    $i = 2;
    foreach($_SESSION['hob_input_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }
    $stmt->execute();

    // 入力した成長技能点の情報をデーターベースに登録
    $sql = "insert into sum_etcP(".$skill_list.") values(".$hatena.")";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(1,$tempId['id'],\PDO::PARAM_INT);
    $i = 2;
    foreach($_SESSION['etc_input_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }
    $stmt->execute();


    // 一部の技能の名前をデーターベースに登録
    $stmt = $this->db->prepare("insert into skill_name(charId,運転,製作,操縦,芸術,母国語,他の言語) values(:charId,:unten,:seisaku,:souju,:geijutu,:bokokugo,:hoka)");
    $stmt->bindValue(':charId',$tempId['id'],\PDO::PARAM_INT);
    $stmt->bindValue(':unten',$_SESSION['untenName'],\PDO::PARAM_STR);
    $stmt->bindValue(':seisaku',$_SESSION['seisakuName'],\PDO::PARAM_STR);
    $stmt->bindValue(':souju',$_SESSION['soujuName'],\PDO::PARAM_STR);
    $stmt->bindValue(':geijutu',$_SESSION['geijutuName'],\PDO::PARAM_STR);
    $stmt->bindValue(':bokokugo',$_SESSION['bokokugoName'],\PDO::PARAM_STR);
    $stmt->bindValue(':hoka',$_SESSION['hokaName'],\PDO::PARAM_STR);
    $stmt->execute();

  }



  // 〜〜〜〜〜〜〜〜〜〜〜ここまでキャラ登録〜〜〜〜〜〜〜〜〜〜〜〜〜〜
  // 〜〜〜〜〜〜〜〜〜〜〜ここからキャラ更新〜〜〜〜〜〜〜〜〜〜〜〜〜〜




  public function update($charId){
    // キャラの基本情報とステータスをデータベースに登録
    $stmt = $this->db->prepare("update chars set 

    name = :name,sex = :sex,age = :age,job = :job,str = :str,dex = :dex,intel = :intel,con = :con,app = :app,pow = :pow,siz = :siz,san = :san,maxSan = :maxSan,edu = :edu,hp = :hp,mp = :mp,idea = :idea,luck = :luck,know = :know,db = :db,profile = :profile,subProfile = :subProfile,sum_jobP = :sum_jobP,sum_hobP = :sum_hobP,sum_etcP = :sum_etcP 

    where id =".$charId);
    $stmt->bindValue(':name',$_SESSION['char_name'],\PDO::PARAM_STR);
    $stmt->bindValue(':sex',$_SESSION['char_sex'],\PDO::PARAM_STR);
    $stmt->bindValue(':age',$_SESSION['char_age'],\PDO::PARAM_INT);
    $stmt->bindValue(':job',$_SESSION['char_job'],\PDO::PARAM_STR);
    $stmt->bindValue(':str',$_SESSION['char_str'],\PDO::PARAM_INT);
    $stmt->bindValue(':dex',$_SESSION['char_dex'],\PDO::PARAM_INT);
    $stmt->bindValue(':intel',$_SESSION['char_int'],\PDO::PARAM_INT);
    $stmt->bindValue(':con',$_SESSION['char_con'],\PDO::PARAM_INT);
    $stmt->bindValue(':app',$_SESSION['char_app'],\PDO::PARAM_INT);
    $stmt->bindValue(':pow',$_SESSION['char_pow'],\PDO::PARAM_INT);
    $stmt->bindValue(':siz',$_SESSION['char_siz'],\PDO::PARAM_INT);
    $stmt->bindValue(':san',$_SESSION['char_san'],\PDO::PARAM_INT);
    $stmt->bindValue(':maxSan',$_SESSION['char_max_san'],\PDO::PARAM_INT);
    $stmt->bindValue(':edu',$_SESSION['char_edu'],\PDO::PARAM_INT);
    $stmt->bindValue(':hp',$_SESSION['char_hp'],\PDO::PARAM_INT);
    $stmt->bindValue(':mp',$_SESSION['char_mp'],\PDO::PARAM_INT);
    $stmt->bindValue(':idea',$_SESSION['char_idea'],\PDO::PARAM_INT);
    $stmt->bindValue(':luck',$_SESSION['char_luck'],\PDO::PARAM_INT);
    $stmt->bindValue(':know',$_SESSION['char_know'],\PDO::PARAM_INT);
    $stmt->bindValue(':db',$_SESSION['char_db'],\PDO::PARAM_STR);
    $stmt->bindValue(':profile',$_SESSION['char_profile'],\PDO::PARAM_STR);
    $stmt->bindValue(':subProfile',$_SESSION['char_sub_profile'],\PDO::PARAM_STR);
    $stmt->bindValue(':sum_jobP',$_SESSION['sum_jobP'],\PDO::PARAM_INT);
    $stmt->bindValue(':sum_hobP',$_SESSION['sum_hobP'],\PDO::PARAM_INT);
    $stmt->bindValue(':sum_etcP',$_SESSION['sum_etcP'],\PDO::PARAM_INT);
    $stmt->execute();

    // 技能一覧を変数に格納しておく
    $skill_list = "回避 = ?,キック = ?,組み付き = ?,こぶし = ?,頭突き = ?,投擲 = ?,マーシャルアーツ = ?,拳銃 = ?,サブマシンガン = ?,ショットガン = ?,マシンガン = ?,ライフル = ?,応急手当 = ?,鍵開け = ?,隠す = ?,隠れる = ?,聞き耳 = ?,忍び歩き = ?,写真術 = ?,精神分析 = ?,追跡 = ?,登攀 = ?,図書館 = ?,目星 = ?,運転 = ?,機械修理 = ?,重機械操作 = ?,乗馬 = ?,水泳 = ?,製作 = ?,操縦 = ?,跳躍 = ?,電気修理 = ?,ナビゲート = ?,変装 = ?,言いくるめ = ?,信用 = ?,説得 = ?,値切り = ?,母国語 = ?,他の言語 = ?,医学 = ?,オカルト = ?,化学 = ?,クトゥルフ神話 = ?,芸術 = ?,経理 = ?,考古学 = ?,コンピューター = ?,心理学 = ?,人類学 = ?,生物学 = ?,地質学 = ?,電子工学 = ?,天文学 = ?,博物学 = ?,物理学 = ?,法律 = ?,薬学 = ?,歴史 = ?";

    // 技能合計点をデーターベースに登録
    $sql = "update skills set ".$skill_list." where charId =".$charId;
    $stmt = $this->db->prepare($sql);
    $i = 1;
    foreach($_SESSION['all_sum_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }  
    $stmt->execute();

    // 技能の初期値をデーターベースに登録
    $sql = "update skills_def set ".$skill_list." where charId =".$charId;
    $stmt = $this->db->prepare($sql);
    $i = 1;
    foreach($_SESSION['def_input_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }
    $stmt->execute();

    // 入力した職業技能点の情報をデーターベースに登録
    $sql = "update sum_jobP set ".$skill_list." where charId =".$charId;
    $stmt = $this->db->prepare($sql);
    $i = 1;
    foreach($_SESSION['job_input_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }
    $stmt->execute();

    // 入力した趣味技能点の情報をデーターベースに登録
    $sql = "update sum_hobP set ".$skill_list." where charId =".$charId;
    $stmt = $this->db->prepare($sql);
    $i = 1;
    foreach($_SESSION['hob_input_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }
    $stmt->execute();

    // 入力した成長技能点の情報をデーターベースに登録
    $sql = "update sum_etcP set ".$skill_list." where charId =".$charId;
    $stmt = $this->db->prepare($sql);
    $i = 1;
    foreach($_SESSION['etc_input_skills'] as $value){
      $stmt->bindValue($i,$value,\PDO::PARAM_INT);
      $i++;
    }
    $stmt->execute();

    // 一部の技能の名前をデーターベースに登録
    $stmt = $this->db->prepare("update skill_name set 運転 = :unten,製作 = :seisaku,操縦 = :souju,芸術 = :geijutu,母国語 = :bokokugo,他の言語 = :hoka where charId =".$charId);
    $stmt->bindValue(':unten',$_SESSION['untenName'],\PDO::PARAM_STR);
    $stmt->bindValue(':seisaku',$_SESSION['seisakuName'],\PDO::PARAM_STR);
    $stmt->bindValue(':souju',$_SESSION['soujuName'],\PDO::PARAM_STR);
    $stmt->bindValue(':geijutu',$_SESSION['geijutuName'],\PDO::PARAM_STR);
    $stmt->bindValue(':bokokugo',$_SESSION['bokokugoName'],\PDO::PARAM_STR);
    $stmt->bindValue(':hoka',$_SESSION['hokaName'],\PDO::PARAM_STR);
    $stmt->execute();
  }



  // 〜〜〜〜〜〜〜〜〜〜〜ここまでキャラ更新〜〜〜〜〜〜〜〜〜〜〜〜〜〜



  // 登録したキャラの名前一覧を取得する
  public function name_list(){
    $sql= "select * from chars where plId =".$_SESSION['me']->id;
    $stmt =$this->db->query($sql);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  // 選択したキャラの基本情報やステータスを取得
  public function char_data(){
    if(isset($_POST['charList']) && $_POST['charList'] == 'call'){
      $_SESSION['charId'] = $_POST['charId'];
    }
    $sql= "select * from chars where id = '".$_SESSION['charId']."'";
    $stmt = $this->db->query($sql);
    return $stmt->fetch();
  }

  // キャラの技能の情報を取得
  public function skills_data(){
    $sql= "select * from skills where charId = '".$_SESSION["charId"]."'";
    $sql2= "select * from skills_def where charId = '".$_SESSION["charId"]."'";
    
    $stmt = $this->db->query($sql);
    $stmt2 = $this->db->query($sql2);
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);

    // 初期値の配列のキーを数字に直す
    $temp = $stmt2->fetch(\PDO::FETCH_ASSOC);
    $res2 = [];
    $i = 0;
    foreach($temp as $value){
      $res2[$i] = $value;
      $i++;
    }

    return [$res,$res2];
  }

  public function input_data(){
    $sql= "select * from sum_jobP where charId = '".$_SESSION["charId"]."'";
    $sql2= "select * from sum_hobP where charId = '".$_SESSION["charId"]."'";
    $sql3= "select * from sum_etcP where charId = '".$_SESSION["charId"]."'";

    $stmt = $this->db->query($sql);
    $stmt2 = $this->db->query($sql2);
    $stmt3 = $this->db->query($sql3);

    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    $res2 = $stmt2->fetch(\PDO::FETCH_ASSOC);
    $res3 = $stmt3->fetch(\PDO::FETCH_ASSOC);

    return [array_values($res),array_values($res2),array_values($res3)];
  }

  // アイコン画像をdbに格納
  public function uploadIcon($image,$charId){
    // var_dump($image);
    $sql = "update chars set icon = :icon where id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':icon' => $image,
      ':id' => $charId
    ]);
  }

  public function test($test){
    $sql = "update test set うんち = ? where id = 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(1,$test,\PDO::PARAM_STR);
    $stmt->execute();
  }

}