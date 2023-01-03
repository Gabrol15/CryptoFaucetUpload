const countDown = setInterval(() => {
  if (typeof wait !== 'undefined') {
    if (wait === 0) {
      clearInterval(countDown);
      $(".next-button").html(
        '<a href="'+site_url+'faucet/currency/'+curr+'" class="btn btn-primary">Go Claim</a>'
      );
    }
    let minutes = Math.floor(wait / 60);
    let seconds = wait % 60;
    $("#minute").text(minutes);
    $("#second").text(seconds);
    wait -= 1;
  }
}, 1000);

function ah() {
  var x1 = document.getElementById("sty0");
  var y1 = document.getElementById("adm2");
    x1.style.display = "none";
    y1.style.display = "none";
}

function aha() {
  var x1 = document.getElementById("sty");
  var y1 = document.getElementById("sty2");
    x1.style.display = "none";
    y1.style = "float:right;position: absolute;top: 25px; right: 2px; padding: 0px 0px; font-size: 11px;";
}

function aha2() {
  var yx = document.getElementById("adm2");
    yx.style.display = "none";
  var xy = document.getElementById("subs");
    xy.style.display = "block";
    window.location.hash = '#subs';
            var uri = window.location.toString();
 
            if (uri.indexOf("#") > 0) {
                var clean_uri = uri.substring(0,
                                uri.indexOf("#"));
 
                window.history.replaceState({},
                        document.title, clean_uri);
            }
}

function showbutton() {
  var xx = document.getElementById("sty");
  var yy = document.getElementById("adm2");
  var sb = document.getElementById("subsub");
    xx.style = "float:right;position: absolute;top: 10px; left: 2px; padding: 0px 0px; font-size: 11px;";
    yy.style = "bottom:0px; width: 300px; height:600px; display:block;position:fixed;top: 70%;left: 50%;transform: translate(-50%, -50%);z-index:1000000;";
    sb.style = "display:none;";
}