<?php
require_once(__DIR__ . '/../config/config.php');
$app = new MyApp\Controller\CharList();

// キャラ修正の時のみサブスキル名を取得し、そうでなければ空白
list($unten,$souju,$seisaku,$geijutu,$bokokugo,$hoka) = $app->setSpecialSkillsName($_SESSION['charId']);


$skill_fight_list = array(
  '回避' => array(
    '名前' => '回避',
    '初期値' => 0
  ),
  'キック' => array(
    '名前' => 'キック',
    '初期値' => 25
  ),
  '組み付き' => array(
    '名前' => '組み付き',
    '初期値' => 25
  ),
  'こぶし' => array(
    '名前' => 'こぶし',
    '初期値' => 50
  ),
  '頭突き' => array(
    '名前' => '頭突き',
    '初期値' => 10
  ),
  '投擲' => array(
    '名前' => '投擲',
    '初期値' => 25
  ),
  'マーシャルアーツ' => array(
    '名前' => 'マーシャルアーツ',
    '初期値' => 1
  ),
  '拳銃' => array(
    '名前' => '拳銃',
    '初期値' => 20
  ),
  'サブマシンガン' => array(
    '名前' => 'サブマシンガン',
    '初期値' => 15
  ),
  'ショットガン' => array(
    '名前' => 'ショットガン',
    '初期値' => 30
  ),
  'マシンガン' => array(
    '名前' => 'マシンガン',
    '初期値' => 15
  ),
  'ライフル' => array(
    '名前' => 'ライフル',
    '初期値' => 25
  )
);
$skill_find_list = array(
  '応急手当' => array(
    '名前' => '応急手当',
    '初期値' => 30
  ),
  '鍵開け' => array(
    '名前' => '鍵開け',
    '初期値' => 1
  ),
  '隠す' => array(
    '名前' => '隠す',
    '初期値' => 15
  ),
  '隠れる' => array(
    '名前' => '隠れる',
    '初期値' => 10
  ),
  '聞き耳' => array(
    '名前' => '聞き耳',
    '初期値' => 25
  ),
  '忍び歩き' => array(
    '名前' => '忍び歩き',
    '初期値' => 10
  ),
  '写真術' => array(
    '名前' => '写真術',
    '初期値' => 10
  ),
  '精神分析' => array(
    '名前' => '精神分析',
    '初期値' => 1
  ),
  '追跡' => array(
    '名前' => '追跡',
    '初期値' => 10
  ),
  '登攀' => array(
    '名前' => '登攀',
    '初期値' => 40
  ),
  '図書館' => array(
    '名前' => '図書館',
    '初期値' => 25
  ),
  '目星' => array(
    '名前' => '目星',
    '初期値' => 25
  )
);
$skill_act_list = array(
  '運転' => array(
    '名前' => '運転(<input type="text" name="untenName" value="'.$unten.'">)',
    '初期値' => 20
  ),
  '重機械操作' => array(
    '名前' => '重機械操作',
    '初期値' => 1
  ),
  '機械修理' => array(
    '名前' => '機械修理',
    '初期値' => 20
  ),
  '乗馬' => array(
    '名前' => '乗馬',
    '初期値' => 5
  ),
  '水泳' => array(
    '名前' => '水泳',
    '初期値' => 25
  ),
  '製作' => array(
    '名前' => '製作(<input type="text" name="seisakuName" value="'.$seisaku.'">)',
    '初期値' => 5
  ),
  '操縦' => array(
    '名前' => '操縦(<input type="text" name="soujuName" value="'.$souju.'">)',
    '初期値' => 1
  ),
  '跳躍' => array(
    '名前' => '跳躍',
    '初期値' => 25
  ),
  '電気修理' => array(
    '名前' => '電気修理',
    '初期値' => 10
  ),
  'ナビゲート' => array(
    '名前' => 'ナビゲート',
    '初期値' => 10
  ),
  '変装' => array(
    '名前' => '変装',
    '初期値' => 1
  )
);
$skill_neg_list = array(
  '言いくるめ' => array(
    '名前' => '言いくるめ',
    '初期値' => 5
  ),
  '信用' => array(
    '名前' => '信用',
    '初期値' => 15
  ),
  '説得' => array(
    '名前' => '説得',
    '初期値' => 15
  ),
  '値切り' => array(
    '名前' => '値切り',
    '初期値' => 5
  ),
  '母国語' => array(
    '名前' => '母国語(<input type="text" name="bokokugoName" value="'.$bokokugo.'">)',
    '初期値' => 0
  ),
  '他の言語' => array(
    '名前' => '他の言語(<input type="text" name="hokaName" value="'.$hoka.'">)',
    '初期値' => 1
  )
);
$skill_know_list = array(
  '医学' => array(
    '名前' => '医学',
    '初期値' => 5
  ),
  'オカルト' => array(
    '名前' => 'オカルト',
    '初期値' => 5
  ),
  '化学' => array(
    '名前' => '化学',
    '初期値' => 1
  ),
  'クトゥルフ神話' => array(
    '名前' => 'クトゥルフ神話',
    '初期値' => 0
  ),
  '芸術' => array(
    '名前' => '芸術(<input type="text" name="geijutuName" value="'.$geijutu.'">)',
    '初期値' => 5
  ),
  '経理' => array(
    '名前' => '経理',
    '初期値' => 10
  ),
  '考古学' => array(
    '名前' => '考古学',
    '初期値' => 1
  ),
  'コンピューター' => array(
    '名前' => 'コンピューター',
    '初期値' => 1
  ),
  '心理学' => array(
    '名前' => '心理学',
    '初期値' => 5
  ),
  '人類学' => array(
    '名前' => '人類学',
    '初期値' => 1
  ),
  '生物学' => array(
    '名前' => '生物学',
    '初期値' => 1
  ),
  '地質学' => array(
    '名前' => '地質学',
    '初期値' => 1
  ),
  '電子工学' => array(
    '名前' => '電子光学',
    '初期値' => 1
  ),
  '天文学' => array(
    '名前' => '天文学',
    '初期値' => 1
  ),
  '博物学' => array(
    '名前' => '博物学',
    '初期値' => 10
  ),
  '物理学' => array(
    '名前' => '物理学',
    '初期値' => 1
  ),
  '法律' => array(
    '名前' => '法律',
    '初期値' => 5
  ),
  '薬学' => array(
    '名前' => '薬学',
    '初期値' => 1
  ),
  '歴史' => array(
    '名前' => '歴史',
    '初期値' => 20
  )
);

foreach($skill_fight_list as $list){
  $skill_fight_def[] = $list['初期値'];
}
foreach($skill_find_list as $list){
  $skill_find_def[] = $list['初期値'];
}
foreach($skill_act_list as $list){
  $skill_act_def[] = $list['初期値'];
}
foreach($skill_neg_list as $list){
  $skill_neg_def[] = $list['初期値'];
}
foreach($skill_know_list as $list){
  $skill_know_def[] = $list['初期値'];
}

$all_skills_def = array_merge($skill_fight_def,$skill_find_def,$skill_act_def,$skill_neg_def,$skill_know_def);