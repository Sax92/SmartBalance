$(document).ready(function(){
    $.post("getDatiCliente",{},
        function(data){
            $('.well').html(data);
        }
    );
    
    $.post("incidenzaTotale",{},
        function(data){
            $('#incidenza').html(data+' %');
        }
    );
});