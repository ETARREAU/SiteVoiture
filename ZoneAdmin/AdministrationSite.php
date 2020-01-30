<?php
require('../general/model.php');

switch ($_GET['action']) {


  case 'Connexion':
    $title='Connexion';

    $errorMessage=ConnexionSession(); // On verifie le login et le mdp, et on dirige sur la page Admin si connexion valide

    require('connexionView.php');
    break;


  case 'Principale':
    $title='Administration';

    session_start();//Démarrage de la Session
    $test=VerifAutorisationPage();
    $privilege=Privilege();

    if (isset($_GET['Supprim'])) {
      $id=$_GET['id'];

      if ($_GET['Supprim']=='C') {
        $leTesteu=SupprimConstructeur($id);
      } else if ($_GET['Supprim']=='V') {
        $leTesteu=SupprimVoiture($id);
      }
    }
    if (isset($_GET['SesDestruc'])) {
      session_destroy();
      header('Location:AdministrationSite.php');
    }
    $ListConstru=ToutLesConstructeurs();
    $ListVoiture=ToutesLesVoitures();
    $ListUtilisateurs=ToutLesUtilisateurs();

    require('PageAdminView.php');
    break;


  case 'FormVoiture':
    $title='Ajouter une Voiture';

    session_start();//Démarrage de la Session
    $test=VerifAutorisationPage();
    $privilege=Privilege();

    if (isset($_POST['submit'])) {
      $MajOuAjou=VerifMajOUAjout();
      $msg=FormulVoiture($MajOuAjou);
    }

    $LaVoiture=LeVehicule($_GET['idV']);
    $ListConstru=ToutLesConstructeurs();

    require('FormVoitureView.php');
    break;


  case 'FormConstructeur':
    $title='Ajouter un Constructeur';

    session_start();//Démarrage de la Session
    $test=VerifAutorisationPage();
    $privilege=Privilege();
    $test2=PasDeModérateur($privilege);

    if (isset($_POST['submit'])) {
      $MajOuAjou=VerifMajOUAjout();
      $msg=FormulConstru($MajOuAjou);
    }

    $LeConstructeur=LeConstructeur($_GET['idC']);

    require('FormConstructeurView.php');
    break;


  default:
    $title='Connexion';

    $errorMessage=ConnexionSession();// On vérifie le login et le mdp, et on dirige sur la page Admin si connexion valide

    require('connexionView.php');
    break;
}

require('templateADMIN.php');
?>
