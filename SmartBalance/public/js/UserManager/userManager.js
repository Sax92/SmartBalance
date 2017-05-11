var riga;
var tableDetEntrate;
var tableDetUscite;
$(document).ready(function(){

    //numero spese odierne
    $.post("getTodayExpense", {}, 
        function(data){
            $('.panel-yellow .huge').html(data);
        }    
    );
    
    //numero entrate odierne
    $.post("getTodayEntry", {}, 
        function(data){
            $('.panel-green .huge').html(data);
        }    
    );
    
    //numero insoluti
    $.post("getInsoluti", {}, 
            function(data){
                $('.panel-danger .huge').html(data);
            }    
    );
    
    //numero entrate non ricevute
    $.post("getEntryNotReiceved", {}, 
            function(data){
                $('.panel-red .huge').html(data);
            }    
    );
    
    //totale uscite
    $.post("getTotExpense", {}, 
            function(data){
                $('#expenseTot').html(data);
            }    
    );
    
    //totale entrate
    $.post("getTotEntry", {}, 
            function(data){
                $('#entryTot').html(data);
                //saldo
                $.post("getSaldo", {}, 
                        function(data){
                            if (data.indexOf('-')!=-1){
                                $('#saldo').addClass('negative');
                                $('#saldo').removeClass('positive');
                            }else{
                                if (data==0){
                                    $('#saldo').removeClass('positive');
                                    $('#saldo').removeClass('negative');
                                }else{
                                    $('#saldo').addClass('positive');
                                    $('#saldo').removeClass('negative');
                                }
                            }
                            $('#saldo').html(data);
                        }    
                );
            }    
    );
    
//recupero detrazioni entrate 
    tableDetEntrate = $('#detEntrate').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getDetEntrate",
        "info": false,
        "order": [[ 1, "desc" ]],
        "columnDefs":[{
            "targets":3,
            "visible":false
        },
        {
            "targets":4,
            "width":"5%",
            "orderable":false,
            "defaultContent":'<a data-toggle="modal" title="Elimina" href="#deleteE"><i class="fa fa-trash fa-2x"></i></a>'
        }]
    });
    
    //recupero detrazioni entrate 
    tableDetUscite = $('#detUscite').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getDetUscite",
        "info": false,
        "order": [[ 1, "desc" ]],
        "columnDefs":[{
            "targets":3,
            "visible":false
        },
        {
            "targets":4,
            "width":"5%",
            "orderable":false,
            "defaultContent":'<a data-toggle="modal" title="Elimina" href="#deleteU"><i class="fa fa-trash fa-2x"></i></a>'
        }]
    });
    
});

//recupero riga det entrate
$('#detEntrate tbody').on('click','i', function(){
    riga = tableDetEntrate.row($(this).parents('tr') ).data();
});

//recupero riga det uscite
$('#detUscite tbody').on('click','i', function(){
    riga = tableDetUscite.row($(this).parents('tr') ).data();
});

//elimino det entrata
$('#deleteE .btn-danger').on('click', function(){
   $.post("deleteDetE", {
        idDetrazione:riga[3]
    }, 
        function(data){
            data = JSON.parse(data);
            if (data=='delete'){
                $('#deleteE').modal('hide');
                tableDetEntrate.ajax.reload();
            }
        }    
    ); 
});

//elimino det uscita
$('#deleteU .btn-danger').on('click', function(){
   $.post("deleteDetU", {
        idDetrazione:riga[3]
    }, 
        function(data){
            data = JSON.parse(data);
            if (data=='delete'){
                $('#deleteU').modal('hide');
                tableDetUscite.ajax.reload();
            }
        }    
    ); 
});


// Extend the default Number object with a formatMoney() method:
// usage: someVar.formatMoney(decimalPlaces, symbol, thousandsSeparator, decimalSeparator)
// defaults: (2, "$", ",", ".")
Number.prototype.formatMoney = function(places, symbol, thousand, decimal) {
	places = !isNaN(places = Math.abs(places)) ? places : 2;
	symbol = symbol !== undefined ? symbol : "$";
	thousand = thousand || ",";
	decimal = decimal || ".";
	var number = this, 
	    negative = number < 0 ? "-" : "",
	    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	    j = (j = i.length) > 3 ? j % 3 : 0;
	return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
};