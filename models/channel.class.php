<?php

require_once('inception.class.php');

class Channel extends Inception
{

  protected $messages_list = [];
  protected $users_list_id = [];

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

    $query = "INSERT INTO ".$this->table_name." (channelname, is_private) VALUES ('private', 1)";

    if($result = mySaveId($query))
    {
      $this->{$this->pk} = $result;
      $query = "INSERT INTO users_channel(id_user, id_channel, is_banned, is_admin) VALUES (".$creator_id.", ".$result.", 0, 1)";
      if($result2 = mySave($query))
      {
        foreach ($users_id as $user_id) {
          $query = "INSERT INTO users_channel (id_user, id_channel, is_banned, is_admin) VALUES (".$user_id.", ".$result.", 0, 0)";
          if($result3 = mySave($query))
            return true;
        }
      }
    }
  }

  public function openChannel($id_channel)
  {
    $this->setPk($id_channel);
    $this->hydrate();
    $users_list = $this->loadChannelUsers();
    return $users_list;
  }

  public function loadChannelUsers()
  {
    $query = "SELECT * FROM users_channel WHERE id_channel = ".$this->{$this->pk};
    $usersInChannel = myFetchAllAssoc($query);

    foreach ($usersInChannel as $user) {
      $temp_user = new User();
      $temp_user->setPk($user['id_user']);
      $temp_user->hydrate();
      $users_list[] = $temp_user;
    }
    return $users_list;
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

  /*
  ** Setters
  */

  public function setPk($id_channel)
  {
    $this->{$this->pk} = $id_channel;
  }

}


?>
