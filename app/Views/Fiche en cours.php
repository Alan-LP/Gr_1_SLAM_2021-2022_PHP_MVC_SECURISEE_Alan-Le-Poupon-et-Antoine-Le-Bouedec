<?php

$token = bin2hex(random_bytes(32));

$_SESSION['token'] = $token;

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
		<link rel="stylesheet" href="<?php echo base_url('/public/css/style4.css'); ?>">
        <title>Fiche en cours</title>
    </head>
    
	<body>
	
		<header>
	
			<div id="titre">
				<img src="<?php echo base_url('/public/images/gsb.png')?>" alt="img">
				<h1>Laboratoire Galaxy Swiss Bourdin</h1>
			</div>
		
			<nav>
				<div class="element">Nous sommes le : <?php echo $dateJour?> </div>
				<div class="element">Fiche en cours (Renseigner fiche de frais)</div>
				<div class="element"><a href="index.php?action=consulter">Historique (Consulter fiche de frais)</a></div>
				<div class="element">Visiteur <?php echo $_SESSION['nom'] ?> </div>
				<div class="element"><a href="index.php?action=deco">Deconnexion</a></div>
			</nav>
		
			</br></br>
		
		</header>
		
		<div id="positionBlock">
		
		<section id="fraisForfait">
		
			<h3>Frais forfaitisés</h3>
				
			<form method="post" action="index.php">
				
				<p>
					
					<label for="km">Km :</label>
					<input type="number" name="km" id="km" min="0" size="10" maxlength="5" value="<?php echo $quantiteKM?>"></br>
                
					<label for="nuits">Nuits :</label>
					<input type="number" name="nuits" id="nuits" min="0" size="10" maxlength="5" value="<?php echo $quantiteNUI?>"></br>
                
					<label for="etapes">Etape :</label>
					<input type="number" name="etapes" id="etapes" min="0" size="10" maxlength="5" value="<?php echo $quantiteETP?>"></br>
                
					<label for="repas">Repas :</label>
					<input type="number" name="repas" id="repas" min="0" size="10" maxlength="5" value="<?php echo $quantiteREP?>"></br>
					
					<div id="positionBouton">

					<input type="hidden" name="token" id="token" value="<?php echo $token ?>">
				
					<input type="submit" name="modifierFraisForfait" value="Modifier">
					
					</div>
					
				</p>
					
			</form>
			
		</section>
		
		<section id="fraisHorsForfait">
		
			<h3>Frais non forfaitisés</h3>
			
			<form method="post" action="index.php">
				
				<p>
					
					<label for="date">Date d'engagement : </label>
					<input type="date" name="date" id="date" required>
					
				</br></br>
                
					<label for="libellé">Libellé :</label> <br/>
					<textarea type="text" name="libellé" id="libellé" maxlength="255" required></textarea>
					
				</br></br>
					
					<label for="montant">Montant :</label> <br/>
					<input type="number" name="montant" id="montant" min="0" size="10" maxlength="5" required>
					
				</br></br>

					<input type="hidden" name="token" id="token" value="<?php echo $token ?>">
					
					<input type="submit" name="ajouterFraisHorsForfait" value="Ajouter"></br></br>
					
				</p>
				
			</form>
			
		</section>
	
		<section id="ficheEnCours">
	
			<h2>Fiche de frais de <?php echo $dateMoisEnCours ?> </h2>
		
			<div id="visiteur">
				<p class="paragraphe">id du visiteur : <?php echo $_SESSION['id'] ?></p>
				<p class="paragraphe"><?php echo $_SESSION['nom'] ?> </p>
				<p class="paragraphe">Dernière modification le : <?php echo $dateModif ?> </p>
			</div>
                    
			<div id="tab1">
				<h3>Ligne de frais forfait</h3>
				<table class="tableau-style">
					<thead>
						<tr>
							<th>Forfait</th>
							<th>Km</th>
							<th>Nuits</th>
							<th>Etapes</th>
							<th>Repas</th>
						</tr>
					</thead>
                            
					<tbody>
						<tr>
							<td>Quantité</td>
							<td><?php echo $quantiteKM ?></td>
							<td><?php echo $quantiteNUI ?></td>
							<td><?php echo $quantiteETP ?></td>
							<td><?php echo $quantiteREP ?></td>
						</tr>
                                
						<tr>
							<td>Coût Unitaire</td>
							<td>1.00 €</td>
							<td>80.00 €</td>
							<td>110.00 €</td>
							<td>25.00 €</td>
						</tr>
                            
						<tr>
							<td>Sous total</td>
							<td><?php echo $montantKM ?> €</td>
							<td><?php echo $montantNUI ?> €</td>
							<td><?php echo $montantETP ?> €</td>
							<td><?php echo $montantREP ?> €</td>
						</tr>
					</tbody>
				</table>
			</div>
		
			<p class="prix"><B>Total : <?php echo $montantTotalFraisForfait = $montantKM + $montantNUI + $montantETP + $montantREP ?> €</B></p>
				
			</br></br>
                
			<div id="tab2">
				<h3>Ligne de frais hors forfait</h3>
				<table class="tableau-style">
					<thead>
						<tr>
							<th>Date</th>
							<th>Libellé</th>
							<th>Montant</th>
							<th>Supprimer</th>
						</tr>
					</thead>
                        
					<tbody>
						<?php

							$montantTotalFraisHF = 0;

							foreach($listFraisHF as $line){
								echo '<tr><td>';
								echo $line->date;
								echo '</td><td>';
								echo $line->libelle;
								echo '</td><td>';
								echo $line->montant;
								echo '</td>';
								echo '<td>
								<form method="post" action="index.php">
                                <input type="hidden" name="idFHF" value="'.$line->id.'" />
                                <button name="supprimerFraisHorsForfait" id="supprimer" class="croix"><img alt="X" src="<?php echo base_url(\'/public/images/croix.jpg\'); ?>"/></button>
                                </form>
								</td>
								</tr>';

								$montantTotalFraisHF = $montantTotalFraisHF + $line->montant;
							}

						?>
					</tbody>
				</table>
			</div>
					
			<p class="prix"><B>Total : <?php echo  $montantTotalFraisHF ?> €</B></p>
				
			</br></br>
                
			<p id="prixTotal"><em>Total fiche : <?php echo  $montantTotalFiche = $montantTotalFraisForfait + $montantTotalFraisHF ?> €</em></p>
		
		</section>
			
		</div>
		
	</body>
	
</html>