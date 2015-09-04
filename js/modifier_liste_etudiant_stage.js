//-----------------------------------------------------------------
// L'ensemble de ces fonctions permettent de changer la liste des 
// étudiants en fonction de la classe saisie
//-----------------------------------------------------------------

	//Instancier XMLHttpRequest
	var xhr=new XMLHttpRequest();
	var sio1=document.getElementById('sio1');
	var sio2=document.getElementById('sio2');
	sio1.onchange=function(){
		testCheck();
	};
	sio2.onchange=function(){
		testCheck();
	};
	xhr.onreadystatechange=function(){
		var liste_etudiant=document.getElementById('ID_ETUDIANT');
		if(xhr.readyState==4 && xhr.status==200){
			liste_etudiant.innerHTML=xhr.responseText;
		}
	};
	// Cette fonction permet de réafficher la page avec la liste d'étudiant voulue ( sio1 ou sio2 )
	function testCheck() {
		// Les deux boutons radios ne peuvent être vrai en même temps
		var sio1Value = document.getElementById('sio1').checked;
		var sio2Value = document.getElementById('sio2').checked;
		var sio="";
		if (sio1Value == true) {
			sio="SIO1";
			xhr.open('GET','../fonctions/recharger_liste_etudiant.php?CODE_CLASSE='+sio);
			xhr.send();
		}
		if (sio2Value == true) {		
			sio="SIO2";
			xhr.open('GET','../fonctions/recharger_liste_etudiant.php?CODE_CLASSE='+sio);
			xhr.send();
		}
	};