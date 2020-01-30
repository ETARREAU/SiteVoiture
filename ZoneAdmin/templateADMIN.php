<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/SiteVoiture/css/normalize.css">
    <link rel="stylesheet" href="/SiteVoiture/css/style.css">
    <title><?= $title ?></title>
  </head>
  <body>
    <!-- NavBar -->
    <ul class="topnav">
      <li><a class="active" href="/SiteVoiture/index.php">Retour à l'Accueil</a></li>
      <li class="right"><a href="AdministrationSite.php?action=Principale&amp;SesDestruc=1">Deconnexion</a></li>
    </ul>
    <main>
      <?= $content ?>
    </main>
    <footer>
      <h4><a href="constructeur.php?id=1"> Mention Légal </a>/<a href="constructeur.php?id=1"> Administration </a>/<a href="constructeur.php?id=1"> Contact </a></h4>
      <p>
         <img class="liensréseault" src="https://img.icons8.com/carbon-copy/100/000000/facebook.png">
         <img class="liensréseault" src="https://img.icons8.com/carbon-copy/100/000000/instagram-new.png">
         <img class="liensréseault" src="https://img.icons8.com/carbon-copy/100/000000/twitter.png">
      </p>
    </footer>
    <script src="/SiteVoiture/js/script.js" charset="utf-8"></script>
  </body>
</html>
