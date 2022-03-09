<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
		<link rel="stylesheet" href="<?php echo base_url('/public/css/style2.css'); ?>">
        <title>Accueil visiteur</title>
    </head>
	
	<body>
	
		<div id="titreBox">
			<h1 class="titre">BIENVENUE VISITEUR <?php echo $_SESSION['prenom'] . " " . $_SESSION['nom']; ?></h1>
            <a href="index.php?action=deco"><p id="deco">Deconnexion</p></a>
		</div>
	
        <div id="fiche">
		
            <h2 class="titre">Veuillez selectionner un des liens ci dessous</h2>
			
			</br></br>
            <a href="index.php?action=renseigner"><p class="lien">Fiche en cours (Renseigner fiche de frais)</p></a>
            <a href="index.php?action=consulter"><p class="lien">Historique (Consulter fiche de frais)</p></a>
			
        </div>
		
    </body>
	
</html>