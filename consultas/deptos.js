$(document).ready(function(){
    
    var monkeyList = new List('departamentos-lista', {
  valueNames: ['nombre', 'codigo'],
  page: 6,
  plugins: [ ListPagination({}) ] 
});
$('.collapsible').collapsible();
    
});