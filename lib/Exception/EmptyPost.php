<?php

namespace MyApp\Exception;

class EmptyPost extends \Exception {
  protected $message = 'ユーザー名とパスワードを入力してください';
}
