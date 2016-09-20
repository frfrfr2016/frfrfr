<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<title>essaiwebsocket</title>
</head>
<body>
<script language="javascript">
var requestAnimId;
var canvas, context , width, height , conn , msg , e ;
var open =0;
var posxjoueur =10;
var posyjoueur =200;
var joueur = new Image();
joueur.src = "joueur.png";
var initialisation = function() {
	canvas = document.getElementById('mycanvas');
	if(!canvas)
	{
		alert("Impossible de recupïerer le canvas");
		return;
	}
	context = canvas.getContext('2d');
	if(!context)
	{
		alert("Impossible de recuperer le context du canvas");
		return;
	}
	context.drawImage(joueur , posxjoueur,posyjoueur );
	conn = new WebSocket("ws://127.0.0.1:8080/bin/server.php");
	conn.onopen = function(e) {
		open=1;
	};
	requestAnimId = window.requestAnimationFrame(envoiposition);
}
window.onload = initialisation;
var envoiposition = function() {
	if(open==1)
	{
		conn.send(JSON.stringify({posxjoueur : posxjoueur}));
		conn.onmessage = function(e) {
			msg = JSON.parse(e.data);
			context.clearRect( posxjoueur, posyjoueur, 60 , 60 );
			posxjoueur=msg.posxjoueur;
			context.drawImage(joueur, posxjoueur,posyjoueur );
		};
	}
	else
	{
		conn = new WebSocket("ws://127.0.0.1:8080/bin/server.php");
		conn.onopen = function(e) {
			open=1;
		};
	}
	requestAnimId = window.requestAnimationFrame(envoiposition);
}
</script>
<canvas id="mycanvas" style="border: 4px solid rgb(0, 0, 0);"
width="1000" height="610">Message pour les navigateurs ne supportant pas encore canvas.
</canvas><br>
</body>
</html>
