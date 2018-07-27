<?php
/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */

	require_once '../controller/Controller.php';
	
	
	$controller = new Controller();
	
	
	if($_SERVER['REQUEST_METHOD']==='POST') {
		$page=$_POST['page'];
		switch ($page) {
			case 'login':
				$controller->login();
				break;
				
			case 'registracija':
				$controller->registracija();
				break;
		}
	} else {
		$page=$_GET['page'];
		switch ($page) {
			case 'logout':
				$controller->logout();
				break;
				
			case 'showregist':
				$controller->showRegist();
				break;
				
			case 'korpa':
				$controller->kupi();
				break;
				
			case 'nazad':
				$controller->nazad();
				break;
				
			case 'isprazni':
				$controller->isprazni();
				break;
				
			case 'remove':
				$controller->remove();
				break;
				
			case '+':
				$controller->uvecaj();
				break;
				
			case 'showkorpa':
				$controller->showKorpa();
				break;
				
			case 'naruci':
				$controller->naruci();
				break;
				
			case 'potvrdi/poruci':
				$controller->poruci();
				break;

			case 'artikliKupca':
				$controller->nastaviKupovinu();
				break;
				
			case 'artikli':
				$controller->artikli();
				break;
				
			case 'insert':
				$controller->showInsert();
				break;
				
			case 'snimi artikal':
				$controller->insert();
				break;
				
			case 'showeditartikal':
				$controller->editArtikal();
				break;
				
			case 'promeni artikal':
				$controller->updateArtikal();
				break;
				
			case 'osobe':
				$controller->selectOsobe();
				break;
				
			case 'showeditosoba':
				$controller->editOsoba();
				break;
				
			case 'promeni korisnika':
				$controller->updateOsoba();
				break;
				
			case 'porudzbina':
				$controller->showPorudzbine();
				break;
				
			case 'isporuceno':
				$controller->insertIsporuceno();
				break;
				
			case 'otkazano':
				$controller->insertOtkazano();
				break;
				
			case 'showisporuceno':
				$controller->showIsporuceno();
				break;
				
			case 'showotkazano':
				$controller->showOtkazano();
				break;
				
				
		}
	}
?>
