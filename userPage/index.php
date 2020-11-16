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
			<?php
				$email = "cq5yc@virginia.edu";
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
<!--
			<form id="mailtext" method="post">
                <input type="submit" name="submit" value="Edit">
            </form>
-->
            <div id="myDiv" style="display:none;">
                WELCOME
            
            </div>
            <input id="myButton" type="button" name="edit" />
            $('#myButton').click(function() {
              $('#myDiv').toggle('slow', function() {
                // Animation complete.
              });
            });
            
			<?php
				if(isset($_POST['submit'])) {
				   $query2 = "UPDATE mailtext SET text=? WHERE id=1";
				   $stmt = mysqli_prepare($connection, $query2);
				   mysqli_stmt_bind_param($stmt, "s", $text);
				   mysqli_stmt_execute($stmt);
				   echo 'Successfully saved!';
				}

				$query = "SELECT text FROM mailtext";
				$result = mysqli_query($connection, $query);

				while($row = mysqli_fetch_assoc($result))
				{
				    $text = iconv('iso-8859-2', 'utf-8', $row['text']);
				    echo'
					<center>
						<form id="mailtext" method="post">
    							<textarea name="text" style="width: 500px; height: 300px;">'.$text.'</textarea>
        						<input type="submit" name="submit" value="Save">
    						</form>
					</center>
					';
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
