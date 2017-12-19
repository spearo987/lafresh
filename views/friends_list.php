<h2>Amis</h2>

<ul>
  <?php
  if(!empty($accepted_user_friends_id)) {
    foreach ($accepted_user_friends_id as $user_id) {
      $channel_id = $_SESSION['chat']->getChannelId($_SESSION['user']->getPk(), $user_id);
      ?>
      <li>
        <?= $_SESSION['chat']->getUsername($user_id); ?> <a href="?action=open_conversation&id=<?= $channel_id ?>">Envoyer un message</a>&nbsp;<a href="?action=delete_friend&id=<?= $user_id ?>">Supprimer</a>
      </li>
      <?php
    }
  }
  ?>
</ul>
<h2>Demandes d'amis</h2>
<h3>Reçues</h3>
<ul>
  <?php
    if(!empty($requesting_user_friends_id)) {
      foreach ($requesting_user_friends_id as $user_id) {
        ?>
        <li>
          <?= $_SESSION['chat']->getUsername($user_id); ?> <a href="?action=accept_friend_request&id=<?= $user_id ?>">Accepter</a>&nbsp;<a href="?action=decline_friend_request&id=<?= $user_id ?>">Refuser</a>
        </li>
        <?php
      }
    }
  ?>
</ul>
<h3>Envoyées</h3>
<ul>
  <?php
  if(!empty($pending_user_friends_id)) {
    foreach ($pending_user_friends_id as $user_id) {
        ?>
        <li>
          <?= $_SESSION['chat']->getUsername($user_id); ?> <a href="?action=cancel_friend_request&id=<?= $user_id ?>">Annuler</a>
        </li>
        <?php
      }
    }
  ?>
</ul>
<h2>Utilisateurs</h2>
<ul>
  <?php
      if(!empty($unknow_users_id)) {
        foreach ($unknow_users_id as $user_id) {
          ?>
          <li>
            <?= $_SESSION['chat']->getUsername($user_id); ?> <a href="?action=send_friend_request&id=<?= $user_id ?>">Ajouter</a>
          </li>
          <?php
        }
      }
  ?>
</ul>
