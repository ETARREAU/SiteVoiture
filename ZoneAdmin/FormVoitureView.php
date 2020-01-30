<?php ob_start(); ?><!-- Démarre la variable de stockage du code HTML-->

<?php if (!empty($_GET['idV'])): ?>

  <!-- Début du formulaire de modification d'une voiture-->
    <form class="AjoutModif" enctype="multipart/form-data" action="AdministrationSite.php?action=FormVoiture" method="post">
      <fieldset>
          <legend>Formulaire de Modification d'une voiture</legend>
              <p>
              <?php foreach ($LaVoiture as $voiture): ?>
                <label for="imgVoiture" title="Image du Véhicule">Image du Véhicule</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>"/>
                <input type="hidden" name="update" value="update">
                <input type="hidden" name="id" value="<?=$voiture['id']?>">
                <input name="imgVoiture" type="file" id="imgVoiture" />
                <label for="selecteurConstru">Nom Du Constructeur</label>
                <select class="selecteurConstru" name="selecteurConstru">
                  <?php
                    foreach ($ListConstru as $SelectConstruct) {
                      echo  '<option value="'.$SelectConstruct['id'].'">'.$SelectConstruct['NomConstru'].'</option>';
                    }
                  ?>
                </select>
                <label for="NomVoiture">Nom Du Modèle</label>
                <input type="text" name="NomVoiture" value="<?=$voiture['NomModèle']?>">
                <label for="AnnéeVoiture">Année de mise en Circulation</label>
                <input type="number" name="AnnéeVoiture" value="<?=$voiture['Année']?>">
                <input type="submit" name="submit" value="Enregistrer la/les modification" />
              <?php endforeach; ?>
              </p>
      </fieldset>
    </form>

<?php else: ?>

  <!-- Début du formulaire d'ajout d'une voiture-->
    <form class="AjoutModif margeSmartPhone" enctype="multipart/form-data" action="AdministrationSite.php?action=FormVoiture" method="post">
      <fieldset>
        <legend>Formulaire d'ajout d'une voiture</legend>
            <p>
              <label for="imgVoiture" title="Image du Véhicule">Image du Véhicule</label>
              <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>"/>
              <input name="imgVoiture" type="file" id="imgVoiture" />
              <label for="selecteurConstru">Nom Du Constructeur</label>
              <select class="selecteurConstru" name="selecteurConstru">
                <?php
                    foreach ($ListConstru as $SelectConstruct) {
                      echo  '<option value="'.$SelectConstruct['id'].'">'.$SelectConstruct['NomConstru'].'</option>';
                    }
                ?>
              </select>
              <label for="NomVoiture">Nom Du Modèle</label>
              <input type="text" name="NomVoiture" value="">
              <label for="AnnéeVoiture">Année de mise en Circulation</label>
              <input type="number" name="AnnéeVoiture" value="">
              <input type="submit" name="submit" value="Ajouter Une Voiture !" />
            </p>
      </fieldset>
    </form>

<?php endif; ?>
<?php
$content=ob_get_clean(); //Ferme la variable de stockage du code HTML et l'envoie dans '$content'
?>
