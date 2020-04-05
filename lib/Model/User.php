<?php

namespace MyApp\Model;

class User extends \MyApp\Model {

  public function create($values) {
    $stmt = $this->db->prepare("insert into users (name, password, created, modified) values (:name, :password, now(), now())");
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\DuplicateName();
    }
  }

  public function login($values) {
    $stmt = $this->db->prepare("select * from users where name = :name");
    $stmt->execute([
      ':name' => $values['name']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    if (empty($user)) {
      throw new \MyApp\Exception\UnmatchNameOrPassword();
    }

    if (!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchNameOrPassword();
    }

    return $user;
  }

}
