(function(){
    
    var url = window.location.href;
    var array = url.split('/');
    var current_folder = array[array.length - 2];
    
    window.idbtnmenuactivo = $('.menu-btn-active').first().attr('id');
    $('#'+window.idbtnmenuactivo).addClass('active');
    
    $('.menu-btn').on('refresh', {
            curr_folder: current_folder
        },function(event){
            /*Materialize.toast('Refresh', 1000);*/
            var data = $(this).attr('data-change');
            $('#main-container').hide("slide", { direction: "left" }, 300, function(){
                $('#loading').show(0);
                $('#main-container').load('/csfrontend/'+event.data.curr_folder+'/'+data, function(){
                    $('#main-container').show("slide", { direction: "right" }, 300);
                    //Materialize.toast('/csfrontend/credito/'+data, 1000);
                    $('#loading').hide(0);
                });
            });
        }
    );
    
    $('.menu-btn').click(function(){

        if(window.idbtnmenuactivo != $(this).attr('id')){

            //Cambiar elemento activo en el menu
            $('#'+window.idbtnmenuactivo).removeClass('active');
            window.idbtnmenuactivo = $(this).attr('id');
            $('#'+window.idbtnmenuactivo).addClass('active');

            //Cambiar de elemento en el contenedor principal
            var data = $(this).attr('data-change');
            $('#main-container').hide("slide", { direction: "left" },300, function(){
                $('#loading').show(0);
                $('#main-container').load('/csfrontend/'+current_folder+'/'+data, function(){
                    $('#main-container').show("slide", { direction: "right" }, 300);
                    //Materialize.toast('/csfrontend/credito/'+data, 1000);
                    $('#loading').hide(0);
                });
            });

        }

    });
    
}());