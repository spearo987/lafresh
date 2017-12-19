<h2>Conversation à plusieurs</h2>

<form class="createGroup" action="?action=open_conversation" method="post">
  <label for="input-channel-name">Nom du groupe :</label>
  <input id="input-channel-name" type="text" name="channelName" required>
  <ul>
  <?php
    foreach ($users_list_id as $user_id) {
      ?>
      <li>
        <input type="checkbox" class="selectUser" name="selectedUsers[]" value="<?= $user_id ?>">
        <label for="selectUser"><?= $_SESSION['chat']->getUsername($user_id); ?></label>
      </li>
      <?php
    }
    ?>
    </ul>
    <input type="submit" value="Créer la conversation">
</form>
