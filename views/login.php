<?php

if(isset($_SESSION['user']))
  header('Location: ?action=chat_home');
else
  header('Location: ?action=login_form&err=errLogin');

?>
