<?php
require_once('./models/user.class.php');
// Affichage du formulaire de connexion
if ($action == 'login_form')
{
  if(isset($_GET['err']))
  {
    if ($_GET['err'] == 'errLogin')
    {
      $err_message = "Mauvaise adresse mail ou mot de passe !";
    }
    else if ($_GET['err'] == 'errAuth')
    {
      $err_message = "Vous devez d'abord vous connecter avant d'avoir accès à ces pages ";
    }
  }
}
// Action de connexion au serveur
elseif ($action == 'login')
{
  if(isset($_POST['username']) && isset($_POST['password']))
  {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $user = new User();
    if($user->login($username, $password))
    {
      $user->hydrate();
      if($user->hasFriends())
      {
        $user->loadAcceptedFriends();
      }
      session_start();
      $_SESSION['user'] = $user;
    }
  }
}
// Affichage du formulaire d'inscription
elseif ($action == 'register_form')
{
  if(isset($_GET['err']))
  {
    if ($_GET['err'] == 'errMdp')
    {
      $err_message = "Pas les même mot de passe";
    }
  }
}
// Action d'inscription
elseif ($action == 'register')
{
  if(isset($_POST['username']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['verify_password']))
  {
    $username = trim($_POST['username']);
    $mail = trim($_POST['mail']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $verify_password = password_hash(trim($_POST['verify_password']), PASSWORD_DEFAULT);
    if($_POST['password'] == $_POST['verify_password'])
    {
      $registering_user = new User();
    }
    else
    {
     header('Location: ?action=register_form&err=errMdp');
    }
    if($registering_user->register($username, $mail, $hashed_password))
    {
      $register_message = 'Merci pour votre inscription !';
    }
    else
    {
      header('Location: ?action=register_form');
    }
  }
}
else if ($action == 'forgotten_password')
{
}
// Action de déconnexion
else if ($action = 'logout')
{
    session_start();
    session_destroy();
}
