<?php

require('general/model.php');

function Accueil()
{
  $title='Bienvenue';

  $TroisDerniereEntree=TroisDernieresEntrees();
  $ConstructAleatoire=ConstructeurAleatoire();
  var_dump($ConstructAleatoire);

  require 'AccueilView.php';
}

function Constructeur()
{
  $title='Le Constructeur';

  $id=VerificationLien($_GET['id']);
  $LeConstructe = LeConstructeur($id);

  require('constructeurView.php');
}

function Galerie()
{
  $title='Galerie des véhicules';

  $afficher = CheckLien($_GET['id']);
  $afficher = CheckLien($_GET['année']);
  $afficher = CheckLien($_GET['Nom']);

  $SousTitre = SelectionMessage($afficher);
  $MethodeAff = SelectionMethodeAff($afficher);

  require('GalerieVoitureView.php');
}

function ModeleVoiture()
{
  $title='Voiture';

  $Lavoiture=LeVehicule($_GET['id']);

  require('ModeleVoitureView.php');
}

?>
