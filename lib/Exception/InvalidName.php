<?php

namespace MyApp\Exception;

class InvalidName extends \Exception {
  protected $message = 'ユーザー名が正しくありません';
}
