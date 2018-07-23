$( document ).ready(function() {
    
    
    
    var form = $("#example-advanced-form").show();
    
    form.validate({
    errorElement : 'div',
        errorPlacement: function (error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
        },
    rules: {
        confirm: {
            equalTo: "#password"
        }
    }
});
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        /*enableAllSteps: true,*/
        onStepChanging: function (event, currentIndex, newIndex)
        {
            // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex)
        {
            return true;
        }
        /*// Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 && Number($("#age-2").val()) < 18)
        {
            return false;
        }*/
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex)
        {
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            alert("Submitted!");
        },
        labels: {
            previous: "Anterior",
            next: "Siguiente",
            finish: "Finalizar"
        }
    });
    
    $(".wizard .actions ul li a").addClass("waves-effect waves-indigo btn");
    $(".wizard .steps ul").addClass("tabs z-depth-1");
    $(".wizard .steps ul li").addClass("tab");
    $('ul.tabs').tabs();
    $('select').material_select();
    $('.select-wrapper.initialized').prev( "ul" ).remove();
    $('.select-wrapper.initialized').prev( "input" ).remove();
    $('.select-wrapper.initialized').prev( "span" ).remove();
    $('.collapsible').collapsible({
      accordion : true // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });
    $('select').on('change', function() {
        $(this).validate().settings.ignore = ":disabled";
            return $(this).valid();
    });
    
    var chkInfecciones = document.getElementById("chkInfecciones");
    if(chkInfecciones.checked){
        
    };
    
    $('input[name=checkboxE]').change(
    function(){
        if (this.checked) {
            var objTo = document.getElementById(this.id+'1');
        var divtest = document.createElement("div");
        divtest.classList.add("col", "s12", "l4");
            divtest.setAttribute("id", this.id+'select');
        divtest.innerHTML = 
            '<select class="browser-default grey-text">'+
                '<option value="" disabled selected>Elija un tratamiento</option>'+
                '<option value="1">Casero</option>'+
                '<option value="2">Posta Médica</option>'+
                '<option value="3">Hospital</option>'+
                '<option value="4">Médico Particular</option>'+
            '</select>';
        objTo.appendChild(divtest);
        }else {
            document.getElementById(this.id+'select').remove();
        }
    });
    
});