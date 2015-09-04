  console.log('graphique.js ouvert')
  function pie(ctx, w, h, datalist) {

    var radius = h / 2 - 5;
    var centerx = w / 2;
    var centery = h / 2;
    var total = 0;
    var colist = ['rgb(255, 87, 35)', 'rgb(255, 158, 128)'];

    for(x = 0; x < datalist.length; x++) {
      total += datalist[x];
    };

    var lastend = 0;
    var offset = Math.PI / 2;

    for(x = 0; x < datalist.length; x++) {
      var thispart = datalist[x]; 
      ctx.beginPath();
      ctx.fillStyle = colist[x];
      ctx.moveTo(centerx,centery);
      var arcsector = Math.PI * (2 * thispart / total);
      ctx.arc(centerx, centery, radius, lastend - offset, lastend + arcsector - offset, false);
      ctx.lineTo(centerx, centery);
      ctx.fill();
      ctx.closePath();
      lastend += arcsector;
    };

    // -----

    var pourcent = Math.round((datalist[0] / datalist[1]) * 100);
    ctx.font = "30px Consolas";
    ctx.fillStyle = '#FFFFFF';
    ctx.fillText(pourcent + '%', centerx - 15, centery + 10);

  };