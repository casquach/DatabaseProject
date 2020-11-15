<!DOCTYPE html>
<html>

<head>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="userPage.css">
	<link rel="stylesheet" href="" id="nav-css">
</head>
<body>

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
		<img id="gamePicture" src="" >
		<div class="column" style="margin:2.5%">
			<h2 id ="gameName">WHAT</header>
			<h3>Gamers: 69</h5>
		</div>
	</div>
	<div class="row">

	</div>
		
</body>
</html>
