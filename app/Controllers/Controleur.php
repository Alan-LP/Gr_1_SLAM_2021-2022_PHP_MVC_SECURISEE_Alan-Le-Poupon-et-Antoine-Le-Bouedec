<?php
//acces au controller parent pour l heritage
namespace App\Controllers;
use CodeIgniter\Controller;

//=========================================================================================
//définition d'une classe Controleur (meme nom que votre fichier Controleur.php) 
//héritée de Controller et permettant d'utiliser les raccoucis et fonctions de CodeIgniter
//Attention vos Fichiers et Classes Controleur et Modele doit commencer par une Majuscule 
//et suivre par des minuscules
//=========================================================================================
session_start();

if((isset($_COOKIE['v_pt']) && isset($_SESSION['v_pt'])) && $_COOKIE['v_pt'] == $_SESSION['v_pt'])
{
    // C'est reparti pour un tour
    $ticket=session_id().microtime().rand(0,9999999999);
    $ticket=hash('sha512', $ticket);
    $_COOKIE['v_pt']=$ticket;
    $_SESSION['v_pt']=$ticket;
}

class Controleur extends Controller {

//=====================================================================
//Fonction index correspondant au Controleur frontal (ou index.php) en MVC libre
//=====================================================================
public function index() {

	//=====================================================================
	//Code du contrôleur frontal
	//dans cette fonction se retrouve le code de votre contrôleur frontal
	//=====================================================================

	//différentes action en fonction de la page souhaité:
	//--> renvoie à une fonction précise grâce à un switch
	if(isset($_GET['action']))
    {
        switch ($_GET['action'])
        {
			case "renseigner": //cas du lien permettant de renseigner une fiche de frais du mois en cours
                $this->renseigner();
            break;

            case "consulter": //cas du lien permettant de consulter l'historique des fiches de frais
                $this->consulter();
            break;

            case "deco": // cas du lien permettant la deconnexion de l'utilisateur
                $this->deconnexion();
            break;
        }

    }
	
	//condition pour tester sa connexion 
	//--> renvoie à la fonction testconnexion du controleur
	elseif (isset($_POST['login'])) {

        // On appel le modele
		$Modele = new \App\Models\Modele();

        // On va chercher l'ip dans la fonction recupIP du controleur
		$ip = $this->recupIP();

        // On vérifie le nombre de connexion avec la fonction verifNbConnexion du modele et l'ip récupéré
        // si le nombre de connexion est inférieur à 10 on l'execute sinon on ne l'execute pas
		if ($Modele->verifNbConnexion($ip)< 10) {

        // on nous envoie à la fonction testconnexion du controleur pour vérifier la connexion du visiteur (identifiant et mot de passe)
        // dans cette fonction si l'identifiant et le mot de passe correspond alors on se connecte a la page dédié au visiteur sinon on revient sur la page de connexion
        // le htmlspecialchars permet de filtrer les caractères HTML sous format brut (plus de problème d'injection HTML et JavaScript)
        $this->testconnexion(htmlspecialchars($_POST['login']), htmlspecialchars($_POST['mdp']));
		
        //ralenti le processus d'une seconde
		sleep(1);
		}

		$cookie_name="v_pt";
		// On génère quelque chose d'aléatoire
		$ticket=session_id().microtime().rand(0,9999999999);
		// on hash pour avoir quelque chose de propre qui aura toujours la même forme
		$ticket=hash('sha512', $ticket);
		// On enregistre des deux cotés
		setcookie($cookie_name, $ticket, time()+(60*20)); 
		// Expire au bout de 20 min
		$_SESSION['v_pt']=$ticket;
	}

	//condition pour mettre a jour la ligne frais forfait ETP, KM, NUI, REP
    //--> renvoie à la fonction modifierFraisForfait du controleur
    elseif (isset($_POST['modifierFraisForfait'])) {
        

        //On verifie que tous les jetons sont là//
        if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {

            //On vérifie que les deux correspondent//
            if ($_SESSION['token'] == $_POST['token']) {
                
                $this->modifierFraisForfait();
                //Verification terminée//
                //On peut modifier le frais forfait//
            }
        }

        else {

            //Les tokens ne correspondent pas//
    
            echo "Erreur de vérification";
        }
        
    }

	//condition pour ajouter une ligne frais hors forfait
	//--> renvoie à la fonction ajouterFraisHorsForfait du controleur
    elseif (isset($_POST['ajouterFraisHorsForfait'])) {
        

        //On verifie que tous les jetons sont là//
        if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {

            //On vérifie que les deux correspondent//
            if ($_SESSION['token'] == $_POST['token']) {
                
                $this->ajouterFraisHorsForfait();
                //Verification terminée//
                //On peut ajouter un frais hors forfait//
            }
        }

        else {

            //Les tokens ne correspondent pas//
    
            echo "Erreur de vérification";
        }
        
    }

	//condition pour supprimer une ligne frais hors forfait
	//--> renvoie à la fonction supprimerFraisHorsForfait du controleur
    elseif (isset($_POST['supprimerFraisHorsForfait'])) {
                $this->supprimerFraisHorsForfait();
    }

	//condition pour voir une fiche de frais
	//--> renvoie à la fonction fichefrais du controleur
	elseif (isset($_POST['moisSelect'])) {
		$this->fichefrais();
	}

	//si aucune condition n'est effectué
	//--> renvoie à la fonction connexion
	else { $this->connexion(); }

	
		
		//=========================
		//fin du controleur frontal
		//=========================
}

public function connexion() {
	echo view('Connexion');
}

public function deconnexion() {
	session_destroy(); //on détruit la session de l'utilisateur
    echo view('Connexion'); //retour à la page connexion
}

public function renseigner() {
	$Modele = new \App\Models\Modele();

	$data['quantiteETP'] = $Modele->selectQuantiteFraisForfaitETP($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
	$data['quantiteKM'] = $Modele->selectQuantiteFraisForfaitKM($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
	$data['quantiteNUI'] = $Modele->selectQuantiteFraisForfaitNUI($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
	$data['quantiteREP'] = $Modele->selectQuantiteFraisForfaitREP($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;

	$data['montantETP'] = $data['quantiteETP'] * 110;
	$data['montantKM'] = $data['quantiteKM'] * 1;
	$data['montantNUI'] = $data['quantiteNUI'] * 80;
	$data['montantREP'] = $data['quantiteREP'] * 25;

	$data['listFraisHF'] = $Modele->selectFraisHF($_SESSION['id'], $Modele->moisTrad(date('F')));

	$data['dateModif'] = $Modele->selectDateModifMoisEnCours($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->dateModif;
	$data['dateJour'] = $Modele->today();
	$data['dateMoisEnCours'] = $Modele->moisTrad(date('F'));
		
	echo view('Fiche en cours', $data);
}

public function modifierFraisForfait() {
    $Modele = new \App\Models\Modele();

    $donnees = $Modele->updateFraisForfaitETP($_SESSION['id'], $Modele->moisTrad(date('F')), $_POST['etapes']);
	$donnees = $Modele->updateFraisForfaitKM($_SESSION['id'], $Modele->moisTrad(date('F')), $_POST['km']);
	$donnees = $Modele->updateFraisForfaitNUI($_SESSION['id'], $Modele->moisTrad(date('F')), $_POST['nuits']);
	$donnees = $Modele->updateFraisForfaitREP($_SESSION['id'], $Modele->moisTrad(date('F')), $_POST['repas']);

	$donnees = $Modele->updateDateModif($_SESSION['id'], $Modele->moisTrad(date('F')), $Modele->today());

    $data['quantiteETP'] = $Modele->selectQuantiteFraisForfaitETP($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
    $data['quantiteKM'] = $Modele->selectQuantiteFraisForfaitKM($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
    $data['quantiteNUI'] = $Modele->selectQuantiteFraisForfaitNUI($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
    $data['quantiteREP'] = $Modele->selectQuantiteFraisForfaitREP($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;

    $data['montantETP'] = $data['quantiteETP'] * 110;
    $data['montantKM'] = $data['quantiteKM'] * 1;
    $data['montantNUI'] = $data['quantiteNUI'] * 80;
    $data['montantREP'] = $data['quantiteREP'] * 25;

    $data['listFraisHF'] = $Modele->selectFraisHF($_SESSION['id'], $Modele->moisTrad(date('F')));

    $data['dateModif'] = $Modele->selectDateModifMoisEnCours($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->dateModif;
    $data['dateJour'] = $Modele->today();
    $data['dateMoisEnCours'] = $Modele->moisTrad(date('F'));

    echo view('Fiche en cours', $data);
}

public function ajouterFraisHorsForfait() {
    $Modele = new \App\Models\Modele();

    $donnees = $Modele->insertFraisHF($_SESSION['id'], $Modele->moisTrad(date('F')), $_POST['libellé'], $_POST['date'], $_POST['montant']);

	$donnees = $Modele->updateDateModif($_SESSION['id'], $Modele->moisTrad(date('F')), $Modele->today());

    $data['quantiteETP'] = $Modele->selectQuantiteFraisForfaitETP($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
    $data['quantiteKM'] = $Modele->selectQuantiteFraisForfaitKM($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
    $data['quantiteNUI'] = $Modele->selectQuantiteFraisForfaitNUI($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
    $data['quantiteREP'] = $Modele->selectQuantiteFraisForfaitREP($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;

    $data['montantETP'] = $data['quantiteETP'] * 110;
    $data['montantKM'] = $data['quantiteKM'] * 1;
    $data['montantNUI'] = $data['quantiteNUI'] * 80;
    $data['montantREP'] = $data['quantiteREP'] * 25;

    $data['listFraisHF'] = $Modele->selectFraisHF($_SESSION['id'], $Modele->moisTrad(date('F')));

    $data['dateModif'] = $Modele->selectDateModifMoisEnCours($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->dateModif;
    $data['dateJour'] = $Modele->today();
    $data['dateMoisEnCours'] = $Modele->moisTrad(date('F'));

    echo view('Fiche en cours', $data);
}

public function supprimerFraisHorsForfait() {
    $Modele = new \App\Models\Modele();

    $donnees = $Modele->deleteFraisHorsForfait($_SESSION['id'], $_POST['idFHF']);

	$donnees = $Modele->updateDateModif($_SESSION['id'], $Modele->moisTrad(date('F')), $Modele->today());

    $data['quantiteETP'] = $Modele->selectQuantiteFraisForfaitETP($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
    $data['quantiteKM'] = $Modele->selectQuantiteFraisForfaitKM($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
    $data['quantiteNUI'] = $Modele->selectQuantiteFraisForfaitNUI($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;
    $data['quantiteREP'] = $Modele->selectQuantiteFraisForfaitREP($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->quantite;

    $data['montantETP'] = $data['quantiteETP'] * 110;
    $data['montantKM'] = $data['quantiteKM'] * 1;
    $data['montantNUI'] = $data['quantiteNUI'] * 80;
    $data['montantREP'] = $data['quantiteREP'] * 25;

    $data['listFraisHF'] = $Modele->selectFraisHF($_SESSION['id'], $Modele->moisTrad(date('F')));

    $data['dateModif'] = $Modele->selectDateModifMoisEnCours($_SESSION['id'], $Modele->moisTrad(date('F')))[0]->dateModif;
    $data['dateJour'] = $Modele->today();
    $data['dateMoisEnCours'] = $Modele->moisTrad(date('F'));

    echo view('Fiche en cours', $data);
}

public function consulter() {
	$Modele = new \App\Models\Modele();

	$data['listFicheFrais'] = $Modele->selectAllFichesFrais($_SESSION['id']);

	$data['dateJour'] = $Modele->today();
	
    echo view('Historique', $data);
}

public function fichefrais() {
	$Modele = new \App\Models\Modele();

	$data['quantiteETP'] = $Modele->selectQuantiteFraisForfaitETP($_SESSION['id'], $Modele->moisTrad($_POST['mois']))[0]->quantite;
	$data['quantiteKM'] = $Modele->selectQuantiteFraisForfaitKM($_SESSION['id'], $Modele->moisTrad($_POST['mois']))[0]->quantite;
	$data['quantiteNUI'] = $Modele->selectQuantiteFraisForfaitNUI($_SESSION['id'], $Modele->moisTrad($_POST['mois']))[0]->quantite;
	$data['quantiteREP'] = $Modele->selectQuantiteFraisForfaitREP($_SESSION['id'], $Modele->moisTrad($_POST['mois']))[0]->quantite;

	$data['montantETP'] = $data['quantiteETP'] * 110;
	$data['montantKM'] = $data['quantiteKM'] * 1;
	$data['montantNUI'] = $data['quantiteNUI'] * 80;
	$data['montantREP'] = $data['quantiteREP'] * 25;

	$data['listFraisHF'] = $Modele->selectFraisHF($_SESSION['id'], $Modele->moisTrad($_POST['mois']));

	$data['mois'] = $Modele->selectFicheFrais($_SESSION['id'],$_POST['mois'])[0]->mois;
	$data['montantValide'] = $Modele->selectFicheFrais($_SESSION['id'],$_POST['mois'])[0]->montantValide;
	$data['dateModif'] = $Modele->selectFicheFrais($_SESSION['id'],$_POST['mois'])[0]->dateModif;
	$data['idEtat'] = $Modele->selectFicheFrais($_SESSION['id'],$_POST['mois'])[0]->idEtat;

	$data['dateJour'] = $Modele->today();

	echo view('Fiche de frais', $data);
}

public function testconnexion($login, $mdp) {
    
 	    $Modele = new \App\Models\Modele();
        
        // on récupère les données de la fonction login du modele (permettant d'avoir les information relatif au visiteur)
        $donnees = $Modele->login($login, $mdp);
        
        $data['resultat']=$donnees;

        // si on a l'id du visiteur
        if (!empty($donnees[0]->id)) {

            // on donne des variables de session pour l'id, le nom et le prenom du visiteur
            $_SESSION['id']=$donnees[0]->id;
            $_SESSION['nom']=$donnees[0]->nom;
            $_SESSION['prenom']=$donnees[0]->prenom;

            // si aucune fiche de frais existe alors on créer la fiche de frais avec ses différentes lignes
            if(empty($Modele->verifFicheFrais($_SESSION['id'], $Modele->moisTrad(date('F'))))) {
                $Modele->creationFicheFrais($_SESSION['id'], $Modele->moisTrad(date('F')), $Modele->today());
                $Modele->creationLigneETP($_SESSION['id'], $Modele->moisTrad(date('F')));
                $Modele->creationLigneKM($_SESSION['id'], $Modele->moisTrad(date('F')));
                $Modele->creationLigneNUI($_SESSION['id'], $Modele->moisTrad(date('F')));
                $Modele->creationLigneREP($_SESSION['id'], $Modele->moisTrad(date('F')));
            }
			
            // on affiche la page du visiteur
				echo view("Accueil visiteur");
        }
        
        // sinon on récupère l'ip (dans la fonction recupIP du controleur)
        // on ajoute une tentative de connexion echouee dans la table connexion grâce à l'ip récupéré
        // enfin on affiche la page connexion
		else {
			$ip = $this->recupIP();
			$Modele->ajoutTentativeConnexionEchouee($ip);
            echo view("Connexion");
        }
}

// fonction permettant de récupérer et de retourner l'ip
public function recupIP() {

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }

    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

//======================================================
// Code du controleur simple (ex fichier Controleur.php)
//======================================================

// Action 1 : Affiche la liste de tous les billets du blog
public function accueil() {
	    //================
		//acces au modele
		//================
		$Modele = new \App\Models\Modele();
		
	    //===============================
		//Appel d'une fonction du Modele
		//===============================	
		$donnees = $Modele->getBillets();
		
		//=================================================================================
		//!!! Création d'un jeu de données $data sécurisé pouvant etre passé à la vue
		//!!! on créé une variable qui récupère le résultat de la requete : $getBillets();
		//=================================================================================
		$data['resultat']=$donnees;
		
		//==========================================
		//on charge la vue correspondante
		//et on envoie le jeu de données $data à la vue
		//la vue aura acces a une variable $resultat
		//==========================================s
		echo view('vueAccueil',$data);
}

// Action 2 : Affiche les détails sur un billet
public function billet($idBillet) {
		//================
		//acces au modele
		//================
		$Modele = new \App\Models\Modele();
		
		//===============================
		//Appel d'une fonction du Modele
		//===============================	
		$donnees = $Modele->getDetails($idBillet);
		
		//=================================================================================
		//!!! Création d'un jeu de données $data sécurisé pouvant etre passé à la vue
		//!!! on créé une variable qui récupère le résultat de la requete : $getBillets();
		//=================================================================================
		$data['resultat']=$donnees;
  		
		//==========================================
		//on charge la vue correspondante
		//et on envoie le jeu de données $data à la vue
		//la vue aura acces a une variable $resultat
		//==========================================
  		echo view('vueBillet',$data);
  
}

// Affiche une erreur
public function erreur($msgErreur) {
  echo view('vueErreur.php', $data);
}

//==========================
//Fin du code du controleur simple
//===========================

//fin de la classe
}



?>