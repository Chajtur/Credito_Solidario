var contador = 0;
var room = 1;
var errornum =5;
function add_fields() {
    contador++;
    if(contador < 5){
        room++;
    errornum++;
    var objTo = document.getElementById('edu');
    var divtest = document.createElement("div");
    divtest.classList.add("row", "card-edu", "margin");
    divtest.innerHTML = '<div class="label">Familiar ' + room +':</div>'+
        '<div class="row margin">'+
            '<div class="input-field col s12 m12 l3">'+
                '<i class="material-icons prefix">person</i>'+
                '<label for="nombre_fam_edu'+room+'">Nombre del familiar</label>'+
                '<input id="nombre_fam_edu'+room+'" type="text" name="nombre_fam_edu'+room+'" class="required validate">'+
            '</div>'+
            '<div class="input-field col s12 m12 l2">'+
                '<i class="material-icons prefix">explicit</i>'+
                '<label for="edad_fam_edu'+room+'">Edad</label>'+
                '<input id="edad_fam_edu'+room+'" type="text" name="edad_fam_edu'+room+'" class="required validate">'+
            '</div>'+
            '<div class="input-field col s12 m12 l2">'+
                /*'<i class="material-icons prefix">school</i>'+*/
                '<label for="select_sexo'+room+'"></label>'+
                '<select required class="grey-text" id="select_sexo'+room+'" name="select_sexo'+room+'">'+
                    '<option value="" disabled selected>Sexo *</option>'+
                    '<option value="1">Masculino</option>'+
                    '<option value="2">Femenino</option>'+
                '</select>'+
            '</div>'+
            '<div class="input-field col s12 m12 l2">'+
                /*'<i class="material-icons prefix">school</i>'+*/
                '<label for="select_nivel_edu'+room+'"></label>'+
                '<select required class="grey-text browser-default" id="select_nivel_edu'+room+'" name="select_nivel_edu'+room+'">'+
                    '<option value="" disabled selected>N. Educación</option>'+
                    '<option value="1">Primaria</option>'+
                    '<option value="2">Secundaria</option>'+
                    '<option value="3">Superior</option>'+
                    '<option value="4">Ninguno</option>'+
                '</select>'+
            '</div>'+
            '<div class="input-field col s12 m12 l2">'+
                '<i class="material-icons prefix">work</i>'+
                '<label for="oficio_edu'+room+'">Oficio</label>'+
                '<input id="oficio_edu'+room+'" type="text" name="oficio_edu'+room+'" class="required validate">'+
            '</div>'+
        '</div>';
        objTo.appendChild(divtest);
    $('#select_nivel_edu'+room+'').material_select('update');
    $('#select_sexo'+room+'').material_select('update');
    
    
    }else{
        Materialize.toast('Ya no puedes agregar más campos', 4000);
    };
    
}