<!DOCTYPE html>
<html>
<?php include "../../inc/dbinfo.inc";
session_start(); ?>
<head>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="userPage.css">
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

		var baseUrl = url.split("/")[0] + "//" + url.split("/")[2]
		window.onload = function() {
			$("#nav-placeholder").load(baseUrl + "/nav.php", function(){
				document.getElementById("home").href = baseUrl;
				document.getElementById("nav-css").href=baseUrl + "/css/nav.css";
				document.getElementById("user").href = baseUrl + "/userPage?user=" + document.getElementById("user").href.split("/")[document.getElementById("user").href.split("/").length - 1];
			});
		} 
	</script>
	<div class="row" style="margin:2.5%">
		<?php
  			$email = $_GET["user"];
  			$result = mysqli_query($connection, "SELECT picture FROM users WHERE email= '" . $email . "'");
  			$query_data = mysqli_fetch_row($result);
  			echo '<img src="data:image/jpeg;base64,'.base64_encode( $query_data[0] ).'"/>';
		?>
		<div class="column" style="margin:2.5%">
			<?php
				$result = mysqli_query($connection, "SELECT firstName, lastName, username, bio FROM users WHERE email= '" . $email . "'");
                $query_data = mysqli_fetch_row($result);
                echo "<h2>" . $query_data[0] . " ";
				echo $query_data[1] . "</h2>";
				$username = $query_data[2];
				echo "@" . $query_data[2];
				echo "<p></p>";
				echo "Bio: " . $query_data[3];
				echo "<p></p>";
				echo "Friends Table";

			?>
			<table id="friendsTable">
				<?php
					$query = "SELECT email2 FROM isFriendsWith WHERE email1 = '" . $email . "'";
					if ($result = mysqli_query($connection, $query)) {
							while ($query_data = mysqli_fetch_row($result)){
							echo "<tr>";
							echo "<td>" . $query_data[0] . "</td>";
							echo "</tr>";
						}
					}
				?>
			</table>
			<?php if ($email == $_SESSION['email']) { ?>
				<div id="myDiv" style="display:none;">
					<form id="mailtext" method="post">
						<textarea name="firstName" style="width: 140px; height: 20px;" placeholder="First Name"></textarea>
						<textarea name="lastName" style="width: 140px; height: 20px;" placeholder="Last Name"></textarea>
						<textarea name="bio" style="width: 140px; height: 20px;" placeholder="Bio"></textarea>
						<input type="submit" name="submit" value="Submit">
					</form>
				</div>
				<input id="myButton" type="button" value="Edit" />
				<script>
					$('#myButton').click(function() {
						$('#myButton').toggle();
						$('#myDiv').toggle('slow', function() {});
					});
				</script>
				<?php
					$stmt = mysqli_stmt_init($connection);
					if(isset($_POST['submit'])) {
						$firstName = $_POST['firstName'];
						$lastName = $_POST['lastName'];
						$bio = $_POST['bio'];
						$query = "UPDATE users SET firstName=?, lastName=?, bio=?  WHERE email= '" . $email . "'";
							mysqli_stmt_prepare($stmt, $query);
							mysqli_stmt_bind_param($stmt, "sss", $firstName, $lastName, $bio);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
						echo "Successfully saved!";
						echo "<meta http-equiv='refresh' content='0'>";
					}
				?>
			<?php } ?>
		</div>
	</div>
	<div class="row" style="margin:2.5%">
	<table id="myTable">
		<tr id="myTable">
			<th onclick="sortTable(0)" id="myTable">Game</th>
			<th onclick="sortTable(1)" id="myTable">Username</th>
			<th onclick="sortTable(2)" id="myTable">Rank</th>
			<?php if ($email == $_SESSION['email']) { ?>
				<th id='myTable'>Delete Game</th>;
                       	<?php } ?>
		</tr>
		<?php
			$query = "SELECT game_name, game_username, game_account.rank FROM game_account where username = '" . $username . "'";
			if ($result = mysqli_query($connection, $query)) {
				while ($query_data = mysqli_fetch_row($result)){
					$game_name = $query_data[0];
					$favquery = "SELECT * FROM favorites WHERE username = '$_SESSION['email']' AND game_name = '$game_name'";
					if($favresult = mysqli_query($connection, $favquery)){
						if(mysqli_num_rows($favresult) > 0){
							$game_name = $game_name + " (favorite)";
						}
					}
					echo "<tr id='myTable'>";
					echo "<td id='myTable'>" . $game_name . "</td>";
					echo "<td id='myTable'>" . $query_data[1] . "</td>";
					echo "<td id='myTable'>" . $query_data[2] . "</td>";
					if ($email == $_SESSION['email']) {
                                                echo "<td><input type='button' value='Delete' onclick='deleteRow(this)'/></td>";
                                        }
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
</html>
<script>
function deleteRow(btn) {
  var row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}

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
