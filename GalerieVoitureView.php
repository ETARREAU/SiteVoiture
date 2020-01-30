<?php ob_start(); ?><!-- Démarre la variable de stockage du code HTML-->
<main class="GalerieVoiture ">

  <h1 class="GalerieVoitureTitre margeSmartPhone"><span class="GA">GA</span><span class="LE">LE</span><span class="RI">RI</span><span class="E">e</span></h1>
  <p><small><?=$SousTitre?></small></p>

  <div class="GalerieVoitureConteneur">
    <?php
    foreach ($MethodeAff as $Voiture) {

      echo '<div class="imgGalerie">
              <a href="index.php?id='.$Voiture['id'].'&amp;action=ModeleVoiture"><img src="'.$Voiture['lienImg'].'" alt="image de la voiture'.$Voiture['NomModèle'].'"></a>
              <br><h2>Nom: </h2><p>'.$Voiture['NomModèle'].'</p>
              <br><h2>Date de Création: </h2><p>'.$Voiture['Année'].'</p>
            </div>';
    }
    ?>
  </div>
</main>
<?php $content=ob_get_clean(); //Ferme la variable de stockage du code HTML et l'envoie dans '$content' ?>
