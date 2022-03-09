<!DOCTYPE html>

<html>

    <head>
        <meta charset="utf-8">
		<link rel="stylesheet" href="<?php echo base_url('/public/css/style.css'); ?>">
        <title>Connexion</title>
    </head>
		
	<body>
	
		<h1>Laboratoire Galaxy Swiss Bourdin</h1>
	
		<div id="connexion">
		
			</br>
		
			<img src="<?php echo base_url('/public/images/gsb.png'); ?>" alt="img">
		
			<form method="post" action="index.php">
            
				<p>
				
					<label for="login"> Login / Identifiant :</label>
					<input type="text" name="login" id="login" maxlength="255" required>
					
					</br></br>
            
					<label for="mdp">Mot de passe :</label>
					<input type="password" name="mdp" id="mdp" maxlength="255" required>
					
					</br></br>
					
					<a><input type="submit" value="Se connecter"></a>
					
					</br></br>
				
				</p>
			
			</form>
		
        </div>
        
    </body>
	
</html>