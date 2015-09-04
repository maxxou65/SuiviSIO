	// On récupère les données sur les entreprises
	var query_entr = document.querySelectorAll('#ID_ENTREPRISE option'),
	// On récupère ce qui a été saisie dans le champ Entreprise
		input_entr=document.getElementById('ID_ENTREPRISE');
		input_entr.textContent="19";
function azerty(){		
	// On vérifie le nom des entreprises
	//alert(query_entr[0].innerHTML);		
	
	//alert(input_entr.textContent);
	
	//input_entr.onkeyup=function(){
	input_entr.onload=function(){
		//alert(input_entr.textContent);
		input_entr.className='correct';
		var nomValue = input_entr.value;
		var i=0;
		var valide = false;
		while(i<input_entr.length && !valide){
			alert("OK");
			if(nomValue==query_entr[0].textContent)
			{
				valide = true;
			}
			i++;
		}
		alert("OK");
		if (nomValue.length=="") {
			input_entr.className = 'correct';
			return true;
		} else {
			input_entr.className = 'incorrect';
			return false;
		}		
	}
}