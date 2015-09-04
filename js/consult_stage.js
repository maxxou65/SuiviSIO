console.log("Script ouvert");

// instancier XMLHttpResquest
var xhr = new XMLHttpRequest();

var sio1 = document.getElementById('sio1');
var sio2 = document.getElementById('sio2');

$('.submit').css("visibility", "hidden");

sio1.onclick = function(){
	console.log("--> sio1.onchange appelé");
	testCheck();
};

sio2.onclick = function(){
	console.log("--> sio2.onchange appelé");
	testCheck();
};

xhr.onreadystatechange = function(){
	console.log("--> xhr.onreadystatechange appelé");
	var t = document.getElementById('tableaux');

	if (xhr.readyState == 4 && xhr.status == 200) {
		t.innerHTML = xhr.responseText;
	};
};


function testCheck() {
	var sio1Value = document.getElementById('sio1').checked;
	var sio2Value = document.getElementById('sio2').checked;
	console.log("valeur de SIO1 : " + sio1Value);
	console.log("valeur de SIO2 : " + sio2Value);
	if (sio1Value == true && sio2Value == true) {
		xhr.open('GET', 'tab_etu_sio.php?sio1=' + sio1Value + '&sio2=' + sio2Value);
		xhr.send();
	} else if (sio1Value == true && sio2Value == false) {
		xhr.open('GET', 'tab_etu_sio.php?sio1='+sio1Value);
		xhr.send();
	} else if (sio1Value == false && sio2Value == true) {
		xhr.open('GET', 'tab_etu_sio.php?sio2='+sio1Value);
		xhr.send();
	} else {
		xhr.open('GET', 'tab_etu_sio.php?sio1=' + sio1Value + '&sio2=' + sio2Value);
		xhr.send();
	};
  var t = document.getElementById('tableaux').innerHTML;
  t = ('<img src="../img/ajax-loader.gif" alt="Chargement">');
};

