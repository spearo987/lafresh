<h2>Discussion avec

  <?php
      if(!empty($users_list)) {
        foreach ($users_list as $user) {
          if ($user->getUsername() != $_SESSION['user']->getUsername()) { ?>
              <?= $user->getUsername(); ?>
          <?php
          }
        }
      }
  ?>
</h2>

<ul>
  <?php
      if(!empty($messages_list)) {
        foreach ($messages_list as $message) {
          ?>
          <li>
            <?= $message->getAuthorUsername($message->getAuthorId()) . " : " . $message->getMessageContent() . "<i style='font-size : 11px;'> envoyé à " . date('h:i d-m-Y',strtotime($message->getMessageDate())) . "</i>"; ?>
          </li>
          <?php
        }
      }
  ?>
</ul>

<form class="" action="?action=save_message" method="post">
    <input type="text" name="messagio" value="">
    <input type="submit" name="" value="Send">
    <input type="hidden" name="channel" value="<?= $channel->getPk(); ?>">
</form>
