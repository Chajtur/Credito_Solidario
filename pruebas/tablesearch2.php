<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <title>TableSearch 2! - Documentación</title>
    <style>
    code.inline {
        background-color: #F5F5F5 !important;
        border: 1px solid #E0E0E0 !important;
        border-radius: 2px !important;
    }
    pre.code-container {
        background-color: #F5F5F5 !important;
        border: 1px solid #E0E0E0 !important;
        border-radius: 2px !important;
    }
    </style>
</head>
<body>

    <div class="row">
        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <h2>TableSearch 2!</h2>
            <p class="flow-text">Maneja información en tablas de manera dinámica, filtrada, paginada y personalizada.</p>
        </div>
    </div>
    <div class="row">
        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <h5>Así funciona:</h5>
            <ul class="collection with-header" id="tablesearch2">
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col l4 m4 s12 offset-l1 offset-m1">
            <h5>Requisitos:</h5>
            <ul class="collection">
                <li class="collection-item"><a target="_blank" href="https://jquery.com/">jQuery 3+</a></li>
                <li class="collection-item"><a target="_blank" href="http://materializecss.com">Materializecss</a></li>
                <li class="collection-item"><a target="_blank" href="https://github.com/alfrcr/paginathing">Paginathing</a></li>
                <li class="collection-item"><a target="_blank" href="http://tinysort.sjeiti.com/">Tinysort</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <h5>Propiedades:</h5>
            <table class="bordered">
                <thead>
                <tr>
                    <th>Propiedad</th>
                    <th>Descripción</th>
                    <th>Tipo de dato</th>
                    <th>Default</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td><code class="inline">Title</code></td>
                    <td>Título de la tabla</td>
                    <td><code class="inline">string</code></td>
                    <td><code class="inline">Tablesearch2</code></td>
                </tr>
                <tr>
                    <td><code class="inline">searchable</code></td>
                    <td>Habilita o deshabilita la búsqueda de datos</td>
                    <td><code class="inline">boolean</code></td>
                    <td><code class="inline">true</code></td>
                </tr>
                <tr>
                    <td><code class="inline">onSearch</code></td>
                    <td>Callback al realizar una búsqueda en el datasource con la tabla.</td>
                    <td><code class="inline">function / boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">searchPlaceholder</code></td>
                    <td>Texto dentro del cuadro de búsqueda</td>
                    <td><code class="inline">string</code></td>
                    <td><code class="inline">Buscar</code></td>
                </tr>
                <tr>
                    <td><code class="inline">dataSource</code></td>
                    <td>Ruta hacia donde se realizarán consultas en base al cuadro de búsqueda. utilizado en caso de que el parámetro <code class="inline">searchable</code> sea <code class="inline">true</code></td>
                    <td><code class="inline">array</code></td>
                    <td><code class="inline">[]</code></td>
                </tr>
                <tr>
                    <td><code class="inline">reloadButton</code></td>
                    <td>Habilita o deshabilita el boton de recargar</td>
                    <td><code class="inline">boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">reloadButtonText</code></td>
                    <td>Texto para mostrar en el botón de recargar. puede contener html</td>
                    <td><code class="inline">string</code></td>
                    <td><code class="inline">Recargar</code></td>
                </tr>
                <tr>
                    <td><code class="inline">reloadButtonCallback</code></td>
                    <td>Callback al hacer clic en el boton de recargar la tabla</td>
                    <td><code class="inline">function / boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">initialMessage</code></td>
                    <td>Mensaje inicial al cargar la tabla sin datos. false para deshabilitar o string para mostrar.</td>
                    <td><code class="inline">string / boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">initialRequest</code></td>
                    <td>Solicita información al cargar la tabla. false para deshabilitar o string conteniendo la ruta del request de información para mostrar datos.</td>
                    <td><code class="inline">string / boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">dataInParameter</code></td>
                    <td>Para expresar a Tablesearch2 que el request devuelve todos los datos para mostrar en un atributo específico de los datos retornados.</td>
                    <td><code class="inline">string / boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">headers</code></td>
                    <td>Arreglo de encabezados, recomendable que sea igual a la cantidad de columnas que devuelve el <code class="inline">datasource</code>. Se colocará respectivamente al orden que el datasource devuelva.</td>
                    <td><code class="inline">array</code></td>
                    <td><code class="inline">[]</code></td>
                </tr>
                <tr>
                    <td><code class="inline">noResultsFoundMessage</code></td>
                    <td>Mensaje a mostrar en caso que no se encuentren datos en el datasource.</td>
                    <td><code class="inline">string</code></td>
                    <td><code class="inline">Ningún dato</code></td>
                </tr>
                <tr>
                    <td><code class="inline">pagination</code></td>
                    <td>Habilita o deshabilita la paginación. requiere <a target="_blank" href="https://github.com/alfrcr/paginathing">Paginathing.js</a></td>
                    <td><code class="inline">boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">sortable</code></td>
                    <td>Habilita o deshabilita el ordenamiento por columnas. requiere <a target="_blank" href="http://tinysort.sjeiti.com/">Tinysort</a></td>
                    <td><code class="inline">boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">eachCcollapseTitle</code></td>
                    <td>Título de cada collapsible body.</td>
                    <td><code class="inline">string</code></td>
                    <td><code class="inline">Detalles</code></td>
                </tr>
                <tr>
                    <td><code class="inline">cardRevealTitleColumnName</code></td>
                    <td>Título de cada card-reveal de cada collapsible body, solamente habilitado si hay subdata configurada.</td>
                    <td><code class="inline">string</code></td>
                    <td><code class="inline">(vacío)</code></td>
                </tr>
                <tr>
                    <td><code class="inline">paginationObject</code></td>
                    <td>Objeto de paginathing. Este se adjuntará al momento de crear el paginador. Configuraciones detalladas en <a target="_blank" href="https://github.com/alfrcr/paginathing">Paginathing.js</a>.</td>
                    <td><code class="inline">object</code></td>
                    <td><code class="inline">{}</code></td>
                </tr>
                <tr>
                    <td><code class="inline">columnNames</code></td>
                    <td>Arreglo de nombres de columnas. Se asignará ese nombre a cada header de cada elemento, incluso dentro d e cada collapsible body.</td>
                    <td><code class="inline">array</code></td>
                    <td><code class="inline">[]</code></td>
                </tr>
                <tr>
                    <td><code class="inline">subData</code></td>
                    <td>Configuración para datos extra (arreglo multidimensional). <a href="#subdata">Ver más detalles.</a></td>
                    <td><code class="inline">object</code></td>
                    <td><code class="inline">{}</code></td>
                </tr>
                <tr>
                    <td><code class="inline">filters</code></td>
                    <td>Habilita o deshabilita el área para mostrar los filtros.</td>
                    <td><code class="inline">boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">filterColumns</code></td>
                    <td>Arreglo de  indices de columnas que serán filtradas (a las cuales se les habilitará el filtro).</td>
                    <td><code class="inline">array</code></td>
                    <td><code class="inline">[]</code></td>
                </tr>
                <tr>
                    <td><code class="inline">maxColumns</code></td>
                    <td>Cantidad máxima que se mostrará en los headers de la tabla y de cada elemento.</td>
                    <td><code class="inline">array</code></td>
                    <td><code class="inline">[]</code></td>
                </tr>
                <tr>
                    <td><code class="inline">columnClass</code></td>
                    <td>Clases extra para cada columna. Se leen de manera indexada, siendo correspondiente su indice al de la tabla a la cual se aplicará. Estas clases están pensadas para que contengan las clases responsive de la grilla de Materialize (ej. s12 m6 l6 + otras clases personalizadas).</td>
                    <td><code class="inline">array</code></td>
                    <td><code class="inline">[]</code></td>
                </tr>
                <tr>
                    <td><code class="inline">collapsibleHeaderClass</code></td>
                    <td>Clase extra a agregar a cada collapsible header.</td>
                    <td><code class="inline">string</code></td>
                    <td><code class="inline">''</code></td>
                </tr>
                <tr>
                    <td><code class="inline">collapsibleColumnClasses</code></td>
                    <td>Clases a agregar en cada elemento dentro del collapsible body, estas clases están pensadas para que contengan las clases responsive de la grilla de Materialize (ej. s12 m6 l6 + otras clases personalizadas).</td>
                    <td><code class="inline">array</code></td>
                    <td><code class="inline">[]</code>(<code class="inline">s12 m6 l6</code>)</td>
                </tr>
                <tr>
                    <td><code class="inline">buttons</code></td>
                    <td>Arreglo de configuraciones de botones.</td>
                    <td><code class="inline">array</code></td>
                    <td><code class="inline">[]</code></td>
                </tr>
                <tr>
                    <td><code class="inline">selectable</code></td>
                    <td>Habilita o deshabilita la opción de hacer seleccionables las filas.</td>
                    <td><code class="inline">boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                <tr>
                    <td><code class="inline">onSelect</code></td>
                    <td>Función que se ejecutará al momento de seleccionar un elemento de la tabla. Funciona cuando selectable == <code class="inline">true</code>.</td>
                    <td><code class="inline">function / boolean</code></td>
                    <td><code class="inline">false</code></td>
                </tr>
                </tbody>
            </table>
            <p>Headers:</p>
            <pre class="code-container">
            <code>
    &lt;!-- jQuery --&gt;
    &lt;script type="text/javascript" src="../js/plugins/jquery-2.2.4.min.js"&gt;&lt;/script&gt;

    &lt;!-- Materialize --&gt;
    &lt;script type="text/javascript" src="../js/materialize.js"&gt;&lt;/script&gt;

    &lt;!-- Plugins requeridos para tablesearch --&gt;
    &lt;script src="..\js\plugins\paginathing-master\paginathing.js"&gt;&lt;/script&gt;
    &lt;script src="..\js\plugins\tinysort\tinysort.min.js"&gt;&lt;/script&gt;

    &lt;!-- Plugin tablesearch --&gt;
    &lt;link rel="stylesheet" href="../js/plugins/tablesearch2/tablesearch2.css"&gt;
    &lt;script src="../js/plugins/tablesearch2/tablesearch2.js"&gt;&lt;/script&gt;</code>
            </pre>
            <p>HTML:</p>
            <pre class="code-container">
            <code>
    &lt;ul class="collection with-header" id="tablesearch2"&gt;
    &lt;/ul&gt;</code>
            </pre>
            <p>JS:</p>
            <pre class="code-container">
            <code>
    $('#tablesearch2').tablesearch2({
        title: 'Tabla Dinámica',
        searchPlaceholder: 'Buscar datos',
        reloadButton: true,
        reloadButtonCallback: function(){
            Materialize.toast('Recargando', 2000);
        },
        searchable: true,
        initialMessage: 'Hola',
        initialRequest: 'tablesearch2-backend.php?initial',
        reloadButtonText: '&lt;i class="material-icons"&gt;cached&lt;/i&gt;',
        headers: ['Nombre', 'ID', 'Direccion', 'Teléfono', 'Acciones'],
        dataSource: 'tablesearch2-backend.php?search',
        pagination: true,
        sortable: true,
        selectable: true,
        onSelect: function(e, checkbox, li){
            if($(checkbox)[0].checked){
                Materialize.toast('Checked', 2000);
            }else{
                Materialize.toast('Unchecked', 2000);
            }
            console.log(window.tablesearch.getAllSelected());
        },
        maxColumns: 5,
        columnClass: ['col s4 m4 l2','col s4 m5 l3','col hide-on-med-and-down l3','col hide-on-small-only m2 l2','col s4 m2 l2'],
        eachCcollapseTitle: 'Detalles de la persona',
        noResultsFoundMessage: 'Ningún registro',
        columnNames: ['Nombre', 'Departamento', 'Direccion', 'Teléfono'],
        paginationObject: {
            perPage: 5,
            limitPagination: 4,
            containerClass: 'collection-item elem with-pagination',
            ulClass: 'pagination',
            prevText: '&lt;i class="material-icons md-18"&gt;chevron_left&lt;/i&gt;', 
            nextText: '&lt;i class="material-icons md-18"&gt;chevron_right&lt;/i&gt;', 
            firstText: '&lt;i class="material-icons md-18"&gt;first_page&lt;/i&gt;',
            lastText: '&lt;i class="material-icons md-18"&gt;last_page&lt;/i&gt;',
            pageNumbers: true
        },
        subData: {
            column: 'Familia',
            title: 'Familiares',
            cardRevealTitleColumnName: 'Nombre',
            columnNames: ['Nombre','Departamento','Parentezco','Direccion']
        },
        filters: true,
        filterColumns: [1,2],
        buttons: [
            {
                name: '&lt;i class="material-icons blue-text" style="line-height: 36px;margin:0"&gt;info&lt;/i&gt;',
                extraClasses: 'blue-text',
                onClick: function(btn, listElement){
                    Materialize.toast('clicked', 2000);
                },
                buttonInHeader: 4
            },
            {
                name: '&lt;i class="material-icons blue-text" style="line-height: 36px;margin:0"&gt;add&lt;/i&gt;',
                extraClasses: 'blue-text',
                onClick: function(btn, listElement){
                    Materialize.toast('clicked', 2000);
                },
                buttonInHeader: 4
            }
        ]
    });</code>
            </pre>
        </div>
    </div>
    <div class="row">
        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <h5>Metodos:</h5>
            <table class="bordered">
                <thead>
                <tr>
                    <th>Metodo</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Returns</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td><code class="inline">tablesearch2.getAllSelected()</code></td>
                    <td>Obtiene todos los elementos que están actualmente seleccionados en la tabla.</td>
                    <td><code class="inline">function</code></td>
                    <td><code class="inline">array</code> de elementos seleccionados.</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" id="subdata">
        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <h5>Datos Secundarios:</h5>
            <p>Los datos secundarios en TableSearch2 son información secundaria que en ocasiones viene acompañada de la información principal representada en un arreglo de objetos. Esta información puede ser facilmente procesada y mostrada con TableSearch enviando la configuración adecuada, aprovechando las características de la carta de Materializecss (card reveal).</p>
            <p>Dado que el parámetro subData es un objeto, es necesario enviarle un objeto con diferentes propiedades que expresan la estructura de la información recibida por TableSearch.</p>
            <p>Las propiedades de este objeto se explican a continuación:</p>
            <table class="bordered">
                <thead>
                    <tr>
                        <th>Propiedad</th>
                        <th>Descripción</th>
                        <th>Tipo de dato</th>
                        <th>Default</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code class="inline">column (requerido)</code></td>
                        <td>Nombre de la propiedad donde se encuentran los datos secundarios en los datos suministrados a TableSearch2.</td>
                        <td><code class="inline">string</code></td>
                        <td><code class="inline">(concluye en error)</code></td>
                    </tr>
                    <tr>
                        <td><code class="inline">title (requerido)</code></td>
                        <td>Título a mostrarse en el collapsible body, donde se listarán las anclas para ver la información secundaria.</td>
                        <td><code class="inline">string</code></td>
                        <td><code class="inline">(concluye en error)</code></td>
                    </tr>
                    <tr>
                        <td><code class="inline">cardRevealTitleColumnName (requerido)</code></td>
                        <td>Nombre de la columna de la cual se tomará el título a mostrar en el card reveal al momento de ver la información secundaria.</td>
                        <td><code class="inline">string</code></td>
                        <td><code class="inline">(concluye en error)</code></td>
                    </tr>
                    <tr>
                        <td><code class="inline">showReveal</code></td>
                        <td>Habilita o deshabilita mostrar en un card reveal los datos extra retornados por el servidor.</td>
                        <td><code class="inline">boolean</code></td>
                        <td><code class="inline">true</code></td>
                    </tr>
                    <tr>
                        <td><code class="inline">columnNames</code></td>
                        <td>Nombres de las columnas a mostrar dentro de cada objeto de la información secundaria.</td>
                        <td><code class="inline">array</code></td>
                        <td><code class="inline">[]</code></td>
                    </tr>
                    <tr>
                        <td><code class="inline">onClick</code></td>
                        <td>Función que se ejecuta al hacer clic en uno de los elementos listados para mostrar información en el card reveal.</td>
                        <td><code class="inline">function</code></td>
                        <td><code class="inline">(nothing)</code></td>
                    </tr>
                </tbody>
            </table>
            <p>Ejemplo:</p>
            <pre class="code-container">
            <code>
    ...
    subData: {
        column: 'personas',
        title: 'Personas',
        cardRevealTitleColumnName: 'nombre',
        showReveal: true,
        columnNames: ['Nombre','Identidad', ...],
        onClick: function(e, button, values, parent){
            // ...
        }
    },
    ...</code>
            </pre>
        </div>
    </div>

<script type="text/javascript" src="../js/plugins/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="../js/materialize.js"></script>
<!-- Plugins requeridos para tablesearch -->
<script src="..\js\plugins\paginathing-master\paginathing.js"></script>
<script src="..\js\plugins\tinysort\tinysort.min.js"></script>

<!-- Plugin tablesearch -->
<link rel="stylesheet" href="../js/plugins/tablesearch2/tablesearch2.css">
<script src="../js/plugins/tablesearch2/tablesearch2.js"></script>
<script>

    window.tablesearch = $('#tablesearch2').tablesearch2({
        title: 'Tabla Dinámica',
        searchPlaceholder: 'Buscar datos',
        reloadButton: true,
        reloadButtonCallback: function(){
            Materialize.toast('Recargando', 2000);
        },
        searchable: true,
        initialMessage: 'Hola',
        initialRequest: 'tablesearch2-backend.php?initial',
        reloadButtonText: '<i class="material-icons">cached</i>',
        headers: ['Nombre', 'ID', 'Direccion', 'Teléfono', 'Acciones'],
        dataSource: 'tablesearch2-backend.php?search',
        pagination: true,
        sortable: true,
        selectable: true,
        onSelect: function(e, checkbox, li){
            if($(checkbox)[0].checked){
                Materialize.toast('Checked', 2000);
            }else{
                Materialize.toast('Unchecked', 2000);
            }
            console.log(window.tablesearch.getAllSelected());
        },
        maxColumns: 5,
        columnClass: ['col s4 m4 l2','col s4 m5 l3','col hide-on-med-and-down l3','col hide-on-small-only m2 l2','col s4 m2 l2'],
        collapsibleColumnClasses: [],
        eachCcollapseTitle: 'Detalles de la persona',
        noResultsFoundMessage: 'Ningún registro',
        columnNames: ['Nombre', 'Departamento', 'Direccion', 'Teléfono'],
        paginationObject: {
            perPage: 5,
            limitPagination: 4,
            containerClass: 'collection-item elem with-pagination',
            ulClass: 'pagination',
            prevText: '<i class="material-icons md-18">chevron_left</i>', 
            nextText: '<i class="material-icons md-18">chevron_right</i>', 
            firstText: '<i class="material-icons md-18">first_page</i>',
            lastText: '<i class="material-icons md-18">last_page</i>',
            pageNumbers: true
        },
        subData: {
            column: 'Familia',
            title: 'Familiares',
            cardRevealTitleColumnName: 'Nombre',
            columnNames: ['Nombre','Departamento','Parentezco','Direccion']
        },
        filters: true,
        filterColumns: [1,2],
        buttons: [
            {
                name: '<i class="material-icons blue-text" style="line-height: 36px;margin:0">info</i>',
                extraClasses: 'blue-text',
                onClick: function(btn, listElement){
                    Materialize.toast('clicked', 2000);
                },
                buttonInHeader: 4
            },
            {
                name: '<i class="material-icons blue-text" style="line-height: 36px;margin:0">add</i>',
                extraClasses: 'blue-text',
                onClick: function(btn, listElement){
                    Materialize.toast('clicked', 2000);
                },
                buttonInHeader: 4
            }
        ]
    });

</script>
    
</body>
</html>