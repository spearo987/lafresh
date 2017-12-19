<?php

require_once('inception.class.php');
require_once('user.class.php');

class Chat extends Inception
{

  protected $users_id = [];
  protected $channels = [];

  function __construct()
  {
    $this->loadUsers();
  }

  public function loadUsers()
  {
    $query = "SELECT * FROM users";
    $users = myFetchAllAssoc($query);
    foreach ($users as $user) {
      $this->users_id[] = $user['id_user'];
    }
  }

  public function getUsersId()
  {
    return $this->users_id;
  }

  public function getUsername($id_user)
  {

    $query = "SELECT username FROM users WHERE id_user=".$id_user;
    if($result = myFetchAssoc($query))
      return $result['username'];

  }

}


?>
