<?php

require_once('inception.class.php');

class Channel extends Inception
{

  protected $messages_list = [];
  protected $users_list = [];

  function __construct()
  {
    $this->pk = 'id_channel';
    $this->table_name = 'channel';
    $this->fields = ['id_channel',
            'channelname',
            'is_private'];
  }

  public function createChannel($creator_id, $users_id, $private, $channelname = 'private')
  {

    $is_private = 1;

    if(!$private)
      $is_private = 0;

    $query = "INSERT INTO ".$this->table_name." (channelname, is_private) VALUES ('".$channelname."', ".$is_private.")";

    if($result = mySaveId($query))
    {
      $this->{$this->pk} = $result;
      $query = "INSERT INTO users_channel(id_user, id_channel, is_banned, is_admin) VALUES (".$creator_id.", ".$result.", 0, 1)";
      if($result2 = mySave($query))
      {
        var_dump($users_id);
        foreach ($users_id as $user_id) {
          var_dump($user_id);
          $query = "INSERT INTO users_channel (id_user, id_channel, is_banned, is_admin) VALUES (".$user_id.", ".$result.", 0, 0)";
          $result3 = mySave($query);
          // if($result3 = mySave($query))
            // return true;
        }
      }
    }
  }

  public function openChannel($id_channel)
  {
    $this->setPk($id_channel);
    $this->hydrate();
    $this->loadChannelUsers();
    return $this->users_list;
  }

  public function loadChannelUsers()
  {
    $query = "SELECT * FROM users_channel WHERE id_channel = ".$this->{$this->pk};
    $usersInChannel = myFetchAllAssoc($query);

    foreach ($usersInChannel as $user) {
      $temp_user = new User();
      $temp_user->setPk($user['id_user']);
      $temp_user->hydrate();
      $this->users_list[] = $temp_user;
    }

  }

  public function loadChannelMessages(){
      $query = "SELECT id_message FROM messages WHERE id_channel = " . $this->{$this->pk} . " ORDER BY date ASC";

      if ($messagesInChannel = myFetchAllAssoc($query)) {
          foreach ($messagesInChannel as $message) {
            $temp_message = new Message();
            $temp_message->setPk($message['id_message']);
            $temp_message->hydrate();
            $messages_list[] = $temp_message;
          }
          return $messages_list;
      }
  }

  public function isPrivate()
  {
    return $this->getPrivate();
  }

  /*
  ** Getters
  */

  public function getPk()
  {
    return $this->{$this->pk};
  }

  public function getChannelName()
  {
    return $this->channelname;
  }

  public function getPrivate()
  {
    return $this->is_private;
  }

  public function getPrivateUsers($username)
  {
    $private_users = [];
    foreach ($this->users_list as $temp_user) {
      if($temp_user->getUsername() != $username)
        $private_users[] = $temp_user;
    }
    return $private_users;
  }

  /*
  ** Setters
  */

  public function setPk($id_channel)
  {
    $this->{$this->pk} = $id_channel;
  }

}


?>
