<?php

/*############################################
                  CONNEXION
############################################*/


//Classe qui initie la connection à la BDD suivant les paramêtres qu'on lui applique
class Connect
{
    private $bdd = '';
    private $connec_host = '';
    private $connec_dbname = '';
    private $connec_pseudo = '';
    private $connec_mdp = '';

    function __construct($connec_host,$connec_dbname,$connec_pseudo,$connec_mdp)
    {
        try {
            $this->bdd = new PDO('mysql:host='.$connec_host.';dbname='.$connec_dbname,$connec_pseudo,$connec_mdp);
            $this->bdd->exec("SET CHARACTER SET utf8");
            $this->bdd->exec("SET NAMES utf8");
        }
        catch(PDOException $e) {
            die('<h3>Erreur !</h3>');
        }
    }

    public function connexion(){
        return $this->bdd;
    }
}

//Utilise la classe 'Connect' et initie la connection à la BDD Voiture, avec le compte en lecture simple, sur MySQL.
function ConnexionLectur()
{
  $DBUSER = new Connect('localhost','Voiture','lecteur','123Soleil');
  $dbu = $DBUSER->connexion();

  return $dbu;
}

//Utilise la classe 'Connect' et initie la connection à la BDD Voiture, avec le compte Administrateur, sur MySQL.
function ConnexionAdmin()
{
  $DBADMIN = new Connect('localhost','Voiture','root','root');
  $dbu = $DBADMIN->connexion();

  return $dbu;
}


/*############################################
                  GETTERS
############################################*/


//Récupère tout les véhicules dans la BDD
function ToutesLesVoitures()
{
  $db=ConnexionLectur();

  $List = $db->prepare("SELECT * FROM vehicule ORDER BY idConstru");
  $List->execute();

  return $List;
}

//Récupère tout les constructeur dans la BDD
function ToutLesConstructeurs()
{
  $db=ConnexionLectur();

  $List = $db->prepare("SELECT * FROM constructeurAuto");
  $List->execute();

  return $List;
}

//Récupère les trois dernières entrées dans la BDD
function TroisDernieresEntrees()
{
  $db=ConnexionLectur();

  $List = $db->prepare("SELECT * FROM vehicule ORDER BY id DESC LIMIT 3");
  $List->execute();

  return $List->fetchAll(PDO::FETCH_ASSOC);
}

//Récupération d'un véhicule dans la BDD avec l'id
function LeVehicule($récup)
{
  $db=ConnexionLectur();

  $LaVoiture = $db->prepare("SELECT * FROM vehicule LEFT JOIN constructeurAuto ON vehicule.idConstru = constructeurAuto.id WHERE vehicule.id='$récup'");
  $LaVoiture->execute(array());

  return $LaVoiture;
}

//Récupération d'un constructeur dans la BDD avec l'id
function LeConstructeur($Leid)
{
  $db=ConnexionLectur();

  $Liste = $db->prepare("SELECT * FROM constructeurAuto WHERE id = ?");
  $Liste->execute(array($Leid));

  return $Liste;
}

//Récupère un constructeur aléatoire dans la BDD
function ConstructeurAleatoire()
{
  $db=ConnexionLectur();

  $List = $db->prepare("SELECT * FROM constructeurAuto ORDER BY rand() LIMIT 1");
  $List->execute();

  return $List;
}

//Ramène l'utilisateur dans la BDD correspondant au $login et $password
function BDD_Utilisateur($login)
{
  $db=ConnexionLectur();

  /*Requète pour récupérer les infos du compte*/
  $requete = "SELECT * FROM utilisateurs WHERE pseudo='$login'";
  $LaConnection = $db->prepare($requete);
  $LaConnection->execute();
    return $LaConnection;
}

function ToutLesUtilisateurs()
{
  $db=ConnexionLectur();

  /*Requète pour récupérer les infos du compte*/
  $requete = "SELECT * FROM utilisateurs ORDER BY id";
  $LaConnection = $db->prepare($requete);
  $LaConnection->execute(array());

  return $LaConnection;
}


/*############################################
                  SETTERS
############################################*/


// Attribue une valeur à $test en fonction de ce qui est récupéré en $_GET
function CheckLien()
{
  if (isset($_GET['année']) AND !empty($_GET['année'])) {
      $test=1;
    } else if (isset($_GET['id']) AND !empty($_GET['id'])){
        $test=2;
        }
  return $test;
}

// Selection de le message dessous le titre, suivant l'information récupéré en $test
function SelectionMessage($test)
{
  if ($test==1) {
  $info='Véhicules de l\'année '.$_GET['année'];
    } else if ($test==2){
          $info='Véhicules de la marque '.$_GET['Nom'];
        } else {
              $info='Tout les véhicules présents dans la base de donnée';
            }
  return $info;
}

// Selection de la manière d'afficher les véhicules, suivant l'information récupéré en $test
function SelectionMethodeAff($teste)
{
  $db=ConnexionLectur();
  if ($teste==1) {
      $année=$_GET['année'];
      $Voiture = $db->prepare("SELECT * FROM vehicule WHERE Année='$année'");
        } else if ($teste==2){
                  $id=$_GET['id'];
                  $Voiture = $db->prepare("SELECT * FROM vehicule WHERE idConstru='$id'");
                } else {
                      $Voiture = $db->prepare("SELECT * FROM vehicule");
                    }
  $Voiture->execute();
  return $Voiture->fetchAll(PDO::FETCH_ASSOC);
}

//------   Accorde les privilèges suivant les comptes:  ------
// ADMIN= ajout/modif/suppression de constructeurs et voitures --> $privilège = 1
// MODO= ajout/modif/suppression des voitures seulement, lecture pour le reste --> $privilège = 0
function Privilege()
{
  $login=$_SESSION['login'];
  $password=$_SESSION['mdp'];
  $requete=BDD_Utilisateur($login,$password);

  //Attribu les droits de modification en fonction de si l'on est connecté à un compte administrateur ou modérateur
  foreach ($requete as $test) {
    if ($test['pouvoir']==2) {
      $privilege=1;
      } else if ($test['pouvoir']==1) {
        $privilege=0;
        } else {
            die('Vous n\'avez pas les droits d\'acces à cette page');
    }
  }
  return $privilege;
}

//°°°°°°°°°° Ajout ou Modification d'un Constructeur °°°°°°°°°°//
function FormulConstru($accepter)
{
    /*--MODIFICATION--*/
    if ($accepter==1) {

                $db=ConnexionAdmin();

                $id=$_POST['id'];
                $NomActuel=$_POST['NomConstructeur'];
                $DescriptionActuel=$_POST['Description'];
                $BioActuel=$_POST['Biographie'];

                $constructeur = $db->prepare("UPDATE constructeurAuto SET NomConstru='$NomActuel', description='$DescriptionActuel', bio='$BioActuel' WHERE id='$id'");
                $constructeur->execute();

                $msg="<strong>TOUT EST BIEN QUI FINI BIEN !!!</strong>";
                header("Location:AdministrationSite.php?action=Principale&amp;msg=".$msg);

    } else {

    /*--AJOUT--*/
    if (isset($_FILES['imgConstru']) && !empty($_FILES['imgConstru']['name'])){


          //On teste la taille maximum de l'image
          $tailleMax=2100000;
          $extentionValid= array('jpg','jpeg','png','gif');

          if ($_FILES['imgConstru']['size']<=$tailleMax){

            //On récupère et vérifie l'extension de l'image qu'on upload
            $extensionRecup=strtolower(substr(strrchr($_FILES['imgConstru']['name'], '.'), 1));

            if (in_array($extensionRecup,$extentionValid)) {

              //On met l'image dans le dossier de réception
              $chemin= '/Applications/MAMP/htdocs/SiteVoiture/img/insertion_img/'.$_FILES['imgConstru']['name'];
              $resultat= move_uploaded_file($_FILES['imgConstru']['tmp_name'],$chemin);

              //On ajoute l'image dans la Bdd
              if ($resultat) {

                $db=ConnexionAdmin();

                $NomActuel=$_POST['NomConstructeur'];
                $DescriptionActuel=$_POST['Description'];
                $BioActuel=$_POST['Biographie'];
                $liensPourBDD='img/insertion_img/'.$_FILES['imgConstru']['name'];

                $constructeur = $db->prepare("INSERT INTO constructeurAuto (NomConstru,description,bio,lienLogo) VALUES ('$NomActuel','$DescriptionActuel','$BioActuel','$liensPourBDD')");
                $constructeur->execute();

                $msg="<strong>TOUT EST BIEN QUI FINI BIEN !!!</strong>";
                header("Location:AdministrationSite.php?action=Principale&amp;msg=".$msg);

              }else {
                $msg="erreur sur l'importation finale ...";
              }

            }else {
              $msg = "Votre photo n'est pas au bon format !";
            }

          } else {
            $msg="Votre photo a une taille trop importante";
          }

        } else {
          echo "GROS PB";
        }
    }
  //Retourne le message de confirmation OU d'erreur suivant la situation
  return $msg;
}


// °°°°°°°°° Ajout ou Modification d'une Voiture °°°°°°°°°° //
function FormulVoiture($accepter)
{
    /*--MODIFICATION--*/
    if ($accepter==1) {

          $db=ConnexionAdmin();

          $id=$_POST['id'];
          $idConstru=$_POST['selecteurConstru'];
          $NomActuel=$_POST['NomVoiture'];
          $année=$_POST['AnnéeVoiture'];
          $BioActuel=$_POST['Biographie'];

          $constructeur = $db->prepare("UPDATE vehicule SET idConstru='$idConstru', NomModèle='$NomActuel', année='$année' WHERE id='$id'");
          $constructeur->execute();

          $msg="<strong>TOUT EST BIEN QUI FINI BIEN !!!</strong>";
          header("Location: AdministrationSite.php?action=Principale&amp;msg=".$msg);

    } else {

    /*--AJOUT--*/
          if (isset($_FILES['imgVoiture']) && !empty($_FILES['imgVoiture']['name'])){

          //On teste la taille maximum de l'image
          $tailleMax=2100000;
          $extentionValid= array('jpg','jpeg','png','gif');

          if ($_FILES['imgVoiture']['size']<=$tailleMax){

            //On récupère et vérifie l'extension de l'image qu'on upload
            $extensionRecup=strtolower(substr(strrchr($_FILES['imgVoiture']['name'], '.'), 1));

            if (in_array($extensionRecup,$extentionValid)) {

              //On met l'image dans le dossier de réception
              $chemin= '/Applications/MAMP/htdocs/SiteVoiture/img/insertion_img/'.$_FILES['imgVoiture']['name'];
              $resultat= move_uploaded_file($_FILES['imgVoiture']['tmp_name'],$chemin);

              //On ajoute l'image dans la Bdd
              if ($resultat) {

                $db=ConnexionAdmin();

                $id=$_POST['id'];
                $idConstru=$_POST['selecteurConstru'];
                $NomModèle=$_POST['NomVoiture'];
                $Année=$_POST['AnnéeVoiture'];
                $liensPourBDD='img/insertion_img/'.$_FILES['imgVoiture']['name'];

                $constructeur = $db->prepare("INSERT INTO vehicule (idConstru,NomModèle,année,lienImg) VALUES ('$idConstru','$NomModèle','$Année','$liensPourBDD')");
                $constructeur->execute();

                $msg="<strong>TOUT EST BIEN QUI FINI BIEN !!!</strong>";
                header("Location: AdministrationSite.php?action=Principale&amp;msg=".$msg);

              }else {
                $msg="erreur sur l'importation finale ...";
              }

            }else {
              $msg = "Votre photo n'est pas au bon format !";
            }

          } else {
            $msg="Votre photo a une taille trop importante";
          }

        } else {
          echo "GROS PB";
        }
    }
  //Retourne le message de confirmation OU d'erreur suivant la situation
  return $msg;
}

//Supprime un constructeur
function SupprimConstructeur($id)
{
  $db=ConnexionAdmin();

  $destructeur = $db->prepare("DELETE FROM constructeurAuto WHERE id='$id'");
  $destructeur->execute();

  return $destructeur;
}

//Supprime un véhicule
function SupprimVoiture($id)
{
  $db=ConnexionAdmin();

  $destructeur = $db->prepare("DELETE FROM vehicule WHERE id='$id'");
  $destructeur->execute();

  return $destructeur;
}


/*############################################
        VERIFICATION / CONFIRMATION
############################################*/


//Vérifie que le lien est bien transmis d'une page à une autre
function VerificationLien($test)
{
  if (isset($test) AND !empty($test)) {
    $v = (int)$test;
    return $v;
    } else {
        die ('Problème sur la requète...');
      }
}

//Se connecte à la BDD en verifiant l'existence, et la correspondance, du login et du mot de passe
function ConnexionSession()
{
  // Test de l'envoi du formulaire
    if(!empty($_POST['submit']))
    {
      // Les identifiants sont transmis ?
      if(!empty($_POST['login']) && !empty($_POST['password']))
      {
        // Requètes pour récupérer les infos des comptes dans la base de donnée
          $login=$_POST['login'];
          $password=$_POST['password'];
          $LaConnection=BDD_Utilisateur($login);
          if($LaConnection->rowCount()==1) {
            foreach ($LaConnection as $value) {
              $hash=$value['mdp'];
            }
                //Vérification d'un seul retour parmis la base de donnée.
                if (password_verify($password,$hash)) {
                  session_start();  // On ouvre la session

                  // on applique les infos en tant que variables de session
                  $_SESSION['login'] = $login;
                  $_SESSION['mdp'] = $password;

                  header('Location:AdministrationSite.php?action=Principale');  // On redirige vers la page Principale de l'admnistration
                  exit();
                } else {
                  $Message = 'identifiant et/ou mot de passe incorrect !';
                }


          } else {
            $Message = 'identifiant incorrect !';
          }

      } else {
        $Message = 'Veuillez inscrire vos identifiants svp !';

      }
    }
return $Message;
}

//Vérifie si l'on est connecté pour pouvoir ouvrir la page
function VerifAutorisationPage()
{
  if (empty($_SESSION['login'])) {
    die('<h1 class="AdminLOOSE">Vous devez être connecté pour pouvoir entrer sur cette page !</h1><a class="AdminLOOSEbutton" href="/SiteVoiture/ZoneAdmin/AdministrationSite.php?action=Connexion">Se Connecter</a><br><a class="AdminLOOSEbutton" href="/SiteVoiture/index.php">Retour a la page d\'accueil</a>');
  }
}

//Vérifie qu'un modérateur n'essaie pas d'arriver à la page
function PasDeModérateur($privilege)
{
  if ($privilege==0) {
    die('<h1 class="AdminLOOSE">Vous n\'avez pas les droits suffisant pour acceder a cette page !</h1><a class="AdminLOOSEbutton" href="/SiteVoiture/ZoneAdmin/AdministrationSite.php?action=Connexion">Se Connecter</a><br><a class="AdminLOOSEbutton" href="/SiteVoiture/index.php">Retour à la page d\'accueil</a>');
  }
}

function VerifMajOUAjout()
{
  if (isset($_POST["update"]) && !empty($_POST["update"])) {
    return 1;
  }else{
    return 0;
  }
}

?>
