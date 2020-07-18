<?php

namespace MyApp\Exception;

class InvalidRoomCreate extends \Exception {
  protected $message = 'ルーム名は半角1文字以上全角20文字以下です';
}
