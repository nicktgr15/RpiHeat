
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta content='True' name='HandheldFriendly' />
		<meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
		<meta name="viewport" content="width=device-width" />
		<title>RpiHeat</title>
		<meta name="author" content="nicktgr15" />
		<script src='js/jquery.js'></script>
		<script src="http://d3js.org/d3.v3.min.js"></script>
        <script src="http://underscorejs.org/underscore-min.js"></script>
        <script src='js/js.js'></script>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
	</head>
	<body>
		<div id='logo'>RpiHeat</div>
		<a class='btn' id='open'>Turn on Heating</a>
		<a class='btn' id='openwater'>Turn on Hot Water</a>
		<a class='btn' id='close'>Turn Off</a>
		<div class='readings'>State: <div class='reading state close'></div></div>
		<div class='readings'>Temperature: <div class='reading temp'></div></div>
		<div class='readings'>Heater Temperature: <div class='reading temp2'></div></div>
		<div class='readings'>Total Time on today: <div class='reading totaltimeon'></div> min</div>
		<div id='debug'></div>
		<a class='btn' id='graphs'>Temperature Graph</a>
		<div id='version'>v0.14</div>
		
		<div id='overlay'>
			<a class='btn_small' id='close'>close</a>
			<div id="graph" class="aGraph"></div>
		</div>
	</body>
</html>

