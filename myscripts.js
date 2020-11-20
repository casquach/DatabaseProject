var url = window.location.href;
var baseUrl = url.split("/")[0] + "//" + url.split("/")[2];

window.onload = function() {
	$("#nav-placeholder").load(baseUrl + "/nav.php", function(){
		document.getElementById("home").href = baseUrl;
		document.getElementById("user").href = baseUrl + "/userPage?user=" + document.getElementById("user").href.split("/")[document.getElementById("user").href.split("/").length - 1];
	});
} 

function goToGamePage(game){
	document.location = 'gamePage?myGame=' + game;
}
