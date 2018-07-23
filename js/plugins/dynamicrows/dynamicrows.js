
(function($){

    var DynamicRows = function(elem, options){

        this.options = options;
        this.container = $(elem);
        this.example = $(elem).find('#example');
        this.example.removeAttr('id').addClass('rowInDynamicRows');
        this.init();

    }

    DynamicRows.prototype = {

        init: function(){
            this.container.empty().append(this.emptyMessage());
            this.renderAddBtn();
        },
        emptyMessage: function(){
            let row = $('<div class="row"></div>');
            let col = $('<div class="col s12 m12 l12 valign-wrapper center-align"></div>');
            col.append(this.options.emptyMessage);
            return row.append(col);
        },
        renderAddBtn: function(){
            var self = this;
            let row = $('<div class="row"></div>');
            let col = $('<div class="col s12 m12 l12"></div>');
            let inputField = $('<div class="input-field"></div>');
            let button = $('<a href="#!" id="" class="btn-flat white-text waves-effect waves-light green lighten-3">Agregar</a>');
            button.click(function(){
                self.addRow();
            });
            row.append(col.append(inputField.append(button)));
            this.container.after(row);
        },
        addRow: function(){
            var self = this;
            var newrow = self.example.clone();
            newrow.find('#delete').click(function(){
                var index = self.container.find('.rowInDynamicRows').index(newrow);
                self.removeRow(index);
            });
            if(self.container.find('.rowInDynamicRows').length == 0){
                self.container.empty();
            }
            self.container.append(newrow);
        },
        removeRow: function(id){
            this.container.find('.rowInDynamicRows').eq(id).remove();
            if(this.container.find('.rowInDynamicRows').length == 0){
                this.container.empty().append(this.emptyMessage());
            }
        }

    }

    DynamicRows.prototype.reset = function(){
        this.container.empty().append(this.emptyMessage());
    }

    $.fn.dynamicRows = function(options){

        var settings = $.extend({
            emptyMessage: 'Vacío'
        }, options);

        var dynamicrows = new DynamicRows(this, settings);
        return dynamicrows;

    }
    
}(jQuery));