
/**
 * Plugin multiselect para Materializecss y jQuery
 * 
 * @author 4Richi (Ricardo Valladares)
 * @version 0.1
 * 
 * @description Carga los selects marcados en base a los datos del select anterior
 * 
 * @requires jQuery
 * @required Materializecss
 * @requires Select2 @description para la busqueda dentro de los selects
 * 
 */

(function($){

    $.fn.multiselect = function(options){

        var ms = this;

        var settings = $.extend({
            amount: 2,
            labels: [],
            optionLabels: [],
            initialData: [],
            selectIds: [],
            defaultValueLabelResult: 'value',
            defaultTextLabelResult: 'text',
            sourceData: [], // required all sourcedata
            select2: false
        }, options);

        if(settings.labels.length == 0){
            for(i = 0; i < settings.amount; i++){
                settings.labels.push('MultiSelect');
            }
        }

        if(settings.optionLabels.length == 0){
            for(i = 0; i < settings.amount; i++){
                settings.optionLabels.push('Elija uno');
            }
        }

        if(settings.sourceData.length === 0 || settings.sourceData.length < (settings.amount-1)){
            console.log(new Date()+' MultiSelect: Por favor incluya todos los sourceData.');
            return false;
        }

        var container = $(`<div class="row"></div>`);

        for(i = 0; i <= (settings.amount-1); i++){
            container.append(createNewSelect({
                index: i,
                label: (settings.labels[i] !== undefined ? settings.labels[i] : settings.defaultLabel),
                optionLabel: (settings.optionLabels[i] !== undefined ? settings.optionLabels[i] : settings.defaultOptionLabel),
                initialData: (settings.initialData[i] !== undefined ? settings.initialData[i] : []),
                sourceData: (settings.sourceData[i+1] !== undefined ? settings.sourceData[i+1] : false),
                materialTable: ms,
                amount: settings.amount,
                optionLabels: settings.optionLabels,
                defaultValueLabelResult: settings.defaultValueLabelResult,
                defaultTextLabelResult: settings.defaultTextLabelResult,
                selectIds: settings.selectIds,
                select2: settings.select2
            }));
        }

        this.append(container);
        if(settings.sourceData[0] !== undefined && settings.initialData.length == 0)
            loadSimpleData(
                $(ms).find('select.select-multiselect').eq(0), 
                (settings.sourceData[0] !== undefined ? settings.sourceData[0] : false), 
                (settings.optionLabels[0] !== undefined ? settings.optionLabels[0] : defaultLabels.optionLabel),
                0,
                ms,
                settings
            );
        $('.select-multiselect').material_select();
        if(settings.select2)
            $('select.select-multiselect').select2();
        
    }

    var loadDataOnSelect = function(arraydata, select, options){
        if(arraydata.length > 0){
            $.each(arraydata, function(index, obj){
                $(select).append('<option value="'+(obj.value !== undefined ? obj.value : obj[options.defaultValueLabelResult])+'">'+(obj.text !== undefined ? obj.text : obj[options.defaultTextLabelResult])+'</option>');
            });
        }else{
            $(select).find('option:selected').attr('value', '');
            $(select).find('option:selected').text('Sin resultados');
        }
    }

    var loadSimpleData = function(select, sourceData, label, index, mt, options){
        $.ajax({
            type: 'POST',
            url: sourceData,
            success: function(data){
                var obj = JSON.parse(data);
                setLabelToSelect(select, label);
                loadDataOnSelect(obj, select, options);
                resetMaterialSelect(mt, index);
            }
        });
    }

    var callForSelectData = function(sourceData, index, mt, amount, optionLabel, optionLabels, defaultValueLabelResult, defaultTextLabelResult, select2){

        if(!sourceData)
            return false;

        var toExternalSourceData = [];
        for(j = 0; j < index+1; j++){
            toExternalSourceData.push($(mt).find('select.select-multiselect').eq(j).find(':selected').val());
        }

        resetAllSelects(index, amount-1, optionLabels, mt);
        setLabelToSelect($(mt).find('select.select-multiselect').eq(index+1), 'Cargando...');
        // console.log(toExternalSourceData);

        $.ajax({
            type: 'POST',
            url: sourceData,
            data: {
                data: JSON.stringify(toExternalSourceData)
            },
            success: function(data){
                var obj = JSON.parse(data);
                // console.log(data);
                setLabelToSelect($(mt).find('select.select-multiselect').eq(index+1), optionLabels[index+1]);
                loadDataOnSelect(obj, $(mt).find('select.select-multiselect').eq(index+1), options = {
                    defaultValueLabelResult: defaultValueLabelResult,
                    defaultTextLabelResult: defaultTextLabelResult
                });
                resetMaterialSelect(mt, index+1);
                if(select2)
                    $('select.select-multiselect').select2();
            }
        });

    }

    var resetAllSelects = function(start, end, labels, multiselect){
        for(j = end; j > start; j--){
            resetSelect(labels[j], multiselect, j);
        }
    }

    var setLabelToSelect = function(select, label){
        $(select).find('option:selected').text(label);
    }

    var resetSelect = function(label, maincontainer, index){
        $(maincontainer).find('select.select-multiselect').eq(index).material_select('destroy');
        $(maincontainer).find('select.select-multiselect').eq(index).empty();
        $(maincontainer).find('select.select-multiselect').eq(index).append('<option value="" disabled selected>'+label+'</option>');
        $(maincontainer).find('select.select-multiselect').eq(index).material_select();
    }

    var resetMaterialSelect = function(maincontainer, index){
        $(maincontainer).find('select.select-multiselect').eq(index).material_select('destroy');
        $(maincontainer).find('select.select-multiselect').eq(index).material_select();
    }

    var createNewSelect = function(config){

        var selectContainer = $(`<div class="input-field col s12" style="margin-bottom: 15px"><label class="active">`+config.label+`</label></div>`);
        var select = $(`
            <select class="select-multiselect `+(config.select2 ? 'browser-default' : '')+`"`+((config.selectIds[config.index]) !== undefined ? 'id="'+config.selectIds[config.index]+'"' : '')+`>
                <option value="" disabled selected>`+config.optionLabel+`</option>
            </select>
        `);
        loadDataOnSelect(config.initialData, select, config);
        select.on('change', function(){
            callForSelectData(
                config.sourceData,
                config.index,
                config.materialTable,
                config.amount,
                config.optionLabel,
                config.optionLabels,
                config.defaultValueLabelResult,
                config.defaultTextLabelResult,
                config.select2
            );
        });
        selectContainer.append(select);
        return selectContainer;
    }

}(jQuery))