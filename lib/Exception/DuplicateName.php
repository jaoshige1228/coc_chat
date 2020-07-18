<?php

namespace MyApp\Exception;

class DuplicateName extends \Exception {
  protected $message = '既に存在するユーザー名です';
}
