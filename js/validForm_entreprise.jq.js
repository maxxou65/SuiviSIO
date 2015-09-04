/**********
 * Nom du fichier : validForm_entreprise.jq.js
 * Finalité : Ce script vérifie les données obligatoires fournies dans le formulaire d'ajout d'entreprise
 * Fichier(s) correspondant : /mod_stages/ajouter_entreprise.php
 * Auteur(s) : Anthony Lozano
 * ----------------------------
 */


 $(document).ready(function() {
 	//function console.log(msg){	console.log(msg);	}
 	console.log("Script 'validForm_entreprise.jq.js' ouvert");

 	$('form span').hide()
 	$('form span').addClass('visible');

	/* Récupération des inputs
	 * Entreprise
	 * ----------------------------
	 */

	var rs = $('input[name=NOM]'); // Raison sociale
	var rsErr = "La Raison Sociale est obligatoire";

	var ville = $('input[name=VILLE]'); //vile de l'entreprise
	var villeErr = "La ville est obligatoire";

    var me = $('input[name=MAIL_ENT]'); //mail entreprise
    var meErr = "Le mail est obligatoire";


    var inputs = [rs, ville, me];
    var errs = [rsErr, villeErr, meErr];

	/**********
	 * Vérification des données obligatoire de l'entreprise qui sont :
	 * - Raison sociale (nom)
	 * - type
	 * - ville
	 */

	 rs.blur(function(){
	 	isValid($(this), rsErr);
	 });

	 ville.blur(function(){
	 	isValid($(this), villeErr);
	 });

	 me.blur(function(){
	 	isValid($(this), meErr);
	 });

	/**********
	 * Vérification des données obligatoired e l'entreprise qui sont :
	 * - Nom
	 * - 
	 * - ville
	 */

	 function isValid(obj, messageErr){
	 	console.log("Appel de isValid()");

	 	obj.removeClass('defaut');
	 	var hint = obj.next();

	 	if (!obj.val()) {
	 		hint.html(messageErr);
	 		hint.show().removeClass('info').addClass('erreur');
	 		obj.removeClass('valide').addClass('invalide');
	 		return false;
	 	} else {
	 		hint.hide();
	 		obj.removeClass('invalide').addClass('valide');
	 		return true;
	 	}
	 }



	// Type (entreprise)
	// ----------

	// Validation du formulaire à l'envoie 
	// ----------


	$('form').submit( function(){
		var result = true;

		for (var i = 0; i <= inputs.length; i++) {
			switch(i){
				case 0:
				result = isValid(inputs[i], errs[i]) && result;
				console.log("isValid() case 1 : " + result)
				break;
				case 1:
				result = isValid(inputs[i], errs[i]) && result;
				console.log("isValid() case 2 : " + result)
				break;
				case 2:
				result = isValid(inputs[i], errs[i]) && result;
				console.log("isValid() case 3 : " + result)
				break;
			};
		};
		console.log(result);
		return result;
	});

	// Aide au choix de l'entreprise
	// ----------

	/*rs.keyup(function(){
		
		console.log("rs.keyup() appelé" + "\n" + "Valeur de l'input :" + $(this).val());
		var hint = rs.next();
		hint.html('<img src="../img/ajax-loader.gif" class="ajax-loader">');
		hint.show().removeClass('erreur').addClass('info').css('z-index', '1');

		$.ajax({
			url: 'ajax/proposer_raisonsociale.php',
			type: 'GET',
			dataType: 'html',
			data: 'NOM=' + $(this).val(),
			success : function(resultat, status){
				console.log("AJAX SUCCESS !" + "\n" + resultat)
				if (resultat != "") {
					hint.html(resultat);
				} else {
					hint.html("Aucune entreprise correspondante dans la base, créez en une !");
				}
			}})


	});*/

/*	***********
	Fontion d'aide a la recherche de type
	*********

	type.keyup(function(){
		
		console.log("type.keyup() appelé" + "\n" + "Valeur de l'input :" + $(this).val());
		var hint = type.next();
		hint.html('<img src="../img/ajax-loader.gif" class="ajax-loader">');
		hint.show().removeClass('erreur').addClass('info').css('z-index', '1');

		$.ajax({
			url: 'ajax/proposer_type.php',
			type: 'GET',
			dataType: 'html',
			data: 'TYPE=' + $(this).val(),
			success : function(resultat, status){
				console.log("AJAX SUCCESS !" + "\n" + resultat)
				if (resultat != "") {
					hint.html(resultat);
				} else {
					hint.html("Aucun type correspondant dans la base, créez en un !");
				}
			}})


});*/

});