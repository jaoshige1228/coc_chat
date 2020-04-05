<?php

namespace MyApp\Exception;

class UnmatchNameOrPassword extends \Exception {
  protected $message = 'ユーザー名とパスワードが一致しません';
}
