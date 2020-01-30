<?php
require('Controlleur.php');

switch ($_GET['action']) {

// PAGE ACCUEIL
    case 'Accueil':
      $title='Bienvenue';

      $TroisDerniereEntree=TroisDernieresEntrees();
      $ConstructAleatoire=ConstructeurAleatoire();

      require 'AccueilView.php';
      break;

// PAGE DU CONSTRUCTEUR
    case 'Constructeur':
      $title='Le Constructeur';

      $id=VerificationLien($_GET['id']);
      $LeConstructe = LeConstructeur($id);

      require('constructeurView.php');
      break;

// PAGE GALERIE
    case 'Galerie':
      $title='Galerie des véhicules';

      $afficher = CheckLien($_GET['id']);
      $afficher = CheckLien($_GET['année']);
      $afficher = CheckLien($_GET['Nom']);

      $SousTitre = SelectionMessage($afficher);
      $MethodeAff = SelectionMethodeAff($afficher);

      require('GalerieVoitureView.php');
      break;

// PAGE INFOS UNE SEUL VOITURE
    case 'ModeleVoiture':
      $title='Voiture';

      $Lavoiture=LeVehicule($_GET['id']);

      require('ModeleVoitureView.php');
      break;


  default:
    $title='Bienvenue';

    $TroisDerniereEntree=TroisDernieresEntrees();
    $ConstructAleatoire=ConstructeurAleatoire();

    require('AccueilView.php');
    break;
}

require('general/template.php');

 ?>
