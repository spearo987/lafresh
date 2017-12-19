<?php

require_once ('./models/chat.class.php');
require_once ('./models/channel.class.php');
require_once ('./models/user.class.php');
require_once ('./models/message.class.php');
session_start();

if (!empty($_SESSION['user'])) {
    if($action == 'chat_home') {

      $chat = new Chat();
      $_SESSION['chat'] = $chat;

      $channels_list = [];
      $_SESSION['user']->activeChannels();
      $_SESSION['user']->loadAcceptedFriends();
      $active_channels_id = $_SESSION['user']->getChannels();

      foreach ($active_channels_id as $channel_id) {
        $channel = new Channel();
        $channel->setPk($channel_id);
        $channel->hydrate();
        $channel->loadChannelUsers();
        $channels_list[] = $channel;
        // var_dump($channels_list);
      }

    }
    else if ($action == 'create_groupe')
    {
      $users_list_id = $_SESSION['user']->getFriendsId();
    }
    else if($action == 'friends_list')
    {

     $users_id = $_SESSION['chat']->getUsersId();
     $unknow_users_id = [];

     foreach ($users_id as $id) {
       switch ($_SESSION['user']->checkFriendStatus($id)) {
         case 'accepted':
         case 'requesting':
         case 'pending':
          $_SESSION['user']->addFriendId($id, $_SESSION['user']->checkFriendStatus($id));
          break;
         case 'unknow':
         case 'declined':
          if ($_SESSION['user']->id_user != $id)
          {
            $unknow_users_id[] = $id;
          }
          break;
         default:
          break;
       }
     }

     $accepted_user_friends_id = $_SESSION['user']->getFriendsId();
     $pending_user_friends_id = $_SESSION['user']->getPendingFriendsId();
     $requesting_user_friends_id = $_SESSION['user']->getRequestingFriendsId();

    }
    else if ($action == 'open_conversation')
    {
        $users_list = [];
        $users_id_list = [];
        $messages_list = [];
        if(isset($_POST['selectedUsers']))
        {
          $channelName = $_POST['channelName'];
          $users_id_list = $_POST['selectedUsers'];
          $channel = new Channel();
          $channel->createChannel($_SESSION['user']->__get('id_user'), $users_id_list, false, $channelName);
          $channel->hydrate();
          $users_list = $channel->openChannel($channel->__get('id_channel'));
          $messages_list = $channel->loadChannelMessages();
        }
        else
        {
          $id_channel = $_GET['id'];
          $channel = new Channel();
          $users_list = $channel->openChannel($id_channel);
          $messages_list = $channel->loadChannelMessages();
        }
        // var_dump($messages_list);
    }
    else if ($action == 'save_message')
    {
        $content = $_POST['messagio'];
        $channel_id = $_POST['channel'];
        $message = new Message();
        $message->newMessage($_SESSION['user']->id_user, $channel_id, $content);
    }
    else if ($action == 'accept_friend_request' || $action == 'decline_friend_request' || $action == 'cancel_friend_request' || $action == 'send_friend_request' || $action='delete_friend')
    {
      $id_user = $_GET['id'];
      if($action == 'accept_friend_request')
      {
        $channel = new Channel();
        $channel->createChannel($_SESSION['user']->id_user, [$id_user], true);
      }
      $_SESSION['user']->manageFriendRequest($action, $id_user);
    }
}
else
{
    header('Location: ?action=login_form&err=errAuth');
}



?>
