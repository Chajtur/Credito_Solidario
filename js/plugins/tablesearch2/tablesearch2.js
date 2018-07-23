/**
 * Tablesearch 2
 * Basado en el diseño de las colecciones de materialize
 * @author Ricardo Valladares (Rychiv4)
 * @requires jQuery
 * @requires materialize.css
 * @requires materialize.js
 * @requires paginathing.js para el paginador
 * @requires tinysort.js para ordenar
 * Documentacion: http://creditosolidario.hn/csfrontend/pruebas/tablesearch2.php
 */


(function($){

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    var Tablesearch = function(elem, options){

        this.elem = elem;
        this.options = options;

        this.title = this.genTitle();
        this.search = this.genSearch();
        if(this.options.filters){
            this.filters = this.genFiltersContainer();
        }
        this.header = this.genHeader();
        this.container = this.genContainer();

        this.init();
        this.render();

    };

    Tablesearch.prototype = {
        init: function(){
            $(this.elem).addClass('tablesearch2');
            $(this.elem).empty();
            if(this.options.initialRequest){
                this.initialRequest();
            }
        },
        render: function(){
            $(this.elem).append(this.title);
            if(this.options.searchable){
                $(this.elem).append(this.search);
            }
            if(this.options.filters){
                $(this.elem).append(this.filters);
                this.toggleFilters();
            }
            $(this.elem).append(this.header);
            $(this.elem).append(this.container);
            if(typeof this.options.initialMessage == 'string'){
                this.container.append(this.genInitialMessageElement());
            }
        },
        genTitle: function(){
            var self = this;
            var li = $('<li class="collection-item"></li>');
            var span = $('<span class="title"></span>');
            span.text(this.options.title);
            if(this.options.reloadButton){
                var rbutton = $('<a class="waves-effect waves-teal btn-flat right"></a>');
                rbutton.click(function(){
                    self.reloadTable();
                });
                rbutton.html(this.options.reloadButtonText);
                span.append(rbutton);
            }
            if(this.options.filters){
                var filterButton = $('<a class="waves-effect waves-teal btn-flat right"><i class="material-icons">filter_list</i></a>');
                filterButton.click(function(){
                    self.toggleFilters();
                });
                span.append(filterButton);
            }
            return li.append(span);
        },
        genSearch: function(){
            var self = this;
            var li = $('<li class="collection-item with-actions"></li>');
            var inputfield = $('<div class="input-field"></div>');
            var input = $('<input id="search" type="search" class="validate search">');
            input.attr('placeholder', self.options.searchPlaceholder);
            input.on('keyup', function(e){
                if(e.keyCode == 13){
                    $(this).trigger("enterKey");
                    self.searchOnSource($(this).val());
                }
            });
            var closeicon = $('<i class="material-icons close">close</i>');
            closeicon.click(function(){
                input.val('').blur();
            });
            inputfield.append(input).append(closeicon);
            return li.append(inputfield);
        },
        genHeader: function(){
            var self = this;
            var li = $('<li class="collection-item headers"></li>');
            var row = $('<div class="row"></div>');
            let i = 0;
            $.each(self.options.headers, function(index, value){
                if(index >= (self.options.maxColumns)){
                    return false;
                }
                var col = $('<div class="col truncate"></div>');
                col.attr('sortable', '.column'+i);
                col.addClass((self.options.columnClass[index] !== undefined ? self.options.columnClass[index] : self.getClass(self.options.headers.length)));
                col.html((self.options.sortable ? '<i class="material-icons left">sort</i>' : '')+self.options.headers[index]);
                if(self.options.sortable){
                    col.css('cursor', 'pointer');
                    col.click(function(){
                        // Cambiamos estilo
                        self.resetSortable();
                        self.resetFilter();
                        $(this).addClass('blue-text text-darken-2');
                        self.resetCollapse();
                        // Procesamos cambio
                        tinysort('#'+self.listcontainer.attr('id')+'>li',{selector:$(this).attr('sortable')});
                        self.showPaginator();
                    });
                }
                if(self.options.buttons.length > 0){
                    $.each(self.options.buttons, function(idx, btnConfig){
                        if(btnConfig.buttonInHeader !== undefined && typeof btnConfig.buttonInHeader == 'number'){
                            if(btnConfig.buttonInHeader == i){
                                col.empty().addClass('center-align');
                                col.text('Acciones');
                                col.off('click');
                            }
                        }
                    });
                }
                row.append(col);
                i++;
            })
            li.css('padding-left', '21px');
            return li.append(row);
        },
        genContainer: function(){
            this.listcontainer = $('<div class="collapsible"></div>');
            this.listcontainer.attr('id', this.elem.attr('id')+'maincontainer');
            return this.listcontainer;
        },
        getClass: function(val){
            if(!val || val < 0)
                return false;
            let classes = '';
            if(val > 4 || val == 0){
                classes = 'l3 m3 s12';
            }else{
                let number = (12 / val);
                classes = 'l'+number+' m'+number+' s12';
            }
            return classes;
        },
        searchOnSource: function(search){
            var self = this;
            if(self.options.dataSource == ''){
                console.log(new Date+' TableSearch: falta configurar el DataSource.');
                return false;
            }
            self.showPreloader();
            $.ajax({
                type: 'POST',
                url: self.options.dataSource,
                data: {
                    search: search
                },
                success: function(data){
                    if(data && data != 'false'){
                        if(typeof data != 'object'){
                            var obj = JSON.parse(data);
                        }else{
                            var obj = data;
                        }
                        // console.log(data);
                        if(typeof self.options.dataInParameter == 'string'){
                            obj = obj[self.options.dataInParameter];
                        }
                        self.listcontainer.empty();
                        if(obj.length > 0){
                            $.each(obj, function(index, row){
                                self.listcontainer.append(self.genElement(row));
                            });
                            if(self.options.pagination){
                                self.showPaginator();
                            }
                            if(obj.length > 3){
                                $('.collapsible').collapsible();
                            }
                            if(self.options.filters){
                                self.loadFilters();
                            }
                        }else{
                            self.listcontainer.append(self.genEmpty());
                        }
                        self.resetSortable();
                        if(typeof self.options.onSearch == 'function'){
                            self.options.onSearch();
                        }
                        
                    }else{
                        console.log(new Date()+' TableSearch2: Error en el datasource proporcionado.');
                    }
                },
                error: function(data){
                    console.log(new Date+' TableSearch2: No se pudo ejecutar la solicitud ajax, revise la ruta (datasource).');
                }
            });
        },
        initialRequest: function(){
            var self = this;
            self.showPreloader();
            $.ajax({
                type: 'POST',
                url: self.options.initialRequest,
                success: function(data){
                    if(data && data != 'false'){
                        if(typeof data != 'object'){
                            var obj = JSON.parse(data);
                        }else{
                            var obj = data;
                        }
                        if(typeof self.options.dataInParameter == 'string'){
                            obj = obj[self.options.dataInParameter];
                        }
                        self.listcontainer.empty();
                        if(obj.length > 0){
                            $.each(obj, function(index, row){
                                self.listcontainer.append(self.genElement(row));
                            });
                            if(self.options.pagination){
                                self.showPaginator();
                            }
                            if(obj.length > 3){
                                $('.collapsible').collapsible();
                            }
                            
                            if(self.options.filters){
                                self.loadFilters();
                            }

                        }else{
                            self.listcontainer.append(self.genEmpty());
                        }
                        self.resetSortable();
                        
                    }else{
                        console.log(new Date()+' TableSearch2: Error en el initialRequest proporcionado.');
                    }
                },
                error: function(data){
                    console.log(new Date+' TableSearch2: No se pudo ejecutar la solicitud ajax, revise la ruta (initialRequest).');
                }
            });
        },
        genElement: function(values){

            // Main
            var self = this;
            var li = $('<li class="collection-item elem"></li>');
            var collapsibleHeader = $('<div class="collapsible-header"></div>');
            var collapsibleBody = $('<div class="collapsible-body"></div>');
            var collapsetitle = $('<div>'+self.options.eachCcollapseTitle+'</div>');
            var multiDataTitle = $('<div>'+self.options.subData.title+'</div>');

            // Card
            var cardCollapsible = $('<div class="card z-depth-0"></div>');
            var cardContent = $('<div class="card-content"></div>');
            var cardAction = $('<div class="card-action"></div>');
            var cardReveal = $('<div class="card-reveal blue-grey darken-2"></div>');
            var cardRevealContent = $('<div class="grey-text text-lighten-2"></div>');
            var cardRevealClose = $('<i class="material-icons right grey-text text-lighten-3">close</i>');
            var cardRevealTitle = $('<span class="card-title grey-text text-lighten-4"></span>');
            var clbodyRowActions = $('<div class="row"></div>');
            var cardClose = $('<span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>');

            // Rows into
            var clbodyrow = $('<div class="row"></div>');
            var rowheader = $('<div class="row"></div>');
            
            // Css
            collapsibleBody.css('padding', '0');
            cardCollapsible.css('margin', '0');
            cardCollapsible.css('font-size', '16px');
            collapsetitle.css('font-size', '20px');
            collapsetitle.css('font-weight', '350');
            collapsetitle.css('margin-bottom', '10px');
            multiDataTitle.css('font-size', '20px');
            multiDataTitle.css('font-weight', '350');
            multiDataTitle.css('margin-bottom', '5px');
            cardRevealContent.css('padding-top', '21px');
            cardRevealContent.css('font-size', '16px');
            collapsibleHeader.addClass(self.options.collapsibleHeaderClass);

            // Mostrando datos en el header de cada elemento
            var  i = 0;
            $.each(values, function(index, value){ // generando cada columna
                if(i >= (self.options.maxColumns)){
                    return false;
                }
                var assignValue = function(self, value, element){
                    if(self.options.selectable && i == 0){
                        var p = $('<p></p>');
                        var input = $('<input type="checkbox" class="filled-in"/>');
                        var label = $('<label></label>');
                        label.hover(function(e){
                            $('.collapsible').collapsible('destroy');
                        }, function(){
                            $('.collapsible').collapsible();
                        });
                        if(self.options.selectable){
                            $(input).click(function(){
                                self.showSelected();
                            });
                            if(typeof self.options.onSelect == 'function'){
                                $(input).click(function(e){
                                    self.options.onSelect(e, input, li);
                                });
                            }
                        }
                        var id = value.toLowerCase().replace(' ', '');
                        input.attr('id', id);
                        label.attr('for', id);
                        label.text(value);
                        element.empty().append(p.append(input).append(label));
                    }else{
                        element.text(value);
                    }
                }
                
                
                var colheader = $('<div class="col truncate"></div>');
                colheader.addClass((self.options.columnClass[i] !== undefined ? self.options.columnClass[i] : self.getClass(self.options.headers.length)));
                
                if(self.options.buttons.length > 0){
                    $.each(self.options.buttons, function(idx, btnConfig){
                        if(btnConfig.buttonInHeader !== undefined && typeof btnConfig.buttonInHeader == 'number'){
                            if(btnConfig.buttonInHeader == i){
                                var buttonsContainer = $('<div></div>');
                                colheader.addClass('center');
                                colheader.append(self.genButton(btnConfig, li));
                            }else{
                                assignValue(self, value, colheader);
                            }
                        }else{
                            assignValue(self, value, colheader);
                        }
                    });
                }else{
                    assignValue(self, value, colheader);
                }
                
                rowheader.append(colheader);
                i++;
            });

            clbodyrow.append($('<div class="col s12 m12 l12"></div>').append(collapsetitle));
            
            // Mostrando el resto de la información en el collapsible
            var i = 0;
            $.each(values, function(index, value){
                if(typeof self.options.subData.column !== undefined){
                    if(index == self.options.subData.column)
                        return true;
                }
                var clbodycol = $('<div class="col"></div>');
                // clbodycol.addClass();
                clbodycol.addClass((self.options.collapsibleColumnClasses[i] !== undefined ? self.options.collapsibleColumnClasses[i] : 's12 m6 l6'));
                clbodycol.css('margin-bottom', '3px');
                clbodycol.html('<b>'+(self.options.columnNames[i] !== undefined ? self.options.columnNames[i] : index)+':</b> '+'<span class="column'+i+'" id="'+(self.options.columnNames[i] !== undefined ? self.options.columnNames[i].replace(' ', '').toLowerCase() : "")+'">'+value+'</span>');
                clbodyrow.append(clbodycol);
                i++;
            });

            // Si tiene subdata
            if(typeof self.options.subData.column !== undefined && !jQuery.isEmptyObject(self.options.subData.column)){

                clbodyRowActions.append('<br>');
                clbodyTitleCol = $('<div class="col s12 m12 l12"></div>');
                clbodyRowActions.append(clbodyTitleCol.append(multiDataTitle));
                cardRevealTitle.append(cardRevealClose);

                $.each(values[self.options.subData.column], function(index, value){
                    var avalue = $('<a href="#!" class="subdatabutton truncate '+(self.options.subData.showReveal !== undefined && typeof self.options.subData.showReveal == 'boolean' && !self.options.subData.showReveal ? '' : 'activator')+' btn-flat blue-text"></a>');
                    avalue.click(function(){
                        var btnCloseReveal = cardRevealTitle.find('i').first();
                        var cardRevealRow = $('<div class="row"></div>');
                        cardRevealContent.empty();
                        cardRevealTitle.empty()
                            .text(values[self.options.subData.column][index][self.options.subData.cardRevealTitleColumnName])
                            .append(btnCloseReveal);
                        var i = 0;
                        // console.log(value);
                        $.each(value, function(idx, val){
                            let cardRevealCol = $('<div class="col s12 m12 l12"></div>');
                            let auxRow = $('<div class="row"></div>');
                            let auxCol1 = $('<div class="col s12 m3 l3"></div>');
                            let auxCol2 = $('<div class="col s12 m9 l9"></div>');
                            auxCol1.html('<b>'+(self.options.subData.columnNames[i] !== undefined ? self.options.subData.columnNames[i] : idx)+':</b> ');
                            auxCol2.html(val == null || val == '' ? '<span class="grey-text">Vacío</span>' : val);
                            auxRow.css('margin-bottom', '3px');
                            auxRow.append(auxCol1).append(auxCol2);
                            cardRevealCol.append(auxRow);
                            cardRevealRow.append(cardRevealCol);
                            i++;
                        });
                        cardRevealContent.append(cardRevealRow);
                    });
                    if(self.options.subData.onClick !== undefined && typeof self.options.subData.onClick == 'function'){
                        avalue.click(function(e){
                            self.options.subData.onClick(e, this, value, li);
                        });
                    }
                    currentCol = $('<div class="col s12 m12 l12"></div>');
                    currentCol.css('padding-left', '0');
                    avalue.html('<i class="material-icons left">keyboard_arrow_right</i>'+capitalizeFirstLetter(value[self.options.subData.cardRevealTitleColumnName].toString()));
                    clbodyRowActions.append(currentCol.append(avalue));
                });
                cardReveal.append(cardRevealTitle);
                cardReveal.append(cardRevealContent);
            }
            li.css('color', '#212121');
            li.append(collapsibleHeader.append(rowheader));
            collapsibleBody.append(cardCollapsible.append(cardContent.append(clbodyrow).append(clbodyRowActions)).append(cardReveal));

            if(self.options.buttons.length > 0){
                var rowButtons = $('<div class="row"></div>');
                var colButtons = $('<div class="col s12 m12 l12"></div>');
                colButtons.append('<br>');
                $.each(self.options.buttons, function(idx, btnConfig){
                    if(btnConfig.buttonInHeader === undefined){
                        colButtons.append(self.genButton(btnConfig, li));
                    }
                });
                cardContent.append(rowButtons.append(colButtons));
            }
            
            li.append(collapsibleBody);
            return li;
        },
        genEmpty: function(){
            var li = $('<li class="collection-item elem"></li>');
            var collapsibleHeader = $('<div class="collapsible-header"></div>');
            var row = $('<div class="row"></div>');
            var col = $('<div class="col s12 m12 l12"></div>');
            col.text(this.options.noResultsFoundMessage);
            return li.append(collapsibleHeader.append(row.append(col)));
        },
        genFiltersContainer: function(){
            var li = $('<li class="filters"></li>');
            if(this.options.filterColumns.length == 0){
                li.append('No hay filtros configurados');
            }else{
                li.append('Cargando filtros...');
            }
            return li;

        },
        genInitialMessageElement: function(){
            var li = $('<li class="collection-item empty"></li>');
            var row = $('<div class="row"></div>');
            var col = $('<div class="col s12 m12 l12 valign-wrapper"></div>');
            col.html(this.options.initialMessage);
            li.append(row.append(col));
            return li;
        },
        genButton: function(btnConfig, li){
            var btn = $('<a class="btn-flat z-depth-0"></a>');
            btn.html(btnConfig.name);
            btn.css('margin-left', '3px');
            btn.on('click', function(e){
                btnConfig.onClick(this, li, e);
                e.stopPropagation();
            });
            if(btnConfig.extraClasses !== undefined){
                btn.addClass(btnConfig.extraClasses);
            }
            return btn;
        },
        toggleFilters: function(elem = this.filters){
            $(elem).animate({
                height: "toggle",
                paddingTop: "toggle",
                paddingBottom: "toggle"
            },150);
        },
        loadFilters: function(){

            var self = this;
            $(self.filters).empty();
            var row = $('<div class="row"></div>');

            $.each(self.options.filterColumns, function(index, columnId){

                var col = $('<div class="col s3 m3 l3"></div>');
                var select = $('<select class="browser-default"></select>');
                var arrayFilter = [];

                $(self.listcontainer).find('li .column'+columnId).each(function(index, elem){
                    arrayFilter.push($(elem).text());
                });

                var newarray = $.distinct(arrayFilter);
    
                $(select).append('<option selected disabled value="">'+self.options.columnNames[columnId]+'</option>');
                $.each(newarray, function(index, value){
                    var option = $('<option value="'+value+'">'+value+'</option>');
                    $(select).append(option);
                });
                
                $(select).change(function(){
                    self.resetSortable();
                    self.filter({
                        selector: '.column'+columnId,
                        content: $(this).val(),
                        class: 'matched',
                        notMatchClass: 'notmatched'
                    });
                });

                $('select').material_select();
                row.append(col.append(select))
            });
            var btnCol = $('<div class="col s3 m3 l3"></div>');
            var btnReset = $('<a class="waves-effect waves-teal btn-flat green-text">Limpiar</a>');
            btnReset.click(function(){
                self.resetFilter();
            });
            $(self.filters).append(row.append(btnCol.append(btnReset)));

        },
        showPreloader: function(){
            var self = this;
            self.listcontainer.empty();
            var li = $('<li class="collection-item elem"></li>');
            var collapsible = $('<div class="collapsible-header"></div>');
            var row = $('<div class="row"></div>');
            var col = $('<div class="col s12 m12 l12 center"></div>');
            col.css('margin-top', '10px');
            var preloader = $(`
            <div class="tablesearch2-preloader-container">
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
            `);
            li.append(collapsible.append(row.append(col.append(preloader))));
            self.listcontainer.append(li);
        },
        showPaginator: function(){
            var self = this;
            self.removePaginator();
            $(self.listcontainer).paginathing(self.options.paginationObject);
            $(self.elem).find('ul.pagination').first().find('li').click(function(){
                self.resetCollapse();
            });
            if(self.options.selectable){
                self.showSelected();
            }
            self.showTotal();
            
        },
        showTotal: function(){
            $(this.listcontainer).next().first().find('#total').remove();
            var span = $('<span id="total"></span>');
            span.css('line-height','30px');
            span.css('padding-left','11px');
            span.text('Total: '+this.getHowManyElements());
            $(this.listcontainer).next().first().prepend(span);
        },
        showSelected: function(){
            $(this.listcontainer).next().first().find('#selected').remove();
            var span = $('<span id="selected"></span>');
            span.css('line-height','30px');
            span.text('/'+this.getHowManySelected());
            $(this.listcontainer).next().first().prepend(span);
            this.showTotal();
        },
        removePaginator: function(){
            $(this.listcontainer).children('li').removeAttr('style');
            this.listcontainer.next().remove();
        },
        resetSortable: function(){
            $(this.header).find('div[sortable*="column"]').removeClass('blue-text text-darken-2');
        },
        reloadTable: function(){
            this.initialRequest();
            if(typeof this.options.reloadButtonCallback == 'function'){
                this.options.reloadButtonCallback();
            }
        },
        resetCollapse: function(){
            $(this.listcontainer).children('li').find('.collapsible-header').removeClass('active');
            $(this.listcontainer).children('li').find('.collapsible-body').css('display', 'none');
        },
        resetFilter: function(){
            $(this.filters).find('select').each(function(){
                $(this).val('');
            });
            if(this.almostfilter !== undefined){
                this.almostfilter.reset();
            }
        },
        getHowManyElements: function(){
            var i = 0;
            $.each(this.listcontainer.find('li.collection-item.elem'), function(index, elem){
                i++;
            });
            return i;
        },
        getHowManySelected: function(){
            var i = 0;
            $.each(this.listcontainer.find('li.collection-item.elem'), function(index, elem){
                // console.log($(elem).find('input:checkbox').first());
                if($(elem).find('input:checkbox').first()[0].checked){
                    i++;
                }
            });
            return i;
        },
        filter: function(object){
            this.almostfilter = $(this.listcontainer).almostfilter(object);
            // tinysort('#'+$(this.listcontainer).attr('id')+'>li:not([class='+object.class+'])',{selector:object.selector});
            this.showPaginator();
        }
    }

    Tablesearch.prototype.getAllSelected = function(){
        var array = [];
        $.each(this.listcontainer.find('li.collection-item.elem'), function(index, elem){
            // console.log($(elem).find('input:checkbox').first());
            if($(elem).find('input:checkbox').first()[0].checked){
                array.push(elem);
            }
        });
        return array;
    }

    Tablesearch.prototype.togglePaginator = function(action){
        if(action == 'disable'){
            console.log($(this.listcontainer).next());
            $(this.listcontainer).next().find('li').css("pointer-events", "none");
        }
        if(action == 'enable'){
            $(this.listcontainer).next().find('li').css("pointer-events", "auto");
        }
    }

    $.fn.tablesearch2 = function(options){

        var settings = $.extend({
            title: 'Tablesearch2',
            searchable: true,
            onSearch: false,
            searchPlaceholder: 'Buscar',
            reloadButton: false,
            reloadButtonCallback: false,
            reloadButtonText: 'Recargar',
            initialMessage: false,
            initialRequest: false,
            dataInParameter: false,
            headers: [],
            dataSource: '',
            noResultsFoundMessage: 'Ningún dato',
            pagination: false,
            sortable: false,
            eachCcollapseTitle: 'Detalles',
            cardRevealTitleColumnName: '',
            paginationObject: {},
            columnNames: [],
            collapsibleColumnClasses: [],
            collapsibleHeaderClass: '',
            subData: {},
            filters: false,
            filterColumns: [],
            maxColumns: 4,
            columnClass: [],
            buttons: [],
            selectable: false,
            onSelect: false
        },options);

        // settings.paginationObject.ulClass += ' right';
        var tsearch = new Tablesearch(this, settings);
        return tsearch;

    }

}(jQuery));

/**
 * Small Plugin AlmostFilter for tablesearch2
 * @requires jQuery
 * @author 4Richi
 * */

(function($){

    $.extend({
        distinct : function(anArray) {
            var result = [];
            $.each(anArray, function(i,v){
                if ($.inArray(v, result) == -1) result.push(v);
            });
            return result;
        }
    });

    var AlmostFilter = function(elem, options){
        this.options = options;
        this.elem = elem;
        this.filteredElements = [];
        this.reset();
        this.filter();
        this.elem.find('.almost').css('background-color', 'red');
    }

    AlmostFilter.prototype = {

        filter: function(){
            var _self = this;
            $(_self.elem).find('li').each(function(index, el){
                if($(el).find(_self.options.selector+':contains("'+_self.options.content+'")').length > 0){
                    $(el).addClass(_self.options.class);
                    _self.filteredElements.push(el);
                }else{
                    $(el).addClass(_self.options.notMatchClass);
                }
            });

            this.reorder(this.filteredElements);
        },
        reorder: function(elems){
            var _self = this;
            $.each(elems, function(index, elem){
                let current = $(_self.elem).find(elem);
                if(_self.options.direction ==  'asc'){
                    $(_self.elem).prepend(current);
                }else{
                    $(_self.elem).append(current);
                }
            });
        },
        genSelect: function(){

        }

    }

    AlmostFilter.prototype.reset = function(){
        var _self = this;
        _self.elem.find('li').removeClass(_self.options.class).removeClass(_self.options.notMatchClass);
    }

    $.fn.almostfilter = function(options){

        var settings = $.extend({
            selector: '', // required
            content: '', // required
            class: 'almost', // class to add to filtered elements
            direction: 'asc', // asc or desc
            notMatchClass: 'notMarch'
        },options);

        var almost = new AlmostFilter(this, settings);
        return almost;

    }

}(jQuery));