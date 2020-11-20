<!DOCTYPE html>
<?php session_start(); 
        if(isset($_SESSION['email']))
        {
    ?>

<html>
<?php include "../../inc/dbinfo.inc"; ?>
<head>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="gamePage.css">
	<link rel="stylesheet" href="asdf" id="nav-css">
</head>
<body id="background">
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
			$("#nav-placeholder").load(baseUrl + "/nav.php", function(){
				document.getElementById("home").href = baseUrl;
				if (document.getElementById("user")){
					document.getElementById("user").href = baseUrl + "/userPage?user=" + document.getElementById("user").href.split("/")[document.getElementById("user").href.split("/").length - 1];
				}
				document.getElementById("nav-css").href = baseUrl + "/css/nav.css";
				document.getElementById("background").style = "background-image: url(" + baseUrl + "/gameBackgrounds/" + game + ".png); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;";
				var userRows = document.getElementsByClassName("userRow");
				
				var i;
				for (i = 0; i < userRows.length; i++){
					userRows[i].href = baseUrl + "/userPage?user=" + userRows[i].id;
				}
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
                                <div id="myDiv" style="display:none;">
                                        <form id="addGame" method="post">
                                                <textarea name="gameUsername" style="width: 140px; height: 20px;" placeholder="Game Username"></textarea>
                                                <textarea name="rank" style="width: 140px; height: 20px;" placeholder="Game Rank"></textarea>
                                                <input type="submit" name="submit" value="Add">
                                        </form>
                                </div>
                                <input id="myButton" type="button" value="Add To My Games" />
                                <script>
                                        $('#myButton').click(function() {
                                                $('#myButton').toggle();
                                                $('#myDiv').toggle('slow', function() {});
                                        });
                                </script>
                        <?php
				$game_name = $spacedName;
				$email = $_SESSION['email'];
				if(isset($_POST['submit'])) {
					$game_username = $_POST['gameUsername'];
                                        $rank = $_POST['rank'];

					$query_username =  "SELECT username FROM users WHERE email = '".$email."'";
					$result = mysqli_query($connection, $query_username);
					$query_data = mysqli_fetch_row($result);
					$username = $query_data[0];

					//echo "game_username: " . $game_username . ", ";
					//echo "rank: " . $rank . ", ";
					//echo "username: " . $username. ", ";
					//echo "game name: " . $game_name ." ";

	                                $stmt = mysqli_stmt_init($connection);
					$query = "INSERT INTO game_account (game_username, game_account.rank, game_name, username) VALUES (?,?,?,?)";
                                        mysqli_stmt_prepare($stmt, $query);
                                        mysqli_stmt_bind_param($stmt, "ssss", $game_username, $rank, $game_name, $username);
                                        mysqli_stmt_execute($stmt);
       	                                mysqli_stmt_close($stmt);
				}
                        ?>
		</div>
	</div>
	<div class="row">
		<table id="myTable">
			<tr>
				<th onclick="sortTable(0)">Name</th>
				<th onclick="sortTable(1)">Username</th>
				<th onclick="sortTable(2)">Rank</th>
				<th onclick="sortTable(3)">Email</th>
			</tr>
			<?php
				$query = "SELECT firstName, lastName, game_username, game_account.rank, email FROM game_account NATURAL JOIN users where game_name = '" . $spacedName . "'";
                                if ($result = mysqli_query($connection, $query)) {
                                        while ($query_data = mysqli_fetch_row($result)){
						echo "<tr>";
                                        	echo "<td><a id='" . $query_data[4] . "' class='userRow' href='asdf'>" . $query_data[0] . " " . $query_data[1] . "</td>";
						echo "<td>" . $query_data[2] . "</td>";
						echo "<td>" . $query_data[3] . "</td>";
						echo "<td>" . $query_data[4] . "</td>";
						echo "</tr>";
                                	}
				}
			?>
		</table>
	</div>
		
	<?php
		mysqli_free_result($result);
		mysqli_close($connection);
	?>
</body>
<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
</html>

<?php 
      	}
	else{
		header('Location: /loginPage/login.php');
	}
    ?>
