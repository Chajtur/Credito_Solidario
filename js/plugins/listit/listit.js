/**
 * Plugin listit
 * @author Ricardo Valladares (Rychiv4)
 */
(function($){

    var Listable = function(elem, options){

        this.options = options;
        this.element = elem;
        this.listcontainer = $(elem).find('.listcontainer').first();
        if(options.pagination){
            this.paginator = this.initPagination();
        }else{
            this.paginator = false;
        }
        this.render();

    }

    Listable.prototype = {

        render: function(){
            this.createHeaders();
            this.createEmptyMessageElement();
        },
        createElement: function(values){
            
            var self = this;
            var li = $('<li class="collection-item elem"></li>');
            var collapsibleheader = $('<div class="collapsible-header"></div>');
            var row = $('<div class="row"></div>');
            var classes = this.createClassesByColumnCount(this.options.columnsCount);

            for(var i = 0; i < this.options.columnsCount; i++){
                var col = $('<div class="col '+classes+' listit-header-column listcol truncate '+this.options.classes.collapsibleHeaderColumns+'"></div>');
                col.text(values[i]);
                if(this.options.buttonsOnElements.length > 0){
                    $.each(this.options.buttonsOnElements, function(index, btn){
                        
                        if(btn.buttonInColumn !==  undefined && btn.buttonInColumn == i){
                            $(col).addClass('center');
                        }
                    });
                }
                row.append(col);
            
            }

            var collapsiblebody = $('<div class="collapsible-body '+this.options.classes.collapsibleBody+'"></div>');
            var collapsiblebodyrow = $('<div class="row"></div>');

            for(i = 0; i < values.length; i++){
                collapsiblebodyrow.append(`
                    <div class="`+this.options.classes.collapsibleBodyColumns+`">
                        <p class="no-margin">
                            <b>`+(this.options.headers[i] !== undefined ? this.options.headers[i].toLowerCase() : this.options.defaultHeaderName)+`:</b> 
                            <span id="`+(this.options.headers[i] !== undefined ? this.options.headers[i].toLowerCase().replace(' ', '') : this.options.defaultHeaderName)+`">`+values[i]+`</span>
                        </p>
                    </div>
                `);
            }

            if(this.options.buttonsOnElements.length > 0){
                var btnsCol = $('<div class="col s12 m12 l12 center"><br></div>');
                $.each(this.options.buttonsOnElements, function(index, btn){

                    var newBtn = self.createButton(btn, li);
                    
                    if(btn.buttonInColumn !==  undefined){
                        $(row).find('.listit-header-column').eq(btn.buttonInColumn).empty().append(newBtn);
                    }else{
                        btnsCol.append(newBtn)
                    }
                });
                collapsiblebodyrow.append(btnsCol);
            }

            if(typeof this.options.onClickCollapse === 'function'){
                var self = this;
                collapsibleheader.on('click', function(e){
                    self.options.onClickCollapse(e, $(this), collapsiblebody);
                });
            }

            li.append(collapsibleheader.append(row));
            li.append(collapsiblebody.append(collapsiblebodyrow));
            return li;

        },
        createButton: function(btn, li){
            var newBtn = $(btn.button);
            if(btn.id !== undefined){
                newBtn.attr('id', btn.id);
            }
            if(btn.buttonOnClick !== undefined){
                newBtn.on('click', function(e){
                    btn.buttonOnClick(e, li, this);
                    e.stopPropagation();
                });
            }
            return newBtn;
        },
        createHeaders: function(){

            var li = $('<li class="collection-item headers"></li>');
            var row = $('<div class="row"></div>');
            var classes = this.createClassesByColumnCount(this.options.columnsCount);

            for(var i = 0; i < this.options.columnsCount; i++){

                var col = $('<div class="col '+classes+'"></div>');
                col.text(this.options.headers[i] !== undefined ? this.options.headers[i] : this.options.defaultHeaderName);
                
                if(this.options.buttonsOnElements.length > 0){
                    $.each(this.options.buttonsOnElements, function(index, btn){
                        
                        if(btn.buttonInColumn !==  undefined && btn.buttonInColumn == i){
                            $(col).css('text-align','center');
                            $(col).text('Acciones');
                        }
                    });
                }
                
                row.append(col);
            
            }

            this.listcontainer.before(li.append(row));

        },
        createEmptyMessageElement: function(){

            var li = $('<li class="collection-item empty"></li>');
            var row = $('<div class="row"></div>');
            var col = $('<div class="col s12 m12 l12 valign-wrapper"></div>');
            col.html(this.options.emptyMessage);
            li.append(row.append(col));
            this.listcontainer.append(li);

        },
        createClassesByColumnCount: function(val){

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
    
        },
        existOnColumn: function(index, value){

            var exists = false;
            var elements = this.listcontainer.find('.collection-item.elem');
            $.each(elements, function(indx, elem){
                if($(elem).find('.listcol').eq(index).text() == value){
                    exists = true;
                    return false;
                }
            });
            return exists;

        },
        initPagination: function(){
            var pagination = $(this.listcontainer).paginathing(this.options.paginationOptions);
            this.showTotal();
            return pagination;
        },
        removePaginator: function(){
            $(this.listcontainer).children('li').removeAttr('style');
            this.listcontainer.next().remove();
        },
        validInsert: function(values){

            var self = this;
            var valid = true;
            $.each(this.options.unique, function(index, uq){
                if(uq){
                    valid = !self.existOnColumn(index, values[index]);
                }
            });
            return valid;

        },
        getAllElements: function(){
            return this.listcontainer.find('.collection-item.elem');
        },
        showTotal: function(){
            $(this.listcontainer).next().first().find('#total').remove();
            var span = $('<span id="total"></span>');
            span.css('line-height','30px');
            span.text('Total: '+this.getHowManyElements());
            $(this.listcontainer).next().first().append(span);
        },
        createLoader: function(){
            return `
            <li class="collection-item loader">
                <div class="container center-align listit-preloader-container">
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
            </li>
            `;
        }

    }

    Listable.prototype.insertElement = function(values, callback = false){

        if(!this.validInsert(values)){
            Materialize.toast(this.options.uniqueErrorMessage, 2000);
            return false;
        }

        var element = this.createElement(values);
        this.listcontainer.find('.collection-item.empty').remove();
        this.listcontainer.append(element);
        if(this.paginator){
            this.removePaginator();
            this.paginator = this.initPagination();
        }
        if(typeof callback == 'function'){
            callback(element);
        }
        return true;
    }

    Listable.prototype.removeElement = function(index){
        this.listcontainer.find('li.collection-item.elem').eq(index).remove();
        if(this.listcontainer.find('li.collection-item.elem').length == 0){
            this.createEmptyMessageElement();
        }
        if(this.paginator){
            this.removePaginator();
            this.paginator = this.initPagination();
        }
    }

    Listable.prototype.loader = function(action){
        if(action == 'show'){
            this.element.append(this.createLoader());
            this.listcontainer.hide();

            // Si está activo el paginador
            if(this.paginator)
                this.listcontainer.next().hide();
        }
        if(action == 'hide'){
            this.element.find('li.collection-item.loader').remove();
            this.listcontainer.show();

            // Si está activo el paginador
            if(this.paginator)
                this.listcontainer.next().show();
        }
    }

    Listable.prototype.removeAllElements = function(){
        var self = this;
        $.each(this.listcontainer.find('li.collection-item.elem'), function(index, elem){
            self.removeElement(index);
        });
    }

    Listable.prototype.getHowManyElements = function(){
        var i = 0;
        $.each(this.listcontainer.find('li.collection-item.elem'), function(index, elem){
            i++;
        });
        return i;
    }

    $.fn.listit = function(options){

        var settings = $.extend({
            headers: [],
            unique: [],
            uniqueErrorMessage: 'Elemento repetido',
            columnsCount: 3,
            classes: {
                collapsibleBody: '',
                collapsibleBodyColumns: 'col s12 m12 l12',
                collapsibleHeaderColumns: 'col s12 m12 l12'
            },
            pagination: false,
            paginationOptions: {},
            defaultHeaderName: 'Columna',
            emptyMessage: 'Lista vacía',
            buttonsOnElements: [],
            onClickCollapse: false
        },options);

        settings.paginationOptions.insertAfter = '.listcontainer';
        settings.paginationOptions.ulClass += ' right';
        settings.showTotal = true;

        settings.columnsCount = settings.columnsCount > 4 ? 4 : settings.columnsCount;

        var listable = new Listable(this, settings);
        return listable;

    }

}(jQuery));