$(document).ready(function() {
	function cl(msg){	console.log(msg);	}
	cl("Script 'hideshow.js' ouvert");


	$('.menu_header').click(function(){
		cl("Entête de menu cliqué");

		var menu_elt = $('.menu_header ~ .menu_elt');
		for (var i = 0; i < menu_elt.length; i++) {
			menu_elt[i].hide();
		};
	});



});