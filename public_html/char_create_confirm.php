<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\CharCreateConfirm();

$app->create_or_update_char();

$all_sum_skills = $app->all_skill_merge('sum_fight','sum_find','sum_act','sum_neg','sum_know','all_sum_skills');
$def_input_skills = $app->all_skill_merge('iniP_fight','iniP_find','iniP_act','iniP_neg','iniP_know','def_input_skills');
$job_input_skills = $app->all_skill_merge('jobP_fight','jobP_find','jobP_act','jobP_neg','jobP_know','job_input_skills');
$hob_input_skills = $app->all_skill_merge('hobP_fight','hobP_find','hobP_act','hobP_neg','hobP_know','hob_input_skills');
$etc_input_skills = $app->all_skill_merge('etcP_fight','etcP_find','etcP_act','etcP_neg','etcP_know','etc_input_skills');

$i = 0;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9,minimum-scale=0.9,user-scalable=no">
  <title>キャラシ登録確認</title>
  <link rel="stylesheet" href="sty.css">
</head>
<body>
  <div class="basicPackage">
    <h1 class="pageTitle">入力内容確認</h1>

    <div class="mainInfoWrap">
      <h2 class="subTitle">●基本情報</h2>
      <div class="yellowBorderContain">
        <p>名前：<?php h($app->confirm('char_name')); ?></p>
        <p>性別：<?php h($app->confirm('char_sex')); ?>　職業：<?php h($app->confirm('char_job')); ?>　年齢：<?php h($app->confirm('char_age')); ?>歳</p>
      </div>
    </div>
    
    <div class="mainInfoWrap">
      <h2 class="subTitle">●ステータス</h2>
      <div class="yellowBorderContain">
        <p>STR:<?php h($app->confirm('char_str')); ?>　DEX:<?php h($app->confirm('char_dex')); ?>　INT:<?php h($app->confirm('char_int')); ?>　CON:<?php h($app->confirm('char_con')); ?>　SIZ:<?php h($app->confirm('char_siz')); ?>　APP:<?php h($app->confirm('char_app')); ?>　POW:<?php h($app->confirm('char_pow')); ?>　SAN:<?php h($app->confirm('char_san')); ?>　MAXSAN:<?php h($app->confirm('char_max_san')); ?>　EDU:<?php h($app->confirm('char_edu')); ?>　HP:<?php h($app->confirm('char_hp')); ?>　MP:<?php h($app->confirm('char_mp')); ?>　アイデア:<?php h($app->confirm('char_idea')); ?>　知識:<?php h($app->confirm('char_know')); ?>　幸運:<?php h($app->confirm('char_luck')); ?>　ダメージボーナス:<?php h($app->confirm('char_db')); ?></p>
      </div>
    </div>

    <div class="mainInfoWrap">
      <h2 class="subTitle">●各種技能</h1>
      <div class="yellowBorderContain">
        <p>※初期値の技能は省略されます</p>
        <?php
        // skill_list_view($all_skills,$all_skills_def);
        $app->skill_list_view($all_sum_skills,$def_input_skills,'untenName','seisakuName','soujuName','bokokugoName','geijutuName','hokaName');
        ?>
        <p>職業技能点合計：<?= $app->confirm('sum_jobP'); ?></p>
        <p>趣味技能点合計：<?= $app->confirm('sum_hobP'); ?></p>
        <p>成長技能点合計：<?= $app->confirm('sum_etcP'); ?></p>
      
        <!-- 技能一覧を表示 -->
        <div class="skillTableConfirm">
          <table border="1">
            <tr>
              <th>技能名</th><th>初期値</th><th>職業P</th><th>興味P</th><th>成長等</th><th>合計</th>
            </tr>
            <?php foreach($all_sum_skills as $key => $value): ?>
              <tr>
                <td><?= $key; ?></td><td><?= $def_input_skills[$i]; ?></td><td><?= $job_input_skills[$i]; ?></td><td><?= $hob_input_skills[$i]; ?></td><td><?= $etc_input_skills[$i]; ?></td><td><?= $value; ?></td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>

    <div class="subInfoWrap">
      <h2 class="subTitle">●その他情報</h1>
      <div class="yellowBorderContain">
        <p>プロフィール:<?php h($app->confirm('char_profile')); ?></p>
        <p>備考:<?php h($app->confirm('char_sub_profile')); ?></p>
      </div>
    </div>

    <form action="" method="post">
      <input type="hidden" name="decide" value="<?= h($app->confirm('input_type')); ?>">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <button type="submit" class="decideButton">決定</button>
    </form>
    <a href="char_create.php">戻る</a>
  </div>
</body>
</html>