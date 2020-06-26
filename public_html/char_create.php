<?php
require_once(__DIR__ . '/../config/config.php');
unset($_SESSION['skillSubName']);
require_once(__DIR__.'/../lib/skill_list.php');

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9,minimum-scale=0.9,user-scalable=no">
  <title>キャラシ登録</title>
  <link rel="stylesheet" href="sty.css">
</head>
<body>
  <div class="basicPackage">
    <form  action="char_create_confirm.php" method="post">
      <div class="title">
        <h1 class="pageTitle">〜キャラクターシート登録画面〜</h1>
      </div>
      <a href="index.php" class="returnHome">ホームに戻る</a>
      
      <div class="mainInfoWrap">
        <h2 class="subTitle">●基本情報</h2>
        <div class="yellowBorderContain">
          <p><label>キャラクター名<input type="text" name="char_name" maxlength="25" required></label></p>
          <p>
            <label>性別
              <select name="char_sex">
                <option value="男">男</option>
                <option value="女">女</option>
              </select>
            </label>
            <label>職業
              <input type="text" name="char_job" maxlength="15" required>
            </label>
            <label>年齢
              <input type="number" name="char_age" min="0" max="1000" required>
            </label>
          </p>
        </div>
      </div>

      <!-- キャラのステータスを設定 -->
      <div class="statusWrap">
        <h2 class="subTitle">●ステータス</h2>
        <div class="yellowBorderContain">
          <p>
            <label>STR<input type="number" name="char_str" min="0" max="99" class="str" required></label>
            <label>DEX<input type="number" name="char_dex" min="0" max="99" class="dex" required></label>
            <label>INT<input type="number" name="char_int" min="0" max="99" class="int" required></label>
            <label>CON<input type="number" name="char_con" min="0" max="99" class="con" required></label>
          </p>
          <p>
            <label>SIZ<input type="number" name="char_siz" min="0" max="99" class="siz" required></label>
            <label>APP<input type="number" name="char_app" min="0" max="99" required></label>
            <label>POW<input type="number" name="char_pow" min="0" max="99" class="pow" required></label>
            <label>EDU<input type="number" name="char_edu" min="0" max="99" class="edu" required></label>
          </p>
          <p>
            <label>HP<input type="number" name="char_hp" min="0" max="199" class="hp" required></label>
            <label>MP<input type="number" name="char_mp" min="0" max="99" class="mp" required></label>
            <label>アイデア<input type="number" name="char_idea" min="0" max="100" class="idea" required></label>
            <label>知識<input type="number" name="char_know" min="0" max="99" class="knowledge" required></label>
            <label>幸運<input type="number" name="char_luck" min="0" max="100" class="luck" required></label>
          </p>
          <label>ダメージボーナス
            <select name="char_db" class="db">
              <option value="-1d6">-1d6</option>
              <option value="-1d4">-1d4</option>
              <option value="0" selected>0</option>
              <option value="+1d4">+1d4</option>
              <option value="+1d6">+1d6</option>
              <option value="+2d6">+2d6</option>
              <option value="+3d6">+3d6</option>
              <option value="+4d6">+4d6</option>
            </select>
          </label>
          <button type="button" id="cal_db">ダメボ自動計算</button>
          <p><label>現在SAN値<input type="number" name="char_san" min="0" max="99" class="san" required>／最大SAN値<input type="number" min="0" max="99" value="99" name="char_max_san"></label></p>
        </div>
      </div>
      
      <div class="skillsWrap">
        <h2 class="subTitle">●各種技能</h2>
        <div class="yellowBorderContain">
          <p>職業技能点<input type="number" class="sum_jobP" name="sum_jobP" readonly="readonly">／<input type="number" class="jobP" readonly="readonly"></p>
          <p>趣味技能点<input type="text" class="sum_hobP" name="sum_hobP" readonly="readonly">／<input type="number" class="hobP" readonly="readonly"></p>
          <input type="hidden" class="sum_etcP" name="sum_etcP">
          <!-- 技能一覧表を表示 -->
          <button class="btn_wrap_skillTable" type="button">技能一覧 ▼</button>
          <div class="wrap_skillTable">
    
            <!-- 戦闘技能一覧 -->
            <button class="btn_skillTable fight" type="button">戦闘技能<span>▼</span></button>
              <div class="skillTable fight">
                <table border="1">
                  <tr>
                    <th>技能名</th><th>初期値</th><th>職業P</th><th>興味P</th><th>成長等</th><th>合計</th>
                  </tr>
                  <?php foreach($skill_fight_list as $value): ?>
                    <tr id="fight">
                      <td><?= $value['名前']; ?></td>
                      <td><input type="number" class="iniP_fight keyUp" value="<?= $value['初期値']; ?>" readonly="readonly" name="iniP_fight[]"></td>
                      <td><input type="number" class="jobP_fight keyUp input_jobP" name="jobP_fight[]"></td>
                      <td><input type="number" class="hobP_fight keyUp input_hobP" name="hobP_fight[]"></td>
                      <td><input type="number" class="etcP_fight keyUp input_etcP" name="etcP_fight[]"></td>
                      <td><input type="number" name="sum_fight[]" class="sumP_fight" value="<?= $value['初期値']; ?>"></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
            
            <!-- 探索技能一覧 -->
            <button class="btn_skillTable find" type="button">探索技能<span>▼</span></button>
              <div class="skillTable find">
                <table border="1">
                  <tr>
                    <th>技能名</th><th>初期値</th><th>職業P</th><th>興味P</th><th>成長等</th><th>合計</th>
                  </tr>
                  <?php foreach($skill_find_list as $value): ?>
                    <tr id="find">
                      <td><?= $value['名前']; ?></td>
                      <td><input type="number" class="iniP_find keyUp" value="<?= $value['初期値']; ?>" readonly="readonly" name="iniP_find[]"></td>
                      <td><input type="number" class="jobP_find keyUp input_jobP" name="jobP_find[]"></td>
                      <td><input type="number" class="hobP_find keyUp input_hobP" name="hobP_find[]"></td>
                      <td><input type="number" class="etcP_find keyUp input_etcP" name="etcP_find[]"></td>
                      <td><input type="number" name="sum_find[]" class="sumP_find" value="<?= $value['初期値']; ?>"></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
    
            <!-- 行動技能一覧 -->
            <button class="btn_skillTable act" type="button">行動技能<span>▼</span></button>
              <div class="skillTable act">
                <table border="1">
                  <tr>
                    <th>技能名</th><th>初期値</th><th>職業P</th><th>興味P</th><th>成長等</th><th>合計</th>
                  </tr>
                  <?php foreach($skill_act_list as $value): ?>
                    <tr id="act">
                      <td><?= $value['名前']; ?></td>
                      <td><input type="number" class="iniP_act keyUp" value="<?= $value['初期値']; ?>" readonly="readonly" name="iniP_act[]"></td>
                      <td><input type="number" class="jobP_act keyUp input_jobP" name="jobP_act[]"></td>
                      <td><input type="number" class="hobP_act keyUp input_hobP" name="hobP_act[]"></td>
                      <td><input type="number" class="etcP_act keyUp input_etcP" name="etcP_act[]"></td>
                      <td><input type="number" name="sum_act[]" class="sumP_act" value="<?= $value['初期値']; ?>"></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
                </div>
    
            <!-- 交渉技能一覧 -->
            <button class="btn_skillTable neg" type="button">交渉技能<span>▼</span></button>
              <div class="skillTable neg">
                <table border="1">
                  <tr>
                    <th>技能名</th><th>初期値</th><th>職業P</th><th>興味P</th><th>成長等</th><th>合計</th>
                  </tr>
                  <?php foreach($skill_neg_list as $value): ?>
                    <tr id="neg">
                      <td><?= $value['名前']; ?></td>
                      <td><input type="number" class="iniP_neg keyUp" value="<?= $value['初期値']; ?>" readonly="readonly" name="iniP_neg[]"></td>
                      <td><input type="number" class="jobP_neg keyUp input_jobP" name="jobP_neg[]"></td>
                      <td><input type="number" class="hobP_neg keyUp input_hobP" name="hobP_neg[]"></td>
                      <td><input type="number" class="etcP_neg keyUp input_etcP" name="etcP_neg[]"></td>
                      <td><input type="number" name="sum_neg[]" class="sumP_neg" value="<?= $value['初期値']; ?>"></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
    
            <!-- 知識技能一覧 -->
            <button class="btn_skillTable know" type="button">知識技能<span>▼</span></button>
              <div class="skillTable know">
                <table border="1">
                  <tr>
                    <th>技能名</th><th>初期値</th><th>職業P</th><th>興味P</th><th>成長等</th><th>合計</th>
                  </tr>
                  <?php foreach($skill_know_list as $value): ?>
                    <tr id="know">
                      <td><?= $value['名前']; ?></td>
                      <td><input type="number" class="iniP_know keyUp" value="<?= $value['初期値']; ?>" readonly="readonly" name="iniP_know[]"></td>
                      <td><input type="number" class="jobP_know keyUp input_jobP" name="jobP_know[]"></td>
                      <td><input type="number" class="hobP_know keyUp input_hobP" name="hobP_know[]"></td>
                      <td><input type="number" class="etcP_know keyUp input_etcP" name="etcP_know[]"></td>
                      <td><input type="number" name="sum_know[]" class="sumP_know" value="<?= $value['初期値']; ?>"></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
          </div>
        </div>
      </div>
      <div class="subInfoWrap">
        <h2 class="subTitle">●その他情報</h2>
        <div class="yellowBorderContain center">
          <p><label>プロフィール<textarea name="char_profile" rows="8" cols="80" placeholder="他のプレイヤーに知ってもらうべきキャラの情報を記載しましょう" maxlength="1000" required></textarea></p></label>
          <p><label>備考<textarea name="char_sub_profile" cols="80" rows="8" placeholder="キャラの裏設定や、自分用メモ等、他のプレイヤーに公開したくない情報を記載することができます" maxlength="3000" required></textarea></label></p>
        </div>
      </div>
      <input type="hidden" name="input_type" value="create">
      <p><button type="submit" class="decideButton">確認画面へ</button></p>
      </form>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="calculate_char_skill.js"></script>
  <script src="function_other.js"></script>
</body>
</html>
