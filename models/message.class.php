<?php

require_once('inception.class.php');

class Message extends Inception
{

  function __construct()
  {
    $this->pk = 'id_message';
    $this->table_name = 'messages';
    $this->fields = ['id_message',
            'id_user',
            'id_channel',
            'content',
            'date'];
  }

  public function newMessage($author_id, $channel_id, $content){
    $query = "INSERT INTO ".$this->table_name." (id_user, id_channel, content, date) VALUES ('".$author_id."', '".$channel_id."', '".$content."', NOW())";

    if($result = mySave($query))
    {
      return true;
    }
    else {
      return false;
    }
  }

  /*
  ** Getters
  */

  public function getMessageId()
  {
    return $this->id_message;
  }

  public function getAuthorId()
  {
    return $this->id_user;
  }

  public function getAuthorUsername($id_user)
  {
      $query = "SELECT username FROM users WHERE id_user=".$id_user;
      if($result = myFetchAssoc($query))
        return $result['username'];
  }

  public function getChannelId()
  {
    return $this->id_channel;
  }

  public function getMessageContent()
  {
    return $this->content;
  }

  public function getMessageDate()
  {
    return $this->date;
  }


  /*
  ** Setters
  */

  public function setPk($id_user)
  {
    $this->{$this->pk} = $id_user;
  }
}


?>
