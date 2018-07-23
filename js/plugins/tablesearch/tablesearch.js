
/**
 * Plugin table search
 * para buscar beneficiarios en x cosa
 * @author Ricardo Valladares
 * @requires paginathing.js 
 * @requires materialize.css
 * @requires materialize.js
 */

(function($){

    $.fn.tablesearch = function(options){

        var settings = $.extend({
            headers: [],
            columnsAmount: 3, // max 4
            defaultHeaderText: 'Columna',
            emptyMessage: `<i class="material-icons orange-text">error</i> Tabla vacía.`,
            sourceData: '',
            pagination: true,
            paginationPerPage: 3,
            maxListElements: 50,
            noFoundMessage: 'Ningún resultado',
            buttonsOnElements: []
        },options);

        settings.columnsAmount = (settings.columnsAmount > 4 ? 4 : settings.columnsAmount);

        if(settings.sourceData == '' || !settings.sourceData){
            console.log(new Date()+'TableSearch: El parámetro sourcedata es requerido.');
            return false;
        }

        return this.each(function(){
            
            var searchElement = $(this).find('input.search');
            var clearSearchButton = searchElement.parent().find('.close').click(function(){
                searchElement.val('').blur();
            });
            var resultsContainer = $(this).find('div.results').empty();
            var headers = createHeaders(settings.headers, settings.defaultHeaderText, settings.columnsAmount);

            var emptyItem = createEmptyMessage(settings.emptyMessage);
            resultsContainer.append(emptyItem);
            resultsContainer.before(headers);

            searchElement.bind("enterKey", function(e){

                if(settings.sourceData === undefined || !settings.sourceData)
                    return false;

                resultsContainer.empty();
                if(settings.pagination)
                    removePaginator(resultsContainer);
                resultsContainer.append(createLoading());

                $.ajax({
                    type: 'POST',
                    url: settings.sourceData,
                    data: {
                        value: searchElement.val()
                    },
                    success: function(data){
                        if(data){
                            var obj = JSON.parse(data);
                            resultsContainer.empty();
                            if(obj.length > 0){
                                $.each(obj, function(index, row){
                                    if(settings.maxListElements <= index){
                                        return false;
                                    }
                                    var newElement = createElement(row, settings.columnsAmount, settings.buttonsOnElements);
                                    resultsContainer.append(newElement);
                                });
                                if(settings.pagination)
                                    resultsContainer.paginathing({
                                        perPage: settings.paginationPerPage,
                                        containerClass: 'collection-item elem',
                                        firstLast: false
                                    });
                            }else{
                                resultsContainer.append(createEmptyMessage(settings.noFoundMessage));
                            }
                            
                        }
                    },
                    error: function(data){
                        console.log(new Date()+'TableSearch: Error interno en el DataSource.');
                    }
                });
            });
            searchElement.keyup(function(e){
                if(e.keyCode == 13)
                    $(this).trigger("enterKey");
            });


        });

    }

    var removePaginator = function(resultContainer){
        $(resultContainer).next('.collection-item.elem').remove();
    }

    var createLoading = function(){
        return `
        <div class="container center-align tablesearch-preloader-container">
            <div class="preloader-wrapper active">
                <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        `;
    }

    var createHeaders = function(headers, defaultHeader, columnsAmount){

        var classes = getClassesByColumnAmount(columnsAmount);
        var header = `
        <li class="collection-item headers">
            <div class="row">
        `;

        for(var i = 0; i < columnsAmount; i++){
            header += `
                <div class="col `+classes+`">
                    <b>`+(headers[i] !== undefined ? headers[i] : defaultHeader)+`</b>
                </div>
            `;
        }

        header += `
            </div>
        </li>
        `;

        return header;

    }

    var createElement = function(data, columnsAmount, buttons){

        var classes = getClassesByColumnAmount(columnsAmount);
        var columnNames = [];

        $.each(data, function(index, value){
            columnNames.push(index);
        });

        var element = `
        <li class="collection-item elem">
            <div class="collapsible-header">
                <div class="row">
        `;

        for(i = 0; i < columnsAmount; i++){
            element += `
                    <div class="col `+classes+` truncate tablesearch-header-column">
                        `+(data[columnNames[i]] !== undefined ? data[columnNames[i]] : 'Vacío')+`
                    </div>
            `;
        }

        element += `
                </div>
            </div>
            <div class="collapsible-body">
                <div class="row">`;

        var dataLength = Object.keys(data).length;

        for(i = 0; i <= dataLength; i++){
            if(data[columnNames[i]] != null && data[columnNames[i]] != ''){
                element += `
                <div class="col s12 m6 l6">
                    <p class="no-margin">
                        <b>`+columnNames[i]+`:</b> <span id="`+columnNames[i].toLowerCase()+`">`+data[columnNames[i]]+`</span>
                    </p>
                </div>`;
            }
        }

        element += `
                </div>
                <div class="row">
                    <div class="col l12 m12 s12" id="btnsContainer">
                        <br>`;
        
        

        element += `                
                    </div>
                </div>
            </div>
        </li>
        `;

        var elm = $(element);
        $.each(buttons, function(index, btn){
            var newBtn = $(btn.button);
            newBtn.on('click', function(e){
                btn.buttonOnClick(e, elm);
                e.stopPropagation();
            });

            if(btn.buttonInColumn !==  undefined){
                elm.find('.tablesearch-header-column').eq(btn.buttonInColumn).empty().append(newBtn);
            }else{
                elm.find('#btnsContainer').append(newBtn);
            }

        });

        return elm;

    }

    var createEmptyMessage = function(message){
        return `
            <li class="collection-item empty">
                <div class="row">
                    <div class="col s12 m12 l12 valign-wrapper">
                        `+message+`
                    </div>
                </div>
            </li>
        `;
    }

    var getClassesByColumnAmount = function(val){

        if(!val || val < 0)
            return false;

        let classes = '';

        if(val > 4){
            classes = 'l3 m3 s12';
            return classes;
        }else{
            let number = (12 / val);
            classes = 'l'+number+' m'+number+' s12';
            return classes;
        }

    }

}(jQuery));