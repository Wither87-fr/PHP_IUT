<?php
class SalarieManager{
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}

	/**
	* Ajoute un salarié à la BD
	* @param per_num : le numéro de la personne
	* @param sal_telprof : le numéro de son téléphone professionnel
	* @param fon_num : le numéro de sa fonction
	* @return effectue : Si oui ou non, l'ajout s'est bien passé.
	*/
	public function addSalarie($per_num, $sal_telprof, $fon_num) {
		$sql = "INSERT INTO salarie(per_num, sal_telprof, fon_num) VALUES (:per_num, :sal_telprof, :fon_num) "; //préparation de la requête
		$req = $this->db->prepare($sql);

		//Valorisation de la requête
		$req->bindValue(':per_num', $per_num);
		$req->bindValue(':sal_telprof', $sal_telprof);
		$req->bindValue(':fon_num', $fon_num);

		$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non

		return $effectue;
	$req->closeCursor();
	}

	/**
	* Récupère le numéro de téléphone professionnel du salarié grâce à son identifiant
	* @param id : L'identifiant du salarié
	* @return telProf : Le numéro de téléphone professionnel du salarié
	*/
	public function getTelProfFromId($id) {
		$sql = "SELECT sal_telprof from salarie WHERE per_num = $id";
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$telProf = $result['sal_telprof'];
		$req->closeCursor();
		return $telProf;
	}

	/**
	* Récupère le numéro de fonction du salarié grâce à son identifiant
	* @param id : L'identifiant du salarié
	* @return fonNum : Le numéro de fonction du salarié
	*/
	public function getFonNumFromId($id) {
		$sql = "SELECT fon_num from salarie WHERE per_num = $id";
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$fonNum = $result['fon_num'];
		$req->closeCursor();
		return $fonNum;
	}

	/**
	* Supprime le salarié de la BD grâce à son identifiant
	* @param id : L'identifiant du salarié
	* @return effectue : Si oui ou non, la suppression s'est bien passé.
	*/
	public function delSal($id) {
		$sql = "DELETE FROM salarie WHERE per_num=$id";
		$req = $this->db->prepare($sql);
		$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non
		return $effectue;
	}

	/**
	* Met à jour les infos du salarié
	* @param tel_prof : son numéro de téléphone professionnel
	* @param fon_num : le numéro de sa fonction
	* @param id : l'identifiant du salarié
	* @return effectue : Si oui ou non, la mise à jour s'est bien passé.
	*/
	public function updateInfos($tel_prof, $fon_num, $id) {
		$sql = "UPDATE salarie SET sal_telprof = :tel_prof; fon_num = :fon_num WHERE per_num = :id";
		$req = $this->db->prepare($sql);
		$req->bindValue('tel_prof', $tel_prof);
		$req->bindValue('fon_num', $fon_num);
		$req->bindValue('id', $id);
		$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non
		return $effectue;
	}
}
