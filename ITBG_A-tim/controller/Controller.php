<?php
/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */
	require_once '../model/DAO.php';
	class Controller {
		
		//logovanje korisnika
		public function login() {
			$username=isset($_POST['username'])?$_POST['username']:"";
			$password=isset($_POST['password'])?$_POST['password']:"";
			
			if (!empty($username)&& !empty($password)) {
				$dao = new DAO();
				$osoba=$dao->selectOsobaByUsernameAndPassword($username, $password);
				
				if ($osoba) {
					session_start();
					$_SESSION['ulogovan']=serialize($osoba);
					$ulogovan=unserialize($_SESSION['ulogovan']);
					$kontrola=$ulogovan['kontrolnasuma'];
					
					if ($kontrola==0) {
						$artikli=$dao->selectArtikli();
						include 'artikli.php';
					} else {
						$kontrola==1;
						$artikli=$dao->selectArtikli();
						include 'adminpanel.php';
					}					
				} else {
					$msg = 'Pogresan Username i Password!!!';
					include 'registracija.php';
				}
			} else {
				$msg = 'Morate popuniti Username i Password!!!';
				include 'login.php';
			}
		}
		
		//odjavljivanje korisnika i praznjenje korpe
		public function logout() {
			session_start();
			$dao=new DAO();
			$ulogovan = unserialize($_SESSION['ulogovan']);
			$idoso = $ulogovan['idoso'];
			$dao->deleteKolicinaByIdoso($idoso);
			$dao->deletePorudzbineByIdoso($idoso);
			session_unset();
			session_destroy();
			header('Location:login.php');
		}
		
		//prelazak na panel za registraciju
		public function showRegist() {
			include 'registracija.php';
		}
		
		//registracija korisnika
		public function registracija() {
			$ime = isset($_POST['ime'])?$_POST['ime']:"";
			$prezime = isset($_POST['prezime'])?$_POST['prezime']:"";
			$username = isset($_POST['username'])?$_POST['username']:"";
			$password = isset($_POST['password'])?$_POST['password']:"";
			$adresa = isset($_POST['adresa'])?$_POST['adresa']:"";
			$mail = isset($_POST['mail'])?$_POST['mail']:"";
			$telefon = isset($_POST['telefon'])?$_POST['telefon']:"";
			$errors = isset($errors)?$errors:array();
			
			if (empty($ime)) {
				$errors['ime'] ='Morate uneti Vase ime.';
			}
			
			if (empty($prezime)) {
				$errors['prezime'] ='Morate uneti Vase prezime.';
			}
			
			if (empty($username)) {
				$errors['username'] ='Morate uneti Vas username.';
			}
			
			if (empty($password)) {
				$errors['password'] ='Morate uneti Vas password.';
			}
			
			if (empty($adresa)) {
				$errors['adresa'] ='Morate uneti Vasu adresu.';
			}
			
			if (empty($mail)) {
				$errors['mail'] ='Morate uneti Vas mail.';
			}
			
			if (empty($mail)) {
				$errors['mail'] ='Morate uneti Vas mail.';
			}
			
			if (empty($telefon)) {
				$errors['telefon'] ='Morate uneti Vas telefon.';
			}
			
			$dao = new DAO();
			$osoba=$dao->selectOsobaByUsernameAndPassword($username, $password);
			
			if (isset($username)==$osoba['username']) {
				$msg="Username vec postoji, morate da prometite username.";
				include 'registracija.php';
			} else {
				
				if (count($errors)==0) {
					$dao = new DAO();
					$dao->insertOsoba($ime, $prezime, $username, $password, $adresa, $mail, $telefon);
				} else {
					$msg="Morate popuniti sva polja korektno.";
					include 'registracija.php';
				}
				include 'login.php';
			}
		}
		
		//kupovina pojedinacnog artikkla
		public function kupi() {
			$dao = new DAO();
			$idart=isset($_GET['idart'])?$_GET['idart']:"";
			$artikal = $dao->selectArtikalById($idart);
			
			if ($artikal) {
				session_start();
				
				if (!isset($_SESSION['korpa'])) {
					$_SESSION['korpa']=array();
					$_SESSION['korpa'][]=$artikal;
					$msg="Artikal dodat u korpu";
					$artikli=$dao->selectArtikli();
					$ulogovan = unserialize($_SESSION['ulogovan']);
					$idoso = $ulogovan['idoso'];
					$dao->insertKolicina($idoso, $idart, 1);
					include 'artikli.php';
				} else {
					$key =array_search($artikal, $_SESSION['korpa']);
					
					if($key===false) {
						$_SESSION['korpa'][]=$artikal;
						$msg="Dodat je jos jedan artikal u korpu";
						$artikli=$dao->selectArtikli();
						include 'artikli.php';
						$ulogovan = unserialize($_SESSION['ulogovan']);
						$idoso = $ulogovan['idoso'];
						$dao->insertKolicina($idoso, $idart, 1);
					} else {
						$msg="Taj artikal vec imate u korpi, molimo Vas uvecajte kolicinu.";
						include 'korpa.php';
					}
				}
			} else {
				$msg ="Pogresan id";
				include 'artikli.php';
			}
		}
		
		//vracanje sa stranice korpe na stranu artikli
		public function nazad() {
			$dao=new DAO();
			$artikli=$dao->selectArtikli();
			include 'artikli.php';
		}
		
		//	
		// nakon kupovine vracamo se na mogucnost nove kupovine
		// praznimo korpu i omogucavamo novu kupovinu
		//
		public function nastaviKupovinu() {
			$dao = new DAO();
			session_start();
			if (isset($_SESSION['korpa'])) {
					$ulogovan = unserialize($_SESSION['ulogovan']);
					$idoso = $ulogovan['idoso'];
					$dao->deleteKolicinaByIdoso($idoso);
					$_SESSION['korpa']=array();
					$msg="Korpa je ispraznjena";
					$artikli=$dao->selectArtikli();
					
					$dao->deletePorudzbineByIdoso($idoso);
					include 'artikli.php';
				}
		}
		
		//prazni se korpa 
		public function isprazni() {
			$dao = new DAO();
			$isprazni = isset($_GET['isprazni'])?$_GET['isprazni']:"";
			
			if (isset($isprazni)) {
				session_start();
				
				if (isset($_SESSION['korpa'])) {
					$ulogovan = unserialize($_SESSION['ulogovan']);
					$idoso = $ulogovan['idoso'];
					$dao->deleteKolicinaByIdoso($idoso);
					$_SESSION['korpa']=array();
					$msg="Korpa je ispraznjena";
					$artikli=$dao->selectArtikli();
					include 'artikli.php';
				}
			} else {
				$msg="Pogresna akcija";
				include 'artikli.php';
			}
		}
		
		//brisanje pojedinacne stavke u korpi
		public function remove() {
			$idart=$_GET['idart'];
			session_start();
			
			if(!empty($_SESSION['korpa'])) {
				foreach ($_SESSION['korpa'] as $select =>$pom) {
					
					if($pom['idart']==$idart) {
						$dao=new DAO();
						$ulogovan = unserialize($_SESSION['ulogovan']);
						$idoso = $ulogovan['idoso'];
						$dao->deleteKolicinaByIdosoAndIdart($idoso, $idart);
						$kolicinapoidart = $dao->selectKolicinaByIdartAndIdoso($idart, $idoso);
						unset($_SESSION['korpa'][$select]);
						
					}
				}
			}
			
			include 'korpa.php';
		}
		
		//uvecavanje kolicine na plus				
		public function uvecaj() {
			$idart = isset($_GET['idart'])?$_GET['idart']:"";
			$kolicina = isset($_GET['kolicina'])?$_GET['kolicina']:"";
			$fiksnakolicina = 1;
			$dao=new DAO();
			$artikal=$dao->selectArtikalById($idart);
			session_start();
			$ulogovan=unserialize($_SESSION['ulogovan']);
			$idoso=$ulogovan['idoso'];
			$dao->insertKolicina($idoso, $idart, $fiksnakolicina);
			$kolicinapoidart = $dao->selectKolicinaByIdartAndIdoso($idart, $idoso);
			include 'korpa.php';
		}
		
		//prikaz korpe
		public function showKorpa() {
			$idart = isset($_GET['idart'])?$_GET['idart']:"";
			session_start();
			$ulogovan=unserialize($_SESSION['ulogovan']);
			$idoso=$ulogovan['idoso'];
			$dao=new DAO();
			$kolicinapoidart = $dao->selectKolicinaByIdartAndIdoso($idart, $idoso);
			include 'korpa.php';
		}
		
		//iz spiska artikala narucuje se pojedinacno i smesta se u korpu		
		public function naruci() {
			$naruci = isset($_GET['naruci'])?$_GET['naruci']:"";
			if(isset($naruci)) {
				$msg = "Proverite podatke, ukoliko je potrebno izvrsite izmenu";
				$idart = isset($_GET['idart'])?$_GET['idart']:"";
				session_start();
				$ulogovan=unserialize($_SESSION['ulogovan']);
				$idoso=$ulogovan['idoso'];
				$dao=new DAO();
				$kolicinapoidart = $dao->selectKolicinaByIdartAndIdoso($idart, $idoso);
				include 'korpa.php';
			}
		}
		
		//nakon kupovine proveravaju se licni podaci ako je potrebno da se promene
		public function poruci() {			
			session_start();
			$ulogovan=unserialize($_SESSION['ulogovan']);
			$idoso=$ulogovan['idoso'];
			$ime = isset($_GET['ime'])?$_GET['ime']:"";
			$prezime = isset($_GET['prezime'])?$_GET['prezime']:"";
			$adresa = isset($_GET['adresa'])?$_GET['adresa']:"";
			$mail = isset($_GET['mail'])?$_GET['mail']:"";
			$telefon = isset($_GET['telefon'])?$_GET['telefon']:"";
			$id_kup = isset($_GET['idkup'])?$_GET['idkup']:"";
			
			$idart = isset($_GET['idart'])?$_GET['idart']:"";
			$kolicina=isset($_GET['kolicina'])?$_GET['kolicina']:"";
			$naziv=isset($_GET['naziv'])?$_GET['naziv']:"";
			$cena=isset($_GET['cena'])?$_GET['cena']:"";
			$ukupno=isset($_GET['ukupno'])?$_GET['ukupno']:"";
			$korpa=isset($_SESSION['korpa'])?$_SESSION['korpa']:array();
			$msg = isset($msg)?$msg:"";
			$errors = isset($errors)?$errors:array();
			$brojFakture=isset($brojFakture)?$brojFakture:array();
			$broj_fakture=isset($_GET['broj_fakture'])?$_GET['broj_fakture']:"";
			
			
			
			if (empty($adresa)) {
				$errors['adresa'] = 'Morate uneti Vasu adresu!!';
			}
			
			if (empty($mail)) {
				$errors['mail'] = 'Morate uneti Vasu mail adresu!!';
			}
			
			if (empty($telefon)) {
				$errors['telefon'] = 'Morate uneti Vas telefon!!';
			}
			
			if (count($errors)==0) {
				$dao = new DAO();
				
				//odredjivanje broja fakture
				$brojFakture = $dao->selectBrojFakture();

				$broj_fakture=$brojFakture["COUNT(broj_fakture)"]+1;
				
				//unosimo podatke kupca i vremena kupovine radi dalje kontrole								
				$dao ->insertBrojFakture($broj_fakture, $idoso);
						
				$msg = "";				
				$korpa=isset($_SESSION['korpa'])?$_SESSION['korpa']:array();
				
				foreach ($korpa as $pom) {
					$id_art = $pom['idart'];
					$naziv = $pom['naziv'];
					$cena = $pom['cena'];
					$kolicinapoidart = $dao->selectKolicinaByIdartAndIdoso($id_art, $id_kup);
					
					foreach ($kolicinapoidart as $p) {
						$dao =new DAO();
						$kol=$dao->selectKolicinaByIdartAndIdoso($id_art, $id_kup);
						$kolicina=$p["SUM(kolicina)"];
						$ukupno= $kolicina*$cena;
					}
								
					$dao->upadateOsobaByIdoso($adresa, $mail, $telefon, $idoso);
					$dao->insertPorudzbine($id_kup, $id_art, $naziv, $cena, $kolicina, $ukupno, $broj_fakture);
					$dao->insertAdminPorudzbina($id_kup, $id_art, $naziv, $cena, $kolicina, $ukupno, $broj_fakture);
										
				}
				$porudzbina=$dao->selectPorudzbine();
				$dao->deleteKolicinaByIdoso($id_kup);
				include 'porudzbenica.php';
			} else {
				$msg="Morate popuniti sva polja korektno.";
				include 'korpa.php';
			}
		}
		
/*
 * ADMINISTRATORSKE METODE
 */		
		// prikaz artikala u admin okruzenju
		public function artikli() {
			$dao = new DAO();
			$artikli=$dao->selectArtikli();
			include 'adminpanel.php';
		}
		
		//prikaz strane za unos novog artikla u admin okruzenju
		public function showInsert() {
			$insert = isset($_GET['insert'])?$_GET['insert']:"";
			include 'adminpanel.php';
		}
		
		//unos novog artikla u admin okruzenju
		public function insert() {
			$naziv = isset($_GET['naziv'])?$_GET['naziv']:"";
			$cena = isset($_GET['cena'])?$_GET['cena']:"";
			
			if (empty($naziv)) {
				$errors['naziv'] = 'Morate uneti naziv artikla!!';
			}
			
			if (empty($cena)) {
				$errors['cena'] = 'Morate uneti cenu artikla!!';
			}
			
			if (count($errors)==0) {
				$dao = new DAO();
				$dao->insertArtikal($naziv, $cena);
				$artikli=$dao->selectArtikli();
				include 'adminpanel.php';
			} else {				
				$insert = isset($_GET['insert'])?$_GET['insert']:"";
				$msg="Morate popuniti sva polja korektno.";
				include 'adminpanel.php';
			}
		}
		
		//izmene podataka artikal u admin okruzenju
		public function editArtikal() {
			$editart = isset($_GET['showeditartikal'])?$_GET['showeditartikal']:"";
			$idart = isset($_GET['idart'])?$_GET['idart']:"";
			if (!empty($idart)) {
				$dao = new DAO();
				$artikal=$dao->selectArtikalById($idart);
				include 'adminpanel.php';
			} else {
				$dao = new DAO();
				$artikli=$dao->selectArtikli();
				$msg = "Nije pokupljen ID artikla.";
				include 'adminpanel.php';
			}
		}
		
		//nakon izmene vrsi izmenu u bazi za artikle  u admin okruzenju
		public function updateArtikal() {
			$naziv=isset($_GET['naziv'])?$_GET['naziv']:"";
			$cena=isset($_GET['cena'])?$_GET['cena']:"";
			$idart = isset($_GET['idart'])?$_GET['idart']:"";
			$errors =array();
			
			if (empty($naziv)) {
				$errors['naziv'] = 'Morate uneti naziv artikla!!';
			}
			
			if (empty($cena)) {
				$errors['cena'] = 'Morate uneti cenu artikla!!';
			}
			
			if (count($errors)==0) {
				$dao = new DAO();
				$dao->updateArtikalByIdart($naziv, $cena, $idart);
				$msg="Uspesno ste izmenili podatke";
				$artikli=$dao->selectArtikli();
				include 'adminpanel.php';
			} 
		}
		
		//prikaz osoba u admin okruzenju
		public function selectOsobe() {
			$dao = new DAO();
			$osobe=$dao->selectOsobe();
			include 'adminpanel.php';
		}
		
		//zahtev za promenu podataka osobe u admin okruzenju
		public function editOsoba() {
			$editoso = isset($_GET['showeditosoba'])?$_GET['showeditosoba']:"";
			$idoso = isset($_GET['idoso'])?$_GET['idoso']:"";
			if (!empty($idoso)) {
				$dao = new DAO();
				$osoba=$dao->selectOsobaByIdoso($idoso);
				include 'adminpanel.php';
			} else {
				$dao = new DAO();
				$osobe=$dao->selectOsobe();
				$msg = "Nije pokupljen ID korisnika.";
				include 'adminpanel.php';
			}
		}
		
		//izmena podataka u bazi za osobu u admin okruzenju
		public function updateOsoba() {
			$ime=isset($_GET['ime'])?$_GET['ime']:"";
			$prezime=isset($_GET['prezime'])?$_GET['prezime']:"";
			$adresa=isset($_GET['adresa'])?$_GET['adresa']:"";
			$mail=isset($_GET['mail'])?$_GET['mail']:"";
			$telefon=isset($_GET['telefon'])?$_GET['telefon']:"";
			$idoso=isset($_GET['idoso'])?$_GET['idoso']:"";
			$errors =array();
			
			if (empty($ime)) {
				$errors['ime'] = 'Morate uneti ime korisnika!!';
			}
			
			if (empty($prezime)) {
				$errors['prezime'] = 'Morate uneti prezime korisnika!!';
			}
			
			if (empty($adresa)) {
				$errors['adresa'] = 'Morate uneti adresu korisnika!!';
			}
			
			if (empty($mail)) {
				$errors['mail'] = 'Morate uneti e-mail korisnika!!';
			}
			
			if (empty($telefon)) {
				$errors['telefon'] = 'Morate uneti telefon korisnika!!';
			}
			
			if (count($errors)==0) {
				$dao = new DAO();
				$dao->updateOsobaByIdOsobe($ime, $prezime, $adresa, $mail, $telefon, $idoso);
				$msg="Uspesno ste izmenili podatke";
				$osobe=$dao->selectOsobe();
				include 'adminpanel.php';
			} 
		}
		
		//metoda za prikaz admin porudzbine
		public function showPorudzbine() {
					
			$dao = new DAO();
			$korisnik=$dao->selectOsobe();
			$dao->selectAdminPorudzbina();
			include 'adminpanel.php';
		}
		
		//metoda Isporuceno prebacuje porudzbinu u tabelu isporuceno i brise porudzbinu u admin porudzbini 
		public function insertIsporuceno() {
			$porudz = isset($_GET['porudz'])?$_GET['porudz']:array();
			$isporuceno=isset($isporuceno)?$isporuceno:array();
			$id_art = isset($_GET['id_art'])?$_GET['id_art']:"";
			$kolicina=isset($_GET['kolicina'])?$_GET['kolicina']:"";
			$naziv=isset($_GET['naziv'])?$_GET['naziv']:"";
			$cena=isset($_GET['cena'])?$_GET['cena']:"";
			$ukupno=isset($_GET['ukupno'])?$_GET['ukupno']:"";
			$broj_fakture=isset($_GET['broj_fakture'])?$_GET['broj_fakture']:"";
			$id_kup = isset($_GET['id_kup'])?$_GET['id_kup']:"";
			$idoso=$id_kup;
					
			$dao = new DAO();
			$dao->insertIsporuceno($id_kup, $id_art, $naziv, $cena, $kolicina, $ukupno, $broj_fakture);
			$dao->deleteAdminPourudzByIdKupIdArtBrojFak($id_kup, $id_art, $broj_fakture);
			$isporuceno=$dao->selectIsporuceno();
					
			include 'adminpanel.php';
		}
		
		public function showIsporuceno() {
					
			$dao = new DAO();
			$isporuceno=$dao->selectIsporuceno();
			include 'adminpanel.php';
		}
		
		public function insertOtkazano() {
			$porudz = isset($_GET['porudz'])?$_GET['porudz']:array();
			$otkazano=isset($otkazano)?$otkazano:array();
			$id_art = isset($_GET['id_art'])?$_GET['id_art']:"";
			$kolicina=isset($_GET['kolicina'])?$_GET['kolicina']:"";
			$naziv=isset($_GET['naziv'])?$_GET['naziv']:"";
			$cena=isset($_GET['cena'])?$_GET['cena']:"";
			$ukupno=isset($_GET['ukupno'])?$_GET['ukupno']:"";
			$broj_fakture=isset($_GET['broj_fakture'])?$_GET['broj_fakture']:"";
			$id_kup = isset($_GET['id_kup'])?$_GET['id_kup']:"";
			$idoso=$id_kup;
			
			$dao = new DAO();
			$dao->insertOtkazano($id_kup, $id_art, $naziv, $cena, $kolicina, $ukupno, $broj_fakture);
			$dao->deleteAdminPourudzByIdKupIdArtBrojFak($id_kup, $id_art, $broj_fakture);
			$otkazano=$dao->selectOtkazano();
			
			include 'adminpanel.php';
			
		}
		
		public function showOtkazano() {
			
			$dao = new DAO();
			$otkazano=$dao->selectOtkazano();
			
			include 'adminpanel.php';
		}
		
	}
?>
