<?php

// 新規登録

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Signup();

$app->run();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>アカウント作成</title>
  <link rel="stylesheet" href="/sty.css">
</head>
<body>
  <div id="container">
    <h1 class="welcome">アカウント作成</h1>
    <div id="loginForm">
      <form action="" method="post" id="signup">
        <p>
          <label>ユーザー名
            <input type="text" name="name" value="<?= isset($app->getValues()->name) ? h($app->getValues()->name) : ''; ?>" class="userInputForm">
          </label>
        </p>
        <p class="err"><?= h($app->getErrors('name')); ?></p>
        <p>
          <label>パスワード
            <input type="password" name="password" class="userInputForm">
          </label>
        </p>
        <p class="err"><?= h($app->getErrors('password')); ?></p>
        <div class="userSubmitForm">
          <div class="loginBtn" onclick="document.getElementById('signup').submit();">新規登録</div>
          <p><a href="/index.php">ホーム画面へ</a></p>
          <p><a href="/login.php">ログイン画面へ</a></p>
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </div>
      </form>
    </div>
  </div>
</body>
</html>
