<?php

function getRandomString($longueur = 10)
{
 return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($longueur/strlen($x)) )),1,$longueur);
}

/*if(isset($_POST['email']) && $_POST['email'] != "")
{*/
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=id8733362_vtc', 'id8733362_root', 'momosouria');
	}
	catch (Exception $e)
	{
		echo 'Error : ' . $e;
	}

	$req = $bdd->prepare('SELECT ID FROM users WHERE Email=?');
	$req->execute(array($_POST['email']));

	if(!empty($req->fetch()['ID']))
	{
		echo "Vous avez déjà bénéficié d'une réduction.";
	}
	else
	{
		$mail = $_POST['email'];
		$code = getRandomString(10);

		$req = $bdd->prepare('INSERT INTO users(Email, Code, Score) VALUES(?, ?, 0)');
		$req->execute(array($mail, $code));

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
		{
			$passage_ligne = "\r\n";
		}
		else
		{
			$passage_ligne = "\n";
		}

		//=====Déclaration des messages au format texte et au format HTML.
		$message_txt = "Votre code de réduction est : " . $code .". Veuillez pésentez de code au chauffeur lors de votre première course.";
		$message_html = "<html><head></head><body>Votre code de réduction est : ". $code .". Veuillez pésentez de code au chauffeur lors de votre première course.</body></html>";
		//==========
		 
		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//==========
		 
		//=====Définition du sujet.
		$sujet = "Réduction sur LicorneVTC";
		//=========
		 
		//=====Création du header de l'e-mail.
		$header = "From: \"LicorneVTC\"<LicorneVTC@".$_SERVER['SERVER_NAME'] .">".$passage_ligne;
		$header.= "Reply-to: \"Licor\" <LicorneVTC@".$_SERVER['SERVER_NAME'] .">".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//==========
		 
		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format HTML
		$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		//==========
		 
		//=====Envoi de l'e-mail.
		mail($mail,$sujet,$message,$header);
		//==========

		echo 'Un mail contenant le code de réduction vous a été envoyé !';
	}
/*}
else
{
	echo "Pas assez de données ou données vides.";
}*/
?>
