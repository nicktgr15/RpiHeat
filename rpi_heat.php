<?php

$command=$_GET['command'];
$db_path="/var/www/mydb/mydb.sqlite3";

switch ($command) {
    case "turn_on_heating":
       echo shell_exec('sudo ./hello 178');
    break;
	case "turn_off_everything":
       echo shell_exec('sudo ./hello 186');
    break;
	case "turn_on_water":
       echo shell_exec('sudo ./hello 186');
    break;
	case "minutes_today":
		$db = new SQLite3($db_path);
		$stmt = $db->prepare("SELECT * FROM heating WHERE time >".mktime(0, 0, 0, date("n",time()), date("j",time()), date("Y",time())));
		$result = $stmt->execute();
		$seconds_sum=0;
		$i=0;
		$lasttime=0;
		$laststate=0;
		
		while($row = $result->fetchArray(SQLITE3_ASSOC)){ 
		
			if($i==0){
				$lasttime=$row['time'];
				$laststate=$row['state'];
			} else {
		
				if($row['state']==1 && $laststate==1){
					$seconds_sum+=$row['time']-$lasttime;
				}
				
				$lasttime=$row['time'];
				$laststate=$row['state'];
			}
			$i++;
		} 
		
		echo "".number_format(($seconds_sum/60),2)."";
		
		$db->close();
		unset($db);
	break;	
	case "read_sensors":
		$db = new SQLite3($db_path);
		$stmt = $db->prepare('SELECT * FROM heating ORDER BY time DESC LIMIT 1');
		$result = $stmt->execute();
		 
		    while($row = $result->fetchArray(SQLITE3_ASSOC)){ 
		      echo $row['time']."|".$row['state']."|".number_format($row['temperature'],2)."|".number_format($row['temperature_body'],2);
		    }
		
		$db->close();
		unset($db);
	break;
	case "get_data":
		$now=time();
		$today=mktime(0, 0, 0, date("n",$now), date("j",$now), date("Y",$now));
		$last24hours=$now-86400;
		
		$db = new SQLite3($db_path);
		$stmt = $db->prepare("SELECT strftime(\"%Y-%m-%d %H:%M\",time,'unixepoch') as time,sum(temperature)/count(time) as temp from heating WHERE time >= $last24hours group by time");
		
		$result = $stmt->execute();
		$temp=array();
		while($res = $result->fetchArray(SQLITE3_ASSOC)){ 
			array_push($temp,$res);
		}
		
		echo json_encode($temp);
		
		$db->close();
		unset($db);
	break;
} 


?>