<?php

namespace MyApp\Controller;

class Signup extends \MyApp\Controller {

  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL . PUBLIC_URL_HEADER);
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  protected function postProcess() {
    // validate
    try {
      $this->_validate();
    } catch (\MyApp\Exception\InvalidName $e) {
      $this->setErrors('name', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    }
    $this->setValues('name', $_POST['name']);


    if ($this->hasError()) {
      return;
    } else{
      try {
        $userModel = new \MyApp\Model\User();
        $userModel->create([
          'name' => $_POST['name'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\DuplicateName $e) {
        $this->setErrors('name', $e->getMessage());
        return;
      }

      // redirect to login
      header('Location: ' . SITE_URL . PUBLIC_URL_HEADER . '/login.php');
      exit;
    }

  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "Invalid Token!";
      exit;
    }

    if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
  }

}
