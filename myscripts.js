
function goToGamePage(game){
	var current = window.location.href;
	var newUrl = current.substring(0,current.length-10) + 'gamePage.html?myGame=' + game;
	window.location.href = newUrl;
}