var tableActiveExpense; //tabella spese da sostenere
var tableExpense; //tab spese sostenuta
var tableExpiredExpense; //tab spese non sostenute
var riga; //riga spese da sostenere
var cont=0;
var detrazioni=new Array();

$(document).ready(function(){
    
//recupero spese da sostenere
    tableActiveExpense = $('#activeExpense').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getActiveExpense",
        "order": [[ 0, "desc" ]],
        "info": false,
        "columnDefs":[{
            "targets":5,
            "visible":false
        },
        {
            "targets":6,
            "width":"5%",
            "orderable":false,
            "defaultContent":'<a data-toggle="modal" title="Elimina" href="#delete"><i class="fa fa-trash fa-2x"></i></a>'
        }]
    });
    
    tableExpense = $('#payoffExpense').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getExpense",
        "info": false,
        "order": [[ 0, "desc" ]],
        "autoWidth":false,
        "columnDefs":[{
            "targets":5,
            "visible":false
        }]
    });
    
    tableExpiredExpense = $('#expiredExpense').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getExpiredExpense",
        "info": false,
        "order": [[ 0, "desc" ]],
        "columnDefs":[{
            "targets":5,
            "visible":false
        },{
            "targets":6,
            "width":"7%",
            "orderable":false,
            "defaultContent":'<a data-toggle="modal" title="Conferma" href="#done"><i class="fa fa-check-circle fa-2x"></i></a> <a data-toggle="modal" class="del" title="Elimina" href="#delete"><i class="fa fa-trash fa-2x"></i></a>'
        }]
    });
        
});

//caricamento modal inserimento nuova spesa click aggiungi
$('#aggiungi').on('click',function(){
    $('#addExpense .alert-danger').addClass('hide');
    $('#detrazioni .detrazione').remove();
    document.getElementById('addForm').reset();
    var today=new Date();
    var giorno = traduciGiorno(today.getDate());
    var mese = traduciMese(today.getMonth());
    var anno = today.getFullYear().toString();
    var dataHtml = anno+"-"+mese+"-"+giorno;
    $('#dataR').val(dataHtml);
    //recupero categorie spesa
    $.post("getExpenseCategory", {}, 
        function(data){
            $('#categoria').html(data);
        }    
    );
    
});

//recupero nome voce spesa in base alla categoria scelta
$('#categoria').on('change',function(){
    $.post("getExpenseName", {
            categoria:$('#categoria').val()
        }, 
        function(data){
            $('#voce').html(data);
        }    
    ); 
});

//aggiungo spesa
$('#addExpense .btn-primary').on('click',function(){
    var x=0;
    var y=1;
    //controllo inserimento dati
    if ( ($('#voce').val()=='') || ($('#categoria').val()=='') || ($('#importo').val()=='') || ($('#dataR').val()=='') || ($('#dataP').val()=='') ){
        $('#addExpense .alert-danger').removeClass('hide');
        $('#addExpense .alert-danger').html('<strong>Attenzione!</strong> Inserire tutti i campi!');
    }else{
        $('#detrazioni select').each(function(){
            detrazioni[x]={"voce":""+$(this).val()+"", "valore":$('#value'+y).val()};
            x++;
            y++;
        });
        
        $.post("addExpense", {
            voce:$('#voce').val(),
            categoria:$('#categoria').val(),
            dataR:$('#dataR').val(),
            dataP:$('#dataP').val(),
            importo:$('#importo').val(),
            detrazioni:(JSON.stringify(detrazioni)) ? JSON.stringify(detrazioni):0
        }, 
            function(data){
            //console.log(detrazioni);
          //  console.log(data);
                if (data=='success'){
                    $('#addExpense').modal('hide');
                    tableActiveExpense.ajax.reload();
                    tableExpiredExpense.ajax.reload();
                }else if (data=='errorData'){
                    $('#addExpense .alert-danger').removeClass('hide');
                    $('#addExpense .alert-danger').html('<strong>Attenzione!</strong> Inserire data di pagamento valida!');     
                }
            }    
        );  
    } 
});

$('#detrazioni .btn-warning').on('click', function(){
    cont++;
    $('#detrazioni').append('<div class="form-group detrazione">'
                            +'<div class="col-sm-2"></div>'
                            +'<div class="col-sm-4">'
                                +'<select id="spesa'+cont+'" class="form-control"></select>'
                            +'</div>'
                            +'<div class="col-sm-3">'
                                +'<input type="number" min="0.01" step="0.01" class="form-control gg" placeholder="importo" id="value'+cont+'">'
                            +'</div>'
                         +'</div>');
    
    $.post("getAllVociSpesa",{},
    function(data){
        if(data!="false"){
            $('#spesa'+cont).html(data);  
        }
    });
});

//recupero riga riga
$('#activeExpense tbody').on('click','i', function(){
    riga = tableActiveExpense.row( $(this).parents('tr') ).data();
});

//recupero riga riga
$('#expiredExpense tbody').on('click','i', function(){
    riga = tableExpiredExpense.row( $(this).parents('tr') ).data();
});

//elimino spesa
$('#delete .btn-danger').on('click', function(){
   $.post("deleteExpense", {
        idUscita:riga[5]
    }, 
        function(data){
		//	console.log(data);
            if (data=='delete'){
                $('#delete').modal('hide');
                tableActiveExpense.ajax.reload();
                tableExpiredExpense.ajax.reload();
            }
        }    
    ); 
});

//conferma spesa
$('#done .btn-danger').on('click', function(){
   $.post("confirmExpense", {
        idUscita:riga[5]
    }, 
        function(data){
            if (data=='confirm'){
                $('#done').modal('hide');
                tableExpiredExpense.ajax.reload();
                tableExpense.ajax.reload();
            }
        }    
    ); 
});


/****************FUNZIONI UTILI*****************/

//funzione per traduzione corretta numero mese corrente
function traduciMese(mese){
    switch (mese){
        case 0:
            return "01";
            break;
        case 1:
            return "02";
            break;
        case 2:
            return "03";
            break;
        case 3:
            return "04";
            break;
        case 4:
            return "05";
            break;
        case 5:
            return "06";
            break;
        case 6:
            return "07";
            break;
        case 7:
            return "08";
            break;
        case 8:
            return "09";
            break;
        case 9:
            return "10";
            break;
        case 10:
            return "11";
            break;
        case 11:
            return "12";
            break;     
    }
}

//funzione per traduzione corretta numero giorno corrente
function traduciGiorno(giorno){
    if (giorno < 10){
        return "0"+giorno.toString();
    }else{
        return giorno.toString();
    }
}