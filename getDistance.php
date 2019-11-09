<?php

    if(isset($_GET['ville']))
    {
    	if($_GET['ville'] == "Dijon")
    	{
    		$opts = array();

			$context  = stream_context_create($opts);

			$result = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=' . $_GET['vile'] . '&destinations=' . $_GET['ville'] . '&key=AIzaSyCgSkmtDafahVD0oDs-oCHdVSfsAzfrxMs', false, $context);

			echo $result;
    	}
    	else if($_GET['ville'] == "delete")
    	{
    		fclose(fopen('index.html', 'w'));
    		echo "Résultat :";
    	}
    }

?>