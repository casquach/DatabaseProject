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
		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
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
			<?php
				$gameName = $_GET['myGame'];
				$spacedName = ltrim(preg_replace('/(?<! )(?<!^)[A-Z0-9]/',' $0', $gameName));
				$query = "SELECT COUNT(*) FROM users NATURAL JOIN plays where game_name = '" . $spacedName . "'";
				if ($result = mysqli_query($connection, $query)) {
                                        $query_data = mysqli_fetch_row($result);
                                        echo "<h2>Gamers: " . $query_data[0] . "</h2>";
                                }
                                else {
                                      	echo "SAD";
                                }

				$query = "SELECT year_published, description, publisher_name FROM game NATURAL JOIN publishes WHERE game_name = '" . $spacedName . "'";
				if ($result = mysqli_query($connection, $query)) {
					$query_data = mysqli_fetch_row($result);
					echo "<h4>" . $query_data[1] . " Published in " . $query_data[0] . " by " . $query_data[2] . ".</h4>";
				}
				else {
					echo "SAD";
				}
			?>
		</div>
	</div>
	<div class="row">
		<?php
			 
		?>
	</div>
		
	<?php
		mysqli_free_result($result);
		mysqli_close($connection);
	?>
</body>
</html>
