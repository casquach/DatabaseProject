<!DOCTYPE html>
<html>
<?php include "../../inc/dbinfo.inc"; ?>
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
			$("#nav-placeholder").load(baseUrl + "/nav.html", function(){
				document.getElementById("home").href = baseUrl;
				document.getElementById("nav-css").href=baseUrl + "/css/nav.css";
			});
		} 
	</script>
	<div class="row" style="margin:2.5%">
		<?php
  			$email = "cq5yc@virginia.edu";
  			$result = mysqli_query($connection, "SELECT picture FROM users WHERE email= '" . $email . "'");
  			$query_data = mysqli_fetch_row($result);
  			echo '<img src="data:image/jpeg;base64,'.base64_encode( $query_data[0] ).'"/>';
		?>
		<div class="column" style="margin:2.5%">
			<h2 id ="gameName">WHAT</h2>
			<?php
				$email = "cq5yc@virginia.edu";
				$result = mysqli_query($connection, "SELECT username FROM users WHERE email= '" . $email . "'");
				$query_data = mysqli_fetch_row($result);
				echo "@" . $query_data[0];
				echo "<p></p>";
				$result = mysqli_query($connection, "SELECT bio FROM users WHERE email= '" . $email . "'");
				$query_data = mysqli_fetch_row($result);
				echo "Bio: " . $query_data[0];
			?>
		</div>
	</div>
	<div class="row">
	<?php
		mysqli_free_result($result);
		mysqli_close($connection);
	?>
	</div>
		
</body>
</html>
