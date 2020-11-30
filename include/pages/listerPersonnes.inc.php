<?php
  if(isset($_POST['idPers'])) {
    $id = $_POST['idPers'];
  }
    $pm = new PersonneManager($db);

    if(!isset($id)) {
      ?>
      <h1>Liste des personnes enregistrées</h1>
      Actuellement <?php echo $pm->countPersonne(); ?> personnes enregistées
    <table>
      <tr>
        <th>Numéro</th>
        <th>Nom</th>
        <th>Prénom</th>
      </tr>
      <?php
        $listePers = $pm->getAllPersonns();
        foreach ($listePers as $unePers) {
          ?>
            <tr>
              <td>
                <form class="personForm" action="#" method="post">
                  <input type="hidden" name="idPers" value="<?php echo $unePers->getNum(); ?>">
                  <input type="submit" value="<?php echo $unePers->getNum(); ?>">
                </form>
              </td>
              <td><?php echo $unePers->getNom(); ?></td>
              <td><?php echo $unePers->getPrenom(); ?></td>
            </tr>
          <?php
        }
      ?>
    </table>
      <?php
    } else {
      $pm = new PersonneManager($db);
      $dm = new DepartementManager($db);
      $em = new EtudiantManager($db);
      $sm = new SalarieManager($db);
      $fm = new FonctionManager($db);
      $vm = new VilleManager($db);
      $estEtudiant = $pm->isEtudiant($id);
      if($estEtudiant ==='true') {
        $depNum = $em->getDepNumFromId($id);
        ?>
        <h1>Détails sur l'étudiant <?php echo $pm->getNomFromId($id);?></h1>
        <table>
          <tr>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Tel</th>
            <th>Département</th>
            <th>Ville</th>
          </tr>
          <tr>
            <td><?php echo $pm->getPrenomFromId($id); ?></td>
            <td><?php echo $pm->getMailFromId($id); ?></td>
            <td><?php echo $pm->getTelFromId($id); ?></td>
            <td><?php echo $dm->getNomFromNum($depNum); ?></td>
            <td><?php echo $vm->getVilleFromId($dm->getVilleNumFromId($depNum)); ?></td>
          </tr>
        </table>
        <?php
      } else {

        ?>
        <h1>Détails sur le salarié <?php echo $pm->getNomFromId($id);?></h1>
        <table>
          <tr>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Tel</th>
            <th>Tel pro</th>
            <th>Fonction</th>
          </tr>
          <tr>
            <td><?php echo $pm->getPrenomFromId($id); ?></td>
            <td><?php echo $pm->getMailFromId($id); ?></td>
            <td><?php echo $pm->getTelFromId($id); ?></td>
            <td><?php echo $sm->getTelProfFromId($id); ?></td>
            <td><?php echo $fm->getLibelleFromNum($sm->getFonNumFromId($id)); ?></td>
          </tr>
        </table>
        <?php
      }
    }
?>
