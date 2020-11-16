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
			$("#nav-placeholder").load(baseUrl + "/nav.php", function(){
				document.getElementById("home").href = baseUrl;
				document.getElementById("nav-css").href=baseUrl + "/css/nav.css";
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
				$result = mysqli_query($connection, "SELECT firstName FROM users WHERE email= '" . $email . "'");
                                $query_data = mysqli_fetch_row($result);
                                echo "<h2>" . $query_data[0] . " ";

				$result = mysqli_query($connection, "SELECT lastName FROM users WHERE email= '" . $email . "'");
                                $query_data = mysqli_fetch_row($result);
                                echo $query_data[0] . "</h2>";

				$result = mysqli_query($connection, "SELECT username FROM users WHERE email= '" . $email . "'");
				$query_data = mysqli_fetch_row($result);
				echo "@" . $query_data[0];
				echo "<p></p>";

				$result = mysqli_query($connection, "SELECT bio FROM users WHERE email= '" . $email . "'");
				$query_data = mysqli_fetch_row($result);
				echo "Bio: " . $query_data[0];
				echo "<p></p>";
				
				$result = mysqli_query($connection, "SELECT email2 FROM isFriendsWith WHERE email1 = '" . $email . "'");
								$query_data = mysqli_fetch_row($result);
                                echo "<h2>" . $query_data[0] . "</h2>";
				echo "<p></p>";

			

			?>
		
            <div id="myDiv" style="display:none;">
		<form id="mailtext" method="post">
                	<textarea name="firstName" style="width: 140px; height: 20px;">First Name</textarea>
			<textarea name="lastName" style="width: 140px; height: 20px;">Last Name</textarea>
			<textarea name="bio" style="width: 140px; height: 20px;">Bio</textarea>
			<input type="submit" name="submit" value="Edit">
            	</form>
            </div>
            <input id="myButton" type="button" value="edit" />
	    <script>
            $('#myButton').click(function() {
	      $('#myButton').toggle();
              $('#myDiv').toggle('slow', function() {
              });
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
				   echo 'Successfully saved! Please refresh';
				}
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
