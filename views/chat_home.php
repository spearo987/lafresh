
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
      if ($channel->isPrivate())
      {
        $private_users = $channel->getPrivateUsers($_SESSION['user']->username);
        ?>
        <li>
        <?php
        foreach ($private_users as $user) {
          if (count($private_users) > 1) {
            ?>
            <?= $user->getUsername() ?>,
            <?php
          }
          else
          {
            ?>
            <?= $user->getUsername() ?>
            <?php
          }
        }
        ?>
        <a href="?action=open_conversation&id=<?= $channel->getPk(); ?>">Ouvrir</a></li>
        <?php
      }
      else
      {
        ?>
        <li><?= $channel->getChannelName() ?> <a href="?action=open_conversation&id=<?= $channel->getPk(); ?>">Ouvrir</a></li>
        <?php
      }
    }
    ?>
    </ul>
    <a href="?action=create_groupe">Créez votre conversation à plusieurs !</a>
    <?php
  }
  else
  {
    ?>
    <p>Pas encore d'amis ? Ajoutes-en <a href="?action=friends_list">ici</a></p>
    <?php
  }

?>
