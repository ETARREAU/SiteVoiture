<?php
ob_start(); //Démarre la variable de stockage du code HTML

if (!empty($_GET['idC'])):
?>
  <!-- Début du formulaire de modification d'un constructeur-->
  <form class="AjoutModif margeSmartPhone" enctype="multipart/form-data" action="AdministrationSite.php?action=FormConstructeur" method="post">
    <fieldset>
      <?php foreach ($LeConstructeur as $Cons): ?>
        <legend>Formulaire de modification de la marque <?=$Cons['NomConstru']?></legend>
          <p>
            <input type="hidden" name="id" value="<?=$Cons['id']?>"/>
            <input type="hidden" name="update" value="update"/>
            <label for="NomConstructeur">Nom Du Constructeur</label>
            <input type="text" name="NomConstructeur" value="<?=$Cons['NomConstru']?>">
            <label for="Description">Résumé</label>
            <input type="text" name="Description" value="<?=$Cons['description']?>">
            <label for="Biographie">Description</label>
            <input type="textarea" name="Biographie" value="<?=$Cons['bio']?>">
            <input type="submit" name="submit" value="Enregistrer la/les modification" />
          </p>
      <?php endforeach; ?>
    </fieldset>
  </form>

<?php else : ?>

  <!-- Début du formulaire d'ajout d'un constructeur-->
  <form class="AjoutModif" enctype="multipart/form-data" action="AdministrationSite.php?action=FormConstructeur" method="post">
    <fieldset>
      <legend>Formulaire d'ajout d'un constructeur</legend>
        <p>
          <label for="imgConstru" title="Recherchez fichier du logo !">Recherchez fichier du logo !</label>
          <input name="imgConstru" type="file"/>
          <label for="NomConstructeur">Nom Du Constructeur</label>
          <input type="text" name="NomConstructeur" value="">
          <label for="Description">Résumé</label>
          <input type="text" name="Description" value="">
          <label for="Biographie">Description</label>
          <input type="textarea" name="Biographie" value="">
          <input type="submit" name="submit" value="Ajouter un constructeur!"/>
        </p>
    </fieldset>
  </form>

<?php endif; ?>
<?php if (!empty($msg)) { echo "<script>alert($msg)</script>"; }?>
<?php
$content=ob_get_clean(); //Ferme la variable de stockage du code HTML et l'envoie dans '$content'
?>
