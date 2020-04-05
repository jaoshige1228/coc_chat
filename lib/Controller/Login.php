<?php

namespace MyApp\Controller;

class Login extends \MyApp\Controller {

  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  protected function postProcess() {
    try {
      $this->_validate();
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('login', $e->getMessage());
    }

    $this->setValues('name', $_POST['name']);

    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \MyApp\Model\User();
        $user = $userModel->login([
          'name' => $_POST['name'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\UnmatchNameOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }

      // login処理

      session_regenerate_id(true);
      $_SESSION['me'] = $user;

      // redirect to home
      header('Location: ' . SITE_URL);
      exit;
    }
  }

  private function _validate() {
    $this->_validateToken();

    if (!isset($_POST['name']) || !isset($_POST['password'])) {
      echo "ちゃんと入力しろ";
      exit;
    }

    if ($_POST['name'] === '' || $_POST['password'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }
  }

  // private function _validateToken(){
  //   if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
  //     echo "トークンが一致しません";
  //     exit;
  //   }
  // }

}
