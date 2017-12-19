<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
  <link rel="stylesheet" href="./lafreshchat/css/styles.css">

  <title><?php echo ucfirst($action); ?></title>
</head>
<body>
  <?php if(isset($_SESSION)){ ?>
    <header>
            <a href="?action=chat_home"><img src="./img/logo.png"></img></a>

    </header>
    <?php }?>

    <?php if(isset($_SESSION)){ ?>
    <nav>
        <ul>
            <li><a href="?action=chat_home">Accueil</a></li>
            <li><a href="?action=friends_list">Liste d'amis</a></li>
            <li><a href="?action=logout">Se déconnecter</a></li>
        </ul>
    </nav>
<?php } ?>

	<?php include($view_path); ?>
</body>
</html>
