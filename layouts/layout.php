<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">

  <title><?php echo ucfirst($action); ?></title>
</head>
<body>
    <header>
        <?php if(isset($_SESSION)){ ?>
            <a href="?action=chat_home"><img src="./img/logo.png"></img></a>
        <?php } else { ?>
            <a href="?action=home"><img src="./img/logo.png"></img></a>
        <?php } ?>
    </header>

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
