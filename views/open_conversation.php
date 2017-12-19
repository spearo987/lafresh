<h2>Discussion

  <?php
      if($channel->isPrivate())
      {
        if(!empty($users_list)) {
          foreach ($users_list as $user) {
            if ($user->getUsername() != $_SESSION['user']->getUsername()) {
            ?>
                avec <?= $user->getUsername(); ?>
            <?php
            }
          }
        }
      }
      else
      {
      ?>
          <?= $channel->getChannelName(); ?>
      <?php
      }
  ?>
</h2>

<ul>
  <?php
      if(!empty($messages_list)) {
        foreach ($messages_list as $message) {
          ?>
          <li>
            <?= $message->getAuthorUsername($message->getAuthorId()) . " : " . $message->getMessageContent() . "<i style='font-size : 11px;'> envoyé à " . date('h:s d-m-Y',strtotime($message->getMessageDate())) . "</i>"; ?>
          </li>
          <?php
        }
      }
  ?>
</ul>

<div id="chat">
    <div id="messages"></div>
    <ul id="connected-users"></ul>
</div>
<form action="" id="send-message">
    <input id="message" autocomplete="off" /><button>Send</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="http://localhost:3000/socket.io/socket.io.js"></script>
<script type="text/javascript">
    var usernameId = "<?php echo $_SESSION['user']->id_username;?>";
    var username = "<?php echo $_SESSION['user']->username;?>";
    var emailadress = "<?php echo $_SESSION['user']->emailadress;?>";
</script>
<script src="./lafreshchat/js/script.js"></script>
