var url = window.location.href;
var baseUrl = url.split("/")[0] + "//" + url.split("/")[2];

window.onload = function() {
	$("#nav-placeholder").load(baseUrl + "/nav.php", function(){
		document.getElementById("home").href = baseUrl;
        document.getElementById("user").href = 'userPage/index.php';
        document.getElementById("login").href = 'loginPage/login.php';
	});
} 

function goToGamePage(game){
	document.location = 'gamePage?myGame=' + game;
}