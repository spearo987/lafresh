
<p>Bienvenue <?= $_SESSION['user']->username; ?></p>

<h2>Conversations</h2>
<?php

  if(!empty($channels_list))
  {
    ?>
    <h3>Actives</h3>
    <ul>
    <?php
    foreach ($channels_list as $channel) {
      ?>
      <li><?= $channel->getChannelName() ?> <a href="?action=open_conversation&id=<?= $channel->getPk(); ?>">Ouvrir</a> </li>
      <?php
    }
    ?>
    </ul>
    <?php
  }
  else
  {
    echo "e";
  }

?>
