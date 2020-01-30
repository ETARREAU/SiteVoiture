<?php ob_start(); ?><!-- Démarre la variable de stockage du code HTML-->

<main class="connexionAdmin">

        <!-- Formulaire pour se connecter -->
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

    <fieldset>
      <legend>Identifiez-vous</legend>
      <?php

        // Rencontre-t-on une erreur lors de la connexion ?
        if(!empty($errorMessage))
        {
          echo '<p>', htmlspecialchars($errorMessage) ,'</p>';
        }

      ?>
      <p>
        <label for="login">Login :</label>
        <input type="text" name="login" id="login" value="" />
      </p>
      <p>
        <label for="password">Mot De Passe :</label>
        <input type="password" name="password" id="password" value="" />
      </p>
      <input type="submit" name="submit" value="Se Connecter" />
    </fieldset>

  </form>
</main>

<?php $content=ob_get_clean(); //Ferme la variable de stockage du code HTML et l'envoie dans '$content' ?>
