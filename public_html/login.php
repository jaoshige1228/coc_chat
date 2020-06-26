<?php

// ログイン

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Login();

$app->run();

// echo "login screen";
// exit;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9,minimum-scale=0.9,user-scalable=no">
  <title>ログイン</title>
  <link rel="stylesheet" href="<?= PUBLIC_URL_HEADER; ?>/sty.css">
</head>
<body>
  <div id="container">
    <h1 class="welcome">ログイン</h1>
    <div id="loginForm">
      <form action="" method="post" id="login">
        <p>
          <label>ユーザー名
            <input type="text" name="name" value="<?= isset($app->getValues()->name) ? h($app->getValues()->name) : ''; ?>" class="userInputForm">
          </label>
        </p>
        <p>
          <label>パスワード
            <input type="password" name="password" class="userInputForm">
          </label>
        </p>
        <p class="err"><?= h($app->getErrors('login')); ?></p>
        <div class="userSubmitForm">
          <div class="loginBtn" onclick="document.getElementById('login').submit();">ログイン</div>
          <p><a href="<?= PUBLIC_URL_HEADER; ?>/index.php">ホーム画面へ</a></p>
          <p><a href="<?= PUBLIC_URL_HEADER; ?>/signup.php">アカウント作成画面へ</a></p>
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </div>
      </form>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="<?= PUBLIC_URL_HEADER; ?>/function_other.js"></script>
  <script>
    $(function(){
      $('.unti').click(function(){
        console.log('鼻毛');
      });
    });
  </script>
</body>
</html>
