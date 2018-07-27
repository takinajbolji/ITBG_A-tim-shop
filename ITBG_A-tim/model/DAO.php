<?php

/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */

	require_once '../config/db.php';
	class DAO {
		private $db;
		//tabela osobe
		private $INSERT_OSOBA = "INSERT INTO osoba(ime, prezime, username, password, adresa, mail, telefon) VALUES (?,?,?,?,?,?,?)";
		private $SELECT_OSOBA_BY_USERNAME_AND_PASSWORD = "SELECT * FROM osoba WHERE username =? AND password=?";
		private $SELECT_OSOBE = "SELECT * FROM osoba";
		private $SELECT_OSOBA_BY_IDOSO = "SELECT * FROM osoba WHERE idoso=?";
		private $UPDATE_OSOBA_BY_ID_OSOBE = "UPDATE osoba SET ime=?, prezime=?, adresa=?, mail=?, telefon=? WHERE idoso=?";
		private $UPDATE_OSOBA_BY_IDOSO = "UPDATE osoba SET adresa=?, mail=?, telefon=? WHERE idoso=?";
		
		//tabela artikal
		private $INSERT_ARTIKAL = "INSERT INTO artikal(naziv, cena) VALUES (?,?)";
		private $SELECT_ARTIKLI = "SELECT * FROM artikal";
		private $SELECT_ARTIKAL_BY_ID = "SELECT * FROM artikal WHERE idart=?";
		private $UPDATE_ARTIKAL_BY_IDART = "UPDATE artikal SET naziv=?, cena=? WHERE idart=?";
		
		//tabela kolicina
		private $INSERT_KOLICINA = "INSERT INTO kolicina(idoso, idart, kolicina) VALUES (?,?,?)";
		private $SELECT_KOLICINA="SELECT kolicina FROM kolicina WHERE idart=? AND idoso=?";
		private $SELECT_KOLICINA_BY_IDART = "SELECT SUM(kolicina) FROM kolicina WHERE idart=? AND idoso=?";
		private $DELETE_KOLICINA_BY_IDOSO = "DELETE FROM kolicina WHERE idoso=?";
		private $DELETE_KOLICINA_BY_IDOSOANDIDART = "DELETE FROM kolicina WHERE idoso=? AND idart=?";
		
		//brojFakture
		private $INSERT_BROJ_FAKTURE = "INSERT INTO faktura(broj_fakture,idoso,vremeFakturisanja) VALUES (?,?,CURRENT_TIMESTAMP)";
		private $SELECT_BROJ_FAKTURE = "SELECT COUNT(broj_fakture) FROM faktura ";
		private $DELETE_BROJ_FAKTURE = "DELETE FROM faktura WHERE broj_fakture=?";
		
		//tabela porudzbine
		private $INSERT_PORUDZBINE = "INSERT INTO porudzbina(id_kup, id_art, naziv, cena, kolicina, ukupno, broj_fakture, vremeobrade) VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";
		private $SELECT_PORUDZBINE = "SELECT * FROM porudzbina";
		private $SELECT_PORUDZBINE_BY_IDOSO = "SELECT porudzbina.*,osoba.idoso FROM porudzbine JOIN osoba ON porudzbine.id_kup=osoba.idoso WHERE osoba.idoso=?";
		private $DELETE_PORUDZBINE_BY_IDKUP = "DELETE FROM porudzbina WHERE id_kup=?";
		
		//tabela admin porudzbina
		private $INSERT_ADMIN_PORUDZBINA = "INSERT INTO adminpor(id_kup, id_art, naziv, cena, kolicina, ukupno, broj_fakture, vremeobrade) VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";
		private $SELECT_ADMIN_PORUDZBINA = "SELECT * FROM adminpor";
		private $SELECT_ADMIN_PORUDZBINA_BY_IDOSO = "SELECT adminpor.*,osoba.idoso FROM adminpor JOIN osoba ON adminpor.id_kup=osoba.idoso WHERE osoba.idoso=?";
		private $SELECT_ADMIN_PORUDZBINA_BY_IDOSO_IDART_BROJFAKTURE = "SELECT adminpor.*,osoba.idoso FROM adminpor JOIN osoba ON adminpor.id_kup=osoba.idoso WHERE osoba.idoso=? AND id_art=? AND broj_fakture=?";
		private $DELETE_ADMIN_PORUDZBINA_BY_IDKUP_IDART_BROJFAKTURA = "DELETE FROM adminpor WHERE id_kup=? AND id_art=? AND broj_fakture=?";
		
		//tabela ISPORUCENO
		private $INSERT_ISPORUCENO = "INSERT INTO isporuceno(id_kup, id_art, naziv, cena, kolicina, ukupno, broj_fakture, vremeobrade) VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";
		private $SELECT_ISPORUCENO = "SELECT * FROM isporuceno";
		private $SELECT_ISPORUCENO_BY_IDOSO = "SELECT isporuceno.*,osoba.idoso FROM isporuceno JOIN osoba ON isporuceno.id_kup=osoba.idoso WHERE osoba.idoso=?";
		
		//tabela OTKAZANO
		private $INSERT_OTKAZANO = "INSERT INTO otkazano(id_kup, id_art, naziv, cena, kolicina, ukupno, broj_fakture, vremeobrade) VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";
		private $SELECT_OTKAZANO = "SELECT * FROM otkazano";
		private $SELECT_OTKAZANO_BY_IDOSO = "SELECT otkazano.*,osoba.idoso FROM otkazano JOIN osoba ON otkazano.id_kup=osoba.idoso WHERE osoba.idoso=?";
		
		
		public function __construct() {
			$this->db= DB::createInstance();
		}
		
		//metode OSOBE
		public function insertOsoba($ime, $prezime, $username, $password, $adresa, $mail, $telefon) {
			$statement = $this->db->prepare($this->INSERT_OSOBA);
			$statement ->bindValue(1, $ime);
			$statement ->bindValue(2, $prezime);
			$statement ->bindValue(3, $username);
			$statement ->bindValue(4, $password);
			$statement ->bindValue(5, $adresa);
			$statement ->bindValue(6, $mail);
			$statement ->bindValue(7, $telefon);
			$statement->execute();
		}
		
		public function selectOsobaByUsernameAndPassword($username, $password) {
			$statement = $this->db->prepare($this->SELECT_OSOBA_BY_USERNAME_AND_PASSWORD);
			$statement ->bindValue(1, $username);
			$statement ->bindValue(2, $password);
			$statement->execute();
			$result = $statement->fetch();
			return $result;
		}
		
		public function selectOsobe() {
			$statement = $this->db->prepare($this->SELECT_OSOBE);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		public function selectOsobaByIdoso($idoso) {
			$statement = $this->db->prepare($this->SELECT_OSOBA_BY_IDOSO);
			$statement ->bindValue(1, $idoso);
			$statement->execute();
			$result = $statement->fetch();
			return $result;
		}
		
		public function updateOsobaByIdoso($ime, $prezime, $adresa, $mail, $telefon, $idoso) {
			$statement = $this->db->prepare($this->UPDATE_OSOBA_BY_ID_OSOBE);
			$statement ->bindValue(1, $ime);
			$statement ->bindValue(2, $prezime);			
			$statement ->bindValue(3, $adresa);
			$statement ->bindValue(4, $mail);
			$statement ->bindValue(5, $telefon);
			$statement ->bindValue(6, $idoso);
			$statement->execute();
		}
		
		public function upadateOsobaByIdoso($adresa, $mail, $telefon, $idoso) {
			$statement = $this->db->prepare($this->UPDATE_OSOBA_BY_IDOSO);
			$statement ->bindValue(1, $adresa);
			$statement ->bindValue(2, $mail);
			$statement ->bindValue(3, $telefon);
			$statement ->bindValue(4, $idoso);
			$statement->execute();
		}
		
		//metode ARTIKLA
		public function selectArtikli() {
			$statement = $this->db->prepare($this->SELECT_ARTIKLI);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		public function selectArtikalById($idart) {
			$statement = $this->db->prepare($this->SELECT_ARTIKAL_BY_ID);
			$statement ->bindValue(1, $idart);
			$statement->execute();
			$result = $statement->fetch();
			return $result;
		}
		
		public function insertArtikal($naziv, $cena) {
			$statement = $this->db->prepare($this->INSERT_ARTIKAL);
			$statement ->bindValue(1, $naziv);
			$statement ->bindValue(2, $cena);
			$statement->execute();
		}
		
		public function updateArtikalByIdart ($naziv, $cena, $idart) {
			$statement = $this->db->prepare($this->UPDATE_ARTIKAL_BY_IDART);
			$statement ->bindValue(1, $naziv);
			$statement ->bindValue(2, $cena);
			$statement ->bindValue(3, $idart);
			$statement->execute();
		}
		
		//metode KOLICINE
		public function insertKolicina($idoso, $idart, $kolicina) {
			$statement = $this->db->prepare($this->INSERT_KOLICINA);
			$statement ->bindValue(1, $idoso);
			$statement ->bindValue(2, $idart);
			$statement ->bindValue(3, $kolicina);
			$statement->execute();
		}
		
		public function selectKolicina($idart, $idoso) {
			$statement = $this->db->prepare($this->SELECT_KOLICINA);
			$statement ->bindValue(1, $idart);
			$statement ->bindValue(2, $idoso);
			$statement->execute();
			$result = $statement->fetch();
			return $result;
		}
		
		public function selectKolicinaByIdartAndIdoso($idart, $idoso) {
			$statement = $this->db->prepare($this->SELECT_KOLICINA_BY_IDART);
			$statement ->bindValue(1, $idart);
			$statement ->bindValue(2, $idoso);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		public function deleteKolicinaByIdoso($idoso) {
			$statement = $this->db->prepare($this->DELETE_KOLICINA_BY_IDOSO);
			$statement ->bindValue(1, $idoso);
			$statement->execute();
		}
		
		public function deleteKolicinaByIdosoAndIdart($idoso, $idart) {
			$statement = $this->db->prepare($this->DELETE_KOLICINA_BY_IDOSOANDIDART);
			$statement ->bindValue(1, $idoso);
			$statement ->bindValue(2, $idart);
			$statement->execute();
		}
		
		//metode FAKTURE
		public function insertBrojFakture($broj_fakture, $idoso){
			$statement = $this->db->prepare($this->INSERT_BROJ_FAKTURE);
			$statement -> bindValue(1, $broj_fakture);
			$statement -> bindValue(2, $idoso);
			$statement -> execute();
		}
		
		public function selectBrojFakture(){
			$statement = $this->db->prepare($this->SELECT_BROJ_FAKTURE);
			$statement -> execute();
			$result = $statement -> fetch();
			return $result;
		}
		
		public function deleteBrojFakture($broj_fakture){
			$statement = $this->db->prepare($this->DELETE_BROJ_FAKTURE);
			$statement -> bindValue(1, $broj_fakture);
			$statement -> execute();
		}
		
		//metode PORUDZBINE
		public function insertPorudzbine($id_kup, $id_art, $naziv, $cena, $kolicina, $ukupno, $broj_fakture) {
			$statement = $this->db->prepare($this->INSERT_PORUDZBINE);
			$statement ->bindValue(1, $id_kup);
			$statement ->bindValue(2, $id_art);
			$statement ->bindValue(3, $naziv);
			$statement ->bindValue(4, $cena);
			$statement ->bindValue(5, $kolicina);
			$statement ->bindValue(6, $ukupno);
			$statement ->bindValue(7, $broj_fakture);
			$statement->execute();
		}
		
		public function selectPorudzbineByIdoso($idoso) {
			$statement = $this->db->prepare($this->SELECT_PORUDZBINE_BY_IDOSO);
			$statement ->bindValue(1, $idoso);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}

		public function selectPorudzbine() {
			$statement = $this->db->prepare($this->SELECT_PORUDZBINE);
			$statement -> execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		public function deletePorudzbineByIdoso($idoso) {
			$id_kup = $idoso;
			$statement = $this->db->prepare($this->DELETE_PORUDZBINE_BY_IDKUP);
			$statement ->bindValue(1, $id_kup);
			$statement->execute();
		}
		

		/*
		 * ADMINISTRATORSKE METODE
		 */
				
		//metode ADMIN PORUDZBINA
		public function insertAdminPorudzbina($id_kup, $id_art, $naziv, $cena, $kolicina, $ukupno, $broj_fakture) {
			$statement = $this->db->prepare($this->INSERT_ADMIN_PORUDZBINA);
			$statement ->bindValue(1, $id_kup);
			$statement ->bindValue(2, $id_art);
			$statement ->bindValue(3, $naziv);
			$statement ->bindValue(4, $cena);
			$statement ->bindValue(5, $kolicina);
			$statement ->bindValue(6, $ukupno);
			$statement ->bindValue(7, $broj_fakture);
			$statement->execute();
		}
		
		public function selectAdminPorudzbina() {
			$statement = $this->db->prepare($this->SELECT_ADMIN_PORUDZBINA);
			$statement -> execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		public function selectAdminPorudzbinaByIdoso($idoso) {
			$statement = $this->db->prepare($this->SELECT_ADMIN_PORUDZBINA_BY_IDOSO);
			$statement ->bindValue(1, $idoso);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		public function selectAdminPorudzbiaByIdosoIdartBrojFakture($idoso, $id_art, $broj_fakture){
			$statement = $this->db->prepare($this->SELECT_ADMIN_PORUDZBINA_BY_IDOSO_IDART_BROJFAKTURE);
			$statement -> bindValue(1, $idoso);
			$statement -> bindValue(2, $id_art);
			$statement -> bindValue(3, $broj_fakture);
			$statement -> execute();
			$result = $statement -> fetchAll();
			return $result;
		}
		
		public function deleteAdminPourudzByIdKupIdArtBrojFak($id_kup, $id_art, $broj_fakture){
			$statement=$this->db->prepare($this->DELETE_ADMIN_PORUDZBINA_BY_IDKUP_IDART_BROJFAKTURA);
			$statement->bindValue(1, $id_kup);
			$statement->bindValue(2, $id_art);
			$statement->bindValue(3, $broj_fakture);
			$statement->execute();
		}

		//metode ISPORUCENO
		public function insertIsporuceno($id_kup, $id_art, $naziv, $cena, $kolicina, $ukupno, $broj_fakture) {
			$statement = $this->db->prepare($this->INSERT_ISPORUCENO);
			$statement ->bindValue(1, $id_kup);
			$statement ->bindValue(2, $id_art);
			$statement ->bindValue(3, $naziv);
			$statement ->bindValue(4, $cena);
			$statement ->bindValue(5, $kolicina);
			$statement ->bindValue(6, $ukupno);
			$statement ->bindValue(7, $broj_fakture);
			$statement->execute();
		}
		
		public function selectIsporuceno() {
			$statement = $this->db->prepare($this->SELECT_ISPORUCENO);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		public function selectIsporucenoByIdoso($idoso) {
			$statement = $this->db->prepare($this->SELECT_ISPORUCENO_BY_IDOSO);
			$statement ->bindValue(1, $idoso);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		//metode OTKAZANO
		public function insertOtkazano($id_kup, $id_art, $naziv, $cena, $kolicina, $ukupno, $broj_fakture) {
			$statement = $this->db->prepare($this->INSERT_OTKAZANO);
			$statement ->bindValue(1, $id_kup);
			$statement ->bindValue(2, $id_art);
			$statement ->bindValue(3, $naziv);
			$statement ->bindValue(4, $cena);
			$statement ->bindValue(5, $kolicina);
			$statement ->bindValue(6, $ukupno);
			$statement ->bindValue(7, $broj_fakture);
			$statement->execute();
		}
		
		public function selectOtkazano() {
			$statement = $this->db->prepare($this->SELECT_OTKAZANO);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		public function selectOtkazanoByIdoso($idoso){
			$statement = $this->db->prepare($this->SELECT_OTKAZANO_BY_IDOSO);
			$statement->bindValue(1, $idoso);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
			
		}
		
	}
?>
