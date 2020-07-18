<?php

namespace MyApp;

class Controller {

  private $_errors;
  private $_values;

  public function __construct() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    $this->_errors = new \stdClass();
    $this->_values = new \stdClass();
  }

  protected function setValues($key, $value) {
  $this->_values->$key = $value;
  }

  public function getValues() {
  return $this->_values;
  }


  protected function setErrors($key, $error) {
    $this->_errors->$key = $error;
  }

  public function getErrors($key) {
    return isset($this->_errors->$key) ?  $this->_errors->$key : '';
  }

  protected function hasError() {
    return !empty(get_object_vars($this->_errors));
  }

  protected function isLoggedIn() {
    // $_SESSION['me']
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

  // ページネーション
  protected function pagenation($list,$mode){
    $list_num = count($list);
    if($mode == 'room'){
      $max = MAX_SHOW_ROOM;
      $pageName = 'roomPage';
    }else if($mode == 'chat'){
      $max = MAX_CHAT_ROOM;
      $pageName = 'roomPage';
    }

    $pages_num = ceil($list_num / $max);

    if(!isset($_GET[$pageName])){
      $now = 1;
    }else{
      $now = $_GET[$pageName];
    }

    $start_no =($now - 1) * $max;

    $dispData = array_slice($list, $start_no, $max, true);

    return [$dispData,$now,$pages_num];
    }

    // トークン検証
    protected function _validateToken(){
      if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo "トークンが一致しません";
        exit;
      }
    }

  }
