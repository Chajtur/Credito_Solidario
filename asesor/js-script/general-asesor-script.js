/**
 * Created by Chajtur on 8/6/2016.
 */
/* Funciones comunes entre todas las pÃ¡ginas */

function checkSession(user) {
    if (!(user == null)) {

    }
    else {
        Materialize.toast("No has iniciado ninguna sesión o la sesión ha expirado, deberís hacer Login nuevamente",4000,'',function (){location.href = "index.html";});
    }
}

function toggleDivs(name){
    $(".cuadro").hide();
    $("#" + name).show();
}

function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function recallResponsive() {
    var tableT = $('.dt-responsive').DataTable();
    
    //$( tableT.column( 2 ).header() ).addClass( 'never' );
 
    tableT.responsive.rebuild();
    tableT.responsive.recalc();
}

function logout() {
    $user = null;
    sessionStorage.setItem("user",$user);
    location.href = "../../test/consultas/index.html";
}

/*------------------------------------------------------------------------*/