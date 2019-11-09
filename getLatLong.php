<?php

	if(isset($_POST['startAddress']) && isset($_POST['endAddress']))
	{
		$opts = array();

		$context  = stream_context_create($opts);

		$result = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=' . $_POST['startAddress'] . '&destinations=' . $_POST['endAddress'] . '&key=AIzaSyCgSkmtDafahVD0oDs-oCHdVSfsAzfrxMs', false, $context);

		echo $result;
	}

?>