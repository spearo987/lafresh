<?php

require_once('inception.class.php');

class User extends Inception
{

  // Friends vars
  protected $user_friends_id = [];
  protected $pending_user_friends_id = [];
  protected $requesting_user_friends_id = [];

  // Channels vars
  protected $user_channels_id = [];

  function __construct()
  {
    $this->pk = 'id_user';
    $this->table_name = 'users';
    $this->fields = ['id_user',
            'username',
            'emailadress',
            'password'];
  }

  // Fonction de login d'un utilisateur
  public function login($username, $password)
  {
    $match = false;
    $query = "SELECT * FROM ".$this->table_name." WHERE username = '".$username."'";
    if($result = myFetchAssoc($query))
    {
      if (password_verify($password, $result['password'])) {
        $match = true;
        $this->{$this->pk} = $result['id_user'];
      }
    }
    return $match;
  }

  // Fonction d'inscription d'un utilisateur
  public function register($username, $mail, $password)
  {
    $user_created = false;
    $user_exists = false;

    $query = "SELECT * FROM ".$this->table_name." WHERE username='".$username."' OR emailadress='".$mail."'";

    if($result = myFetchAssoc($query))
      $user_exists = true;

    if(!$user_exists)
    {
      $query = "INSERT INTO ".$this->table_name." (username, emailadress, password) VALUES ('".$username."', '".$mail."', '".$password."')";
      if($result = mySave($query))
      {
        $user_created = true;
      }
    }

    return $user_created;

  }

  /*
  ** Gestion des amis
  */

  // Vérifie l'existence d'amis
  public function hasFriends()
  {
    $query = "SELECT * FROM friends WHERE id_user1=".$this->{$this->pk}." OR id_user2=".$this->{$this->pk};
    if($result = myFetchAssoc($query))
      return true;
    else
      return false;
  }

  // Vérifie si l'utilisateur a déjà une relation avec
  // un autre utilisateur dans la base 'friends'
  public function hasLink($id_user2)
  {
    $query = "SELECT * FROM friends WHERE (id_user1=".$this->{$this->pk}." AND id_user2=".$id_user2.") OR (id_user1=".$id_user2." AND id_user2=".$this->{$this->pk}.")";
    if($result = myFetchAssoc($query))
      return true;
    else
      return false;
  }

  // Envoi une requête d'amis à l'utilisateur passé en paramètre
  public function sendFriendRequest($id_user2)
  {
    var_dump($this->hasLink($id_user2));
    if($this->hasLink($id_user2))
      $query = "UPDATE friends SET status=2 WHERE id_user1=".$this->{$this->pk}." AND id_user2=".$id_user2;
    else
      $query = "INSERT INTO friends (id_user1, id_user2, status) VALUES (".$this->{$this->pk}.", ".$id_user2.", 2)";

    if($result = mySave($query))
    {
      $pending_user_friends_id[] = $id_user2;
      return true;
    }
    else
      return false;
  }

  // Update la relation de l'utilisateur avec un autre utilisateur
  // pour définir le statut de la requête (acceptée, en attente, annulée)
  public function updateFriendRequest($action, $id_user)
  {

    switch ($action) {
      case 'accept_friend_request':
        $status = 1;
        $query = "UPDATE friends SET status=".$status." WHERE id_user1=".$id_user." AND id_user2=".$this->{$this->pk};
        if (($key = array_search($id_user, $this->requesting_user_friends_id)) !== false) {
          unset($this->requesting_user_friends_id[$key]);
          $this->user_friends_id[] = $id_user;
        }
        break;
      case 'decline_friend_request':
        $query = "DELETE FROM friends WHERE id_user1=".$id_user." AND id_user2=".$this->{$this->pk};
        if (($key = array_search($id_user, $this->requesting_user_friends_id)) !== false) {
          unset($this->requesting_user_friends_id[$key]);
        }
        break;
      case 'cancel_friend_request':
        $status = 0;
        $query = "UPDATE friends SET status=".$status." WHERE id_user1=".$this->{$this->pk}." AND id_user2=".$id_user;
        if (($key = array_search($id_user, $this->pending_user_friends_id)) !== false) {
          unset($this->pending_user_friends_id[$key]);
        }
        break;
      case 'delete_friend':
        $query = "DELETE FROM friends WHERE (id_user1=".$id_user." AND id_user2=".$this->{$this->pk}.") OR (id_user1=".$this->{$this->pk}." AND id_user2=".$id_user.")";
        if (($key = array_search($id_user, $this->user_friends_id)) !== false) {
          unset($this->user_friends_id[$key]);
        }
        $query2 = "DELETE uc, c FROM users_channel uc INNER JOIN channel c ON uc.id_channel = c.id_channel WHERE c.is_private=1 AND uc.id_channel =
        (SELECT * FROM
          (SELECT id_channel FROM users_channel WHERE id_user = ".$this->{$this->pk}." AND id_channel =
            (SELECT id_channel FROM users_channel WHERE id_user=".$id_user.")
          )
        as temp)";
        $this->activeChannels();
        break;
      default:
        break;
    }

    if (isset($query2)) {
      if($result = mySave($query))
        if($result = mySave($query2))
          return true;
        else
          return false;
      else
        return false;
    }
    else
    {
      if($result = mySave($query))
        return true;
      else
        return false;
    }

  }

  // Gestion des relations de l'utilisateur avec un autre
  public function manageFriendRequest($action, $id_user)
  {
    switch ($action) {
      case 'send_friend_request':
        $this->sendFriendRequest($id_user);
        break;
      case 'accept_friend_request':
      case 'decline_friend_request':
      case 'cancel_friend_request':
      case 'delete_friend':
        $_SESSION['user']->updateFriendRequest($action, $id_user);
        break;
      default:
        break;
    }
  }

  // Vérifie le statut d'une relation de l'utilisateur
  // avec un autre
  public function checkFriendStatus($id_user2)
  {
    $query = "SELECT * FROM friends WHERE (id_user1=".$this->{$this->pk}." AND id_user2=".$id_user2.") OR (id_user1=".$id_user2." AND id_user2=".$this->{$this->pk}.")";
    if($result = myFetchAssoc($query))
      if($result['status'] == 1)
        return 'accepted';
      else if($result['status'] == 2)
      {
        if($result['id_user2'] == $id_user2)
          return 'pending';
        else
          return 'requesting';
      }
      else
        return 'declined';
    else
      return 'unknow';
  }

  // Ajoute l'id d'un utilisateur dans le tableau
  // correspondant au statut de la relation
  // avec l'utilisateur
  public function addFriendId($id, $status)
  {
    if($status == 'accepted')
    {
      if(!in_array($id, $this->user_friends_id))
        $this->user_friends_id[] = $id;
    }
    else if($status == 'pending')
    {
      if(!in_array($id, $this->pending_user_friends_id))
        $this->pending_user_friends_id[] = $id;
    }
    else
    {
      if(!in_array($id, $this->requesting_user_friends_id))
        $this->requesting_user_friends_id[] = $id;
    }
  }

  // Charge la liste d'amis dont le statut est accepté
  public function loadAcceptedFriends()
  {
    $temp_user_friends_id = [];
    $query = "SELECT * FROM friends WHERE id_user1=".$this->{$this->pk}." OR id_user2=".$this->{$this->pk};
    if($results = myFetchAllAssoc($query))
    {
      foreach ($results as $result) {
        if($result['status'] == 1)
        {
          if($result['id_user1'] == $this->{$this->pk})
            $temp_user_friends_id[] = $result['id_user2'];
          else
            $temp_user_friends_id[] = $result['id_user1'];
        }
      }
    }
    $this->user_friends_id = $temp_user_friends_id;
  }

  /*
  ** Gestion des channels
  */

  // Méthode modifiée pour le delete de channel
  public function activeChannels()
  {
    $temp_channels_id = [];
    $query = "SELECT * FROM users_channel WHERE id_user=".$this->{$this->pk};
    if($results = myFetchAllAssoc($query))
    {
      foreach ($results as $result) {
        $temp_channels_id[] = $result['id_channel'];
      }
    }
    $this->user_channels_id = $temp_channels_id;
  }

  public function addChannelId($channel_id)
  {
    $this->user_channels_id[] = $channel_id;
  }

  /*
  ** Getters
  */

  public function getPk()
  {
    return $this->{$this->pk};
  }

  public function getFriendsId()
  {
    return $this->user_friends_id;
  }

  public function getPendingFriendsId()
  {
    return $this->pending_user_friends_id;
  }

  public function getRequestingFriendsId()
  {
    return $this->requesting_user_friends_id;
  }

  public function getChannels()
  {
    return $this->user_channels_id;
  }

  public function getUsername()
  {
      return $this->username;
  }

  /*
  ** Setters
  */

  public function setPk($id_user)
  {
    $this->{$this->pk} = $id_user;
  }

  public function setChannels($active_channels_id)
  {
    $this->user_channels_id = $active_channels_id;
  }

}


?>
