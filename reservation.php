<?php

	$mail = "licorne-vtc@gmail.com";

	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}

	$message_txt = "";
	$message_html = "<html><head></head><body>Ce numéro de téléphone (" . $_POST['phone'] . ") a réservé le trajet " . $_POST['start'] . " => ". $_POST['end'] . " à ". $_POST['heure'] . " le " . $_POST['date'] . " (" . $_POST['bagages'] . " bagages et " . $_POST['passagers'] . " passagers)</body></html>";
		 
	$boundary = "-----=".md5(rand());
		 
	$sujet = "Réservation LicorneVTC";
		 
	$header = "From: \"LicorneVTC\"<LicorneVTC@".$_SERVER['SERVER_NAME'] .">".$passage_ligne;
	$header.= "Reply-to: \"Licor\" <LicorneVTC@".$_SERVER['SERVER_NAME'] .">".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		 
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		 
	mail($mail,$sujet,$message,$header);

	echo 'Votre réservation a bien été prise en compte, nous vous rappelerons dans les plus bref délais!';

?>