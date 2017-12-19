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

  public function getChannelId($current_user_id, $user_id)
  {
    $query = "SELECT * FROM channel WHERE is_private=1 AND id_channel IN
      (SELECT id_channel FROM users_channel WHERE id_user=".$current_user_id." AND id_channel IN
        (SELECT id_channel FROM users_channel WHERE id_user=".$user_id.")
      )";
    if($result = myFetchAssoc($query))
      return $result['id_channel'];
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
