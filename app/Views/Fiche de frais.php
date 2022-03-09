<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
		<link rel="stylesheet" href="<?php echo base_url('/public/css/style7.css'); ?>">
        <title>Fiche de frais</title>
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
				<div class="element"><a href="index.php?action=consulter">Historique (Consulter fiche de frais)</a></div>
				<div class="element">Visiteur <?php echo $_SESSION['nom'] ?> </div>
				<div class="element"><a href="index.php?action=deco">Deconnexion</a></div>
			</nav>
		
			</br></br>
		
		</header>
		
		<section id="fiche">
            
            <h2>Fiche de frais de <?php echo $mois ?></h2>
			<p id="etat">Etat de la fiche : <?php echo $idEtat ?></p>
            <div id="visiteur">
				<p class="paragraphe">id du visiteur : <?php echo $_SESSION['id'] ?></p>
				<p class="paragraphe"><?php echo $_SESSION['nom'] ?></p>
				<p class="paragraphe">Dernière modification le : <?php echo $dateModif ?></p>
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
                            <td>Coût unitaire</td>
                            <td>1.00€</td>
                            <td>80.00€</td>
                            <td>110.00€</td>
                            <td>25.00€</td>
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
                <p class="prix"><B>Total : <?php echo $montantTotalFraisForfait = $montantKM + $montantNUI + $montantETP + $montantREP ?> €</B></p>         
            </div>
			
			</br></br>
            
            <div id="tab2">
                <h3>Ligne de frais hors forfait</h3>
                <table class="tableau-style">
                    <thead>
                        <tr>
                            <th>Date d'engagement</th>
                            <th>Libellé</th>
                            <th>Montant</th>
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
								echo '</td></tr>';

								$montantTotalFraisHF = $montantTotalFraisHF + $line->montant;
							}

						?>
                    </tbody>
                </table>
                <p class="prix"><B>Total : <?php echo  $montantTotalFraisHF ?> €</B></p>         
            </div>
            
            <p id="prixFiche"><em>Total fiche : <?php echo  $montantTotalFiche = $montantTotalFraisForfait + $montantTotalFraisHF ?> €</em></p>
            <p id="prixTotal"><em>Total validé : <?php echo $montantValide ?> €</em></p>
        </section>
    </body>
</html>