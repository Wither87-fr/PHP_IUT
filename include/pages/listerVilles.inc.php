<h1>Liste des villes</h1>
<?php
  $vm = new VilleManager($db);
?>
  <p>Actuellement <?php echo $vm->compterVille(); // Affiche le nombre de villes?> villes sont enregistrées</p>
  <table>
    <thead>
      <tr>
        <th>Numéro</th>
        <th>Nom</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $listeVille = $vm->listerVilles(); // Liste la totalité des villes
        foreach ($listeVille as $ville) {
          ?>
            <tr>
              <td><?php echo $ville->getNum();?></td>
              <td><?php echo $ville->getNom(); ?></td>
            </tr>
          <?php
        }
      ?>
    </tbody>
  </table>
