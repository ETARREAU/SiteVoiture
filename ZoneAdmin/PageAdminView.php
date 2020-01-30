<?php ob_start(); ?><!-- Démarre la variable de stockage du code HTML-->

    <h1>Administration</h1>

    <div class="ListeAdmin">

      <div class="AdminMarques">

       <!-- Affichage des Marques Enregistrées-->
       <h2>Les Marques Enregistrées:</h2>
         <p>
           <?php
           foreach ($ListConstru as $constructeur) {
             if ($privilege==1) {
               echo $constructeur['NomConstru'].'
              <br><a class="BTupdtdel" href="AdministrationSite.php?idC='.$constructeur['id'].'&amp;action=FormConstructeur"> Mettre à jour </a> //  <a class="BTupdtdel" href="AdministrationSite.php?action=Principale&amp;Supprim=C&amp;id='.$constructeur['id'].'"> Supprimer </a>
              <br><hr><br>';
             } else {
                echo $constructeur['NomConstru'].'<br><br><hr><br><br>';
                }
           }
           ?>
        </p>
         <!-- Bouton pour ajouter une marque-->
        <br>
        <?php if ($privilege==1): ?>
           <a class="AdminBouton" href="AdministrationSite.php?action=FormConstructeur"> Ajouter une Marque </a>
        <?php endif; ?>
        <br>

      </div>
      <div class="AdminVoiture">

        <!-- Affichage des Modèles de Voitures Enregistrées-->
        <h2>Les Voitures par Marques</h2>
        <p>
          <?php
          foreach ($ListVoiture as $voiture) {
             if ($privilege==1 || $privilege==0) {
              echo $voiture['NomModèle'].'
              <br><a class="BTupdtdel" href="AdministrationSite.php?idV='.$voiture['id'].'&amp;action=FormVoiture"> Mettre à jour </a> // <a class="BTupdtdel" onClick="ConfirmMessage()" href="AdministrationSite.php?action=Principale&amp;Supprim=V&amp;id='.$voiture['id'].'"> Supprimer </a>
              <br><hr><br>';
            } else {
               echo $voiture['NomModèle'].'<br><br><hr><br><br>';
            }
          }
           ?>
         </p>
         <!-- Bouton pour ajouter une voiture -->
         <br>
         <?php
           if ($privilege==1 || $privilege==0) {
             echo '<a class="AdminBouton" href="AdministrationSite.php?action=FormVoiture"> Ajouter une Voiture </a>';
           }
         ?>
         <br>
      </div>
      <div class="">
        <!-- Affichage des Utilisateurs Enregistrées -->
        <h2>Les Utilisateurs</h2>
        <p>
          <?php
          foreach ($ListUtilisateurs as $utilisateurs) {
            if ($privilege==1) {
              echo 'Login: '.$utilisateurs['pseudo'].'
                    <br>Mot De Passe: <br>'.$utilisateurs['mdp'].'
                    <br><a class="BTupdtdel" href="AdministrationSite.php?idU='.$utilisateurs['id'].'"> Mettre à jour </a> // <a class="BTupdtdel" href="Suppress.php?idU='.$utilisateurs['id'].'"> Supprimer </a>
                    <br><hr><br>';
            } else {
              echo "Login: ".$utilisateurs['pseudo'].'<br><br><hr><br><br>';
            }
          }
          ?>
        </p>
        <!-- Bouton pour ajouter un compte -->
        <br>
          <?php
          if ($privilege==1) {
            echo '<a class="AdminBouton" href="AdministrationSite.php">Ajouter un Utilisateur</a>';
          }
          ?>
        <br>
      </div>
    </div>
<hr>
      <a class="AdminBouton" href="/SiteVoiture/index.php">Retour au Menu</a>
<?php
$content=ob_get_clean(); //Ferme la variable de stockage du code HTML et l'envoie dans '$content'
?>
