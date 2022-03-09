<?php
//acces au Modele parent pour l heritage
namespace App\Models;
use CodeIgniter\Model;

//=========================================================================================
//définition d'une classe Modele (meme nom que votre fichier Modele.php) 
//héritée de Modele et permettant d'utiliser les raccoucis et fonctions de CodeIgniter
//  Attention vos Fichiers et Classes Controleur et Modele doit commencer par une Majuscule 
//  et suivre par des minuscules
//=========================================================================================
class Modele extends Model {

//==========================
// Code du modele
//==========================

//=========================================================================
// Fonction 1
// récupère les données BDD dans une fonction login
// Retourne l'id, le nom et le prenom du visiteur en fonction de ses identifiants (si il existe)
//=========================================================================
public function login($login, $mdp) { 

    //==========================================================================================
    // Connexion à la BDD en utilisant les données féninies dans le fichier app/Config/Database.php
    //==========================================================================================
	    $db = db_connect();

    //=============================
    // rédaction de la requete sql
    //=============================
        $sql = 'SELECT * FROM Visiteur WHERE login = ? AND mdp = ?';
	
    //=============================
    // execution de la requete sql
    //=============================	
        $resultat = $db->query($sql, [$login, $mdp]);

    //=============================
    // récupération des données de la requete sql
    //=============================
	    $resultat = $resultat->getResult();

    //=============================
    // renvoi du résultat au Controleur
    //=============================	
        return $resultat;
   
}

//=========================================================================
// Fonction 2
// récupère les données BDD dans une fonction verifFicheFrais
// Vérifie si une fiche de frais existe
//=========================================================================
public function verifFicheFrais($idVisiteur, $moisEnCours) {
	
    //==========================================================================================
    // Connexion à la BDD en utilisant les données féninies dans le fichier app/Config/Database.php
    //==========================================================================================
        $db = db_connect();	
	
    //=============================
    // rédaction de la requete sql 
    //=============================
	    $sql = 'SELECT * FROM FicheFrais WHERE idVisiteur = ? AND mois = ?';
	
    //=============================
    // execution de la requete sql 
    //=============================
        $resultat = $db->query($sql, [$idVisiteur, $moisEnCours]);
	
    //=============================
    // récupération des données de la requete sql
    //=============================
	    $resultat = $resultat->getResult();

    //=============================
    // renvoi du résultat au Controleur
    //=============================		
        return $resultat;
  
}

//=========================================================================
// Fonction 3
// récupère les données BDD dans une fonction selectAllFichesFrais
// Sélectionne l'entiereté des données de la table fiche frais
// en fonction de l'id du visiteur
//=========================================================================
public function selectAllFichesFrais($idVisiteur) {
	
    //==========================================================================================
    // Connexion à la BDD en utilisant les données féninies dans le fichier app/Config/Database.php
    //==========================================================================================
        $db = db_connect();	
	
    //=============================
    // rédaction de la requete sql 
    //=============================
	    $sql = 'SELECT * FROM FicheFrais WHERE idVisiteur = ?';
	
    //=============================
    // execution de la requete sql 
    //=============================
        $resultat = $db->query($sql, [$idVisiteur]);
	
    //=============================
    // récupération des données de la requete sql
    //=============================
	    $resultat = $resultat->getResult();

    //=============================
    // renvoi du résultat au Controleur
    //=============================		
        return $resultat;
  
}

//=========================================================================
// Fonction 4
// récupère les données BDD dans une fonction selectFicheFrais
// Sélectionne l'entiereté des données de la table fiche frais
// en fonction de l'id du visiteur et du mois
//=========================================================================
public function selectFicheFrais($idVisiteur, $mois) {
    
    //==========================================================================================
    // Connexion à la BDD en utilisant les données féninies dans le fichier app/Config/Database.php
    //==========================================================================================
        $db = db_connect(); 
    
    //=============================
    // rédaction de la requete sql 
    //=============================
        $sql = 'SELECT * FROM FicheFrais WHERE idVisiteur = ? AND mois = ?';
    
    //=============================
    // execution de la requete sql 
    //=============================
        $resultat = $db->query($sql, [$idVisiteur, $mois]);
    
    //=============================
    // récupération des données de la requete sql
    //=============================
        $resultat = $resultat->getResult();

    //=============================
    // renvoi du résultat au Controleur
    //=============================     
        return $resultat;
  
}

//=========================================================================
// Fonction 5
// récupère les données BDD dans une fonction creationFicheFrais
// créer une fichefrais
//=========================================================================
public function creationFicheFrais($idVisiteur, $moisEnCours, $today) {
    
    $db = db_connect();	
    $sql = 'INSERT INTO FicheFrais VALUES (?, ?, ?, ?, ?, ?)';
    $resultat = $db->query($sql, [$idVisiteur, $moisEnCours, 0, 0, $today, "CR"]);

}

//=========================================================================
// Fonction 6
// récupère les données BDD dans une fonction creationFicheFrais
// créer une ligne de frais concernant les Etapes
//=========================================================================
public function creationLigneETP($idVisiteur, $moisEnCours) {
	
    $db = db_connect();	
    $sql = 'INSERT INTO LigneFraisForfait VALUES (?, ?, ?, ?)';
    $resultat = $db->query($sql, [$idVisiteur, $moisEnCours, "ETP", 0]);
                          
}

//=========================================================================
// Fonction 7
// récupère les données BDD dans une fonction creationFicheFrais
// créer une ligne de frais concernant les Kilometres
//=========================================================================
public function creationLigneKM($idVisiteur, $moisEnCours) {
	
    $db = db_connect();	
    $sql = 'INSERT INTO LigneFraisForfait VALUES (?, ?, ?, ?)';
    $resultat = $db->query($sql, [$idVisiteur, $moisEnCours, "KM", 0]);
                          
}

//=========================================================================
// Fonction 8
// récupère les données BDD dans une fonction creationFicheFrais
// créer une ligne de frais concernant les nuits à l'hotel
//=========================================================================
public function creationLigneNUI($idVisiteur, $moisEnCours) {
	
    $db = db_connect();	
    $sql = 'INSERT INTO LigneFraisForfait VALUES (?, ?, ?, ?)';
    $resultat = $db->query($sql, [$idVisiteur, $moisEnCours, "NUI", 0]);
                          
}

//=========================================================================
// Fonction 9
// récupère les données BDD dans une fonction creationFicheFrais
// créer une ligne de frais concernant les repas
//=========================================================================
public function creationLigneREP($idVisiteur, $moisEnCours) {
	
    $db = db_connect();	
    $sql = 'INSERT INTO LigneFraisForfait VALUES (?, ?, ?, ?)';
    $resultat = $db->query($sql, [$idVisiteur, $moisEnCours, "REP", 0]);
                          
}

//=========================================================================
// Fonction 10
// récupère les données BDD dans une fonction updateFraisForfaitETP
// modifie la quantite d'une ligne de frais concernant les Etapes
//=========================================================================
public function updateFraisForfaitETP($idVisiteur, $moisEnCours, $quantiteETP) {
	
    $db = db_connect();	
    $sql = 'UPDATE LigneFraisForfait SET quantite = ? WHERE idVisiteur = ? AND mois = ? AND idFraisForfait = "ETP" ';
    $resultat = $db->query($sql, [$quantiteETP, $idVisiteur, $moisEnCours]);    

}

//=========================================================================
// Fonction 11
// récupère les données BDD dans une fonction updateFraisForfaitKM
// modifie la quantite d'une ligne de frais concernant les Kilometres
//=========================================================================
public function updateFraisForfaitKM($idVisiteur, $moisEnCours, $quantiteKM) {
	
    $db = db_connect();	
    $sql = 'UPDATE LigneFraisForfait SET quantite = ? WHERE idVisiteur = ? AND mois = ? AND idFraisForfait = "KM" ';
    $resultat = $db->query($sql, [$quantiteKM, $idVisiteur, $moisEnCours]);   

}

//=========================================================================
// Fonction 12
// récupère les données BDD dans une fonction updateFraisForfaitNUI
// modifie la quantite d'une ligne de frais concernant les nuits à l'hotel
//=========================================================================
public function updateFraisForfaitNUI($idVisiteur, $moisEnCours, $quantiteNUI) {
	
    $db = db_connect();	
    $sql = 'UPDATE LigneFraisForfait SET quantite = ? WHERE idVisiteur = ? AND mois = ? AND idFraisForfait = "NUI" ';
    $resultat = $db->query($sql, [$quantiteNUI, $idVisiteur, $moisEnCours]);       

}

//=========================================================================
// Fonction 13
// récupère les données BDD dans une fonction updateFraisForfaitREP
// modifie la quantite d'une ligne de frais concernant les repas
//=========================================================================
public function updateFraisForfaitREP($idVisiteur, $moisEnCours, $quantiteREP) {
	
    $db = db_connect();	
    $sql = 'UPDATE LigneFraisForfait SET quantite = ? WHERE idVisiteur = ? AND mois = ? AND idFraisForfait = "REP" ';
    $resultat = $db->query($sql, [$quantiteREP, $idVisiteur, $moisEnCours]);                       

}

//=========================================================================
// Fonction 14
// récupère les données BDD dans une fonction selectQuantiteFraisForfaitETP
// sélectionne la quantite d'une ligne de frais concernant les Etapes
//=========================================================================
public function selectQuantiteFraisForfaitETP($idVisiteur, $mois) {
	
    $db = db_connect();	
    $sql = 'SELECT quantite FROM LigneFraisForfait WHERE idVisiteur = ? AND idFraisForfait = "ETP" AND mois = ?';                      
    $resultat = $db->query($sql, [$idVisiteur, $mois]);
    $resultat = $resultat->getResult();
    return $resultat;                       

}

//=========================================================================
// Fonction 15
// récupère les données BDD dans une fonction selectQuantiteFraisForfaitKM
// sélectionne la quantite d'une ligne de frais concernant les Kilometres
//=========================================================================
public function selectQuantiteFraisForfaitKM($idVisiteur, $mois) {
	
    $db = db_connect();	
    $sql = 'SELECT quantite FROM LigneFraisForfait WHERE idVisiteur = ? AND idFraisForfait = "KM" AND mois = ?';                      
    $resultat = $db->query($sql, [$idVisiteur, $mois]);
    $resultat = $resultat->getResult();
    return $resultat;    
                            
}

//=========================================================================
// Fonction 16
// récupère les données BDD dans une fonction selectQuantiteFraisForfaitNUI
// sélectionne la quantite d'une ligne de frais concernant les nuits à l'hotel
//=========================================================================
public function selectQuantiteFraisForfaitNUI($idVisiteur, $mois) {
	
    $db = db_connect();	
    $sql = 'SELECT quantite FROM LigneFraisForfait WHERE idVisiteur = ? AND idFraisForfait = "NUI" AND mois = ?';                      
    $resultat = $db->query($sql, [$idVisiteur, $mois]);
    $resultat = $resultat->getResult();
    return $resultat;    

}

//=========================================================================
// Fonction 17
// récupère les données BDD dans une fonction selectQuantiteFraisForfaitREP
// sélectionne la quantite d'une ligne de frais concernant les repas
//=========================================================================
public function selectQuantiteFraisForfaitREP($idVisiteur, $mois) {
	
    $db = db_connect();	
    $sql = 'SELECT quantite FROM LigneFraisForfait WHERE idVisiteur = ? AND idFraisForfait = "REP" AND mois = ?';                      
    $resultat = $db->query($sql, [$idVisiteur, $mois]);
    $resultat = $resultat->getResult();
    return $resultat;    

}

//=========================================================================
// Fonction 18
// récupère les données BDD dans une fonction insertFraisHF
// créer une ligne de frais Hors Forfait en fonction des informations entrées
//=========================================================================
public function insertFraisHF($idVisiteur, $moisEnCours, $libelle, $date, $montant) {
	
    $db = db_connect();	
    $sql = 'INSERT INTO LigneFraisHorsForfait (idVisiteur, mois, libelle, date, montant) VALUES (?, ?, ?, ?, ?)';
    $db->query($sql, [$idVisiteur, $moisEnCours, $libelle, $date, $montant]);

}

//=========================================================================
// Fonction 19
// récupère les données BDD dans une fonction selectFraisHF
// sélectionne toute la table LigneFraisHorsForfait en fonction de 
// l'id du visiteur et du mois
//=========================================================================
public function selectFraisHF($idVisiteur, $mois) {
	
    $db = db_connect();	
    $sql = 'SELECT * FROM LigneFraisHorsForfait WHERE idVisiteur = ? AND mois = ?';                      
    $resultat = $db->query($sql, [$idVisiteur, $mois]);
    $resultat = $resultat->getResult();
    return $resultat;    

}

//=========================================================================
// Fonction 20
// récupère les données BDD dans une fonction deleteFraisHorsForfait
// supprime une ligne de frais hors forfait en fonction de l'id du visiteur 
// et de la ligne frais hors forfait
//=========================================================================
public function deleteFraisHorsForfait($id, $frais_hors_fortfait_id){
    $sql = 'SELECT idVisiteur FROM LigneFraisHorsForfait WHERE id=?';
    $result = $this->db->query($sql, [$frais_hors_fortfait_id]);
    $result = $result->getResult();

    if($result){
        if($id == $result[0]->idVisiteur){
            $sql = 'DELETE FROM LigneFraisHorsForfait WHERE id=?';
            $this->db->query($sql, [$frais_hors_fortfait_id]);
        }
    }
}

//=========================================================================
// Fonction 21
// récupère les données BDD dans une fonction updateDateModif
// modifie la date de modification du mois en cours
//=========================================================================
public function updateDateModif($idVisiteur, $moisEnCours, $today) {
	
    $db = db_connect();	
    $sql = 'UPDATE FicheFrais SET dateModif = ? WHERE idVisiteur = ? AND mois = ?';
    $resultat = $db->query($sql, [$today, $idVisiteur, $moisEnCours]);    

}

//=========================================================================
// Fonction 22
// récupère les données BDD dans une fonction selectFraisHF
// sélectionne la date de modification du mois en cours
//=========================================================================
public function selectDateModifMoisEnCours($idVisiteur, $moisEnCours) {
	
    $db = db_connect();	
    $sql = 'SELECT dateModif FROM FicheFrais WHERE idVisiteur = ? AND mois = ?';                      
    $resultat = $db->query($sql, [$idVisiteur, $moisEnCours]);
    $resultat = $resultat->getResult();
    return $resultat;    

}

//=========================================================================
// Fonction 23
// récupère les données BDD dans une fonction moisTrad
// retourne le mois traduit
//=========================================================================
public function moisTrad($datefr) {

    switch ($datefr) {
         case 'January':
         $datefr = "Janvier";
        break;
         case 'February':
         $datefr = "Fevrier";
        break;
         case 'March':
         $datefr = 'Mars';
        break;
         case 'April':
         $datefr = "Avril";
        break;
         case 'May':
         $datefr = "Mai";
        break;
         case 'June':
         $datefr = 'Juin';
        break;
         case 'July':
         $datefr = 'Juillet';
        break;
         case 'August':
         $datefr = "Aout";
        break;
         case 'September':
         $datefr = 'Septembre';
        break;
         case 'October':
         $datefr = 'Octobre';
        break;
         case 'November':
         $datefr = 'Novembre';
        break;
         case 'December':
         $datefr = 'Decembre';
        break;
    }

    return $datefr;
}

//=========================================================================
// Fonction 24
// récupère les données BDD dans une fonction moisTrad
// retourne la date d'aujourd'hui
//=========================================================================
public function today() {
    return date('Y-m-d');
}

// FONCTIONS POUR SÉCURISÉ LA FAILLE PAR BRUTE FORCE

//=========================================================================
// Fonction 25
// récupère les données BDD dans une fonction verifNbConnexion
// vérifie le nombre de connexion concernant l'ip dans la table connexion et retourne une valeur
//=========================================================================
public function verifNbConnexion($ip) {

    $db = db_connect();
    $sql = 'SELECT * FROM connexion WHERE ip = ?';
    $resultat = $db->query($sql, [$ip]);
    $resultat = $resultat->getResult();
    $count = sizeof($resultat);

    return $count;

}

//=========================================================================
// Fonction 26
// récupère les données BDD dans une fonction ajoutTentativeConnexionEchouee
// ajout d'une tentative de connexion echouee dans la table connexion
//=========================================================================
public function ajoutTentativeConnexionEchouee($ip) {

    $db = db_connect();
    $sql = 'INSERT INTO connexion VALUES (?)';
    $db->query($sql, [$ip]);

}

//==========================
// Fin Code du modele
//===========================


//fin de la classe
}


?>