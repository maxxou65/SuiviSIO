$(document).ready(function()){
  console.log("Document prêt.");

  // $('.submit').css("visibility", "hidden");
  $('#choix_classe .submit').hide();
  console.log("Bouton submit caché.")

  $('#sio1').click(function(){
    console.log("--> sio1.onclick appelé");
    testCheck();
  });

  $('#sio2').click(function(){
    console.log("--> sio2.onclick appelé");
    testCheck();
  });

  function testCheck(){
    console.log("testCheck() appelé");
    
    var sio1Value = $('#sio1').is(':checked');
    console.log("valeur de SIO1 : " + sio1Value);

    var sio2Value = $('#sio2').is(':checked');
    console.log("valeur de SIO2 : " + sio2Value);

    if (sio1Value == true && sio2Value == true) {
      $.get(
        'tab_etu_sio.php',
        'sio1=' + sio1Value + '&sio2=' + sio2Value,
        function(donnee){
          $('#tableaux').html(donnee);
        }
      );
    } else if (sio1Value == true && sio2Value == false) {
      $.get(
        'tab_etu_sio.php',
        'sio1=' + sio1Value,
        function(donnee){
          $('#tableaux').html(donnee);
        }
      )
    } else if (sio1Value == false && sio2Value == true) {
      $.get(
        'tab_etu_sio.php',
        'sio2=' + sio2Value,
        function(donnee){
          $('#tableaux').html(donnee);
        }
      )
    } else {
      $.get(
        'tab_etu_sio.php',
        'sio1=' + sio1Value + '&sio2=' + sio2Value,
        function(donnee){
          $('#tableaux').html(donnee);
        }
      );
    };
  };


  $('#Supp_Etu').click(function(){
    console.log("Suppression...");

  })

});