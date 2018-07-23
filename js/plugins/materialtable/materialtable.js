
/**
 * Plugin Material Table
 * @requires jQuery
 * @requires paginathing @description Para el paginador
 * Creador: Ricardo Valladares
 */

(function($){

    $.fn.loadMaterialTable = function(obj) {

        var settings = $.extend({
            tableName: 'Nombre de la Tabla',
            tableSubName: 'Subnombre de la tabla',
            headers: [],
            toCollapsible: 3,
            listElements: []
        },obj);

        var pureid = $(this).attr('id');
        id = '#'+pureid;
        if(obj.toCollapsible === undefined || obj.toCollapsible > 3 || obj.toCollapsible < 0)
            obj.toCollapsible = 3;

        var classes = getClassesByQuantity(obj.toCollapsible);
        var headers = createHeaders(obj.headers, classes, obj.toCollapsible);
        var elements = createElements(obj.listElements, classes, obj.toCollapsible, obj.headers);
        

        $(id).append(`
            <div id="work-collections" class="">
                <div class="row">
                    <div class="col s12 m12 l12" id="list`+pureid+`">
                        <ul id="projects-collection" class="collapsible no-border" style="border: none !important;">
                            <li class="collapsible-item-header avatar">
                                <i class="material-icons circle light-blue ">location_on</i>
                                <span class="collection-header">`+obj.tableName+`</span>
                                <p>`+obj.tableSubName+`</p>
                            </li>
                            <li>
                                <div class="collapsible-header-titles sin-icon">
                                    <div class="row" id="headersList`+pureid+`">
                                        `+headers+`
                                    </div>
                                </div>
                            </li>
                            <div class="list collapsible no-padding no-margin z-depth-0" id="listItems`+pureid+`">
                                `+elements+`
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        `);

        $('#listItems'+pureid).paginathing({
            perPage: 10,
            limitPagination: false,
            containerClass: 'card-panel card-panel-pagination no-margin z-depth-0',
            firstLast: false,
        });

        if(obj.headers > 4 || obj.headers.length > obj.toCollapsible)
            $('.collapsible').collapsible();

        return this;
    };

    var createHeaders = function(headers, classes, limit){
        var heads = '';
        $.each(headers, function(index, hname){
            if(index >= limit)
                return false;

            heads += `
                <div class="col `+classes+`">
                    <p class="collections-title">`+hname+`</p>
                </div>
            `;
        });
        return heads;
    }

    var createElements = function(obj, classes, limit, headers){

        var elms = '';
        
        $.each(obj, function(index, row){
            elms += `
            <li>
                <div class="collapsible-header sin-icon">
                    <div class="row">
            `;
            $.each(row, function(idx, value){
                if(idx >= limit)
                    return false;
                elms += `
                    <div class="col `+classes+`">
                        <p class="collapsible-content truncate no-margin">`+value+`</p>
                    </div>
                `;
            });
            elms += `
                    </div>
                </div>
                <div class="collapsible-body">`;
            
            $.each(row, function(idx, value){
                if(idx < limit)
                    return;
                elms += `
                    <h5>`+headers[idx]+`</h5>
                    <span>`+value+`</span>
                `;
            });
                    
            elms += `</div>
            </li>
            `;
        });

        return elms;

    }

    var getClassesByQuantity = function(val){

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