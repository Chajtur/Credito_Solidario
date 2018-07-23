/*Custom JavaScript*/

// Preloader
$(window).load(function () {
    setTimeout(function () {
        $('body').addClass('loaded');
    }, 200);
});

// makes sure the whole site is loaded
jQuery(window).load(function () {
    // will first fade out the loading animation
    jQuery(".status").fadeOut();
    /*jQuery(".statusl-tb").fadeOut();*/
    // will fade out the whole DIV that covers the website.
    jQuery(".preloader").delay(1000).fadeOut("slow");
    jQuery(".preloader-tb").delay(1000).fadeOut("slow");
});

function limpiarfields() {
    $('input').val('');
    $(".close-search").hide();
    $('#search').focus();
};

function hideMenuOnClick() {
    if (window.innerWidth <= 992) {
        $('.sidebar-collapse').sideNav('hide');
    }
}

$(document).ready(function () {
    $('.collapsible-header').collapsible({
        // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
    $('.collapsible-body').collapsible({

    });

    $('.icon-collapse-search').click(function () {
        $('.search-expandida').toggleClass('expanded');
        $('.search-expandida').focus();
    });

    // chart Dropdown
    /*$('.dropdown-chart').dropdown({
      inDuration: 300,
      outDuration: 125,
      constrain_width: false, // Does not change width of dropdown to that of the activator
      hover: false, // Activate on click
      alignment: 'right', // Aligns dropdown to left or right edge (works with constrain_width)
      gutter: 0, // Spacing from edge
      belowOrigin: true // Displays dropdown below the button
    });*/

    // OBTENIENDO COOKIES PARA PERMITR MENSAJE DE BIENVENIDA Y BORRAR CACHE
    /*var visit = getCookie("cookie");
    if (visit == null) {
        alert("Bienvenidos s la Nueva Plataforma de Credito Solidario!");
        var expire = new Date();
        expire = new Date(expire.getTime() + 7776000000);
        document.cookie = "cookie=here; expires=" + expire + "; path=/";
    }*/

    var input = document.querySelector('#search');
    if (input) {
        if (input.value.length == 0) {
            $(".close-search").hide();
        }
        input.addEventListener('input', function () {
            if (input.value.length >= 1) {
                $(".close-search").show();
            }
            if (input.value.length == 0) {
                $(".close-search").hide();
            }
        });
    }
});

/*function getCookie(c_name) {
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}*/

function showBntCloseOnSearch() {
    var inputSearch = document.querySelector('#search');
    input.addEventListener('input', function () {

        if (inputSearch.value == "") {
            $('.close-search').hide();
        } else {
            $('.close-search').show();
        }
    });
}

// Activa o desactiva los collapsible de Materialize
function toggleCollapsible(param) {

    if (param == "off")
        $('.collapsible').off('click');
    if (param == "on")
        $('.collapsible').collapsible();

}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}