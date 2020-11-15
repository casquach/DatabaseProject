<!DOCTYPE html>
<html>
<?php include "../../inc/dbinfo.inc"; ?>
<head>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="gamePage.css">
	<link rel="stylesheet" href="" id="nav-css">
</head>
<body>
	<?php
		/* Connect to MySQL and select the database. */
		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

		if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
		$database = mysqli_select_db($connection, DB_DATABASE);
	?>

	<div id="nav-placeholder">

	</div>

	<script type="text/javascript">
		var url = window.location.href;
		var game = url.substring(url.indexOf("myGame=")+7);

		var spacedGame = "";
		for (let i = 0; i < game.length; i++){
			if (game.charAt(i) == game.charAt(i).toUpperCase()){
				spacedGame += " ";
			}
			spacedGame += game.charAt(i);
		}

		var baseUrl = url.split("/")[0] + "//" + url.split("/")[2]
		window.onload = function() {
			document.getElementById("gamePicture").src= baseUrl + "/gameImages/" + game + ".jpg";
			$("#nav-placeholder").load(baseUrl + "/nav.html", function(){
				document.getElementById("home").href = baseUrl;
				document.getElementById("nav-css").href=baseUrl + "/css/nav.css";
			});
			document.getElementById("gameName").textContent = spacedGame;
		} 
	</script>
	<div class="row" style="margin:2.5%">
		<img id="gamePicture" src="" >
		<div class="column" style="margin:2.5%">
			<h2 id ="gameName">WHAT</header>
			<h3>Gamers: 69</h5>
			<?php
				$gameName = $_GET['myGame'];
				$spacedName = ltrim(preg_replace('/(?<! )(?<!^)[A-Z0-9]/',' $0', $gameName));
				$result = mysqli_query($connection, "SELECT * FROM game NATURAL JOIN hasGenres WHERE game_name=",$spacedName);
				$query_data = mysqli_fetch_row($result);
				echo "SELECT * FROM game NATURAL JOIN hasGenres WHERE game_name=".$spacedName;
				echo $query_data[0];
				echo $query_data[1];
				echo $query_data[2];
			?>
		</div>
	</div>
	<div class="row">

	</div>
		
	<?php
		mysqli_free_result($result);
		mysqli_close($connection);
	?>
</body>
</html>
