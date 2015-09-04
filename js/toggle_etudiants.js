$(document).ready(function(){
    console.log( "ready!" );
    $('span').next().css('display','none');
});
$('span').click(function(){
    $(this).next().toggle();
});