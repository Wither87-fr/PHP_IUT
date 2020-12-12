<h1>Liste des parcours proposés</h1>
  <?php
    $pm = new ParcoursManager($db);
    $vm = new VilleManager($db);
  ?>
  <p>Actuellement <?php echo $pm->countParcours(); //compte le nombre de parcours existant?> parcours sont enregistrés</p>
  <?php
    $listeParcours = $pm->listerParcoursProposés(); // La liste des parcours
  ?>
  <table>
    <thead>
      <tr>
        <th>Numéro</th>
        <th>Nom Ville</th>
        <th>Nom Ville</th>
        <th>Nombre de Km</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($listeParcours as $parcours) {
          ?>
            <tr>
              <td><?php echo $parcours->getId(); ?></td>
              <td><?php echo $vm->getVilleFromId($parcours->getVilleID1()); ?></td>
              <td><?php echo $vm->getVilleFromId($parcours->getVilleID2()); ?></td>
              <td><?php echo $parcours->getDistance(); ?></td>
            </tr>
          <?php
        }
      ?>
    </tbody>
  </table>
