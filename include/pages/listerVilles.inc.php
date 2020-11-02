<?php
  //include_once 'include/ejectNotConnected.inc.php';
?>
<h1>Liste des villes</h1>
<?php
  $vm = new VilleManager($db); //Instanciation du VilleManager, qui contient toutes les requetes SQL
?>
  <p>Actuellement <?php echo $vm->compterVille(); //Permet de retourner un entier correspondant au nombre de villes?> villes sont enregistrées</p>
  <table>
    <thead>
      <tr>
        <th>Numéro</th>
        <th>Nom</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $listeVille = $vm->listerVilles(); //attribution d'un tableau de ville à la variable listeVille
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
