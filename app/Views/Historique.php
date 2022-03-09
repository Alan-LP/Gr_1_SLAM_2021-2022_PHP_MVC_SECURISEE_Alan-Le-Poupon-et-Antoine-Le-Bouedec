<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
		<link rel="stylesheet" href="<?php echo base_url('/public/css/style6.css'); ?>">
        <title>Historique</title>
    </head>
    
	<body>
	
		<header>
	
			<div id="titre">
				<img src="<?php echo base_url('/public/images/gsb.png')?>" alt="img">
				<h1>Laboratoire Galaxy Swiss Bourdin</h1>
			</div>
        
			<nav>
				<div class="element">Nous sommes le : <?php echo $dateJour?></div>
				<div class="element"><a href="index.php?action=renseigner">Fiche en cours (Renseigner fiche de frais)</a></div>
				<div class="element">Historique (Consulter fiche de frais)</div>
				<div class="element">Visiteur <?php echo $_SESSION['nom'] ?></div>
				<div class="element"><a href="index.php?action=deco">Deconnexion</a></div>
			</nav>
		
			</br></br>
		
		</header>
		
		<div id="positionBlock">
		
		<section id="fiche">
            
            <h2>Historique des fiches</h2>
            <div id="tab1">
                <table class="tableau-style">
                    <thead>
                         <tr>
                            <th>Mois</th>
                            <th>Dernière modif</th>
                            <th>nbJustificatifs</th>
                            <th>Montant validé</th>
                            <th>idEtat</th>
                        </tr>
                    </thead>
                            
                    <tbody>
                        <?php 
                        
                            foreach($listFicheFrais as $line){
								echo '<tr><td>';
								echo $line->mois;
								echo '</td><td>';
								echo $line->dateModif;
								echo '</td><td>';
								echo $line->nbJustificatifs;
								echo '</td><td>';
								echo $line->montantValide;
								echo '</td><td>';
								echo $line->idEtat;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            </br></br>
        </section>
        
        <section id="fiche2">
		
            <h2>Recherche d'une fiche</h2>
			
            </br></br>
			
			<form method="post" action="index.php">
			
				<p>
			
					<label for="mois">Mois de l'année :</label>
					<select name="mois" id="mois">
						<option value="Janvier">Janvier</option>
						<option value="Fevrier">Février</option>
						<option value="Mars">Mars</option>
						<option value="Avril">Avril</option>
						<option value="Mai">Mai</option>
						<option value="Juin">Juin</option>
						<option value="Juillet">Juillet</option>
						<option value="Aout">Août</option>
						<option value="Septembre">Septembre</option>
						<option value="Octobre">Octobre</option>
						<option value="Novembre">Novembre</option>
						<option value="Decembre">Décembre</option>
					</select></br></br></br>
                
				<input type="submit" name="moisSelect" value="Voir Fiche">
				
				</p>
			</form>
        </section>
		</div>
	</body>
</html>