<?php

namespace MyApp\Exception;

class InvalidPassword extends \Exception {
  protected $message = 'パスワードが正しくないw';
}
