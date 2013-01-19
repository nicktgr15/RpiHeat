<?php

	$state=trim(shell_exec('sudo /var/www/test'));
	if($state<300) $state=0; else $state=1; 
	$temp_reading=trim(shell_exec('sudo /var/www/temperature'));
	$temp=(($temp_reading*4.79)/1024)/0.01;
	$temp_reading2=trim(shell_exec('sudo /var/www/temperature_body'));
    $temp2=(($temp_reading2*4.79)/1024)/0.01;

	$db = new SQLite3('/var/www/mydb/mydb.sqlite3');
	
    $stmt = $db->prepare("INSERT INTO heating (time,state,temperature,temperature_body) VALUES (:time,:state,:temp1,:temp2 );");
    $stmt->bindParam(':time', time());
	$stmt->bindParam(':state', $state);
	$stmt->bindParam(':temp1', $temp);
	$stmt->bindParam(':temp2', $temp2);
    $stmt->execute();
?>
